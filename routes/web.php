<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\SubCatController;
use App\Http\Controllers\RepsController;
use App\Http\Controllers\RepsMediaController;
use App\Http\Controllers\RepsCommentController;
use App\Http\Controllers\RepsActivityController;
use App\Http\Controllers\OtpController;

Route::get('/', function () {
    return view('welcome');
});

// auth
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:6',
    ]);

    $user = \App\Models\User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password_hash' => bcrypt($validated['password']),
        'role' => 'warga',
    ]);

    // Generate and send OTP
    $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiresAt = now()->addMinutes(10);

    \App\Models\OtpVerification::where('email', $validated['email'])
        ->whereNull('used_at')
        ->update(['used_at' => now()]);

    \App\Models\OtpVerification::create([
        'email' => $validated['email'],
        'otp_code' => $otpCode,
        'expires_at' => $expiresAt,
        'created_at' => now(),
    ]);

    \Illuminate\Support\Facades\Mail::to($validated['email'])->send(new \App\Mail\OtpMail($validated['email'], $otpCode));

    return redirect()->route('otp')->with('email', $validated['email'])->with('status', 'Kode OTP telah dikirim ke email Anda.');
})->name('register.post');

Route::post('/password/update', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:6',
        'password_confirmation' => 'required|same:password',
    ]);

    $user = \App\Models\User::where('email', $validated['email'])->first();
    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak terdaftar.']);
    }

    $user->update(['password_hash' => bcrypt($validated['password'])]);

    // Generate and send OTP for confirmation
    $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiresAt = now()->addMinutes(10);

    \App\Models\OtpVerification::where('email', $validated['email'])
        ->whereNull('used_at')
        ->update(['used_at' => now()]);

    \App\Models\OtpVerification::create([
        'email' => $validated['email'],
        'otp_code' => $otpCode,
        'expires_at' => $expiresAt,
        'created_at' => now(),
    ]);

    \Illuminate\Support\Facades\Mail::to($validated['email'])->send(new \App\Mail\OtpMail($validated['email'], $otpCode));

    return redirect()->route('otp')->with('email', $validated['email'])->with('status', 'Kode OTP konfirmasi telah dikirim ke email Anda.');
})->name('password.update');

// landing page
Route::get('/landing', function () {
    return view('auth.landing-page');
})->name('landing');

Route::get('/otp', function () {
    return view('auth.otp');
})->name('otp');

Route::post('/otp/request', [OtpController::class, 'request'])->name('otp.request');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');

Route::get('/account-type', function () {
    return view('auth.account-type-sel');
})->name('account-type');

// cats
Route::get('/categories', function () {
    return view('categories.cat-index');
})->name('categories.index');

Route::get('/categories/{category}', function ($category) {
    return view('categories.cat-show', ['category' => $category]);
})->name('categories.show');

Route::get('/categories/{category}/edit', function ($category) {
    return view('categories.cat-edit', ['category' => $category]);
})->name('categories.edit');

// reps
Route::get('/reports', function () {
    $reports = \App\Models\Reps::with('category', 'subCategory', 'comments', 'media')->latest()->get();
    return view('reports.report-index', compact('reports'));
})->name('reports.index');

Route::get('/reports/create', function () {
    return view('reports.report-create');
})->name('reports.create');

Route::get('/reports/{report}', function ($report) {
    $report = \App\Models\Reps::with('category', 'subCategory', 'comments.user', 'media')->findOrFail($report);
    return view('reports.report-show', compact('report'));
})->name('reports.show');

Route::get('/reports/admin', function () {
    $reports = \App\Models\Reps::with('category', 'subCategory', 'comments', 'media')->latest()->get();
    return view('reports.admin-report', compact('reports'));
})->name('reports.admin');

// report comments
Route::post('/reports/{report}/comments', function ($report) {
    $report = \App\Models\Reps::findOrFail($report);
    $comment = \App\Models\RepsComment::create([
        'report_id' => $report->report_id,
        'body' => request('body'),
        'created_at' => now(),
    ]);
    return back()->with('success', 'Komentar berhasil ditambahkan');
})->name('reports.comments.store');

// delete report
Route::delete('/reports/{report}', function ($report) {
    $report = \App\Models\Reps::findOrFail($report);
    $report->delete();
    return back()->with('success', 'Laporan berhasil dihapus');
})->name('reports.destroy');

// stats
Route::get('/statistics', function () {
    return view('statistics.statistics');
})->name('statistics');

// users
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

// activities
Route::get('/activities', function () {
    return view('activities.log');
})->name('activities.index');

// logout
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');

//api-routes (d sini aja ga usah bikin separate file -> api.php)
Route::apiResource('users', UserController::class);
Route::apiResource('cats', CatController::class);
Route::apiResource('s-cats', SubCatController::class);
Route::apiResource('reps', RepsController::class);
Route::apiResource('rep-media', RepsMediaController::class);
Route::apiResource('rep-comments', RepsCommentController::class);
Route::apiResource('rep-activity', RepsActivityController::class);