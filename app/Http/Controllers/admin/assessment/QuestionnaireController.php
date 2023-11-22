<?php

namespace App\Http\Controllers\admin\assessment;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireRequest;
use App\Mail\SendEmailToQuestionnaireContact;
use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\Asset;
use App\Models\ContactQuestionnaireAnswer;
use App\Models\ContactQuestionnaireAnswerResult;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireRisk;
use App\Traits\UpoladFileTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Events\QuestionnaireCreated;
use App\Events\QuestionnaireUpdated;
use App\Events\QuestionnaireDeleted;
use App\Models\User;
use App\Models\Action;

class QuestionnaireController extends Controller
{
    use UpoladFileTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assessments = Assessment::query()->with('questions:id,question')->select('name', 'id')->latest('id')->get();
        $users = DB::table('users')->select('id', 'username')->get();
        return view('admin.content.assessment.questionnaires.index', ['assessments' => $assessments, 'users' => $users]);
    }

    /**
     * @return JsonResponse
     */
    public function data(): \Illuminate\Http\JsonResponse
    {
        $questionnaires = Questionnaire::query()->with('assessment:id,name', 'contacts:id,name')->select(['id', 'name', 'assessment_id'])->latest('id');
    
        return DataTables::eloquent($questionnaires)
            ->addIndexColumn()
            ->skipTotalRecords()
            ->addColumn('actions', function ($questionnaire) {
                // Check if contacts id matches the authenticated user's id
                if ($questionnaire->contacts->contains('id', auth()->user()->id) || auth()->user()->hasPermission('assessment.create')) {
                    // Initialize an empty string to hold the dropdown menu items
                    $dropdownItems = '';
    
                    // Check for 'assessment.Edit' permission
                    if (auth()->user()->hasPermission('assessment.Edit')) {
                        $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item btn-flat-warning edit_questionnaire_btn"
                                            data-url="' . route('admin.questionnaires.edit', $questionnaire->id) . '"
                                            data-id="' . $questionnaire->id . '">
                                            <i class="fa fa-edit fa-sm"></i> ' . __('locale.Edit') . '
                                        </a>';
                    }
    
                    // Check for 'assessment.Delete' permission
                    if (auth()->user()->hasPermission('assessment.Delete')) {
                        $dropdownItems .= '<a href="' . route('admin.answers.index', $questionnaire->id) . '"
                                            class="dropdown-item btn-flat-danger delete_questionnaires_btn"
                                            data-id="' . $questionnaire->id . '"
                                            data-url="' . route('admin.questionnaires.destroy', $questionnaire->id) . '">
                                            <i class="fa fa-close fa-sm"></i> ' . __('locale.Delete') . '
                                        </a>';
                    }
    
                    // Check for 'assessment.Send' permission
                    if (auth()->user()->hasPermission('assessment.Send')) {
                        $dropdownItems .= '<a href="javascript:void(0)" class="dropdown-item btn-flat-secondary send_email_btn"
                                            data-id="' . $questionnaire->id . '"
                                            data-url="' . route('admin.questionnaires.sendEmail') . '">
                                            <i class="fa fa-paper-plane fa-sm"></i> ' . __('locale.Send') . '
                                        </a>';
                    }
    
                    // Check for 'assessment.showOption' permission
                    $showOptionDropdown = auth()->user()->hasPermission('assessment.showOption');
    
                    // Return the HTML content for the dropdown menu
                    return '<div class="d-inline-flex">' . ($showOptionDropdown ? '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown" aria-expanded="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-more-vertical font-small-4">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="12" cy="5" r="1"></circle>
                                            <circle cx="12" cy="19" r="1"></circle>
                                        </svg>
                                    </a>' : '') . '
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        ' . $dropdownItems . '
                                    </div>
                                </div>';
                } else {
                    // Return an empty string for the "actions" column
                    return '';
                }
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
    



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionnaireRequest $request)
    {
        $basic_data = $request->safe()->except(['contacts', 'questions']);


        $questions = $request->questions ?? [];
        $contacts = $request->contacts ?? [];
        try {
            DB::beginTransaction();
            $questionnaire = Questionnaire::query()->create($basic_data);
            $questionnaire->contacts()->attach($contacts);
            $questionnaire->questions()->attach($questions);
            DB::commit();
            event(new QuestionnaireCreated($questionnaire));
            $message = __('assessment.A questionnaire Added with name') . ' "' . ($questionnaire->name ?? __('locale.[No Name]')) . '" '
                . __('assessment.and the instruction is') . ' "' . ($questionnaire->instructions ?? __('locale.[No Instructions]')) . '" '
                . __('assessment.and the assessment is') . ' "' . ($questionnaire->assessment->name ?? __('locale.[No Assessment]')) . '" '
                . __('assessment.and the contact is') . ' "' . (implode(", ", $questionnaire->contacts()->pluck('users.name')->toArray()) ?? __('locale.[No Contacts]')) . '" '
                . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User]') . '".';
            write_log(1, auth()->id(), $message, 'Creating questionnaire');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $id = decrypt($id);
        } catch (\Exception $exception) {
            abort(403);
        }
        if (!in_array($id, auth()->user()->questionnaires->pluck('id')->toArray())) {
            abort(403);
        }


        $questionnaire = Questionnaire::query()->with(['latestAnswers.results', 'assessment.questions.answers'])->findOrFail($id);

        $assets = Asset::query()->get(['id', 'name']);

        return view('admin.content.assessment.questionnaires.answer', compact('questionnaire', 'assets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $questionnaire = Questionnaire::query()->find($id);
        $questionnaire->load('assessment:id', 'contacts:id', 'questions');
        return response()->json($questionnaire);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionnaireRequest $request, Questionnaire $questionnaire)
    {


        $basic_data = $request->safe()->except(['contacts', 'questions']);
        $questions = $request->questions ?? [];
        $contacts = $request->contacts ?? [];

        $basic_data['answer_percentage'] = $request->answer_percentage ?? 0;
        $basic_data['percentage_number'] = $request->percentage_number ?? '';
        $basic_data['specific_mandatory_questions'] = $request->specific_mandatory_questions ?? 0;
        $basic_data['all_questions_mandatory'] = $request->all_questions_mandatory ?? 0;


        try {
            DB::beginTransaction();
            $questionnaire->update($basic_data);
            $questionnaire->contacts()->sync($contacts);
            if ($questions != null) {
                $questionnaire->questions()->sync($questions);
            } else {
                $questionnaire->questions()->detach();
            }

            DB::commit();
            event(new QuestionnaireUpdated($questionnaire));
            $message = __('assessment.A questionnaire with name') . ' "' . ($questionnaire->name ?? __('locale.[No Name]')) . '" ' . __('locale.UpdatedBy') . ' "' . (auth()->user()->name ?? '[No User]') . '".';
            write_log(1, auth()->id(), $message, 'Updating questionnaire');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questionnaire = Questionnaire::query()->find($id);
        $contacts = $questionnaire->contacts()->get(); // Fetch the contacts before detachment and deletion
        $questionnaire->questions()->detach();
        $questionnaire->contacts()->detach();
        $questionnaire->delete();
        DB::commit();
        event(new QuestionnaireDeleted($questionnaire, $contacts));
        $message = __('assessment.A questionnaire with name') . ' "' . ($questionnaire->name ?? __('locale.[No Name]')) . '" ' . __('locale.DeletedBy') . ' "' . (auth()->user()->name ?? '[No User]') . '".';
        write_log(1, auth()->id(), $message, 'deleting questionnaire');
    }

    public function sendEmail(Request $request)
    {

        $request->validate([
            'questionnaire_id' => ['required', 'exists:questionnaires,id']
        ]);
        $questionnaire = Questionnaire::query()->with('contacts:id,email,name')->find($request->questionnaire_id);


        if (!empty($questionnaire->assessment->questions)) {
            $UnAnsweredQuestionsCount = Question::query()->where('answer_type', '!=', 3)->whereDoesntHave('answers')->whereIn('id', $questionnaire->assessment->questions->pluck('id')->toArray())->count();
            if ($UnAnsweredQuestionsCount > 0) {
                return response()->json('Be Sure That All Questions Have At Least One Answer', 400);
                // return response()->json(__('assessment.Be Sure That All Questions Have At Least One Answer'), 400);

            }
        }

        foreach ($questionnaire->contacts as $contact) {
            ContactQuestionnaireAnswer::query()->where([['questionnaire_id', $questionnaire->id], ['contact_id', $contact->id]])->delete();
            ContactQuestionnaireAnswer::query()->create([
                'questionnaire_id' => $questionnaire->id,
                'contact_id' => $contact->id,
            ]);
        }
        $questionnaire_contacts = $questionnaire->contacts;
        /*dispatch(new SendEmailToContacts($questionnaire_contacts_emails, $questionnaire));*/


        foreach ($questionnaire_contacts as $questionnaire_contact) {

            Mail::to($questionnaire_contact->email)->send(new SendEmailToQuestionnaireContact($questionnaire, $questionnaire_contact));
        }
    }

    public function answer(Request $request)
    {


        $rules = [
            'contact_id' => ['required', 'exists:users,id'],
            'questionnaire_id' => ['required', 'exists:questionnaires,id'],
            // 'asset_id' => ['required', 'exists:assets,id'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.answers' => ['required_if:questions.*.question_is_required,=,true'],
            'questions.*.question_is_required' => ['required', 'in:true,false'],
            'questions.*.file' => ['sometimes', 'nullable', 'file', 'max:12288'],
            'questions.*.comment' => ['sometimes', 'nullable', 'max:1000']

        ];

        $answers_count = 0;

        foreach (request()->questions as $question) {
            if (array_key_exists('answers', $question) && $question['answers'] != null) {
                $answers_count++;
            }
        }


        $answer_percentage = ceil(($answers_count / count(request()->questions)) * 100);


        if (request()->answer_percentage == 1) {
            if ($answer_percentage < request('percentage_number')) {

                $rules['answer_percentage'] = ['required', 'gte: ' . request('percentage_number') . ' %'];
            }
        }

        if ($request->submission_type != 'draft') {
            $validator = Validator::make(
                $request->all(),
                $rules,
                [
                    'questions.*.answers.required_if' => 'Please answer all questions with [*] sign.'
                ],
                [
                    'questions.*.answers' => 'The Answer field'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('errors', $validator->errors()->all());
            }
        }


        $contact_questionnaire_answers_complete = ContactQuestionnaireAnswer::query()->where('contact_id', $request->contact_id)->where('questionnaire_id', $request->questionnaire_id)->where('submission_type', 'complete')->exists();
        if ($contact_questionnaire_answers_complete) {
            return redirect()->back()->with('error', 'you  have answered this questionnaire before !');
        }

        $questionnaire_answer = ContactQuestionnaireAnswer::query()->where([['questionnaire_id', $request->questionnaire_id], ['contact_id', $request->contact_id]])->latest()->first();

        $status = $request->submission_type == 'complete' ? 'complete' : "incomplete";


        $basic_data = $request->only(['asset_name', 'questionnaire_id', 'contact_id', 'asset_id', 'submission_type']);
        $basic_data['percentage_complete'] = $answer_percentage;
        $basic_data['status'] = $status;


        $preparedData = [];
        $RiskAnswers = [];
        foreach ($request->questions as $question) {


            // get all  answers which raise a risk
            if ($question['answer_type'] != 3) {
                if (isset($question['answers'])) {
                    if (is_array($question['answers'])) {
                        foreach ($question['answers'] as $answer_id) {
                            $answer = AssessmentAnswer::query()->whereSubmitRisk(1)->where('id', $answer_id)->first();
                            if ($answer != null) {
                                $RiskAnswers[] = $answer;
                            }
                        }
                    } else {
                        $answer = AssessmentAnswer::query()->whereSubmitRisk(1)->where('id', $question['answers'])->first();
                        if ($answer != null) {
                            $RiskAnswers[] = $answer;
                        }
                    }
                }
            }

            // prepare  questions data
            $question = [
                'contact_questionnaire_answer_id' => '',
                'answer_type' => $question['answer_type'],
                'question_id' => $question['question_id'],
                'answer_id' => is_array(@$question['answers']) || $question['answer_type'] == 3 ? null : @$question['answers'],
                'answer' => (is_array(@$question['answers'])) ? implode(',', @$question['answers']) : ($question['answer_type'] == 3 ? @$question['answers'] : ""),
                'file' => (isset($question['file']) && is_file($question['file'])) ? $this->storeFile($question['file'], 'images/questionnaire_results') : null,
                'comment' => @$question['comment'],
                'created_at' => now(),
                'updated_at' => now(),
            ];


            array_push($preparedData, $question);
        }


        try {

            $answers_data = [];
            DB::beginTransaction();

            $questionnaire_answer->update($basic_data);

            foreach ($preparedData as $preparedDatum) {
                $preparedDatum['contact_questionnaire_answer_id'] = $questionnaire_answer->id;
                $answers_data[] = $preparedDatum;
            }

            ContactQuestionnaireAnswerResult::query()->where('contact_questionnaire_answer_id', $questionnaire_answer->id)->delete();
            ContactQuestionnaireAnswerResult::query()->insert($answers_data);


            QuestionnaireRisk::query()->whereQuestionnaireId($request->questionnaire_id)->delete();
            // insert answers which arise risk
            foreach ($RiskAnswers as $answer) {
                QuestionnaireRisk::query()->create([
                    'questionnaire_id' => $request->questionnaire_id,
                    'answer_id' => $answer->id,
                    'risk_subject' => $answer->risk_subject,
                    'risk_scoring_method_id' => $answer->risk_scoring_method_id,
                    'likelihood_id' => $answer->likelihood_id,
                    'impact_id' => $answer->impact_id,
                    'owner_id' => $answer->owner_id,
                    'assets_ids' => $answer->assets_ids,
                    'tags_ids' => $answer->tags_ids,
                    'framework_controls_ids' => $answer->framework_controls_ids,
                ]);
            }


            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }

        //return redirect()->to('admin/dashboard')->with('success', 'you  have  answered the questionnaire successfully');
        return redirect()->back()->with('success', 'you  have  answered the questionnaire successfully');
    }
    public function notificationsSettingsquestionnaire()
    {

        //defining the breadcrumbs that will be shown in page
        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['link' => route('admin.questionnaires.index'), 'name' => __('locale.questionnaires')],
            ['name' => __('locale.NotificationsSettings')]
        ];
        $users = User::select('id', 'name')->get();  // getting all users to list them in select input of users
        $moduleActionsIds = [65, 66, 67];   // defining ids of actions modules
        $moduleActionsIdsAutoNotify = [];  // defining ids of actions modules

        // defining variables associated with each action "for the user to choose variables he wants to add to the message of notification" "each action id will be the array key of action's variables list"
        $actionsVariables = [
            65 => ['Name', 'Instructions', 'Assessment', 'Answer_Percentage'],
            66 => ['Name', 'Instructions', 'Assessment', 'Answer_Percentage'],
            67 => ['Name', 'Instructions', 'Assessment', 'Answer_Percentage'],
        ];
        // defining roles associated with each action "for the user to choose roles he wants to sent the notification to" "each action id will be the array key of action's roles list"
        $actionsRoles = [
            65 => ['Questionnaire-contact' => __('assessment.QuestionnaireContact')],
            66 => ['Questionnaire-contact' => __('assessment.QuestionnaireContact')],
            67 => ['Questionnaire-contact' => __('assessment.QuestionnaireContact')],

        ];
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
}
