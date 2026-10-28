<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\OtpController;
use App\Models\User;
use App\Models\Reps;
use App\Models\RepsComment;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

// ---------------------------------------------------------------------------
// Landing / Account Type Selection (guest entry point)
// ---------------------------------------------------------------------------
Route::get('/', function () {
    return view('auth.account-type-sel');
})->name('account-type');

// ---------------------------------------------------------------------------
// AUTH — Warga (email/password) + Admin (admin/email+password)
// ---------------------------------------------------------------------------

// Warga login form
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Warga login POST (email + password)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->guard('web')->attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('reports.create');
    }

    return back()
        ->withErrors(['email' => 'Kredensial tidak sesuai.'])
        ->withInput();
})->name('login.post');

// Admin login form
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

// Admin login POST
Route::post('/admin/login', [AdminLoginController::class, 'store'])
    ->name('admin.login.post');

// Register (warga)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email'    => 'required|email|max:255',
        'password' => 'required|string|min:6',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (! $user) {
        $user = User::create([
            'username'      => $validated['username'],
            'email'         => $validated['email'],
            'password_hash' => bcrypt($validated['password']),
            'role'          => 'warga',
        ]);
    } else {
        // Update username/password for existing account on re-registration
        $user->update([
            'username'      => $validated['username'],
            'password_hash' => bcrypt($validated['password']),
        ]);
    }

    $otpCode   = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiresAt = now()->addMinutes(10);

    OtpVerification::where('email', $validated['email'])
        ->whereNull('used_at')
        ->update(['used_at' => now()]);

    OtpVerification::create([
        'email'      => $validated['email'],
        'otp_code'   => $otpCode,
        'expires_at' => $expiresAt,
        'created_at' => now(),
    ]);

    try {
        Mail::to($validated['email'])
            ->send(new OtpMail($validated['email'], $otpCode));
    } catch (\Throwable $e) {
        report($e);
    }

    $request->session()->put('email', $validated['email']);
    $request->session()->put('otp_code', $otpCode);

    return redirect()
        ->route('otp')
        ->with('status', 'Kode OTP telah dikirim ke email Anda.');
})->name('register.post');

Route::post('/password/update', function (Request $request) {
    $validated = $request->validate([
        'email'                 => 'required|email|max:255',
        'password'              => 'required|string|min:6',
        'password_confirmation' => 'required|same:password',
    ]);

    $user = User::where('email', $validated['email'])->first();
    if (! $user) {
        return back()->withErrors(['email' => 'Email tidak terdaftar.']);
    }

    $user->update(['password_hash' => bcrypt($validated['password'])]);

    $otpCode   = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiresAt = now()->addMinutes(10);

    OtpVerification::where('email', $validated['email'])
        ->whereNull('used_at')
        ->update(['used_at' => now()]);

    OtpVerification::create([
        'email'      => $validated['email'],
        'otp_code'   => $otpCode,
        'expires_at' => $expiresAt,
        'created_at' => now(),
    ]);

    try {
        Mail::to($validated['email'])
            ->send(new OtpMail($validated['email'], $otpCode));
    } catch (\Throwable $e) {
        report($e);
    }

    $request->session()->put('email', $validated['email']);
    $request->session()->put('otp_code', $otpCode);

    return redirect()
        ->route('otp')
        ->with('status', 'Kode OTP konfirmasi telah dikirim ke email Anda.');
})->name('password.update');

// Forgot-password placeholder
Route::get('/forgot-password', function () {
    return redirect()->route('login');
})->name('forgot-password');

// ---------------------------------------------------------------------------
// OTP (warga verification — session based, redirects after login)
// ---------------------------------------------------------------------------
Route::get('/otp', function () {
    return view('auth.otp');
})->name('otp');

Route::post('/otp/request', [OtpController::class, 'request'])
    ->name('otp.request');

Route::post('/otp/verify', [OtpController::class, 'verify'])
    ->name('otp.verify');

