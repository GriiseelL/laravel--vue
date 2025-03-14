<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    public function verifyOtp(Request $request)
    {
        // Validasi OTP saja (tanpa email)
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek jika user tidak ditemukan
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Periksa OTP dan masa berlakunya
        if ($user->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['error' => 'OTP expired'], 422);
        }

        // Reset OTP setelah berhasil diverifikasi
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['message' => 'OTP verified successfully']);
    }

}