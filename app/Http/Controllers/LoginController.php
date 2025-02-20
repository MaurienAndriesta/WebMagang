<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('login');  // Menampilkan form login
    }

    // Proses login
    public function login(Request $request)
    {
       
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah login berhasil
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Login berhasil, arahkan ke dashboard yang sesuai berdasarkan role
            $role = Auth::user()->role;
            if ($role == 'admin') {
                return redirect()->route('dashboardadmin');
            } elseif ($role == 'spv') {
                return redirect()->route('dashboardspv');
            } elseif ($role == 'manager') {
                return redirect()->route('dashboardmanager');
            } else {
                return redirect()->route('dashboardpegawai');
            }
        }
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            dd(Auth::user());  // Debugging untuk melihat data pengguna yang login
            // Kode lainnya
        }
        

        // Jika login gagal, kembali ke halaman login dengan error
        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();  // Logout user
        return redirect()->route('login.form');
    }

    // Dashboard untuk admin
    public function admin()
    {
        return view('dashboardadmin');  // Pastikan Anda memiliki view dashboard_admin.blade.php
    }

    // Dashboard untuk SPV
    public function spv()
    {
        return view('dashboardspv');  // Pastikan Anda memiliki view dashboard_spv.blade.php
    }

    // Dashboard untuk Manager
    public function manager()
    {
        return view('dashboardmanager');  // Pastikan Anda memiliki view dashboard_manager.blade.php
    }

    // Dashboard untuk Karyawan
    public function staff()
    {
        return view('dashboardpegawai');  // Pastikan Anda memiliki view dashboard_karyawan.blade.php
    }
}