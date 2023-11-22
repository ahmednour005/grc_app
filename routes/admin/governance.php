<?php

use App\Http\Controllers\admin\governance\DocumentationsDataController;
use App\Http\Controllers\admin\governance\FrameworkControlController;
use App\Http\Controllers\admin\governance\FrameworkController;
use App\Http\Controllers\admin\governance\FrameWorksDataController;
use App\Http\Controllers\admin\governance\GovernanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin governance routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'governance', // Prefix applied on all `governance` group routes
        'middleware' => [], // Middlewares applied on all `governance` group routes
        'as' => 'governance.'
    ],
    function () {
        //test route
        Route::get('test', function () {
            return view('admin.content.governance.testlive');
        });

        Route::get('/todo', [GovernanceController::class, 'todo'])->name('todo');
        Route::get('notifications-settings', [GovernanceController::class, 'notificationsSettingsFramework'])
            ->name('notificationsSettingsFramework');
        Route::get('notifications-settings-Cateogry', [GovernanceController::class, 'notificationsSettingsCateogry'])
            ->name('notificationsSettingsCateogry');
            Route::get('notifications-settings-Documentation', [GovernanceController::class, 'notificationsSettingsDocumentation'])
            ->name('notificationsSettingsDocumentation');
        //        Route::get('/', [GovernanceController::class, 'index'])->name('index');
        //Frameworks
        Route::get('/', [FrameWorksDataController::class, 'index'])->name('index');
        //Pagination
        Route::get('/next-frame-work-page', [FrameWorksDataController::class, 'NexFramePage']);
        Route::get('/prev-frame-work-page', [FrameWorksDataController::class, 'PrevFramePage']);
        //Side Right Content
        Route::get('/frame-details', [FrameWorksDataController::class, 'frameDetails']);
        Route::get('/frame-delete', [FrameWorksDataController::class, 'deleteFrame']);
        //Datatables
        Route::get('/FrameFamiliesTable', [FrameWorksDataController::class, 'FrameFamiliesTable']);


        //        Route::get('/category', [GovernanceController::class, 'listCategory'])->name('category');

        Route::get('/category', [DocumentationsDataController::class, 'index'])->name('category');
        //Pagination
        Route::get('/next-doc-page', [DocumentationsDataController::class, 'NexDocPage']);
        Route::get('/prev-doc-page', [DocumentationsDataController::class, 'PrevDocPage']);
        //Side Right Content
        Route::get('/doc-details', [DocumentationsDataController::class, 'docDetails']);
        Route::get('/doc-delete', [DocumentationsDataController::class, 'deleteDoc']);
        //Datatables
        Route::get('/DocTable', [DocumentationsDataController::class, 'ajaxGetList']);

        Route::POST('/framework/store',  [GovernanceController::class, 'store'])->name('framework.store');
        Route::POST('framework/copy/{id}',  [GovernanceController::class, 'copy'])->name('framework.copy');
        Route::POST('framework/update/{id}',  [GovernanceController::class, 'update'])->name('framework.update');
        Route::delete('framework/delete/{id}', [GovernanceController::class, 'destroy'])->name("framework.destroy");

        Route::get('get-list-test/{id}', [GovernanceController::class, 'ajaxGetListTest'])->name('ajax.get-list-test');
        Route::get('get-list-map/{id}', [GovernanceController::class, 'ajaxGetListMap'])->name('ajax.get-list-map');

        Route::POST('framework-map', [GovernanceController::class, 'frameMap'])->name('framework.map');

        Route::get('unmapping/{id}', [GovernanceController::class, 'unMapControl'])->name('unmap.control');
        Route::get('edit_control/{id}', [GovernanceController::class, 'editControl'])->name('ajax.edit_control');
        Route::POST('control/update',  [GovernanceController::class, 'updateControl'])->name('control.update');
        Route::POST('/control/store/{id}',  [GovernanceController::class, 'storeControl'])->name('control.store');

        Route::get('/control/list', [GovernanceController::class, 'listControl'])->name("control.list");
        Route::get('control/notifications-settings', [GovernanceController::class, 'notificationsSettingscontrol'])
            ->name('notificationsSettingscontrol');        // Route::get('get-list-control', [GovernanceController::class, 'ajaxGetListControl'])->name('ajax.get-list-control');
        Route::post('get-list-control/list', [GovernanceController::class, 'ajaxGetListControl'])->name('ajax.get-list-control');
        Route::POST('/control/store',  [GovernanceController::class, 'storeControl2'])->name('control.store2');
        Route::get('control/delete/{id}', [GovernanceController::class, 'destroyControl'])->name("control.destroy");

        Route::get('get-list-control-map/{id}', [GovernanceController::class, 'ajaxGetListControlMap'])->name('ajax.get-list_control-map');



        Route::get('/audit/store',  [GovernanceController::class, 'storeAudit'])->name('audit.store');

        //documents
        Route::POST('/category/store',  [GovernanceController::class, 'storeCategory'])->name('category.store');
        Route::POST('category/update/{id}',  [GovernanceController::class, 'updateCategory'])->name('category.update');
        Route::delete('category/delete/{id}', [GovernanceController::class, 'destroyCategory'])->name("category.destroy");
        Route::POST('/document/store/{id}',  [GovernanceController::class, 'storeDocument'])->name('document.store');
        Route::get('document/get-list/{id}', [GovernanceController::class, 'ajaxGetListDocument'])->name('ajax.get-list-document');
        Route::get('edit_document/{id}', [GovernanceController::class, 'editDocument'])->name('ajax.edit_document');
        Route::get('show_document/{id}', [GovernanceController::class, 'showDocument'])->name('ajax.show_document');
        Route::POST('document/update',  [GovernanceController::class, 'updateDocument'])->name('document.update');
        Route::delete('document/delete/{id}', [GovernanceController::class, 'destroyDocument'])->name("document.destroy");
        Route::get('document/download/{id}',  [GovernanceController::class, 'download'])->name('document.download');

        Route::get('get_control/list/{id}',  [GovernanceController::class, 'ajaxGetListFrameControl'])->name('framecontrol.list');

        Route::get('next_review/{id}/{last?}',  [GovernanceController::class, 'ajaxAddNextReviewToFrequency'])->name('nextreview');

        Route::POST('/note', [GovernanceController::class, 'send_note'])->name('send-note');
        Route::POST('/note-file', [GovernanceController::class, 'send_note_file'])->name('send-note-file');
        Route::post('/download-note-file', [GovernanceController::class, 'downloadNoteFile'])->name('download_note_file');
        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/download-file', [GovernanceController::class, 'downloadFile'])->name('download_file');
            }
        );

        Route::group(
            [
                'prefix' => 'framework', // Prefix applied on all `department` group routes
                'middleware' => [], // Middlewares applied on all `department` group routes
                'as' => 'framework.'
            ],
            function () {
                Route::get('/import', [FrameworkController::class, 'openImportForm'])->name('import');

                Route::group(
                    [
                        'prefix' => 'ajax', // Prefix applied on all `department` group routes
                        'middleware' => [], // Middlewares applied on all `department` group routes
                        'as' => 'ajax.'
                    ],
                    function () {
                        Route::post('/export', [FrameworkController::class, 'ajaxExport'])->name('export');
                        Route::Post('/import-data', [FrameworkController::class, 'importData'])->name('importData');

                    }
                );
            }
        );

        Route::group(
            [
                'prefix' => 'control', // Prefix applied on all `governance` group routes
                'middleware' => [], // Middlewares applied on all `governance` group routes
                'as' => 'control.'
            ],
            function () {
                Route::get('/import', [FrameworkControlController::class, 'openImportForm'])->name('import');

                Route::group(
                    [
                        'prefix' => 'ajax', // Prefix applied on all `governance` group routes
                        'middleware' => [], // Middlewares applied on all `governance` group routes
                        'as' => 'ajax.'
                    ],
                    function () {
                        Route::post('/export', [FrameworkControlController::class, 'ajaxExport'])->name('export');
                        Route::Post('/import-data', [FrameworkControlController::class, 'importData'])->name('importData');

                        Route::Group(
                            [
                                'prefix' => 'objective', // Prefix applied on all `objective` group routes
                                'middleware' => [], // Middlewares applied on all `objective` group routes
                                'as' => 'objective.'
                            ],

                            function () {
                                Route::get('/get/{id}', [GovernanceController::class, 'getControlObjectives'])->name('get');
                                Route::get('/get-all/{id}', [GovernanceController::class, 'getAllObjectives'])->name('getAll');
                                Route::post('/add-objective-to-control', [GovernanceController::class, 'addObjectiveToControl'])->name('addObjectiveToControl');
                                Route::post('/store-evidence', [GovernanceController::class, 'storeEvidence'])->name('storeEvidence');
                                Route::get('/get-evidences/{id}', [GovernanceController::class, 'getEvidences'])->name('getEvidences');
                                Route::get('/get-evidence/{id}', [GovernanceController::class, 'getEvidence'])->name('getEvidence');
                                Route::get('/download-evidence-file/{id}', [GovernanceController::class, 'downloadEvidenceFile'])->name('downloadEvidenceFile');
                                Route::post('/update-evidence', [GovernanceController::class, 'updateEvidence'])->name('updateEvidence');
                                Route::post('/get-responsibles', [GovernanceController::class, 'getResponsibles'])->name('getResponsibles');
                                Route::get('/get-department-members/{id}', [GovernanceController::class, 'getDepartmentMembers'])->name('getDepartmentMembers');
                                Route::post('/update-objective-responsible', [GovernanceController::class, 'updateObjectiveResponsible'])->name('updateObjectiveResponsible');
                                Route::delete('/delete-objective/{id}', [GovernanceController::class, 'deleteObjective'])->name('deleteObjective');
                                Route::delete('/delete-evidence/{id}', [GovernanceController::class, 'deleteEvidence'])->name('deleteEvidence');
                            }
                        );
                    }
                );
            }
        );
    }
);
