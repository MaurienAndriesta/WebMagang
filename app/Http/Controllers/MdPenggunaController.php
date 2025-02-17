<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MdPengguna;
use App\Models\MdPegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MdPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penggunaList = MdPengguna::with('pegawai')
            ->when($search, function ($query, $search) {
                return $query->where('username', 'like', "%{$search}%")
                             ->orWhereHas('pegawai', function ($q) use ($search) {
                                 $q->where('nama', 'like', "%{$search}%");
                             });
            })
            ->orderBy('id', 'desc') 
            ->get();

        $pegawaiList = MdPegawai::all();

        return view('md_pengguna', compact('penggunaList', 'pegawaiList'));
    }

    public function store(Request $request)
    {
        

        $request->validate([
            'id_pegawai' => 'required',
            'username'   => 'required|unique:md_pengguna,username',
            'password'   => 'required|min:6',
            'role'       => 'required'
        ]);

        $pengguna = MdPengguna::create([
            'id_pegawai' => $request->id_pegawai,
            'username'   => $request->username,
            'password'   => bcrypt($request->password),
            'role'       => $request->role
        ]);

        
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'role'     => 'required'
        ]);

        $pengguna = MdPengguna::findOrFail($id);
        $pengguna->update([
            'username' => $request->username,
            'role'     => $request->role
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengguna = MdPengguna::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}