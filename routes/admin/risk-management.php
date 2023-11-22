<?php

use App\Http\Controllers\admin\risk_management\RiskManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin risk-management routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'risk-management', // Prefix applied on all `risk-management` group routes
        'middleware' => [], // Middlewares applied on all `risk-management` group routes
        'as' => 'risk_management.'
    ],
    function () {
        Route::get('/', [RiskManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [RiskManagementController::class, 'show'])->whereNumber('id')->name('show');
        Route::get('notifications-settings', [App\Http\Controllers\admin\risk_management\RiskManagementController::class, 'notificationsSettingsRisk'])
        ->name('notificationsSettingsRisk');
        Route::get('/import', [RiskManagementController::class, 'openImportForm'])->name('import');

        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/download-file', [RiskManagementController::class, 'downloadFile'])->name('download_file');
                Route::delete('/delete-file', [RiskManagementController::class, 'deleteFile'])->name('delete_file');


                Route::post('/accept-reject-mitigation', [RiskManagementController::class, 'acceptOrRejectMitigation'])->name('accept_reject_mitigation');

                Route::post('/update-risk-mitigation', [RiskManagementController::class, 'updateRiskMitigation'])->name('update_risk_mitigation');

                Route::post('/add-risk-review', [RiskManagementController::class, 'addRiskReview'])->name('add_risk_review');

                Route::put('/risk-close-reason', [RiskManagementController::class, 'riskCloseReason'])->name('risk_close_reason');

                Route::put('/risk-reopen', [RiskManagementController::class, 'riskReopen'])->name('risk_reopen');

                Route::put('/risk-change-status', [RiskManagementController::class, 'riskChangeStatus'])->name('risk_Change_Status');

                Route::put('/reset-risk-mitigations', [RiskManagementController::class, 'resetRiskMitigations'])->name('reset_risk_mitigations');

                Route::put('/reset-risk-reviews', [RiskManagementController::class, 'resetRiskReviews'])->name('reset_risk_reviews');

                Route::post('/list', [RiskManagementController::class, 'ajaxGetList'])->name('index');
                Route::post('/', [RiskManagementController::class, 'store'])->name('store');

                Route::get('/risk-levels', [RiskManagementController::class, 'getRiskLevels'])->name('get_risk_levels');
                Route::get('/residual-scoring-history/{id}', [RiskManagementController::class, 'residualScoringHistory'])->name('residual_scoring_history');
                Route::get('/scoring-history/{id}', [RiskManagementController::class, 'scoringHistory'])->name('get_scoring_histories');

                // Route::get('edit/{id}', [RiskManagementController::class, 'ajaxGet'])->name('show');
                Route::put('/update-subject', [RiskManagementController::class, 'updateRiskSubject'])->name('update_subject');
                Route::put('/update-risk-scoring', [RiskManagementController::class, 'updateRiskScoring'])->name('update_risk_scoring');
                Route::put('/add-comment', [RiskManagementController::class, 'addRiskComment'])->name('add_comment');
                Route::put('/details', [RiskManagementController::class, 'update'])->name('update');
                Route::delete('/{id}', [RiskManagementController::class, 'destroy'])->name('destroy');

                Route::post('/export', [RiskManagementController::class, 'ajaxExport'])->name('export');
                Route::Post('/import-data', [RiskManagementController::class, 'importData'])->name('importData');

            }
        );
    }
);
