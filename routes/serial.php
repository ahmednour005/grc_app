<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\serial\SerialController;

Route::view('/serial', 'admin.content.serial.index')->name('serial.index');
Route::post('/serial/check', [SerialController::class, 'check_serial'])->name('serial.check');
Route::view('/manipulation', 'admin/manipulation')->name('serial.manipulation');
