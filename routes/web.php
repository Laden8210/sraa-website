<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;


Route::get('', [RouteController::class, 'index'])->name('welcome');
Route::get('dashboard', [RouteController::class, 'dashboard'])->name('dashboard');
Route::get('qr-code', [RouteController::class, 'qrCode'])->name('qr-code');
Route::get('faculty', [RouteController::class, 'faculty'])->name('faculty');
Route::get('student', [RouteController::class, 'student'])->name('student');
Route::get('attendance', [RouteController::class, 'attendance'])->name('attendance');
