<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OtpMail;
use App\Models\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminRegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => 'admin',
            'email_verified_at' => null,
        ]);

        // Send OTP for email confirmation
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(10);

        OtpVerification::where('email', $user->email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        OtpVerification::create([
            'email' => $user->email,
            'otp_code' => $otpCode,
            'expires_at' => $expiresAt,
            'created_at' => now(),
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($user->email, $otpCode));
        } catch (\Throwable $e) {
            report($e);
        }

        $request->session()->put('email', $user->email);
        $request->session()->put('otp_for', 'admin_register');

        return redirect()->route('otp')
            ->with('status', 'Kode OTP telah dikirim ke email Anda. Silakan verifikasi untuk melanjutkan.');
    }
}