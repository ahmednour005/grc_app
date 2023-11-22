<?php

use App\Http\Controllers\admin\assessment\AnswerController;
use App\Http\Controllers\admin\assessment\AssessmentController;
use App\Http\Controllers\admin\assessment\QuestionController;
use App\Http\Controllers\admin\assessment\QuestionnairController;
use App\Http\Controllers\admin\assessment\QuestionnaireController;
use App\Http\Controllers\admin\assessment\QuestionnaireResultController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin assessment routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Assessments
Route::group(
    [
        'prefix' => 'assessments', // Prefix applied on all `assessment` group routes
        'middleware' => [], // Middlewares applied on all `assessment` group routes
        'as' => 'assessment.'
    ],
    function () {
        Route::get('/', [AssessmentController::class, 'index'])->name('index');
        Route::get('notifications-settings', [ AssessmentController::class, 'notificationsSettingsassessments'])
        ->name('notificationsSettingsassessments');

        Route::post('assessment', [AssessmentController::class, 'store'])->name('store');
        Route::put('assessment/{assessment}', [AssessmentController::class, 'update'])->name('update');
        Route::delete('assessments/{id}', [AssessmentController::class, 'destroy'])->name('destroy');
        Route::group(
            [
                'prefix' => 'ajax',
                'middleware' => [],
                'as' => 'ajax.'
            ],
            function () {
                Route::post('assessments/list', [AssessmentController::class, 'ajaxGetList'])->name('index');
                Route::get('assessments', [AssessmentController::class, 'paginatedData'])->name('paginated_data');
                Route::get('assessments/edit/{id}', [AssessmentController::class, 'ajaxGet'])->name('edit');
            }
        );
    }
);

Route::group(
    [
        'prefix' => 'questions',
        'middleware' => [],
        'as' => 'questions.'
    ],
    function () {
        Route::get('notifications-settings-Questions', [ QuestionController::class, 'notificationsSettingsQuestions'])
        ->name('notificationsSettingsQuestions');
        Route::get('questions/list', [QuestionController::class, 'data'])->name('list');
        Route::post('questions', [QuestionController::class, 'store'])->name('store');
        Route::get('questions/edit/{question}', [QuestionController::class, 'edit'])->name('edit');
        Route::put('questions/update/{question}', [QuestionController::class, 'update'])->name('update');
        Route::delete('questions/delete/{question}', [QuestionController::class, 'destroy'])->name('destroy');
        Route::post('questions/import', [QuestionController::class, 'importQuestions'])->name('importQuestions');
        Route::get('fetch_questions_from_assessment', [QuestionController::class, 'fetch_questions_from_assessment'])->name('fetch_questions_from_assessment');
    }
);

Route::group(
    [
        'prefix' => 'questions/{question}',
        'middleware' => [],
        'as' => 'answers.'
    ],
    function () {

        Route::get('answers', [AnswerController::class, 'index'])->name('index');
        Route::get('answers/list', [AnswerController::class, 'data'])->name('list');
        Route::get('answers/create', [AnswerController::class, 'create'])->name('create');
        Route::get('answers/edit/{answer}', [AnswerController::class, 'edit'])->name('edit');
        Route::post('answers', [AnswerController::class, 'store'])->name('store');
        Route::put('answers/{answer}', [AnswerController::class, 'update'])->name('update');
        Route::delete('answers/{answer}', [AnswerController::class, 'destroy'])->name('destroy');
    }
);

Route::group(
    [
        'prefix' => 'questionnaires',
        'middleware' => [],
        'as' => 'questionnaires.',
        'controller' => QuestionnaireController::class,
    ],
    function () {
        Route::get('notifications-settings-questionnaire', [ QuestionnaireController::class, 'notificationsSettingsquestionnaire'])
        ->name('notificationsSettingsquestionnaire');
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{questionnaire}', 'edit')->name('edit');
        Route::put('update/{questionnaire}', 'update')->name('update');
        Route::delete('delete/{questionnaire}', 'destroy')->name('destroy');
        Route::post('send-email', 'sendEmail')->name('sendEmail');
        Route::get('{id}', 'show')->name('view');
        Route::post('/questionnaire/answer', 'answer')->name('answer');
    }
);


Route::group(
    [
        'prefix' => 'questionnaire-results',
        'middleware' => [],
        'as' => 'questionnaire-results.',
        'controller' => QuestionnaireResultController::class,
    ],
    function () {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::delete('delete/{questionnaire-result}', 'destroy')->name('destroy');
        Route::get('{id}', 'show')->name('view');
        Route::get('change-status/{id}/{status}', 'changeStatus')->name('changeStatus');
        Route::post('{risk_id}/change-risk-status', 'changeRiskStatus')->name('changeRiskStatus');

    }
);
