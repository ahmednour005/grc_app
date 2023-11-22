<?php

use App\Http\Controllers\admin\task\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin task routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'task', // Prefix applied on all `task` group routes
        'middleware' => [], // Middlewares applied on all `task` group routes
        'as' => 'task.'
    ],
    function () {
        Route::get('/', [TaskController::class, 'createdTasks'])->name('index');
        Route::get('/assigned-to-me', [TaskController::class, 'assignedTasks'])->name('assigned_to_me');
        // Route::get('/assigned-to-our-teams', [TaskController::class, 'assignedTeamTasks'])->name('assigned_to_team');
        Route::get('/calendar', [TaskController::class, 'calendar'])->name('calendar');
        Route::get('/notification_settings', [TaskController::class, 'notificationsSettingsTask'])->name('notificationsSettingsTask');

        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/download-file', [TaskController::class, 'downloadFile'])->name('download_file');
                Route::post('/download-note-file', [TaskController::class, 'downloadNoteFile'])->name('download_note_file');
                Route::post('/', [TaskController::class, 'store'])->name('store');
                Route::delete('/delete-file', [TaskController::class, 'deleteFile'])->name('delete_file');
                Route::get('edit/{id}', [TaskController::class, 'ajaxGet'])->name('edit');
                Route::get('show/{id}', [TaskController::class, 'ajaxGet'])->name('show');
                Route::put('/update', [TaskController::class, 'update'])->name('update');
                Route::put('/change-complete-status', [TaskController::class, 'changeCompleteStatus'])->name('change_complete_status');
                Route::put('/assignee-update-status', [TaskController::class, 'assigneeUpdateStatus'])->name('assignee_update_status');
                Route::delete('/{id}', [TaskController::class, 'destroy'])->name('destroy');
                Route::post('/note', [TaskController::class, 'send_note'])->name('send-note');
                Route::post('/note-file', [TaskController::class, 'send_note_file'])->name('send-note-file');
                Route::post('created/export', [TaskController::class, 'ajaxCreatedExport'])->name('created.export');
                Route::post('assigned/export', [TaskController::class, 'ajaxAssignedExport'])->name('assigned.export');
            }
        );
    }
);
