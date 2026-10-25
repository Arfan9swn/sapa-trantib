<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;

// OTP verification (stateless API - no CSRF)
Route::post('otp/request', [OtpController::class, 'request'])->name('otp.request');
Route::post('otp/verify', [OtpController::class, 'verify'])->name('otp.verify');