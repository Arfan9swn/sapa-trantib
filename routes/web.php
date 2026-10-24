<?php

use Illuminate\Support\Facades\Route;

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
