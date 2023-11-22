<?php

namespace App\Http\Controllers\admin\control_objective;

use App\Exports\ControlObjectivesExport;
use App\Http\Controllers\Controller;
use App\Imports\ControlObjectivesImport;
use App\Models\ControlObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Action;
use App\Events\ControlObjectivesMainCreated;
use App\Events\ControlObjectivesMainUpdated;
use App\Events\ControlObjectivesMainDeleted;
use Illuminate\Support\Str;




class ControlObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controlObjectives = ControlObjective::select('id', 'name')->get();
        $breadcrumbs = [
            [
                'link' => route('admin.dashboard'),
                'name' => __('locale.Dashboard')
            ], ['link' => route('admin.hierarchy.index'), 'name' => __('locale.Hierarchy')],

            ['name' => __('locale.ControlObjectives')]
        ];

        return view('admin.content.control_objective.index', compact('breadcrumbs', 'controlObjectives'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'unique:control_objectives,name'],
            'description' => ['required', 'max:500']
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingTheControlObjective')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();
            try {
                $ControlObjective = ControlObjective::create([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);

                DB::commit();
                event(new ControlObjectivesMainCreated($ControlObjective));

                $response = array(
                    'status' => true,
                    'message' => __('locale.ControlObjectiveWasAddedSuccessfully'),
                );
                $message = __('locale.A New Objective created with name') . ' "' . ($ControlObjective->name ?? __('locale.[No Objective Name]')) . '". '
                    . __('locale.And with description is') . ' "' . ($ControlObjective->description ?? __('locale.[No Description]')) . '". '
                    . __('CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log($ControlObjective->id, auth()->id(), $message, 'Creating ControlObjective');

                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                );
                return response()->json($response, 502);
            }
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
        $controlObjective = ControlObjective::find($id);
        if ($controlObjective) {

            $data = $controlObjective->toArray();

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $controlObjectiveOldDetAils = ControlObjective::find($id);
        $controlObjective = ControlObjective::find($id);
        if ($controlObjective) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:100', 'unique:control_objectives,name,' .  $controlObjective->id],
                'description' => ['required', 'max:500']
            ]);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemUpdatingTheControlObjective')
                        . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();
                try {
                    $controlObjective->update([
                        'name' => $request->name,
                        'description' => $request->description,
                    ]);

                    DB::commit();
                    event(new ControlObjectivesMainUpdated($controlObjective));
                    $response = array(
                        'status' => true,
                        'message' => __('locale.ControlObjectiveWasUpdatedSuccessfully'),
                    );

                    if ($controlObjectiveOldDetAils->name != $controlObjective->name && $controlObjectiveOldDetAils->description != $controlObjective->description) {
                        $message = __('locale.An Objective that name is') . ' "' . ($controlObjectiveOldDetAils->name ?? __('locale.[No Name]')) . '" '
                            . __('locale.changed to') . ' "' . ($controlObjective->name ?? __('locale.[No Name]')) . '". '
                            . __('locale.The Description Changed from') . ' "' . ($controlObjectiveOldDetAils->description ?? __('locale.[No Description]')) . '" '
                            . __('locale.to') . ' "' . ($controlObjective->description ?? '[No Description]') . '". '
                            . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                    } else if ($controlObjectiveOldDetAils->name != $controlObjective->name) {
                        $message = __('locale.An Objective that name is') . ' "' . ($controlObjectiveOldDetAils->name ?? __('locale.[No Name]')) . '" '
                            . __('locale.changed to') . ' "' . ($controlObjective->name ?? __('locale.[No Name]')) . '". '
                            . __('locale.Which the description of it') . ' "' . ($controlObjectiveOldDetAils->description ?? __('locale.[No Description]')) . '". '
                            . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                    } else if ($controlObjectiveOldDetAils->description != $controlObjective->description) {
                        $message = __('locale.An Objective that name is') . ' "' . ($controlObjectiveOldDetAils->name ?? __('locale.[No Name]')) . '" '
                            . __('locale.The Description Changed from') . ' "' . ($controlObjectiveOldDetAils->description ?? __('locale.[No Description]')) . '" '
                            . __('governance.to') . ' "' . ($controlObjective->description ?? __('locale.[No Description]')) . '". '
                            . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                    } else {
                        $message = __('locale.An Objective that name is') . ' "' . ($controlObjectiveOldDetAils->name ?? '[No Name]') . '" '
                            . __('locale.That Description of it is') . ' "' . ($controlObjectiveOldDetAils->description ?? '[No Description]') . '". '
                            . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                    }

                    write_log($controlObjective->id, auth()->id(), $message, 'Updating controlObjective');

                    return response()->json($response, 200);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return $th->getMessage();
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
        $controlObjective = ControlObjective::find($id);
        if ($controlObjective) {
            DB::beginTransaction();
            try {
                $controlObjective->delete();

                DB::commit();
                event(new ControlObjectivesMainDeleted($controlObjective));

                $response = array(
                    'status' => true,
                    'message' => __('locale.ControlObjectiveWasDeletedSuccessfully'),
                );
                $message = __('locale.An Objective that name is') . ' "' . $controlObjective->name . '". ' . __('locale.and the Description of it is') . ' "' . $controlObjective->description . '". ' . __('locale.DeletedBy') . ' "' . auth()->user()->name . '".';
                write_log($controlObjective->id, auth()->id(), $message, 'Deleting controlObjective');
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                DB::rollBack();

                if ($th->errorInfo[0] == 23000) {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEmployee')
                        . "<br>" . __('locale.CannotDeleteRecordRelationError');
                } else {
                    $errorMessage = __('locale.ThereWasAProblemDeletingTheEmployee');
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
     * Return a listing of the resource after some manipulation.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetList(Request $request)
    {
        /* Start reading datatable data and custom fields for filtering */
        $dataTableDetails = [];
        $customFilterFields = [
            'normal' => ['name'],
            'relationships' => [],
            'other_global_filters' => ['description', 'created_at'],
        ];
        $relationshipsWithColumns = [];

        prepareDatatableRequestFields($request, $dataTableDetails, $customFilterFields);
        /* End reading datatable data and custom fields for filtering */

        // Getting total records count with and without apply global search
        [$totalRecords, $totalRecordswithFilter] = getDatatableFilterTotalRecordsCount(
            ControlObjective::class,
            $dataTableDetails,
            $customFilterFields
        );

        $mainTableColumns = getTableColumnsSelect(
            'control_objectives',
            [
                'id',
                'name',
                'description',
                'created_at'
            ]
        );

        // Getting records with apply global search */
        $controlObjectives = getDatatableFilterRecords(
            ControlObjective::class,
            $dataTableDetails,
            $customFilterFields,
            $relationshipsWithColumns,
            $mainTableColumns
        );

        // Custom control_objectives response data as needs
        $dataArr = [];
        foreach ($controlObjectives as $controlObjective) {
            $dataArr[] = array(
                'id' =>  $controlObjective->id,
                'name' => $controlObjective->name,
                'description' => $controlObjective->description,
                'created_at' => $controlObjective->created_at->format('Y-m-d H:i:s'),
                'Actions' => $controlObjective->id,
            );
        }

        // Get custom response for datatable ajax request
        $response = getDatatableAjaxResponse(
            intval($dataTableDetails['draw']),
            $totalRecords,
            $totalRecordswithFilter,
            $dataArr
        );

        return response()->json($response, 200);
    }

    /**
     * Return an Export file for listing of the resource after some manipulation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxExport(Request $request)
    {
        if ($request->type != 'pdf') {
            return Excel::download(new ControlObjectivesExport, 'ControlObjectives.xlsx');
        } else {
            return 'ControlObjectives.pdf';
        }
    }

    /**
     * Download import template.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadImportTemplate()
    {
        $exists = Storage::disk('local')->exists('imports/ControlObjective-template.xlsx');
        if ($exists) {
            return Storage::download('imports/ControlObjective-template.xlsx', 'ControlObjective-template.xlsx');
        } else {
            return redirect('/');
        }
    }


    public function notificationsSettingsobjective()
    {
        // defining the breadcrumbs that will be shown in page

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.control_objectives.index'), 'name' => __('locale.ControlObjectives')],
            ['name' => __('locale.NotificationsSettings')]
        ];

        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [41, 42, 43];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            41 => ['Name', 'Description'],
            42 => ['Name', 'Description'],
            43 => ['Name', 'Description'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [];
        // getting actions with their system notifications settings, sms settings and mail settings to list them in tables
        $actionsWithSettings = Action::whereIn('actions.id', $moduleActionsIds)
            ->leftJoin('system_notifications_settings', 'actions.id', '=', 'system_notifications_settings.action_id')
            ->leftJoin('mail_settings', 'actions.id', '=', 'mail_settings.action_id')
            ->leftJoin('sms_settings', 'actions.id', '=', 'sms_settings.action_id')
            ->get([
                'actions.id as action_id',
                'actions.name as action_name',
                'system_notifications_settings.id as system_notification_setting_id',
                'system_notifications_settings.status as system_notification_setting_status',
                'mail_settings.id as mail_setting_id',
                'mail_settings.status as mail_setting_status',
                'sms_settings.id as sms_setting_id',
                'sms_settings.status as sms_setting_status',
            ]);
        $actionsWithSettingsAuto = [];

        return view('admin.notifications-settings.index', compact('breadcrumbs', 'users', 'actionsWithSettings', 'actionsVariables', 'actionsRoles', 'moduleActionsIdsAutoNotify', 'actionsWithSettingsAuto'));
    }

    // This function is used to open the import form and send the required data for it
    public function openImportForm()
    {
        // Defining breadcrumbs for the page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.control_objectives.index'), 'name' => __('locale.ControlObjectives')],
            ['name' => __('locale.Import')]
        ];

        // Defining database columns with rules and examples
        $databaseColumns = [
            // Column: 'name'
            ['name' => 'name', 'rules' => ['required', 'should be unique in control_objectives table'], 'example' => 'Control Objective1'],

            // Column: 'description'
            ['name' => 'description', 'rules' => ['required'], 'example' => 'Some description'],
        ];

        // Define the path for the import data function
        $importDataFunctionPath = route('admin.control_objectives.ajax.importData');

        // Return the view with necessary data
        return view('admin.import.index', compact('breadcrumbs', 'databaseColumns', 'importDataFunctionPath'));
    }


    // This function is used to validate the data coming from mapping column and then
    // sending them to "ControlObjectivesImport" class to import its data
    public function importData(Request $request)
    {
        // Validate the incoming request for the 'import_file' field
        $validator = Validator::make($request->all(), [
            'import_file' => ['required', 'file', 'max:5000'],
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            // Prepare response with validation errors
            $response = [
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.ControlObjectives')])
                    . "<br>" . __('locale.Validation error'),
            ];
            return response()->json($response, 422);
        } else {
            // Start a database transaction
            DB::beginTransaction();
            try {
                // Mapping columns from the request to database columns
                $columnsMapping = array();
                $columns = ['name','description'];

                foreach ($columns as $column) {
                    if ($request->has($column)) {
                        $snakeCaseColumn = Str::snake($request->input($column));
                        $columnsMapping[$column] = $snakeCaseColumn;
                    }
                }

                // Extract values and filter out null values
                $values = array_values(array_filter($columnsMapping, function ($value) {
                    if ($value != null && $value != '') {
                        return $value;
                    }
                }));

                // Check for duplicate values
                if (count($values) !== count(array_unique($values))) {
                    $response = [
                        'status' => false,
                        'message' => __('locale.YouCantUseTheSameFileColumnForMoreThanOneDatabaseColumn'),
                    ];
                    return response()->json($response, 422);
                }

                // Import data using the specified columns mapping
                (new ControlObjectivesImport($columnsMapping))->import(request()->file('import_file'));

                // Commit the transaction
                DB::commit();

                // Prepare success response
                $response = [
                    'status' => true,
                    'reload' => true,
                    'message' => __('locale.ItemWasImportedSuccessfully', ['item' => __('locale.ControlObjectives')]),
                ];
                return response()->json($response, 200);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                // Rollback the transaction in case of an exception
                DB::rollBack();

                // Handle validation exceptions and prepare error response
                $failures = $e->failures();
                $errors = [];
                foreach ($failures as $failure) {
                    if (!array_key_exists($failure->row(), $errors)) {
                        $errors[$failure->row()] = [];
                    }
                    $errors[$failure->row()][] = [
                        'attribute' => $failure->attribute(),
                        'value' =>  $failure->values()[$failure->attribute()] ?? '',
                        'error' => $failure->errors()[0]
                    ];
                }

                $response = [
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('locale.ThereWasAProblemImportingTheItem', ['item' => __('locale.ControlObjectives')]),
                ];
                return response()->json($response, 502);
            }
        }
    }
  
}
