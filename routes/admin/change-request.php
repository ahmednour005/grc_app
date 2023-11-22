<?php

use App\Http\Controllers\admin\change_request\ChangeRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin change-request routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'change-request', // Prefix applied on all `change-request` group routes
        'middleware' => [], // Middlewares applied on all `change-request` group routes
        'as' => 'change_request.'
    ],
    function () {
        Route::get('/', [ChangeRequestController::class, 'index'])->name('index');

        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `change-request` group routes
                'middleware' => [], // Middlewares applied on all `change-request` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/list', [ChangeRequestController::class, 'ajaxGetList'])->name('index');
                Route::post('/', [ChangeRequestController::class, 'store'])->name('store');
                Route::post('/decision', [ChangeRequestController::class, 'make_decision'])->name('decision');
                Route::get('edit/{id}', [ChangeRequestController::class, 'ajaxGet'])->name('edit');
                Route::get('show/{id}', [ChangeRequestController::class, 'ajaxGet'])->name('show');
                Route::put('/{id}', [ChangeRequestController::class, 'update'])->name('update');
                Route::delete('/{id}', [ChangeRequestController::class, 'destroy'])->name('destroy');
                Route::post('/download-file', [ChangeRequestController::class, 'downloadFile'])->name('download_file');
                Route::post('/export', [ChangeRequestController::class, 'ajaxExport'])->name('export');
            }
        );
    }
);
