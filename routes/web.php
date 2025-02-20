<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\QRController;
use Illuminate\Support\Facades\Auth;
Route::get('', [RouteController::class, 'index'])->name('login');
Route::get('login', [RouteController::class, 'login'])->name('login');
Route::get('register', [RouteController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('single-qr-code', [QRController::class, 'generateSingleQrCode'])->name('single-qr-code');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['check.role:admin'])->group(function () {
    Route::get('dashboard', [RouteController::class, 'dashboard'])->name('dashboard');
    Route::get('qr-code', [QRController::class, 'show'])->name('qr-code');
    Route::get('faculty', [CoachController::class, 'show'])->name('faculty');
    Route::get('users', [UserController::class, 'showUsers'])->name('users');
    Route::get('student', [StudentController::class, 'show'])->name('student');
    Route::get('attendance', [RouteController::class, 'attendance'])->name('attendance');

    Route::post('save_user', [UserController::class, 'createUser'])->name('save_user');
    Route::post('update_user', [UserController::class, 'updateUser'])->name('update_user');

    Route::post('save_student', [StudentController::class, 'create'])->name('save_student');
    Route::post('update_student', [StudentController::class, 'update'])->name('update_student');
    Route::post('save_from_excel', [StudentController::class, 'createFromExcel'])->name('save_from_excel');

    Route::post('save_coach', [CoachController::class, 'store'])->name('save_coach');
    Route::post('update_coach', [CoachController::class, 'update'])->name('update_coach');
    Route::post('save-coach-excel', [CoachController::class, 'createFromExcel'])->name('save-coach-excel');

    Route::post('/generate-qr-code', [QRController::class, 'generateQrCode'])->name('generate-qr-code');
});
