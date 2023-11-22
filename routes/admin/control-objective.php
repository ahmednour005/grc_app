<?php

use App\Http\Controllers\admin\control_objective\ControlObjectiveController;
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

Route::group(
    [
        'prefix' => 'control-objectives', // Prefix applied on all `control-objectives` group routes
        'middleware' => [], // Middlewares applied on all `control-objectives` group routes
        'as' => 'control_objectives.'
    ],
    function () {

        Route::get('/', [ControlObjectiveController::class, 'index'])->name('index');
        Route::get('notifications-settings', [ControlObjectiveController::class, 'notificationsSettingsobjective'])
        ->name('notificationsSettingsobjective');
        Route::get('/import', [ControlObjectiveController::class, 'openImportForm'])->name('import');

        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/list', [ControlObjectiveController::class, 'ajaxGetList'])->name('index');
                Route::post('/', [ControlObjectiveController::class, 'store'])->name('store');
                Route::get('show/{id}', [ControlObjectiveController::class, 'ajaxGet'])->name('show');
                Route::get('edit/{id}', [ControlObjectiveController::class, 'ajaxGet'])->name('edit');
                Route::put('/{id}', [ControlObjectiveController::class, 'update'])->name('update');
                Route::delete('/{id}', [ControlObjectiveController::class, 'destroy'])->name('destroy');
                Route::post('/export', [ControlObjectiveController::class, 'ajaxExport'])->name('export');
                // Route::post('/import', [ControlObjectiveController::class, 'ajaxImport'])->name('import');
                // Route::post('/import/template', [ControlObjectiveController::class, 'downloadImportTemplate'])->name('import.template');
                Route::Post('/import-data', [ControlObjectiveController::class, 'importData'])->name('importData');

            }
        );
    }
);
