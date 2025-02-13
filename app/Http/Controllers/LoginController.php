<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\MdPengguna;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Logging untuk debugging
        Log::info('Percobaan login dengan username: ' . $request->username);

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari pengguna berdasarkan username
        $user = MdPengguna::where('username', $request->username)->first();

        if (!$user) {
            Log::error('Login gagal: Username tidak ditemukan');
            return response()->json(['error' => 'Username tidak ditemukan!'], 401);
        }

        Log::info('User ditemukan: ' . $user->username);

        // Periksa apakah password cocok dengan hash di database
        if (!Hash::check($request->password, $user->password)) {
            Log::error('Login gagal: Password salah untuk user ' . $request->username);
            return response()->json(['error' => 'Password salah!'], 401);
        }

        // Login pengguna menggunakan guard khusus
        Auth::guard('web')->login($user);
        Log::info('Login berhasil untuk user: ' . $user->username);

        return response()->json(['redirect' => url('/dashboardadmin')]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
