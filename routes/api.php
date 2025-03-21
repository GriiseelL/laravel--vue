<?php

// use App\Http\Controllers\Api\RegisterController;

use App\Http\Controllers\LoginOtpController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ResendotpController;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\sendMail;


Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

// Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
Route::post('/resend-otp', [ResendotpController::class,'resend']);

Route::post('/send-otp', [LoginOtpController::class, 'sendOtp']);

Route::post('/verif-login', [LoginOtpController::class, 'Otplogin']);

// $data = [
    //     'name' => 'Syahrizal As',
    //     'body' => 'Testing Kirim Email di Santri Koding'
    // ];

    // Mail::to('takun2971@gmail.com')->send(new sendMail($data));

    // dd("Email Berhasil dikirim.");

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});