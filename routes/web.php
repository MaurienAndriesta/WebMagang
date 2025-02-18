<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\MdBidangController;
use App\Http\Controllers\MdPenilaianController;
use App\Http\Controllers\MdSubbidangController;
use App\Http\Controllers\MdNilaiakhirController;
use App\Http\Controllers\MdSkalapenilaianController;
use App\Http\Controllers\MdPegawaiController;
use App\Http\Controllers\MdPenggunaController;
use App\Http\Controllers\TrskpispvController;
use App\Http\Controllers\TrskpimanagerController;
use App\Http\Controllers\HalkpiController;

// Halaman Utama
Route::get('/', function () {
    return view('dashboard1');
});

// Halaman Login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Halaman Dashboard Manager
Route::get('/dashboardmanager', function () {
    return view('dashboardmanager');
});

// Halaman Dashboard Pegawai
Route::get('/dashboardpegawai', function () {
    return view('dashboardpegawai   ');
});

// Halaman Dashboard Admin
Route::get('/dashboardadmin', function () {
    return view('dashboardadmin');
});

// Halaman Dashboard SPV
Route::get('/dashboardspv', function () {
    return view('dashboardspv');
});

// Halaman KPI Pegawai
Route::get('/kpipegawai', function () {
    return view('kpipegawai');
});

// Halaman KPI Manager
Route::get('/kpimanager', function () {
    return view('kpimanager');
});

// Halaman KPI Manager
Route::get('/kpispv', function () {
    return view('kpispv');
});

// Halaman TRANSAKSI KPI SPV
Route::get('/trs_kpispv', function () {
    return view('trs_kpispv');
});

// Halaman TRANSAKSI KPI MANAGER
Route::get('/trs_kpimanager', function () {
    return view('trs_kpimanager');
});

// Halaman HALAMAN KPI
Route::get('/halkpi', function () {
    return view('halkpi');
});

// Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/', [LoginController::class, 'logout'])->name('logout');

// Master Data Bidang
Route::get('/md_bidang', [MdBidangController::class, 'index'])->name('bidang.index');
Route::post('/md_bidang', [MdBidangController::class, 'store'])->name('bidang.store');
Route::put('/md_bidang/{id}', [MdBidangController::class, 'update'])->name('bidang.update');
Route::delete('/md_bidang/{id}', [MdBidangController::class, 'destroy'])->name('bidang.destroy');

// Master Data Penilaian
Route::get('/md_penilaian', [MdPenilaianController::class, 'index'])->name('penilaian.index');
Route::post('/md_penilaian', [MdPenilaianController::class, 'store'])->name('penilaian.store');
Route::put('/md_penilaian/{id}', [MdPenilaianController::class, 'update'])->name('penilaian.update');
Route::delete('/md_penilaian/{id}', [MdPenilaianController::class, 'destroy'])->name('penilaian.destroy');

// Master Data Sub Bidang
Route::get('/md_subbidang', [MdSubbidangController::class, 'index'])->name('subbidang.index');
Route::post('/md_subbidang', [MdSubbidangController::class, 'store'])->name('subbidang.store');
Route::put('/md_subbidang/{id}', [MdSubbidangController::class, 'update'])->name('subbidang.update');
Route::delete('/md_subbidang/{id}', [MdSubbidangController::class, 'destroy'])->name('subbidang.destroy');

// Master Data Nilai Akhir
Route::get('/md_nilaiakhir', [MdNilaiakhirController::class, 'index'])->name('nilai-akhir.index');
Route::post('/md_nilaiakhir', [MdNilaiakhirController::class, 'store'])->name('nilai-akhir.store');
Route::put('/md_nilaiakhir/{id}', [MdNilaiakhirController::class, 'update'])->name('nilai-akhir.update');
Route::delete('/md_nilaiakhir/{id}', [MdNilaiakhirController::class, 'destroy'])->name('nilai-akhir.destroy');

// Master Data Skala Penilaian
Route::get('/md_skalapenilaian', [MdSkalapenilaianController::class, 'index'])->name('skala-penilaian.index');
Route::post('/md_skalapenilaian', [MdSkalapenilaianController::class, 'store'])->name('skala-penilaian.store');
Route::put('/md_skalapenilaian/{id}', [MdSkalapenilaianController::class, 'update'])->name('skala-penilaian.update');
Route::delete('/md_skalapenilaian/{id}', [MdSkalapenilaianController::class, 'destroy'])->name('skala-penilaian.destroy');

// Master Data Pegawai
Route::get('/md_pegawai', [MdPegawaiController::class, 'index'])->name('pegawai.index'); // Menampilkan daftar pegawai
Route::post('/md_pegawai', [MdPegawaiController::class, 'store'])->name('pegawai.store'); // Menyimpan pegawai baru
Route::put('/md_pegawai/{id}', [MdPegawaiController::class, 'update'])->name('pegawai.update'); // Mengupdate pegawai
Route::delete('/md_pegawai/{id}', [MdPegawaiController::class, 'destroy'])->name('pegawai.destroy'); // Menghapus pegawai

// Master Data Pengguna
Route::get('/md_pengguna', [MdPenggunaController::class, 'index'])->name('pengguna.index'); 
Route::get('/md_pengguna/create', [MdPenggunaController::class, 'create'])->name('pengguna.create');
Route::post('/md_pengguna', [MdPenggunaController::class, 'store'])->name('pengguna.store');
Route::get('/md_pengguna/{id}/edit', [MdPenggunaController::class, 'edit'])->name('pengguna.edit');
Route::put('/md_pengguna/{id}', [MdPenggunaController::class, 'update'])->name('pengguna.update');
Route::delete('/md_pengguna/{id}', [MdPenggunaController::class, 'destroy'])->name('pengguna.destroy');

// Login ke Dashboard sesuai bidang masing-masing
Route::middleware('auth')->group(function () {
    Route::get('/dashboardadmin', [LoginController::class, 'admin'])->name('dashboardadmin');
    Route::get('/dashboardspv', [LoginController::class, 'spv'])->name('dashboardspv');
    Route::get('/dashboardmanager', [LoginController::class, 'manager'])->name('dashboardmanager');
    Route::get('/dashboardpegawai', [LoginController::class, 'pegawai'])->name('dashboardpegawai');
});

// Download PDF
Route::get('/pdf', [PdfController::class, 'generatePDF']);


Route::get('/Trskpispv', [TrskpispvController::class, 'index'])->name('Trskpispv.index');
Route::post('/Trskpispv', [TrskpispvController::class, 'store'])->name('Trskpispv.store');

Route::get('/Trskpimanager', [TrskpimanagerController::class, 'index'])->name('Trskpimanager.index');
Route::post('/Trskpimanager', [TrskpimanagerController::class, 'store'])->name('Trskpimanager.store');

Route::get('/Halkpi-evaluation', [HalkpiController::class, 'index'])->name('Halkpi.evaluation');