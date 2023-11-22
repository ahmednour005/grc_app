<?php

namespace App\Http\Controllers\admin\task;

use App\Events\EmployeeChangeStatus;
use App\Events\TaskCreated;
use App\Events\TaskDelated;
use App\Events\TaskUpdated;
use App\Exports\TasksExport;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Department;
use App\Models\FileTask;
use App\Models\Task;
use App\Models\TaskNote;
use App\Models\TaskNoteFile;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource that created by authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function createdTasks()
    {
        $currentUser = auth()->user();
        $tasks = $currentUser->createdTasks()->with('assignable')->orderBy('due_date')->get();
        $teams = Team::all();

        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $createdByMe = true;

        // Get available user to assign task
        $availableUsers = $this->getAvailableUsersToAssignTask($currentUser);

        $files[1] = FileTask::where('task_id', 1)->get();

        return view('admin.content.task.index', compact('createdByMe', 'pageConfigs', 'tasks', 'availableUsers', 'files', 'teams'));
    }

    /**
     * Display a listing of the resource that assigned to authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function assignedTasks()
    {
        $currentUser = auth()->user();
        $currentUserTasks = $currentUser->tasks()->orderBy('due_date')->get();
        $teamIds = $currentUser->teams()->pluck('id')->toArray();
        $teamTasks = Task::where('assignable_type', 'App\Models\Team')->whereIn('assignable_id', $teamIds)->orderBy('due_date')->get();
        $tasks = $currentUserTasks->merge($teamTasks);
        unset($currentUserTasks, $teamTasks);
        $teams = Team::all();

        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        $createdByMe = false;

        // Get available user to assign task
        $availableUsers = $this->getAvailableUsersToAssignTask($currentUser);

        return view('admin.content.task.index', compact('createdByMe', 'pageConfigs', 'tasks', 'availableUsers', 'teams'));
    }

    /**
     * Display a listing of the resource that assigned to authenticated user teams.
     *
     * @return \Illuminate\Http\Response
     */
    // public function assignedTeamTasks()
    // {
    //     $currentUser = auth()->user();
    //     $teamIds = $currentUser->teams()->pluck('id')->toArray();
    //     $tasks = Task::where('assignable_type', 'App\Models\Team')->whereIn('assignable_id', $teamIds)->orderBy('due_date')->get();

    //     $teams = Team::all();

    //     $pageConfigs = [
    //         'pageHeader' => false,
    //         'contentLayout' => "content-left-sidebar",
    //         'pageClass' => 'todo-application',
    //     ];

    //     $createdByMe = false;

    //     // Get available user to assign task
    //     $availableUsers = $this->getAvailableUsersToAssignTask($currentUser);

    //     return view('admin.content.task.index', compact('createdByMe', 'pageConfigs', 'tasks', 'availableUsers', 'teams'));
    // }

    protected function getChildDepartMents($department, &$departmentIds)
    {
        $departmentIds[] = $department->id;

        if ($department->departments) {
            foreach ($department->departments as $_department) {
                $this->getChildDepartMents($_department, $departmentIds);
            }
        } else {
            return;
        }
    }

    protected function getAvailableUsersToAssignTask($currentUser)
    {
        // Get other user via team
        $teamIds = $currentUser->teams()->pluck('id');
        $teamIdsString = implode(',', $teamIds->toArray());

        if (count($teamIds))
            $usersFromTeams = DB::select("SELECT DISTINCT `users`.`id`, `users`.`name` from `users` inner join `user_to_teams` on `users`.`id` = `user_to_teams`.`user_id` where `user_to_teams`.`team_id` in ($teamIdsString) AND `users`.`id` <> $currentUser->id ORDER BY `users`.`name`");
        else
            $usersFromTeams = [];

        // Get other user via departments
        $availableDpartments = $currentUser->department()->with(['departments'])->get();
        $availableDpartmentIds = [];
        foreach ($availableDpartments as $availableDpartment) {
            $this->getChildDepartMents($availableDpartment, $availableDpartmentIds);
        }
        unset($availableDpartments);
        $availableDpartmentIds = array_unique($availableDpartmentIds);
        $usersFromDepartments = User::whereIn('department_id', $availableDpartmentIds)->select('id', 'name')->get();

        $tempUser = new \stdClass();
        $tempUser->id = $currentUser->id;
        $tempUser->name = $currentUser->name;

        $availableUsers = collect([]);
        $availableUsers->push(clone $tempUser);
        foreach ($usersFromTeams as $user) {
            $tempUser->id = $user->id;
            $tempUser->name = $user->name;
            $availableUsers->push(clone $tempUser);
        }

        foreach ($usersFromDepartments as $user) {
            $tempUser->id = $user->id;
            $tempUser->name = $user->name;
            $availableUsers->push(clone $tempUser);
        }
        unset($usersFromTeams);
        unset($usersFromDepartments);

        return $availableUsers->unique();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = [];
        $rules = [
            'title' => ['required', 'max:255'],
            'assignee_type' => ['required', Rule::in(['Team', 'User'])],
            'task-start-date' => ['required', 'date', 'before:task-due-date'],
            'task-due-date' => ['required', 'date', 'after:task-start-date'],

            'task-priority' => ['required', Rule::in(['Urgent', 'High', 'Normal', 'Low', 'No Priority'])],
            'description' => ['required', 'string'],
            'supporting_documentation' => ['nullable', 'array'],
            'supporting_documentation.*' => ['nullable', 'file'],
        ];

        if ($request->assignee_type == 'User') {
            $rules['task-assigned'] = ['required', 'exists:users,id'];
        } else if ($request->assignee_type == 'Team') {
            $rules['task_assigned_team'] = ['required', 'exists:teams,id'];
        }

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('task.ThereWasAProblemAddingTheTask') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {
                $data = [
                    'title' => $request->title,
                    'description' => $request->description,
                    'priority' => $request['task-priority'],
                    'start_date' => $request['task-start-date'],
                    'due_date' => $request['task-due-date'],
                    'created_by' => auth()->id(),
                ];

                if ($request->assignee_type == 'User') {
                    $user = User::find($request['task-assigned']);
                    $task = $user->tasks()->create($data);
                } else if ($request->assignee_type == 'Team') {
                    $team = Team::find($request->task_assigned_team);
                    $task = $team->tasks()->create($data);
                }
                // Start submitting task data

                // File upload Start
                if ($request->hasFile('supporting_documentation')) {
                    foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                        if ($supporting_documentation->isValid()) {
                            $path = $supporting_documentation->store('task/' . $task->id);
                            $fileName = pathinfo($supporting_documentation->getClientOriginalName(), PATHINFO_FILENAME);
                            $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                            FileTask::create([
                                'task_id' => $task->id,
                                'display_name' => $fileName,
                                'unique_name' => $path
                            ]);
                        } else {
                            DB::rollBack();
                            Storage::deleteDirectory('task/' . $task->id);
                            $response = array(
                                'status' => false,
                                'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                'message' => __('task.ThereWasAProblemAddingTheTask') . "<br>" . __('locale.Validation error'),
                            );

                            return response()->json($response, 422);
                        }
                    }
                }
                // File upload End

                DB::commit();
                // Assuming $data is an array and you want to create a Task instance
                if (!isset($team)) {
                    $task = new Task($data);
                    event(new TaskCreated($task, $user, null));
                } else {
                    $task = new Task($data);
                    event(new TaskCreated($task, null, $team));
                }
                $response = array(
                    'status' => true,
                    // 'message' => __('locale.TaskWasAddedSuccessfully'),
                    'reload' => true,
                    'message' => __('task.TaskSubmitSuccess', ["title" => $request->title]),

                );
                $task = Task::latest()->first();
                $message = __('task.A New Task created with name') . ' "' . ($task->title ?? __("locale.No Name")) . '". ' .
                    __('task.And with description is') . ' "' . ($task->description ?? __("locale.[No Description]")) . '" ' .
                    __('locale.CreatedBy') . ' "' . auth()->user()->name . '".';
                write_log($task->id, auth()->id(), $message, 'Creating Task');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                // Storage::deleteDirectory('task/' . $task->id);

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // get old data to tto write log
        $taskOldDetAils = Task::find($request->id);

        $task = Task::find($request->id);

        if ($task) {
            $rules = [
                'title' => ['required', 'max:255'],
                'assignee_type' => ['required', Rule::in(['Team', 'User'])],
                'task-start-date' => ['required', 'date', 'before:task-due-date'],
                'task-due-date' => ['required', 'date', 'after:task-start-date'],
                'task-status' => ['nullable', Rule::in(['Accepted', 'Closed', 'In Progress', 'In Progress'])],

                'task-priority' => ['required', Rule::in(['Urgent', 'High', 'Normal', 'Low', 'No Priority'])],
                'description' => ['required', 'string'],
                'supporting_documentation' => ['nullable', 'array'],
                'supporting_documentation.*' => ['nullable', 'file'],
            ];

            if ($request->assignee_type == 'User') {
                $rules['task-assigned'] = ['required', 'exists:users,id'];
            } else if ($request->assignee_type == 'Team') {
                $rules['task_assigned_team'] = ['required', 'exists:teams,id'];
            }

            // Validation rules
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('task.ThereWasAProblemUpdatingTheTask') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                $uploadfilePaths = [];
                try {
                    // Start updating task data
                    $task->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'priority' => $request['task-priority'],
                        'status' => $request['task-status'] ?? 'Open',
                        'start_date' => $request['task-start-date'],
                        'due_date' => $request['task-due-date'],
                        'assignable_id' => $request->assignee_type == 'User' ? $request['task-assigned'] : $request->task_assigned_team,
                        'assignable_type' => $request->assignee_type == 'User' ? 'App\Models\User' : 'App\Models\Team',
                        'created_by' => auth()->id(),
                    ]);

                    if ($request['task-status'] == 'Accepted') {
                        $task->update([
                            'accepted_date' => now(),
                            'completed' => 0
                        ]);
                    } else {
                        $task->accepted_date = null;
                        $task->completed = 0;
                        $task->save();
                    }

                    // File upload Start
                    if ($request->hasFile('supporting_documentation')) {
                        foreach ($request->file('supporting_documentation') as $supporting_documentation) {
                            if ($supporting_documentation->isValid()) {
                                $path = $supporting_documentation->store('task/' . $task->id);
                                $uploadfilePaths[] = $path;
                                $fileName = pathinfo($supporting_documentation->getClientOriginalName(), PATHINFO_FILENAME);
                                $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                                FileTask::create([
                                    'task_id' => $task->id,
                                    'display_name' => $fileName,
                                    'unique_name' => $path
                                ]);
                            } else {
                                DB::rollBack();
                                foreach ($uploadfilePaths as $uploadfilePath) {
                                    Storage::delete($uploadfilePath);
                                }
                                $response = array(
                                    'status' => false,
                                    'errors' => ['supporting_documentation' => ['There were problems uploading the files']],
                                    'message' => __('task.ThereWasAProblemUpdatingTheTask') . "<br>" . __('locale.Validation error'),
                                );

                                return response()->json($response, 422);
                            }
                        }
                    }
                    // File upload End

                    // End updating task data

                    DB::commit();
                        event(new TaskUpdated($task));
                    $response = array(
                        'status' => true,
                        'task' => $task,
                        'reload' => true,
                        'message' => __('task.TaskWasUpdatedSuccessfully'),
                    );

                    if ($taskOldDetAils->title != $task->title && $taskOldDetAils->description != $task->description) {
                        $message = __('task.A Task that name is') . ' "' . $taskOldDetAils->title . '" ' . __('locale.changed to') . ' "' . $task->title . '". ' . __('task.And the description changed from') . ' "' . strip_tags($taskOldDetAils->description) . '" ' . __('locale.to') . ' "' . strip_tags($task->description) . '". ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    } else if ($taskOldDetAils->title != $task->title) {
                        $message = __('task.A Task that name is') . ' "' . $taskOldDetAils->title . '" ' . __('locale.changed to') . ' "' . $task->title . '". ' . __('task.Which the description of it') . ' "' . strip_tags($taskOldDetAils->description) . '". ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    } else if ($taskOldDetAils->description != $task->description) {
                        $message = __('task.A Task that name is') . ' "' . $taskOldDetAils->title . '". ' . __('task.The Description changed from') . ' "' . strip_tags($taskOldDetAils->description) . '" ' . __('locale.to') . ' "' . strip_tags($task->description) . '". ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    } else {
                        $message = __('task.A Task that name is') . ' "' . $taskOldDetAils->title . '". ' . __('task.The Description of it is') . ' "' . strip_tags($taskOldDetAils->description) . '". ' . __('locale.UpdatedBy') . ' "' . auth()->user()->name . '".';
                    }

                    write_log($task->id, auth()->id(), $message, 'Updating task');

                    return response()->json($response, 200);
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    foreach ($uploadfilePaths as $uploadfilePath) {
                        Storage::delete($uploadfilePath);
                    }
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        // 'message' => $th->getLine()
                        'message' => __('locale.Error'),
                    );
                    return response()->json($response, 502);
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Update complete status for the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeCompleteStatus(Request $request)
    {
        $task = Task::find($request->id);
        if ($task) {
            DB::beginTransaction();
            $task_id = $task->id;
            try {

                // update the task completed status
                $task->update([
                    'completed' => $request->completed == 'true' ? 1 : 0
                ]);

                DB::commit();

                $response = array(
                    'status' => true,
                    'message' =>  $request->completed == 'true' ? __('task.TaskWasCompletedSuccessfully') : __('task.TaskWasNotCompletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Update status the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assigneeUpdateStatus(Request $request)
    {
        $task = Task::find($request->id);
        if ($task) {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'task-status' => ['required', Rule::in(['In Progress', 'Completed'])],
            ]);
            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('task.ThereWasAProblemUpdatingTheTask') . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    // update the task status status
                    $task->update([
                        'status' => $request['task-status'],
                        'action_by' => auth()->id()
                    ]);

                    if ($request['task-status'] == 'Completed') {
                        $task->update([
                            'completed_date' => now(),
                            'completed' => 1,
                            'action_by' => auth()->id()
                        ]);
                    } else {
                        $task->completed_date = null;
                        $task->completed = 0;
                        $task->action_by = auth()->id();
                        $task->save();
                    }

                    DB::commit();
                    event(new EmployeeChangeStatus($task));

                    $response = array(
                        'status' => true,
                        'data' => $task,
                        'message' =>  __('task.TaskStatusUpdatedSuccessfully', ['status' => __('locale.' . $request['task-status'])])
                    );
                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();

                    $response = array(
                        'status' => false,
                        'message' => __('locale.Error'),
                        // 'message' => $th->getMessage(),
                    );
                    return response()->json($response, 404);
                }
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            DB::beginTransaction();
            $task_id = $task->id;
            try {
                // Remove the task
                $task->delete(); // tasks

                Storage::deleteDirectory('task/' . $task_id);
                DB::commit();
                event(new TaskDelated($task));
                $response = array(
                    'status' => true,
                    'message' => __('locale.TaskWasDeletedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
            
                if ($th->getCode() == 23000) {
                    $errorMessage = __('task.ThereWasAProblemDeletingTheTask') . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('task.ThereWasAProblemDeletingTheTask');
                }
                $response = array(
                    'status' => false,
                    'message' => $errorMessage,
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 404);
            }
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $file = Task::where('id', $request->task_id)->first()->files()->where('id', $request->id)->first() ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name);
        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->display_name);
        } else {
            return redirect()->route('admin.task.index');
        }
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFile(Request $request)
    {
        $file = Task::where('id', $request->task_id)->first()->files()->where('id', $request->id)->first() ?? null;
        if ($file) {
            Storage::delete($file->unique_name);
            $file->delete();


            $response = array(
                'status' => true,
                'message' => __('locale.FileDeletedSuccessfully'),
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Get specified resource data for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet($id)
    {
        $task = Task::with(['action_by_user:id,name', 'notes', 'note_files'])->find($id);

        if ($task) {
            $data['id'] = $task->id;
            $data['title'] = $task->title;
            $data['description'] = $task->description;
            $data['priority'] = $task->priority;
            $data['start_date'] = $task->start_date->format('Y-m-d');
            $data['due_date'] = $task->due_date->format('Y-m-d');
            $data['completed_date'] = $task->completed_date ? date('Y-m-d H:i', strtotime($task->completed_date)) : '';
            $data['accepted_date'] = $task->accepted_date ? date('Y-m-d H:i', strtotime($task->accepted_date)) : '';
            $data['completed'] = $task->completed;
            $data['status'] = $task->status;
            $data['assignable_id'] = $task->assignable_id;
            $data['assignable_type'] = $task->assignable_type == 'App\Models\User' ? 'User' : 'Team';
            $data['created_by'] = $task->created_by;
            $data['action_by'] = $task->action_by_user->name ?? '';
            $data['created_at'] = $task->created_at->format('Y-m-d H:i');
            $data['files'] = $task->files;
            $notes = $task->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $task->note_files->map(function ($noteFile) {
                return [
                    'type' => 'f',
                    'id' => $noteFile->id,
                    'user_id' => $noteFile->user_id,
                    'note' => $noteFile->display_name,
                    'user_name' => $noteFile->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($noteFile->user->name, 2),
                    'created_at' => $noteFile->created_at->format('Y-m-d H:i:s'),
                ];
            });
            $data['notes'] = new Collection();

            if ($notes->count()) {
                $data['notes'] = $notes;
            } else if ($noteFiles->count()) {
                if ($data['notes']->count())
                    $data['notes'] = $data['notes']->merge($noteFiles);
                else
                    $data['notes'] = $noteFiles;
            }

            // $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            $data['notes'] = $data['notes']->merge($noteFiles)->sortBy('created_at')->values()->all();
            unset($noteFiles);
            $response = array(
                'status' => true,
                'data' => $data,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Display a calendar of the tasks for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        $currentUser = auth()->user();
        $currentUserTasks = $currentUser->tasks()->orderBy('due_date')->get();
        $teamIds = $currentUser->teams()->pluck('id')->toArray();
        $teamTasks = Task::where('assignable_type', 'App\Models\Team')->whereIn('assignable_id', $teamIds)->orderBy('due_date')->get();
        $tasks = $currentUserTasks->merge($teamTasks);
        unset($currentUserTasks, $teamTasks);

        $events = $tasks->map(function ($task) {
            return (object)[
                'id' =>  $task->id,
                'url' => '',
                'title' => $task->title,
                'start' =>  $task->start_date->format('Y-m-d'),
                'end' =>  $task->due_date->format('Y-m-d'),
                'allDay' => false,
                'extendedProps' => array(
                    'calendar' => $task->assignable_type == 'App\Models\User' ? 'Personal' : 'Team'
                ),
            ];
        });

        $pageConfigs = [
            'pageHeader' => false
        ];

        // return $events;
        return view('admin.content.task.calendar', compact('pageConfigs', 'events'));
    }

    /**
     * Store a newly created task note resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send_note(Request $request)
    {
        $rules = [
            'task_id' => ['required', 'exists:tasks,id'],
            'note' => ['required', 'string'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('task.ThereWasAProblemAddingTheTaskNote') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {
                $note = TaskNote::create([
                    'user_id' => auth()->id(),
                    'task_id' => $request->task_id,
                    'note' => $request->note,
                ]);

                $note = TaskNote::find($note->id);

                DB::commit();

                $response = array(
                    'status' => true,
                    'message' => __('task.TaskNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $note,
                        'task' => $note->task
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }
    /**
     * Store a newly created task note file resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send_note_file(Request $request)
    {
        $rules = [
            'note_file' => ['file'],
            'task_id' => ['required', 'exists:tasks,id'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('task.ThereWasAProblemAddingTheTaskNote') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {

            DB::beginTransaction();
            try {

                $fileName = '';
                $path = '';
                // File upload Start
                if ($request->hasFile('note_file')) {
                    $note_file = $request->file('note_file');
                    $path = '';
                    if ($note_file->isValid()) {
                        $path = $note_file->store('task/' . $request->task_id . '/notes');
                        $fileName = pathinfo($note_file->getClientOriginalName(), PATHINFO_FILENAME);
                        $fileName .= pathinfo($path, PATHINFO_EXTENSION) ? '.' . pathinfo($path, PATHINFO_EXTENSION) : '';
                    } else {
                        if ($path)
                            Storage::delete($path);
                        $response = array(
                            'status' => false,
                            'errors' => ['note_file' => ['There were problems uploading the files']],
                            'message' => __('task.ThereWasAProblemAddingTheTaskNote') . "<br>" . __('locale.Validation error'),
                        );

                        return response()->json($response, 422);
                    }
                }

                $taskFile = TaskNoteFile::create([
                    'user_id' => auth()->id(),
                    'task_id' => $request->task_id,
                    'display_name' => $fileName,
                    'unique_name' => $path
                ]);
                // File upload End

                DB::commit();
                $taskFile = TaskNoteFile::find($taskFile->id);

                $response = array(
                    'status' => true,
                    'message' => __('task.TaskNoteWasAddedSuccessfully'),
                    'data' => [
                        'note' => $taskFile,
                        'task' => $taskFile->task
                    ],
                    'reload' => false,
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                if ($path)
                    Storage::delete($path);
                $response = array(
                    'status' => false,
                    'errors' => [],
                    // 'message' => $th->getMessage(),
                    'message' => __('locale.ThereAreUnexpectedProblems')
                );
                return response()->json($response, 502);
            }
        }
    }


    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadNoteFile(Request $request)
    {
        $file = Task::where('id', $request->task_id)->first()->note_files()->where('id', $request->id)->first() ?? null;
        $exists = Storage::disk('local')->exists($file->unique_name);
        if ($file && $exists) {
            return Storage::download($file->unique_name, $file->display_name);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxCreatedExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new TasksExport('created'), 'Created_tasks.xlsx');
        else
            return 'Created_tasks.pdf';
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxAssignedExport(Request $request)
    {
        if ($request->type != 'pdf')
            return Excel::download(new TasksExport('assigned'), 'Assigned_tasks.xlsx');
        else
            return 'Assigned_tasks.pdf';
    }

    public function notificationsSettingsTask()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.awarness_survey.GetDataSurvey'), 'name' => __('locale.Survey')],
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [77, 78, 79,81];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [80];  // defining ids of actions modules
        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            77 => ['Title','Team','Assignee','Start_Date','Due_Date','Task_Priority','Description'],
            78 => ['Title','Team','Assignee','Start_Date','Due_Date','Task_Priority','Description'],
            79 => ['Title','Team','Assignee','Start_Date','Due_Date','Task_Priority','Description'],
            80 => ['Title','Team','Assignee','Start_Date','Due_Date','Task_Priority','Description'],
            81 => ['Title','Team','Assignee','Start_Date','Due_Date','Task_Priority','Description','Status','Task_Tacker','Completed_Date'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            77 => ['Assignee' => __('locale.Assignee'), 'Team-teams' => __('locale.TeamsOfTask'),'creator' => __('locale.TaskCreator'),],
            78 => ['Assignee' => __('locale.Assignee'), 'Team-teams' => __('locale.TeamsOfTask'),'creator' => __('locale.TaskCreator'),],
            79 => ['Assignee' => __('locale.Assignee'), 'Team-teams' => __('locale.TeamsOfTask'),'creator' => __('locale.TaskCreator'),],
            80 => ['Assignee' => __('locale.Assignee'), 'Team-teams' => __('locale.TeamsOfTask'),'creator' => __('locale.TaskCreator'),],
            81 => ['creator' => __('locale.TaskCreator')],
        ];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        $actionsWithSettingsAuto = Action::whereIn('actions.id', $moduleActionsIdsAutoNotify)
            ->leftJoin('auto_notifies', 'actions.id', '=', 'auto_notifies.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'auto_notifies.id as auto_notifies_id',
                'auto_notifies.status as auto_notifies_status',
            ]);
        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }
}
