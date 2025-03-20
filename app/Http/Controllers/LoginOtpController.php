<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LoginOtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        if ($user->email_verified_at === null) {
            return response()->json(['message' => 'Email belum diverifikasi.'], 403);
        }


        $otp = rand(10000, 99999);

        // Simpan OTP di database
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        Session::put('otp_email', $user->email);

        Mail::to($user->email)->send(new sendMail($otp));

        return response()->json(['message' => 'OTP telah dikirim ke email'], 200);
    }

    public function Otplogin(Request $request)
    {
        // Validasi OTP (wajib angka)
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:5'
        ]);

        // Cari user berdasarkan email (diambil dari session)
        $email = $request->email;
        if (!$email) {
            return response()->json(['message' => 'Sesi OTP berakhir. Silakan kirim ulang OTP.'], 400);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        // Cek OTP dan masa berlakunya
        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'OTP tidak valid'], 400);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['message' => 'OTP kadaluarsa'], 400);
        }

        // Bersihkan OTP setelah verifikasi
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        // Login pengguna (opsional)
        Auth::login($user);
        Session::forget('otp_email');


        return response()->json([
            'message' => 'Login berhasil',
            'user' => [
                'name' => $user->name,
            ],
            // 'token' => $user->createToken('auth_token')->plainTextToken, // kalau pakai sanctum
        ], 200);

    }

}