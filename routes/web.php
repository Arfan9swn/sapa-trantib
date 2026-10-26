<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/otp', function () {
    return view('auth.otp');
})->name('otp');

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
    return view('reports.report-index');
})->name('reports.index');

Route::get('/reports/create', function () {
    return view('reports.report-create');
})->name('reports.create');

Route::get('/reports/{report}', function ($report) {
    return view('reports.report-show', ['report' => $report]);
})->name('reports.show');

Route::get('/reports/admin', function () {
    return view('reports.admin-report');
})->name('reports.admin');

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

//api-routes (d sini aja ga usah bikin separate file -> api.php)
Route::apiResource('users', UserController::class);
Route::apiResource('cats', CatController::class);
Route::apiResource('s-cats', SubCatController::class);
Route::apiResource('reps', RepsController::class);
Route::apiResource('rep-media', RepsMediaController::class);
Route::apiResource('rep-comments', RepsCommentController::class);
Route::apiResource('rep-activity', RepsActivityController::class);