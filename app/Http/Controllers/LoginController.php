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
        Log::info('Percobaan login dengan username: ' . $request->username);

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = MdPengguna::where('username', $request->username)->first();

        if (!$user) {
            Log::error('Login gagal: Username tidak ditemukan');
            return response()->json(['error' => 'Username atau password salah!'], 401);
        }

        Log::info('User ditemukan: ' . $user->username);
        Log::info('Password input: ' . $request->password);
        Log::info('Password hash di database: ' . $user->password);
        
        if ($user && Hash::check($request->password, $user->password)) {
            session(['user' => $user->username]);
            return redirect()->route('dashboard');
        }

        Auth::login($user);
        Log::error('Login gagal: Password salah untuk user ' . $request->username);
        Log::info('Login berhasil untuk user: ' . $user->username);

        return response()->json(['redirect' => url('/dashboardadmin')]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
