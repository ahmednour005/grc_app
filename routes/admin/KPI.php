<?php

use App\Http\Controllers\admin\KPI\KPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin KPI routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'KPI', // Prefix applied on all `KPI` group routes
        'middleware' => [], // Middlewares applied on all `KPI` group routes
        'as' => 'KPI.'
    ],
    function () {
        Route::get('/', [KPIController::class, 'index'])->name('index');
        Route::get('assessment', [KPIController::class, 'listAssessment'])->name('assessment.all');
        Route::get('notifications-settings', [KPIController::class, 'notificationsSettingsKpi'])
        ->name('notificationsSettingsKpi');
        
        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `KPI` group routes
                'middleware' => [], // Middlewares applied on all `KPI` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::get('assessment', [KPIController::class, 'ajaxListAssessment'])->name('assessment.all');
                Route::put('assessment', [KPIController::class, 'setAssessment'])->name('assessment.set');
                Route::post('assessment/initiate/{id}', [KPIController::class, 'initiateAssessment'])->name('assessment.initiate');
                Route::get('assessment/{id}', [KPIController::class, 'KPIAssessment'])->name('assessment.list');

                Route::post('/list', [KPIController::class, 'ajaxGetList'])->name('index');
                Route::post('/', [KPIController::class, 'store'])->name('store');
                Route::get('edit/{id}', [KPIController::class, 'ajaxGet'])->name('edit');
                Route::put('/{id}', [KPIController::class, 'update'])->name('update');
                Route::delete('/{id}', [KPIController::class, 'destroy'])->name('destroy');
                Route::post('/export', [KPIController::class, 'ajaxExport'])->name('export');
            }
        );
    }
);
