<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('record_attendance', [APIController::class, 'recordAttendances'])->name('record_attendance');

Route::get('fetch_attendance', [APIController::class, 'fetchAttendance'])->name('fetch_attendance');

Route::post('login', [APIController::class, 'login'])->name('login');

Route::get('retrieve-user', [APIController::class, 'retrieveUser'])->name('retrieve-user');