Route::post('/otp/resend', function (Request $request) {
    $email = $request->session()->get('email');

    if (! $email) {
        return back()->withErrors(['resend' => 'Email tidak ditemukan. Silakan daftar ulang.']);
    }

    $lastResend = $request->session()->get('otp_resend_at');
    if ($lastResend && (now()->getTimestamp() - $lastResend) < 60) {
        $remaining = 60 - (now()->getTimestamp() - $lastResend);
        return back()->withErrors(['resend' => 'Tunggu ' . $remaining . ' detik sebelum mengirim ulang kode.']);
    }

    $otpCode   = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
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
        return back()->withErrors(['resend' => 'Gagal mengirim email. Silakan coba lagi nanti.']);
    }

    $request->session()->put('otp_resend_at', now()->getTimestamp());
    $request->session()->put('otp_code', $otpCode);

    return back()->with('status', 'Kode OTP baru telah dikirim ke ' . $email);
})->name('otp.resend');

// ---------------------------------------------------------------------------
// Categories
// ---------------------------------------------------------------------------
Route::get('/categories', function () {
    return view('categories.cat-index');
})->name('categories.index');

Route::get('/categories/{category}', function ($category) {
    return view('categories.cat-show', ['category' => $category]);
})->name('categories.show');

Route::get('/categories/{category}/edit', function ($category) {
    return view('categories.cat-edit', ['category' => $category]);
})->name('categories.edit');

// ---------------------------------------------------------------------------
// Reports (reps)
// ---------------------------------------------------------------------------
Route::get('/reports', function () {
    $reports = Reps::with('category', 'subCategory', 'comments', 'media')
        ->latest()->get();
    return view('reports.report-index', compact('reports'));
})->name('reports.index');

Route::get('/reports/create', function () {
    return view('reports.report-create');
})->name('reports.create');

Route::get('/reports/{report}', function ($report) {
    $report = Reps::with('category', 'subCategory', 'comments.user', 'media')
        ->findOrFail($report);
    return view('reports.report-show', compact('report'));
})->name('reports.show');

Route::get('/reports/admin', function () {
    $reports = Reps::with('category', 'subCategory', 'comments', 'media')
        ->latest()->get();
    return view('reports.admin-report', compact('reports'));
})->name('reports.admin');

Route::post('/reports/{report}/comments', function ($report) {
    $report = Reps::findOrFail($report);
    RepsComment::create([
        'report_id'   => $report->report_id,
        'body'        => request('body'),
        'created_at'  => now(),
    ]);
    return back()->with('success', 'Komentar berhasil ditambahkan');
})->name('reports.comments.store');

Route::delete('/reports/{report}', function ($report) {
    $report = Reps::findOrFail($report);
    $report->delete();
    return back()->with('success', 'Laporan berhasil dihapus');
})->name('reports.destroy');

// ---------------------------------------------------------------------------
// Statistics
// ---------------------------------------------------------------------------
Route::get('/statistics', function () {
    return view('statistics.statistics');
})->name('statistics');

// ---------------------------------------------------------------------------
// Users (admin / CMS)
// ---------------------------------------------------------------------------
Route::get('/users', function () {
    return view('users.user-index');
})->name('users.index');

Route::get('/users/{user}', function ($user) {
    return view('users.user-show', ['user' => $user]);
})->name('users.show');

Route::get('/users/{user}/edit', function ($user) {
    return view('users.user-edit', ['user' => $user]);
})->name('users.edit');

Route::get('/users/sa-user', function () {
    return view('users.sa-user');
})->name('super-admin.user');

// ---------------------------------------------------------------------------
// Activities
// ---------------------------------------------------------------------------
Route::get('/activities', function () {
    return view('activities.log');
})->name('activities.index');

// ---------------------------------------------------------------------------
// Logout (both web and api guards)
// ---------------------------------------------------------------------------
Route::post('/logout', function () {
    if (auth()->guard('web')->check()) {
        auth()->guard('web')->logout();
    }
    if (auth()->guard('api')->check()) {
        auth()->guard('api')->logout();
    }
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ---------------------------------------------------------------------------
// Admin / CMS — API Resources (fully qualified controllers)
// ---------------------------------------------------------------------------
Route::apiResource('users',         \App\Http\Controllers\UserController::class);
Route::apiResource('cats',          \App\Http\Controllers\CatController::class);
Route::apiResource('s-cats',        \App\Http\Controllers\SubCatController::class);
Route::apiResource('reps',          \App\Http\Controllers\RepsController::class);
Route::apiResource('rep-media',     \App\Http\Controllers\RepsMediaController::class);
Route::apiResource('rep-comments',  \App\Http\Controllers\RepsCommentController::class);
Route::apiResource('rep-activity',  \App\Http\Controllers\RepsActivityController::class);