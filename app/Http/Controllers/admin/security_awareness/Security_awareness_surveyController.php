<?php

namespace App\Http\Controllers\admin\security_awareness;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset;
use App\Models\Privacy;
use App\Models\Category;
use App\Mail\SurveySendEmailTest;
use App\Models\Review;
use App\Models\SurveyQuestion;
use App\Models\AwarenessSurvey;
use App\Models\ScoringMethod;
use App\Models\Setting;
use App\Models\Source;
use App\Models\Status;
use App\Models\DocumentStatus;
use App\Models\Team;
use App\Models\User;
use Exception;
use App\Models\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Models\AnswerQuestionSurvey;
use App\Events\SurveyCreated;
use App\Events\SurveyUpdated;
use App\Events\SurveyDeleted;
use Stichoza\GoogleTranslate\TranslateClient;




class Security_awareness_surveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // validation of insert survey
        $rules = [
            // 'name' => ['required', 'max:512', 'unique:awareness_surveys,name'],
            'description' => ['required', 'max:500'],
            'name' => ['required', 'max:500'],
            'team' => ['nullable', 'array'],
            'team.*' => ['exists:teams,id'],
            'additional_stakeholder' => ['nullable', 'array'],
            'filter_status' => ['required', 'exists:document_statuses,id'],
            'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
            'review_frequency' => ['required', 'integer'],
            'owner_id' => ['nullable', 'exists:users,id'],
        ];

        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($request->filter_status == 2) {
            $rules['reviewer'] = ['required', 'exists:users,id'];
        } else {
            $rules['reviewer'] = ['nullable', 'exists:users,id'];
        }

        if ($request->filter_status == 3) {
            $rules['privacy'] = ['required', 'exists:privacies,id'];
            $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
        } else {
            $rules['privacy'] = ['nullable', 'exists:privacies,id'];
            $rules['approval_date'] = ['nullable', 'date'];
        }

        // validation of question mandatory

        if ($request->all_questions_mandatory == 1) {
            $rules['answer_percentage'] = ['nullable'];
            $rules['specific_questions'] = ['nullable'];
        } elseif (
            $request->all_questions_mandatory != 1 &&
            $request->answer_percentage != 1 &&
            $request->specific_mandatory_questions != 1
        ) {
            $rules['all_questions_mandatory'] = ['required'];
        } elseif (
            $request->all_questions_mandatory != 1 &&
            $request->answer_percentage == 1 &&
            $request->specific_mandatory_questions != 1
        ) {
            $rules['all_questions_mandatory'] = ['nullable'];
            $rules['specific_questions'] = ['nullable'];
            $rules['answer_percentage'] = ['exclude_if:all_questions_mandatory,1', 'in:1,0'];
            $rules['percentage_number'] = ['required', 'integer', 'between:1,100'];
        } elseif (
            $request->all_questions_mandatory != 1 &&
            $request->answer_percentage != 1 &&
            $request->specific_mandatory_questions == 1
        ) {
            $rules['all_questions_mandatory'] = ['nullable'];
            $rules['specific_mandatory_questions'] = ['required'];
            $rules['answer_percentage'] = ['nullable'];
            $rules['percentage_number'] = ['nullable'];
            $rules['questions'] = ['required'];
            $rules['questions.*'] = ['required'];
        }
        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('survey.ThereWasAProblemAddingSurvey')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                $ownerId = $request->owner_id ?? auth()->user()->id;
                $survey = AwarenessSurvey::create([
                    'name' => $request->name,
                    'additional_stakeholder' => implode(',', $request->additional_stakeholder ?? []),
                    'owner_id' => $ownerId,
                    'team' => implode(',', $request->team ?? []),
                    'last_review_date' => $request->last_review_date,
                    'review_frequency' => $request->review_frequency,
                    'next_review_date' => $request->next_review_date,
                    'filter_status' => $request->filter_status,
                    'reviewer' => implode(',', $request->reviewer ?? []),
                    'approval_date' => $request->approval_date,
                    'privacy' => $request->privacy,
                    'description' => $request->description,
                    'created_by' => (Auth::user()->id),
                    'all_questions_mandatory' => $request->all_questions_mandatory,
                    'answer_percentage' => $request->answer_percentage,
                    'percentage_number' => $request->percentage_number,
                    'specific_mandatory_questions' => $request->specific_mandatory_questions,
                    'questions' => implode(',', $request->questions ?? []),
                ]);
                DB::commit();
                event(new SurveyCreated($survey));
                $message = __('survey.A New Survey Added by name') . ' "' . ($survey->name ?? '[No Name]') . '" '
                    . __('survey.and the Description of it is') . ' "' . ($survey->description ?? '[No Description]') . '" '
                    . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log($survey->id, auth()->id(), $message, 'Creating survey');
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editmodal($id)
    {
        $survey = AwarenessSurvey::find($id);
        // to find the stakeholder values in users table
        // $stakehoder = User::whereIn( 'id', explode(',',$survey->additional_stakeholder) )->select('id', 'name')->distinct()->get();
        $userIds = explode(',', $survey->additional_stakeholder);
        $stakehoder = User::whereIn('id', $userIds)->select('id', 'name')->distinct()->get();
        // to find the Team values in users table
        $toam = Team::whereIn('id', explode(',', $survey->team))->select('id', 'name')->get();
        // to find the Reviewer values in users table
        $reviewer = User::whereIn('id', explode(',', $survey->reviewer))->select('id', 'name')->get();
        // dd($reviewer->id);
        $statuses = DocumentStatus::all();
        $teams = Team::all();
        $privacies = Privacy::all();
        $enabledUsers = User::where('enabled', true)
            // ->where('id', '!=', auth()->user()->id)
            ->with('manager:id,name,manager_id')
            ->get();
        // to find the questions selected
        $question = SurveyQuestion::whereIn('id', explode(',', $survey->questions))->select('id', 'question')->get();
        $returnHTML = view(
            'admin.content.awareness_survey.edit',
            compact('stakehoder', 'reviewer', 'toam', 'enabledUsers', 'teams', 'survey', 'statuses', 'privacies', 'question')
        )->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
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
        // validation of update

        $rules = [
            // 'name' => ['required', 'max:512', 'unique:awareness_surveys,name'],
            'description' => ['required', 'max:500'],
            'team' => ['nullable', 'array'],
            'team.*' => ['exists:teams,id'],
            'additional_stakeholder' => ['nullable', 'array'],
            'filter_status' => ['nullable', 'exists:document_statuses,id'],
            'last_review_date' => ['required', 'date', 'after_or_equal:creation_date'],
            'review_frequency' => ['required', 'integer'],
            'owner_id' => ['nullable', 'exists:users,id'],
        ];

        // [1 => Draft],[2=> InReview, [3 => Approved]
        if ($request->filter_status == 2) {
            $rules['reviewer'] = ['required', 'exists:users,id'];
        } else {
            $rules['reviewer'] = ['nullable', 'exists:users,id'];
        }

        if ($request->filter_status == 3) {
            $rules['privacy'] = ['required', 'exists:privacies,id'];
            $rules['approval_date'] = ['required', 'date', 'after_or_equal:creation_date'];
        } else {
            $rules['privacy'] = ['nullable', 'exists:privacies,id'];
            $rules['approval_date'] = ['nullable', 'date'];
        }

        // validation of question mandatory

        if ($request->all_questions_mandatory == 1) {
            $rules['answer_percentage'] = ['nullable'];
            $rules['specific_questions'] = ['nullable'];
        } elseif (
            $request->all_questions_mandatory != 1 &&
            $request->answer_percentage != 1 &&
            $request->specific_mandatory_questions != 1
        ) {
            $rules['all_questions_mandatory'] = ['required'];
        } elseif (
            $request->all_questions_mandatory != 1 &&
            $request->answer_percentage == 1 &&
            $request->specific_mandatory_questions != 1
        ) {
            $rules['all_questions_mandatory'] = ['nullable'];
            $rules['specific_questions'] = ['nullable'];
            $rules['answer_percentage'] = ['exclude_if:all_questions_mandatory,1', 'in:1,0'];
            $rules['percentage_number'] = ['required', 'integer', 'between:1,100'];
        } elseif (
            $request->all_questions_mandatory != 1 &&
            $request->answer_percentage != 1 &&
            $request->specific_mandatory_questions == 1
        ) {
            $rules['all_questions_mandatory'] = ['nullable'];
            $rules['specific_mandatory_questions'] = ['required'];
            $rules['answer_percentage'] = ['nullable'];
            $rules['percentage_number'] = ['nullable'];
            $rules['questions'] = ['required'];
            $rules['questions.*'] = ['required'];
        }
        // Validation rules
        $validator = Validator::make($request->all(), $rules);
        $survey = AwarenessSurvey::findOrFail($id);
        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('survey.ThereWasAProblemAddingSurvey')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                $surveyoldData = AwarenessSurvey::findOrFail($id);
                $survey = AwarenessSurvey::findOrFail($id);
                $oldValues = $survey->toArray(); // get the old values before the update

                $survey->update([
                    'name' => $request->name,
                    'additional_stakeholder' => implode(',', $request->additional_stakeholder ?? []),
                    // 'owner_id'=>$request->owner_id,
                    'team' => implode(',', $request->team ?? []),
                    'last_review_date' => $request->last_review_date,
                    'review_frequency' => $request->review_frequency,
                    'next_review_date' => $request->next_review_date,
                    'filter_status' => $request->filter_status,
                    'reviewer' => implode(',', $request->reviewer ?? []),
                    'approval_date' => $request->approval_date,
                    'privacy' => $request->privacy,
                    'description' => $request->description,
                    'all_questions_mandatory' => $request->all_questions_mandatory,
                    'answer_percentage' => $request->answer_percentage,
                    'percentage_number' => $request->percentage_number,
                    'specific_mandatory_questions' => $request->specific_mandatory_questions,
                    'questions' => implode(',', $request->questions ?? []),
                ]);
                // dd($survey);
                DB::commit();
                // pass the $survey object and the old values to the event
                event(new SurveyUpdated($survey));

                if (($surveyoldData->name ?? '') != ($survey->name ?? '') && ($surveyoldData->description ?? '') != ($survey->description ?? '')) {
                    $message = __('survey.A Survey that name is') . ' "' . ($surveyoldData->name ?? __('locale.[No Name]')) . '" ' . __('survey.changed to') . ' "' . ($survey->name ?? __('locale.[No Name]')) . '". ' . __('survey.And the description changed from') . ' "' . ($surveyoldData->description ?? __('locale.[No Description]')) . '" ' . __('locale.to') . ' "' . ($survey->description ?? '[No Description]') . '". ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                } else if (($surveyoldData->name ?? '') != ($survey->name ?? '')) {
                    $message = __('survey.A Survey that name is') . ' "' . ($surveyoldData->name ?? __('locale.[No Name]')) . '" ' . __('survey.changed to') . ' "' . ($survey->name ?? __('locale.[No Name]')) . '". ' . __('survey.Which the description of it') . ' "' . ($surveyoldData->description ?? __('locale.[No Description]')) . '". ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                } else if (($surveyoldData->description ?? '') != ($survey->description ?? '')) {
                    $message = __('survey.A Survey that name is') . ' "' . ($surveyoldData->name ?? __('locale.[No Name]')) . '" ' . __('survey.The Description Changed from') . ' "' . ($surveyoldData->description ?? __('locale.[No Description]')) . '" ' . __('locale.to') . ' "' . ($survey->description ?? __('locale.[No Description]')) . '". ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                } else {
                    $message = __('survey.A Survey that name is') . ' "' . ($surveyoldData->name ?? __('locale.[No Name]')) . '" ' . __('survey.The Description of it is') . ' "' . ($surveyoldData->description ?? __('locale.[No Description]')) . '". ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? __('locale.[No Description]')) . '".';
                }


                write_log($survey->id, auth()->id(), $message, 'Updating survey');
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                // return response()->json($response, 502);
            }
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
        //
    }

    public function sendMail($id)
    {
        // dd($id);
        $survey = AwarenessSurvey::findOrFail($id);
        // dd($survey);
        Mail::to(Auth::user()->email)->send(new SurveySendEmailTest($survey));
        $response = array(
            'status' => false,
            'errors' => [],
            // 'message' => $th->getMessage(),
            'message' => '',
        );
    }

    public function GetDataEmail($id)
    {
        $survey = AwarenessSurvey::where('id', $id)->get();
        $user_survey = SurveyQuestion::where('survey_id', $id)->get();
        $draftorsend = AnswerQuestionSurvey::whereIn('question_id', $user_survey->pluck('id'))
            ->where('user_id', auth()->user()->id)
            ->select('draft', 'user_id')
            ->get();

        // the return of draftorsend to check the user can complete exam or he finish it
        $draftStatus = 0;

        if ($draftorsend->isEmpty()) {
            $draftStatus = 0;
        } elseif ($draftorsend->contains('draft', 0)) {
            $draftStatus = 1;
        } elseif ($draftorsend->contains('draft', 1)) {
            $draftStatus = 2;
        }
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Survey')]
        ];
        return view("admin.content.awareness_survey.detailSurvey", compact('survey', 'breadcrumbs', 'user_survey', 'draftStatus'));
    }


    public function GetDataSurvey(Request $request)
    {


        if ($request->ajax()) {
            $userId = auth()->user()->id;
            $query = DB::table('awareness_surveys')
                ->join('user_to_teams', DB::raw('FIND_IN_SET(user_to_teams.team_id, REPLACE(awareness_surveys.team, " ", ""))'), '>', DB::raw('0'))
                ->where('user_id', $userId)
                ->whereIn('filter_status', [3]);

            if (auth()->user()->role_id == 2) {
                return DataTables::of($query)
                    ->addColumn('action', 'admin.content.awareness_survey.actions2')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            } else {
                return DataTables::of(AwarenessSurvey::query())
                    ->addColumn('action', 'admin.content.awareness_survey.actions2')
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
        }
        $statuses = DocumentStatus::all();
        $teams = Team::all();
        $privacies = Privacy::all();
        $survey = AwarenessSurvey::all();
        $survey_id = AwarenessSurvey::where('owner_id', auth()->user()->id)
            ->select('owner_id')
            ->pluck('owner_id');
        $enabledUsers = User::where('enabled', true)
            ->where('id', '!=', auth()->user()->id)
            ->with('manager:id,name,manager_id')
            ->get();
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Survey')]
        ];
        $questions = SurveyQuestion::all();
        return view(
            'admin.content.awareness_survey.survey',
            compact('breadcrumbs', 'enabledUsers', 'teams', 'survey', 'statuses', 'privacies', 'questions', 'survey_id')
        );
    }

    // to delete the survey
    public function surveyDelete($id)
    {
        $questions_id = SurveyQuestion::where('survey_id', $id)->pluck('survey_id');
        if ($questions_id->count() == 0) {
            $survey = AwarenessSurvey::query()->find($id);
            $survey->delete();
            DB::commit();
            event(new SurveyDeleted($survey));
            $message = __('survey.A Survey with name') . ' "' . ($survey->name ?? __('locale.[No Name]')) . '" ' . __('locale.and the Description of it is') . ' "' . ($survey->description ?? __('locale.[No Description]')) . '". ' . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
            write_log($survey->id, auth()->id(), $message, 'deleting survey');
            return response()->json(['status' => true]);
        } else {
            $response = array(
                'status' => false,
                'errors' => [],
                'message' => '',
            );
            return response()->json($response);
        }
    }
    // public function ajaxExport(Request $request)
    // {
    //     if ($request->type != 'pdf')
    //         return Excel::download(new SecurityAwarenessesExport, 'Security_awarenesses.xlsx');
    //     else
    //         return 'Security_awarenesses.pdf';
    // }


    public function notificationsSettingsawareness()
    {
        // defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.awarness_survey.GetDataSurvey'), 'name' => __('locale.Survey')],
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [4, 5, 6];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [70];  // defining ids of actions modules
        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            4 => ['Name', 'Privacy', 'Created_By', 'Description', 'Additional_Stakeholder', 'Status', 'Teams'],
            5 => ['Name', 'Privacy', 'Created_By', 'Description', 'Additional_Stakeholder', 'Status', 'Teams', 'Reviewer'],
            6 => ['Name', 'Privacy', 'Created_By', 'Description', 'Additional_Stakeholder', 'Status', 'Teams', 'Reviewer'],
            70 => ['Name', 'Privacy', 'Created_By', 'Description', 'Additional_Stakeholder', 'Status', 'Teams', 'Reviewer','Next_Review_Date'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            4 => ['creator' => __('locale.SurveyCreator'), 'Team-teams' => __('locale.TeamsOfSurvey'), 'Stakeholder-teams' => __('locale.StakeholderOfSurvey')],
            5 => ['creator' => __('locale.SurveyCreator'), 'Team-teams' => __('locale.TeamsOfSurvey'), 'Stakeholder-teams' => __('locale.StakeholderOfSurvey'), 'reviewers-teams' => __('locale.ReviewersOfSurvey')],
            6 => ['creator' => __('locale.SurveyCreator'), 'Team-teams' => __('locale.TeamsOfSurvey'), 'Stakeholder-teams' => __('locale.StakeholderOfSurvey'), 'reviewers-teams' => __('locale.ReviewersOfSurvey')],
            70 => ['creator' => __('locale.SurveyCreator'), 'Team-teams' => __('locale.TeamsOfSurvey'), 'Stakeholder-teams' => __('locale.StakeholderOfSurvey'), 'reviewers-teams' => __('locale.ReviewersOfSurvey')],
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
