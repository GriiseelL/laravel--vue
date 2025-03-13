<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $otp = rand(1000, 9999);

        $data = [
            'otp' => $otp
        ];

        Mail::to('takun2971@gmail.com')->send(new sendMail($data));

        return response()->json(['message' => 'OTP sent successfully']);
    }}