<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\WargaLoginController;
use App\Http\Controllers\Auth\WargaRegisterController;
use App\Http\Controllers\CategoryManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserTagController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StatRepsController;
use App\Models\User;
use App\Models\Reps;
use App\Models\RepsComment;
use App\Models\OtpVerification;
use App\Models\Cat;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Http\Controllers\RTController;

Route::get('/', function () {
    return view('auth.landing-page');
});

// ---------------------------------------------------------------------------
// AUTH — Admin only
// ---------------------------------------------------------------------------

// Admin login form
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

// Admin login POST
Route::post('/admin/login', [AdminLoginController::class, 'store'])
    ->name('admin.login.post');

// Admin registration
Route::get('/account-type', function () {
    return view('auth.account-type-sel');
})->name('account.type');

Route::get('/admin/register', function () {
    return view('auth.admin-register');
})->name('admin.register');

Route::post('/admin/register', [AdminRegisterController::class, 'store'])
    ->name('admin.register.post');

// Admin registration success page
Route::get('/admin/register-success', function () {
    return view('auth.register-success');
})->name('admin.register.success');

// ---------------------------------------------------------------------------
// Warga / Guest registration & login (name + phone only)
// ---------------------------------------------------------------------------

Route::get('/warga/register', function () {
    return view('auth.warga-register');
})->name('warga.register');

Route::post('/warga/register', [WargaRegisterController::class, 'store'])
    ->name('warga.register.post');

Route::get('/warga/login', function () {
    return view('auth.warga-login');
})->name('warga.login');

Route::post('/warga/login', [WargaLoginController::class, 'store'])
    ->name('warga.login.post');

// ---------------------------------------------------------------------------
// OTP (admin email verification — session based)
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
// Super admin — verify pending admins
// ---------------------------------------------------------------------------
Route::get('/admin/pending', function () {
    $pendingAdmins = User::where('role', 'admin')
        ->whereNull('email_verified_at')
        ->get();

    return view('users.sa-user', ['pendingAdmins' => $pendingAdmins]);
})->name('admin.pending');

Route::post('/admin/verify/{user}', function (Request $request, User $user) {
    $authUserId = session('auth_user_id');
    $userRole = session('auth_user_role') ?? 'warga';
    if ($authUserId === null || strtolower($userRole) !== 'super_admin') {
        return back()->withErrors(['error' => 'Hanya super admin yang dapat memverifikasi admin.']);
    }

    if ($user->role !== 'admin') {
        return back()->withErrors(['error' => 'Hanya akun admin yang dapat diverifikasi.']);
    }

    $user->update(['email_verified_at' => now()]);

    return back()->with('status', 'Admin ' . $user->email . ' telah diverifikasi dan dapat masuk.');
})->name('admin.verify');

// ---------------------------------------------------------------------------
// Forgot-password placeholder
// ---------------------------------------------------------------------------
Route::get('/forgot-password', function () {
    return redirect()->route('admin.login');
})->name('forgot-password');

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
Route::get('/reports', function (Request $request) {
    $query = Reps::with(['category', 'subCategory', 'media']);

    // State filter
    if ($request->filled('status')) {
        $status = $request->status;
        $statusMap = ['pending' => 'pending', 'denied' => 'rejected', 'complete' => 'resolved'];
        if (isset($statusMap[$status])) {
            $query->where('status', $statusMap[$status]);
        }
    }

    // Category filter
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // Subcategory filter
    if ($request->filled('sub_category_id')) {
        $query->where('sub_category_id', $request->sub_category_id);
    }

    $reports = $query->latest()->paginate(15)->withQueryString();
    $categories = App\Models\Cat::all();
    $subCategories = $request->filled('category_id')
        ? App\Models\SubCat::where('category_id', $request->category_id)->get()
        : collect();

    return view('reports.report-index', compact('reports', 'request', 'categories', 'subCategories'));
})->name('reports.index');

Route::get('/reports/create', [App\Http\Controllers\ReportsController::class, 'create'])->name('reports.create');

