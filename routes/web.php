<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; // Tambahkan ini

// Halaman Utama
Route::get('/', function () {
    return view('dashboard1');
});

// Halaman Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Halaman Dashboard
Route::get('/dashboardkaryawan', function () {
    return view('dashboardkaryawan');
});

Route::get('/dashboardadmin', function () {
    return view('dashboardadmin');
});

// Halaman KPI
Route::get('/kpi', function () {
    return view('kpi');
});

// Login & Logout
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
