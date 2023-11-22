<?php

use App\Http\Controllers\admin\notification_setting\NotificationSettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin notification setting routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'notification-setting', // Prefix applied on all `notification-setting` group routes
        'middleware' => [], // Middlewares applied on all `notification-setting` group routes
        'as' => 'notification_setting.'
    ],
    function () {
        Route::group(
            [
                'prefix' => 'ajax', // Prefix applied on all `notification-setting` group routes
                'middleware' => [], // Middlewares applied on all `notification-setting` group routes
                'as' => 'ajax.'
            ],
            function () {
                Route::post('/update-system-notification-setting', [NotificationSettingController::class, 'updateSystemNotificationSetting'])->name('updateSystemNotificationSetting');
                Route::get('edit-system-notification-setting/{id}', [NotificationSettingController::class, 'getSystemNotificationSetting'])->name('getSystemNotificationSetting');
                Route::post('/update-mail-setting', [NotificationSettingController::class, 'updateMailSetting'])->name('updateMailSetting');
                Route::get('edit-mail-setting/{id}', [NotificationSettingController::class, 'getMailSetting'])->name('getMailSetting');
                Route::post('/update-sms-setting', [NotificationSettingController::class, 'updateSmsSetting'])->name('updateSmsSetting');
                Route::get('edit-sms-setting/{id}', [NotificationSettingController::class, 'getSmsSetting'])->name('getSmsSetting');
                Route::post('/update-autonotify-setting', [NotificationSettingController::class, 'updateAutoNotifySetting'])->name('updateAutoNotifySetting');
                Route::get('edit-AutoNotify-setting/{id}', [NotificationSettingController::class, 'getAutoNotifySetting'])->name('getAutoNotifySetting');
            
            }
        );
    }
);
