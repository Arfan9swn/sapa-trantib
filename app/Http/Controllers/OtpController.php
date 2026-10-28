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

        try {
            Mail::to($email)->send(new OtpMail($email, $otpCode));
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json([
            'message' => 'Kode OTP telah dikirim ke email Anda',
            'email'   => $email,
            'otp_code' => $otpCode,
        ]);
    }

    public function verify(Request $request)
    {
        $email = $request->input('email', $request->session()->get('email'));
        $otpCode = $request->input('otp_code');

        if (! $otpCode && is_array($request->input('otp'))) {
            $otpCode = implode('', array_values($request->input('otp')));
        }

        $request->merge([
            'email' => $email,
            'otp_code' => $otpCode,
        ]);

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
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Akun belum terdaftar. Hubungi super admin untuk membuat akun admin.',
                ], 422);
            }

            return back()
                ->withErrors(['otp_code' => 'Akun belum terdaftar. Hubungi super admin untuk membuat akun admin.'])
                ->withInput();
        }

        // OTP confirms email ownership but does NOT grant access.
        // Account remains on hold (email_verified_at = null) until super admin verifies.
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kode OTP telah diverifikasi. Silakan tunggu super admin menyetujui akun Anda.',
                'user_id' => $user->user_id,
            ]);
        }

        return redirect()->route('admin.login')
            ->with('status', 'Kode OTP telah diverifikasi. Akun Anda masih menunggu persetujuan super admin sebelum dapat masuk.');
    }
}