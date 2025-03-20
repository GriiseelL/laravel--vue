<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResendotpController extends Controller
{
    public function resend(Request $request) // Perbaikan di parameter
    {
        // Validasi email
        // $request->validate([
        //     'email' => 'required|email',
        // ]);

        // Cari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        // Buat OTP baru (contoh: 6 digit angka acak)
        $otp = rand(10000, 99999);

        // Simpan OTP di database (sesuaikan dengan struktur tabel)
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // Kirim email
        Mail::to($request->email)->send(new sendMail($otp));

        // Beri respon sukses
        return response()->json(['message' => 'OTP berhasil dikirim'], 200);
    }
}