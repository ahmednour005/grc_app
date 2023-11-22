<?php

namespace App\Http\Controllers\admin\security_awareness;

use App\Http\Controllers\Controller;
use App\Models\SecurityAwareness;
use App\Models\SecurityAwarenessExamAnswer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SecurityAwarenessExamController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $securityAwareness = SecurityAwareness::find($request->id);

        if ($securityAwareness->owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        $rules = [
            'questions' => ['required', 'array'],
            'questions.*.question' => ['required', 'string'],
            'questions.*.answer' => ['required', Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'questions.*.option_A' => ['required', 'string'],
            'questions.*.option_B' => ['required', 'string'],
            'questions.*.option_C' => ['required', 'string'],
            'questions.*.option_D' => ['required', 'string'],
            'questions.*.option_E' => ['required', 'string'],
        ];

        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('securityAwareness.ThereWasAProblemAddingTheSecurityAwarenessExam')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            DB::beginTransaction();

            try {
                if (!is_null($securityAwareness->exam)) { // Exam already founded
                    $response = array(
                        'status' => false,
                        'errors' => [],
                        'message' => __('securityAwareness.SecurityAwarenessExamAlreadyExists'),
                    );

                    return response()->json($response, 200);
                } else {
                    $securityAwarenessExam = $securityAwareness->exam()->create(); // create exam for security awareness

                    foreach ($request->questions as $question) {
                        $securityAwarenessExam->questions()->create([
                            'question' => $question['question'],
                            'option_a' => $question['option_A'],
                            'option_b' => $question['option_B'],
                            'option_c' => $question['option_C'],
                            'option_d' => $question['option_D'],
                            'option_e' => $question['option_E'],
                            'answer' => $question['answer'],
                        ]);
                    }

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'reload' => true,
                        'message' => __('securityAwareness.SecurityAwarenessExamWasAddedSuccessfully'),
                    );
                    return response()->json($response, 200);
                }
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => __('locale.Error'),
                    // 'message' => $th->getMessage(),
                );
                return response()->json($response, 502);
            }
        }
    }

    /**
     * Get specified resource data for viewing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGet($id)
    {
        $securityAwareness = SecurityAwareness::find($id);

        if ($securityAwareness->owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness) {
            $data = $securityAwareness->exam->questions->toArray();

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
     * Get for edit the specified resource in storage.
     *
     *  * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetEdit(Request $request, $id)
    {
        $securityAwareness = SecurityAwareness::find($id);

        if ($securityAwareness->owner != auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness) {
            $data['id'] = $securityAwareness->id;
            $data['title'] = $securityAwareness->title;
            $data['description'] = $securityAwareness->description;
            $data['team_ids'] = ($securityAwareness->team_ids) ? explode(',', $securityAwareness->team_ids) : [];
            $data['additional_stakeholders'] = ($securityAwareness->additional_stakeholders)
                ? explode(',', $securityAwareness->additional_stakeholders) : [];
            $data['privacy'] = $securityAwareness->privacy;
            $data['status'] = $securityAwareness->status;
            $data['file_id'] = $securityAwareness->file_id;
            $data['last_review_date'] = $securityAwareness->last_review_date;
            $data['review_frequency'] = $securityAwareness->review_frequency;
            $data['next_review_date'] = $securityAwareness->next_review_date;
            $data['approval_date'] = $securityAwareness->approval_date;
            $data['owner'] = $securityAwareness->owner;
            $data['reviewer'] = $securityAwareness->reviewer;
            $data['opened'] = $securityAwareness->opened ? true : false;

            $notes = $securityAwareness->notes->map(function ($note) {
                return [
                    'type' => 't',
                    'note' => $note->note,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user->name,
                    'custom_user_name' => getFirstChartacterOfEachWord($note->user->name, 2),
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $noteFiles = $securityAwareness->note_files->map(function ($noteFile) {
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
     * Get specified resource data for take exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTakeExam($id)
    {
        $securityAwareness = SecurityAwareness::find($id);

        if (
            is_null($securityAwareness->exam) ||
            (auth()->id() == $securityAwareness->owner) ||
            $securityAwareness->status != 3 /*Approved*/
        ) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness->exam->answers()->where('examinee', auth()->id())->exists()) {
            $answer = $securityAwareness->exam->answers()->where('examinee', auth()->id())->first();
            $answer->uniqid = null;
            $answer->save();
            $response = array(
                'status' => false,
                'message' => __('securityAwareness.SecurityAwarenessExamAlreadyAnsweredBefore'),
            );
            return response()->json($response, 403);
        }

        if ($securityAwareness) {
            $data = $securityAwareness->exam->questions()->select(
                'id',
                'security_awareness_exams_id',
                'question',
                'option_a',
                'option_b',
                'option_c',
                'option_d',
                'option_e'
            )->get()->toArray();
            $securityAwarenessExamAnswer = $securityAwareness->exam->answers()->create([
                'examinee' => auth()->id(),
                'uniqid' => uniqid(),
                'success_answers' => 0,
                'fail_answers' => $securityAwareness->exam->questions()->count()
            ]); // create exam answer for security awareness

            $uniqid = $securityAwarenessExamAnswer->uniqid;

            $response = array(
                'status' => true,
                'data' => $data,
                'uniqid' => $uniqid
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
     * Store a newly created resource for user that take exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function takeExam(Request $request)
    {
        $securityAwareness = SecurityAwareness::find($request->id);

        if ($securityAwareness->owner == auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness->exam->answers()->whereNull('uniqid')->where('examinee', auth()->id())->exists()) {
            $response = array(
                'status' => false,
                'message' => __('securityAwareness.SecurityAwarenessExamAlreadyAnsweredBefore'),
            );
            return response()->json($response, 403);
        }

        if ($securityAwareness) {

            $rules = [
                'questions' => ['required', 'array'],
                'questions.*.id' => ['exists:security_awareness_exam_questions,id'],
                'questions.*.answer' => ['required', Rule::in(['A', 'B', 'C', 'D', 'E'])],
            ];

            // Validation rules
            $validator = Validator::make($request->all(), $rules);

            // Check if there is any validation errors
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $response = array(
                    'status' => false,
                    'errors' => $errors,
                    'message' => __('securityAwareness.ThereWasAProblemAddingTheSecurityAwarenessExam')
                        . "<br>" . __('locale.Validation error'),
                );
                return response()->json($response, 422);
            } else {
                DB::beginTransaction();

                try {
                    $successCount = 0;
                    $failCount = 0;

                    $securityAwarenessExamAnswers =
                        $securityAwareness->exam->questions()->pluck('answer', 'id')->toarray();
                    $securityAwarenessExamUserAnswers = [];
                    foreach ($request->questions as $question) {
                        $securityAwarenessExamUserAnswers[$question['id']] = $question['answer'];
                    }

                    foreach ($securityAwarenessExamAnswers as $questionId => $answer) {
                        if ($securityAwarenessExamUserAnswers[$questionId] == $answer)
                            $successCount++;
                        else
                            $failCount++;
                    }

                    $securityAwarenessExamAnswer = $securityAwareness->exam->answers()->where(
                        'uniqid',
                        $request->uniqid
                    )->where('examinee', auth()->id())->first();

                    if ($securityAwarenessExamAnswer) {
                        $securityAwarenessExamAnswer->update([
                            'examinee' => auth()->id(),
                            'success_answers' => $successCount,
                            'fail_answers' => $failCount,
                        ]); // create exam answer for security awareness

                        $securityAwarenessExamAnswer->uniqid = null;
                        $securityAwarenessExamAnswer->save();
                    } else {
                        $securityAwarenessExamAnswer = $securityAwareness->exam->answers()->where(
                            'examinee',
                            auth()->id()
                        )->first();
                        $securityAwarenessExamAnswer->uniqid = null;
                        $securityAwarenessExamAnswer->save();
                    }

                    DB::commit();

                    $response = array(
                        'status' => true,
                        'result' => [
                            'success_answers' => $successCount,
                            'fail_answers' => $failCount,
                            'total' => $successCount + $failCount,
                            'message' => __(
                                'securityAwareness.YourSecurityAwarenessExamResult',
                                ['pass' => $successCount, 'fail' => $failCount, 'total' => $successCount + $failCount]
                            )
                        ],
                        'reload' => true,
                        'message' => __('securityAwareness.SecurityAwarenessExamWasAddedSuccessfully'),
                    );
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
        } else {
            $response = array(
                'status' => false,
                'message' => __('locale.Error 404'),
            );
            return response()->json($response, 404);
        }
    }

    /**
     * Get specified resource data for viewing exam resut.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showExamRsult($id)
    {
        $securityAwareness = SecurityAwareness::find($id);

        if ($securityAwareness->owner == auth()->id()) {
            $response = array(
                'status' => false,
                'message' => __('locale.YouDonotHavePermissionToDoThat'),
            );
            return response()->json($response, 401);
        }

        if ($securityAwareness) {

            if (!$securityAwareness->exam->answers()->where('examinee', auth()->id())->exists()) {
                $response = array(
                    'status' => false,
                    'message' => __('securityAwareness.SecurityAwarenessExamIsnotAnsweredBefore'),
                );
                return response()->json($response, 401);
            }

            $answer = $securityAwareness->exam->answers()->where('examinee', auth()->id())->first();

            $response = array(
                'status' => true,
                'result' => [
                    'success_answers' => $answer->success_answers,
                    'fail_answers' => $answer->fail_answers,
                    'total' => $answer->success_answers + $answer->fail_answers,
                    'message' => __(
                        'securityAwareness.YourSecurityAwarenessExamResult',
                        [
                            'pass' => $answer->success_answers,
                            'fail' => $answer->fail_answers,
                            'total' => $answer->success_answers + $answer->fail_answers
                        ]
                    )
                ],
                'message' => __('securityAwareness.SecurityAwarenessExamWasAddedSuccessfully'),
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
}
