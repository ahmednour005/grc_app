<?php

use App\Http\Controllers\admin\hierarchy\DepartmentController;
use App\Http\Controllers\admin\hierarchy\EmployeeController;
use App\Http\Controllers\admin\hierarchy\HierarchyController;
use App\Http\Controllers\admin\hierarchy\JobController;
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
        'prefix' => 'hierarchy', // Prefix applied on all `hierarchy` group routes
        'middleware' => [], // Middlewares applied on all `hierarchy` group routes
        'as' => 'hierarchy.'
    ],
    function () {
        Route::get('/', [HierarchyController::class, 'index'])->name('index');
        Route::get('/org-chart', [HierarchyController::class, 'orgChart'])->name('org_chart');
        Route::get('/get-org-chart', [HierarchyController::class, 'getOrgChart'])->name('get_org_chart');
        Route::get('notifications-settings', [HierarchyController::class, 'notificationsSettingsMovingDepartement'])
        ->name('notificationsSettingsMovingDepartement');

        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::get('/', [HierarchyController::class, 'ajaxGetList'])->name('index');
                Route::put('/', [HierarchyController::class, 'dragAndDrop'])->name('drag_and_drop');
            }
        );

        Route::group([
            'prefix' => 'job', // Prefix applied on all `job` group routes
            'as' => 'job.'
        ], function () {
            Route::get('notifications-settings', [JobController::class, 'notificationsSettingsJob'])
            ->name('notificationsSettingsJob');
            Route::get('/', [JobController::class, 'index'])->name('index');
            Route::get('/import', [JobController::class, 'openImportForm'])->name('import');

            Route::group(
                [
                    'prefix' => 'ajax', // Prefix applied on all `department` group routes
                    'middleware' => [], // Middlewares applied on all `department` group routes
                    'as' => 'ajax.'
                ],
                function () {
                    Route::post('/list', [JobController::class, 'ajaxGetList'])->name('index');
                    Route::post('/', [JobController::class, 'store'])->name('store');
                    Route::get('show/{id}', [JobController::class, 'ajaxGet'])->name('show');
                    Route::get('edit/{id}', [JobController::class, 'ajaxGet'])->name('edit');
                    Route::put('/{id}', [JobController::class, 'update'])->name('update');
                    Route::delete('/{id}', [JobController::class, 'destroy'])->name('destroy');
                    Route::post('/export', [JobController::class, 'ajaxExport'])->name('export');
                    Route::Post('/import-data', [JobController::class, 'importData'])->name('importData');
                    // Route::post('/import', [JobController::class, 'ajaxImport'])->name('import');
                    // Route::post('/import/template', [JobController::class, 'downloadImportTemplate'])->name('import.template');
                }
            );
        });

        Route::group([
            'prefix' => 'department', // Prefix applied on all `department` group routes
            'as' => 'department.'
        ], function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('index');
            Route::get('notifications-settings', [DepartmentController::class, 'notificationsSettingsDepartement'])
            ->name('notificationsSettingsDepartement');
            Route::get('/import', [DepartmentController::class, 'openImportForm'])->name('import');

            Route::group(
                [
                    'prefix' => 'ajax', // Prefix applied on all `department` group routes
                    'middleware' => [], // Middlewares applied on all `department` group routes
                    'as' => 'ajax.'
                ],
                function () {
                    Route::post('/list', [DepartmentController::class, 'ajaxGetList'])->name('index');
                    Route::post('/', [DepartmentController::class, 'store'])->name('store');
                    Route::get('show/{id}', [DepartmentController::class, 'ajaxGet'])->name('show');
                    Route::get('edit/{id}', [DepartmentController::class, 'ajaxGet'])->name('edit');
                    Route::put('/{id}', [DepartmentController::class, 'update'])->name('update');
                    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy');
                    Route::post('/export', [DepartmentController::class, 'ajaxExport'])->name('export');
                    Route::Post('/import-data', [DepartmentController::class, 'importData'])->name('importData');

                }
            );
        });

        Route::group([
            'prefix' => 'employee', // Prefix applied on all `employee` group routes
            'as' => 'employee.'
        ], function () {
            // Route::get('/', [EmployeeController::class, 'index'])->name('index');
        });
    }
);
