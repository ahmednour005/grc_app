<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    // locale Route
    Route::get('lang/{locale}', [LanguageController::class, 'swap'])->name('language.swap');
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::redirect('/admin', '/admin/dashboard');
    Route::get('/notification/read/{id}', [NotificationController::class, 'notificationMakeRead'])->name('notification-read');
    Route::get('/notifications', [NotificationController::class, 'notificationMore'])->name('notifications.more');
});

// Authentication Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
