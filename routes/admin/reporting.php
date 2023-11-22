<?php

use App\Http\Controllers\admin\reporting\AllOpenrisksReportController;
use App\Http\Controllers\admin\reporting\ObjectiveReportingController;
use App\Http\Controllers\admin\reporting\OverviewReportingController;
use App\Http\Controllers\admin\reporting\riskDashboardReportingController;
use App\Http\Controllers\admin\reporting\controlGapAnalysisReportingController;
use App\Http\Controllers\admin\reporting\LikelihoodImpactReportController;
use App\Http\Controllers\admin\reporting\dynamicRiskReportController;
use App\Http\Controllers\admin\reporting\FrameWorkControllerReportingController;
use App\Http\Controllers\admin\reporting\RiskByControlReportController;
use App\Http\Controllers\admin\reporting\RiskByAssetReportController;
use App\Http\Controllers\admin\reporting\SecurityAwarenessExamController;
use App\Http\Controllers\admin\reporting\awareness_survey_infoController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin reporting routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'reporting', // Prefix applied on all `reporting` group routes
        'middleware' => [], // Middlewares applied on all `reporting` group routes
        'as' => 'reporting.'
    ],
    function () {
        Route::get('/overview', [OverviewReportingController::class, 'overviewReport'])->name('overviewReport');
        Route::get('/risk-dashboard', [riskDashboardReportingController::class, 'riskDashboardReport'])->name('riskDashboardReport');
        Route::get('/control-gap-analysis', [controlGapAnalysisReportingController::class, 'controlGapAnalysis'])->name('controlGapAnalysis');
        Route::get('/display-gap-analysis-table', [controlGapAnalysisReportingController::class, 'displayGapAnalysisTable'])->name('displayGapAnalysisTable');
        Route::get('/likelihood-impact', [LikelihoodImpactReportController::class, 'getRisks'])->name('likelhoodImpactReport');
        Route::post('/likelihood-impact-tooltip', [LikelihoodImpactReportController::class, 'get_tooltip'])->name('likelhoodImpactReportTooltip');
        Route::get('/my-open-risks', [AllOpenrisksReportController::class, 'index'])->name('MyopenRiskReport');
        Route::get('/my-open-risks/list', [AllOpenrisksReportController::class, 'ajaxGetList'])->name('MyopenRiskReport.ajax.index');
        Route::get('/dynamic-risk', [dynamicRiskReportController::class, 'dynamicRiskReport'])->name('dynamicRiskReport');
        Route::get('/get-dynamic-risks', [dynamicRiskReportController::class, 'GetListRisk'])->name('ajax.getDynamicRisks');
        Route::get('/risk-controls', [RiskByControlReportController::class, 'GetRiskByControl'])->name('GetRiskByControl');
        Route::get('/risk-assets', [RiskByAssetReportController::class, 'GetRiskByAsset'])->name('GetRiskByAsset');
        Route::get('/framewrok-control-compliance-status', [FrameWorkControllerReportingController::class, 'framewrokControlComplianceStatus'])->name('framewrok_control_compliance_status');
        Route::post('/framewrok-control-compliance-status-info', [FrameWorkControllerReportingController::class, 'framewrokControlComplianceStatusInfo'])->name('framewrok_control_compliance_status_info');
        Route::get('/summary-of-results-for-evaluation-and-compliance', [FrameWorkControllerReportingController::class, 'summaryOfResultsForEvaluationAndCompliance'])->name('summary_of_results_for_evaluation_and_compliance');
        Route::post('/summary-of-results-for-evaluation-and-compliance-info', [FrameWorkControllerReportingController::class, 'summaryOfResultsForEvaluationAndComplianceInfo'])->name('summary_of_results_for_evaluation_and_compliance_info');
        Route::get('/security-awareness-exam', [SecurityAwarenessExamController::class, 'securityAwarenessExam'])->name('security_awareness_exam');
        Route::post('/security-awareness-exam-info', [SecurityAwarenessExamController::class, 'securityAwarenessExamInfo'])->name('security_awareness_exam_info');
        Route::get('/awareness-survey-info', [awareness_survey_infoController::class, 'AwarenessSurveyInfo'])->name('awareness_survey_info');
        Route::get('/awareness-survey-detail/{id}', [awareness_survey_infoController::class, 'AwarenessSurveyDetail'])->name('awareness_survey_detail');

        Route::get('/objectives', [ObjectiveReportingController::class, 'index'])->name('objectives');
        Route::post('/ajax-list-objectives', [ObjectiveReportingController::class, 'ajaxGetList'])->name('ajax_list_objectives');
    }
);
