<?php

use App\Http\Controllers\admin\import\ImportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin import routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'import', // Prefix applied on all `import` group routes
        'middleware' => [], // Middlewares applied on all `import` group routes
        'as' => 'import.'
    ],
    function () {
        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `import` group routes
                'middleware' => [], // Middlewares applied on all `import` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/map-columns', [ImportController::class, 'mapColumns'])->name('mapColumns');
                // Route::get('edit-system-import/{id}', [NotificationSettingController::class, 'getSystemNotificationSetting'])->name('getSystemNotificationSetting');
            
            }
        );
    }
);
