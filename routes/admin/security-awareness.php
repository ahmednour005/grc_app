<?php

use App\Http\Controllers\admin\security_awareness\SecurityAwarenessController;
use App\Http\Controllers\admin\security_awareness\SecurityAwarenessExamController;
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

Route::group(
    [
        'prefix' => 'security-awareness', // Prefix applied on all `security-awareness` group routes
        'middleware' => [], // Middlewares applied on all `security-awareness` group routes
        'as' => 'security_awareness.'
    ],
    function () {
        Route::get('/', [SecurityAwarenessController::class, 'index'])->name('index');
        Route::get('/notifications-settings', [SecurityAwarenessController::class,'notificationsSettings'])->name('notificationsSettings');

        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `security-awareness` group routes
                'middleware' => [], // Middlewares applied on all `security-awareness` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/list', [SecurityAwarenessController::class, 'ajaxGetList'])->name('index');
                Route::post('/', [SecurityAwarenessController::class, 'store'])->name('store');
                Route::get('show/{id}', [SecurityAwarenessController::class, 'ajaxGet'])->name('show');
                Route::get('preview/{id}', [SecurityAwarenessController::class, 'ajaxPreview'])->name('preview');
                Route::get('edit/{id}', [SecurityAwarenessController::class, 'ajaxGetEdit'])->name('edit');
                Route::put('/{id}', [SecurityAwarenessController::class, 'update'])->name('update');
                Route::delete('/{id}', [SecurityAwarenessController::class, 'destroy'])->name('destroy');
                Route::post('/export', [SecurityAwarenessController::class, 'ajaxExport'])->name('export');
            }
        );

        Route::POST('/note', [SecurityAwarenessController::class, 'send_note'])->name('send-note');
        Route::POST('/note-file', [SecurityAwarenessController::class, 'send_note_file'])->name('send-note-file');
        Route::post('/download-note-file', [SecurityAwarenessController::class, 'downloadNoteFile'])->name('download_note_file');
        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/download-file', [SecurityAwarenessController::class, 'downloadFile'])->name('download_file');
                Route::post('/remove-temp-file/{id}', [SecurityAwarenessController::class, 'removeTempFile'])->name('remove_temp_file');
            }
        );

        // Exam
        Route::group(
            [
                'prefix' => 'exam', // Prefix applied on all `security-awareness` group routes
                'middleware' => [], // Middlewares applied on all `security-awareness` group routes
                'as' => 'exam.'
            ],
            function () {
                Route::group(
                    [
                        'prefix' => 'ajax', // Prefix applied on all `security-awareness` group routes
                        'middleware' => [], // Middlewares applied on all `security-awareness` group routes
                        'as' => 'ajax.'
                    ],
                    function () {
                        Route::get('edit/{id}', [SecurityAwarenessExamController::class, 'ajaxGetEdit'])->name('edit');
                        Route::put('/{id}', [SecurityAwarenessExamController::class, 'update'])->name('update');
                        Route::post('/', [SecurityAwarenessExamController::class, 'store'])->name('store');
                        Route::get('show-exam/{id}', [SecurityAwarenessExamController::class, 'ajaxGet'])->name('show-exam');
                        Route::get('show-take-exam/{id}', [SecurityAwarenessExamController::class, 'showTakeExam'])->name('show_take_exam');
                        Route::post('take-exam', [SecurityAwarenessExamController::class, 'takeExam'])->name('take_exam');
                        Route::get('show-exam-result/{id}', [SecurityAwarenessExamController::class, 'showExamRsult'])->name('show_exam_result');
                    }
                );
            }
        );
    }
);