Route::get('/reports/admin', function (Request $request) {
    $status = $request->query('status');
    $categoryId = $request->query('category_id');
    $subCategoryId = $request->query('sub_category_id');
    $search = $request->query('search');

    $query = Reps::with('category', 'subCategory', 'comments', 'media');

    if ($status) {
        $query->where('status', $status);
    }

    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    if ($subCategoryId) {
        $query->where('sub_category_id', $subCategoryId);
    }

    if ($search) {
        $query->where('title', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%');
    }

    $reports = $query->latest()->get();

    $categories = Cat::all();

    return view('reports.admin-report', compact('reports', 'categories', 'status', 'categoryId', 'subCategoryId', 'search'));
})->name('reports.admin');

Route::get('/reports/{report}', function ($report) {
    $report = Reps::with('category', 'subCategory', 'comments.user', 'media')
        ->findOrFail($report);
    return view('reports.report-show', compact('report'));
})->name('reports.show');

Route::post('/reports/{report}/comments', function ($report) {
    $report = Reps::findOrFail($report);
    RepsComment::create([
        'report_id'   => $report->report_id,
        'user_id'     => session('auth_user_id'),
        'body'        => request('body'),
        'created_at'  => now(),
    ]);
    return back()->with('success', 'Komentar berhasil ditambahkan');
})->name('reports.comments.store');

Route::delete('/reports/{report}', [App\Http\Controllers\ReportsController::class, 'destroy'])->name('reports.destroy');
Route::post('/reports/{report}/status', [App\Http\Controllers\ReportsController::class, 'updateStatus'])->name('reports.status.update');

// ---------------------------------------------------------------------------
// Statistics
// ---------------------------------------------------------------------------
Route::get('/statistics', [StatRepsController::class, 'index'])->name('statistics');

// ---------------------------------------------------------------------------
// Category Management (Admin / Super Admin)
// ---------------------------------------------------------------------------
Route::get('/admin/categories', [CategoryManagementController::class, 'index'])->name('admin-categories.index');
Route::get('/admin/categories/create', [CategoryManagementController::class, 'create'])->name('admin-categories.create');
Route::post('/admin/categories', [CategoryManagementController::class, 'store'])->name('admin-categories.store');
Route::get('/admin/categories/{category}/edit', [CategoryManagementController::class, 'edit'])->name('admin-categories.edit');
Route::put('/admin/categories/{category}', [CategoryManagementController::class, 'update'])->name('admin-categories.update');
Route::delete('/admin/categories/{category}', [CategoryManagementController::class, 'destroy'])->name('admin-categories.destroy');

// ---------------------------------------------------------------------------
// Users (admin / CMS)
// ---------------------------------------------------------------------------
Route::get('/users', [UserManagementController::class, 'index'])->name('admin-users.index');
Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin-users.create');
Route::post('/users', [UserManagementController::class, 'store'])->name('admin-users.store');
Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('admin-users.show');
Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin-users.edit');
Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('admin-users.update');
Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin-users.destroy');
Route::get('/users/sa-user', function () {
    $pendingAdmins = User::where('role', 'admin')
        ->whereNull('email_verified_at')
        ->get();

    return view('users.sa-user', ['pendingAdmins' => $pendingAdmins]);
})->name('super-admin.user');

// User Tag Management (CRUD)
Route::get('/admin/user-tags', [UserTagController::class, 'index'])->name('admin-user-tags.index');
Route::get('/admin/user-tags/create', [UserTagController::class, 'create'])->name('admin-user-tags.create');
Route::post('/admin/user-tags', [UserTagController::class, 'store'])->name('admin-user-tags.store');
Route::get('/admin/user-tags/{tag}/edit', [UserTagController::class, 'edit'])->name('admin-user-tags.edit');
Route::put('/admin/user-tags/{tag}', [UserTagController::class, 'update'])->name('admin-user-tags.update');
Route::delete('/admin/user-tags/{tag}', [UserTagController::class, 'destroy'])->name('admin-user-tags.destroy');
Route::post('/admin/user-tags/apply', [UserTagController::class, 'apply'])->name('admin-user-tags.apply');

// ---------------------------------------------------------------------------
// Activities
// ---------------------------------------------------------------------------
Route::get('/activities', function () {
    return view('activities.log');
})->name('activities.index');

Route::get('/warga/reports/create', [App\Http\Controllers\ReportsController::class, 'wargaCreate'])->name('warga.reports.create');
Route::post('/warga/reports', [App\Http\Controllers\ReportsController::class, 'wargaStore'])->name('warga.reports.store');
Route::post('/warga/reports/new-residence/{id}/status', [App\Http\Controllers\ReportsController::class, 'newResidenceStatus'])->name('warga.reports.new-residence.status');
Route::get('/warga/reports/new-residence', [App\Http\Controllers\ReportsController::class, 'newResidenceIndex'])->name('warga.reports.new-residence.index');
Route::delete('/warga/reports/new-residence/{id}', [App\Http\Controllers\ReportsController::class, 'newResidenceDestroy'])->name('warga.reports.new-residence.destroy');
Route::get('/warga/reports/create/new-residence', [App\Http\Controllers\ReportsController::class, 'newResidenceCreate'])->name('warga.reports.create.new-residence');
Route::post('/warga/reports/new-residence', [App\Http\Controllers\ReportsController::class, 'newResidenceStore'])->name('warga.reports.store.new-residence');
Route::get('/api/subcategories', [App\Http\Controllers\ReportsController::class, 'getSubCategories'])->name('api.subcategories');

// ---------------------------------------------------------------------------
Route::prefix('rts')->name('rts.')->group(function () {
    Route::get('/', [App\Http\Controllers\RTController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\RTController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\RTController::class, 'store'])->name('store');
    Route::get('/{rt}/edit', [App\Http\Controllers\RTController::class, 'edit'])->name('edit');
    Route::put('/{rt}', [App\Http\Controllers\RTController::class, 'update'])->name('update');
    Route::delete('/{rt}', [App\Http\Controllers\RTController::class, 'destroy'])->name('destroy');
    
    // Check RT number existence
    Route::get('/check-rt-number', [App\Http\Controllers\RTController::class, 'checkRtNumber'])->name('check-rt-number');
});
// ---------------------------------------------------------------------------
Route::post('/logout', function (Request $request) {
    auth()->logout();
    if (auth()->guard('web')->check()) {
        auth()->guard('web')->logout();
    }

    session()->forget(['auth_user_id', 'auth_user_role', 'auth_user_name',
        'warga_user_id', 'warga_user_role', 'warga_user_name']);

    $request->session()->regenerateToken();

    return redirect()->route('warga.login')
        ->with('success', 'Anda telah berhasil logout.')
        ->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
})->name('logout');

// ---------------------------------------------------------------------------
// Admin / CMS — API Resources (fully qualified controllers)
// ---------------------------------------------------------------------------
Route::prefix('api')->name('api.')->group(function () {
    Route::apiResource('users',         \App\Http\Controllers\UserController::class);
    Route::apiResource('cats',          \App\Http\Controllers\CatController::class);
    Route::apiResource('s-cats',        \App\Http\Controllers\SubCatController::class);
    Route::apiResource('reps',          \App\Http\Controllers\RepsController::class);
    Route::apiResource('rep-media',     \App\Http\Controllers\RepsMediaController::class);
    Route::apiResource('rep-comments',  \App\Http\Controllers\RepsCommentController::class);
    Route::apiResource('rep-activity',  \App\Http\Controllers\RepsActivityController::class);
});