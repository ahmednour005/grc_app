<?php

use App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController;
use App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController;
use App\Http\Controllers\admin\security_awareness\SurveyQuestionController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin security-awareness routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Route::group(['prefix' => 'awarness-survey', 'middleware' => 'auth'], function() {
//     RRoute::get('GetDataSurveyQuestion/{id}', [App\Http\Controllers\admin\security_awareness\SurveyQuestionController::class, 'GetDataSurveyQuestion'])->name('GetDataSurveyQuestion');
// });

Route::group(['prefix' => 'awarness-survey', 'middleware' => 'auth','as' => 'awarness_survey.'
 ], function () {
    Route::get('/survey', [App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController::class, 'GetDataSurvey'])
    ->name('GetDataSurvey');
    // to questions
    Route::resource('SurveyQuestion', 'App\Http\Controllers\admin\security_awareness\SurveyQuestionController');
    // to delete survey
    Route::get('surveyDelete/{id}', [App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController::class, 'surveyDelete'])
        ->name('awarness-survey.surveyDelete');
    // to edit survey 
    Route::get('EditSurvey/{id}', [App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController::class, 'editmodal'])
        ->name('editmodal');
    // send mail of survey 
    Route::POSt('SendSurveyMail/{id}', [App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController::class, 'sendMail'])
        ->name('awarness-survey.sendMail');
    // to get mail contain data survey
    Route::get('GetSurveyEmail/{id}', [App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController::class, 'GetDataEmail'])
        ->name('awarness-survey.GetDataEmail');
    // to edit or store survey 
    Route::resource('surveyManagement', 'App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController');
    // to get questions of survey
    Route::get('Question/{id}', [App\Http\Controllers\admin\security_awareness\SurveyQuestionController::class, 'GetDataSurveyQuestion'])->name('GetDataSurveyQuestion');
    // to delet question of survey 
    Route::get('SurveyquestionDelete/{id}', [App\Http\Controllers\admin\security_awareness\SurveyQuestionController::class, 'questionDelete'])->name('questionDelete');
    // to Edit  questions of survey
    Route::get('questionEdit/{id}', [App\Http\Controllers\admin\security_awareness\SurveyQuestionController::class, 'questionEdit'])->name('questionEdit');
    // route of all answers
    Route::resource('AnswersQuestionsSurvey', 'App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController');
    // the bar of answer questions 
    // Route::post('/checkbox-submit', [App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController::class, 'checkboxSubmit'])->name('checkbox.submit');
    //get the eaxam of survey
    Route::get('GetExam/{id}', [App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController::class, 'GetExam'])->name('GetExam');
    //to get notification setting 
    Route::get('notifications-settings', [App\Http\Controllers\admin\security_awareness\Security_awareness_surveyController::class, 'notificationsSettingsawareness'])
        ->name('notificationsSettingsawareness');
        Route::post('/export', [Security_awareness_surveyController::class, 'ajaxExport'])->name('export');

});
Route::group(['prefix' => 'awarness-survey','as' => 'awarness_survey.'], function () {
    Route::get('Examoutside/{id}', [App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController::class, 'Examoutside'])->name('Examoutside')->withoutMiddleware('auth');
    // the bar of answer questions 
    Route::post('/checkbox-submit', [App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController::class, 'checkboxSubmit'])->name('checkbox.submit')->withoutMiddleware('auth');
    Route::post('/svaeoutside', [App\Http\Controllers\admin\security_awareness\AnswerQuestionSurveyController::class, 'SaveOutSideAnswer'])->name('svaeoutside')->withoutMiddleware('auth');
});
