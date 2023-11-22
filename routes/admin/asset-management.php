<?php

use App\Http\Controllers\admin\asset_management\AssetManagementController;
use App\Http\Controllers\admin\asset_management\asset\AssetController;
use App\Http\Controllers\admin\asset_management\asset\AssetGroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin asset-management routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'asset-management', // Prefix applied on all `asset-management` group routes
        'middleware' => [], // Middlewares applied on all `asset-management` group routes
        'as' => 'asset_management.'
    ],
    function () {
        Route::get('/', [AssetController::class, 'index'])->name('index');
        Route::get('/asset-value-settings',[AssetManagementController::class,'assetValueSettings'])->name('asset_value_settings');
        Route::get('/asset-group', [AssetGroupController::class, 'index'])->name('asset_group.index');
        Route::get('/automated-discovery', [AssetManagementController::class, 'index'])->name('automated_discovery');
        Route::get('notifications-settings', [AssetController::class, 'notificationsSettingsActiveAsset'])
        ->name('notificationsSettingsActiveAsset');
        Route::get('notifications-settings-AssetGroup', [AssetGroupController::class, 'notificationsSettingsAssetManagement'])
        ->name('notificationsSettingsAssetManagement');
        Route::get('/import', [AssetController::class, 'openImportForm'])->name('import');
        Route::get('/import-groups', [AssetGroupController::class, 'openImportForm'])->name('importGroups');

        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `asset-management` group routes
                'middleware' => [], // Middlewares applied on all `asset-management` group routes
                'as' => 'ajax.'
            ],
            function () {

                Route::post('/list', [AssetController::class, 'ajaxGetList'])->name('index');
                Route::post('/', [AssetController::class, 'store'])->name('store');
                Route::get('edit/{id}', [AssetController::class, 'ajaxGet'])->name('edit');
                Route::get('show/{id}', [AssetController::class, 'ajaxGet'])->name('show');
                Route::put('/{id}', [AssetController::class, 'update'])->name('update');
                Route::delete('/{id}', [AssetController::class, 'destroy'])->name('destroy');
                Route::post('/export', [AssetController::class, 'ajaxExport'])->name('export');
                Route::Post('/import-data', [AssetController::class, 'importData'])->name('importData');
                Route::post('/asset-value-settings',[AssetManagementController::class,'store'])->name('asset_value_settings.store');
                Route::post('/asset-value-settings-answers',[AssetManagementController::class,'store_answers'])->name('asset_value_settings.store_answers');


                Route::group(
                    [
                        'prefix' => 'asset-group', // Prefix applied on all `asset-management` group routes
                        'middleware' => [], // Middlewares applied on all `asset-management` group routes
                        'as' => 'asset_group.'
                    ],
                    function () {
                        Route::post('/list', [AssetGroupController::class, 'ajaxGetList'])->name('index');
                        Route::post('/', [AssetGroupController::class, 'store'])->name('store');
                        Route::get('edit/{id}', [AssetGroupController::class, 'ajaxGet'])->name('edit');
                        Route::get('show/{id}', [AssetGroupController::class, 'ajaxGet'])->name('show');
                        Route::put('/{id}', [AssetGroupController::class, 'update'])->name('update');
                        Route::delete('/{id}', [AssetGroupController::class, 'destroy'])->name('destroy');
                        Route::post('/export', [AssetGroupController::class, 'ajaxExport'])->name('export');
                        Route::Post('/import-data', [AssetGroupController::class, 'importData'])->name('importData');

                    }
                );
            }
        );



    }
);
