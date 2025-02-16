<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\MdBidangController;
use App\Http\Controllers\MdPenilaianController;
use App\Http\Controllers\MdSubbidangController;
use App\Http\Controllers\MdNilaiakhirController;
use App\Http\Controllers\MdSkalapenilaianController;
use App\Http\Controllers\MdPegawaiController;




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

// Halaman Dashboard Admin
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
//Route::get('/hash-passwords', [LoginController::class, 'hashExistingPasswords']);

// Master Data Bidang
Route::get('/md_bidang', [MdBidangController::class, 'index'])->name('bidang.index');
Route::post('/md_bidang', [MdBidangController::class, 'store'])->name('bidang.store');
Route::put('/md_bidang/{id}', [MdBidangController::class, 'update'])->name('bidang.update');
Route::delete('/md_bidang/{id}', [MdBidangController::class, 'destroy'])->name('bidang.destroy');


Route::get('/md_penilaian', [MdPenilaianController::class, 'index'])->name('penilaian.index');
Route::post('/md_penilaian', [MdPenilaianController::class, 'store'])->name('penilaian.store');
Route::put('/md_penilaian/{id}', [MdPenilaianController::class, 'update'])->name('penilaian.update');
Route::delete('/md_penilaian/{id}', [MdPenilaianController::class, 'destroy'])->name('penilaian.destroy');

Route::get('/md_subbidang', [MdSubbidangController::class, 'index'])->name('subbidang.index');
Route::post('/md_subbidang', [MdSubbidangController::class, 'store'])->name('subbidang.store');
Route::put('/md_subbidang/{id}', [MdSubbidangController::class, 'update'])->name('subbidang.update');
Route::delete('/md_subbidang/{id}', [MdSubbidangController::class, 'destroy'])->name('subbidang.destroy');

Route::get('/md_nilaiakhir', [MdNilaiakhirController::class, 'index'])->name('nilai-akhir.index');
Route::post('/md_nilaiakhir', [MdNilaiakhirController::class, 'store'])->name('nilai-akhir.store');
Route::put('/md_nilaiakhir/{id}', [MdNilaiakhirController::class, 'update'])->name('nilai-akhir.update');
Route::delete('/md_nilaiakhir/{id}', [MdNilaiakhirController::class, 'destroy'])->name('nilai-akhir.destroy');

Route::get('/md_skalapenilaian', [MdSkalapenilaianController::class, 'index'])->name('skala-penilaian.index');
Route::post('/md_skalapenilaian', [MdSkalapenilaianController::class, 'store'])->name('skala-penilaian.store');
Route::put('/md_skalapenilaian/{id}', [MdSkalapenilaianController::class, 'update'])->name('skala-penilaian.update');
Route::delete('/md_skalapenilaian/{id}', [MdSkalapenilaianController::class, 'destroy'])->name('skala-penilaian.destroy');

Route::get('/md_pegawai', [MdPegawaiController::class, 'index'])->name('pegawai.index'); // Menampilkan daftar pegawai
Route::post('/md_pegawai', [MdPegawaiController::class, 'store'])->name('pegawai.store'); // Menyimpan pegawai baru
Route::put('/md_pegawai/{id}', [MdPegawaiController::class, 'update'])->name('pegawai.update'); // Mengupdate pegawai
Route::delete('/md_pegawai/{id}', [MdPegawaiController::class, 'destroy'])->name('pegawai.destroy'); // Menghapus pegawai