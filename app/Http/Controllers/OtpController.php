<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function request(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $validated['email'];
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(10);

        OtpVerification::where('email', $email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        OtpVerification::create([
            'email'      => $email,
            'otp_code'   => $otpCode,
            'expires_at' => $expiresAt,
            'created_at' => now(),
        ]);

        Mail::to($email)->send(new OtpMail($email, $otpCode));

        return response()->json([
            'message' => 'Kode OTP telah dikirim ke email Anda',
            'email'   => $email,
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email|max:255',
            'otp_code' => 'required|digits:6',
        ]);

        $otp = OtpVerification::where('email', $validated['email'])
            ->where('otp_code', $validated['otp_code'])
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->first();

        if (! $otp) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Kode OTP tidak valid atau sudah kadaluarsa.',
                ], 422);
            }

            return back()
                ->withErrors(['otp_code' => 'Kode OTP tidak valid atau sudah kadaluarsa.'])
                ->withInput();
        }

        $otp->update(['used_at' => now()]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            $user = User::create([
                'username'      => 'user_' . uniqid(),
                'email'         => $validated['email'],
                'password_hash' => bcrypt('temp_password_' . uniqid()),
                'role'          => 'warga',
            ]);
        }

        $user->update(['email_verified_at' => now()]);

        // Log the user in via session (web guard)
        $request->session()->put('auth_user_id', $user->user_id);
        $request->session()->put('auth_user_role', $user->role);
        $request->session()->regenerate();

        if ($request->wantsJson()) {
            return response()->json([
                'message'           => 'Email berhasil diverifikasi.',
                'user_id'           => $user->user_id,
                'email_verified_at' => $user->email_verified_at,
            ]);
        }

        return redirect()->route('reports.create')
            ->with('status', 'Selamat datang! Akun Anda telah diverifikasi.');
    }
}