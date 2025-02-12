<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard1', function () {
    return view('dashboard1');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboardkaryawan', function () {
    return view('dashboardkaryawan');
});

Route::get('/dashboardadmin', function () {
    return view('dashboardadmin');
});

Route::get('/kpi', function () {
    return view('kpi');
});


