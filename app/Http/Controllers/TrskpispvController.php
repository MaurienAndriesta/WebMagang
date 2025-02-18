<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrskpispvModel;

class TrskpispvController extends Controller
{
    // Menampilkan form penilaian
    public function index()
    {
        return view('Trskpispv_form');
    }

    // Menyimpan data penilaian
    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'masakerja' => 'required|string|max:255',
            'nama_penilai' => 'required|string|max:255',
            'periode_penilaian' => 'required|string|max:255',
            'tanggal_penilaian' => 'required|date',
            'sub_dir' => 'required|string|max:255',
            'kelebihan' => 'nullable|string',
            'improvement' => 'nullable|string',
            'datang_lambat_hari' => 'nullable|integer',
            'datang_lambat_penalty' => 'nullable|integer',
            'datang_lambat_total' => 'nullable|integer',
            'mangkir_hari' => 'nullable|integer',
            'mangkir_penalty' => 'nullable|integer',
            'mangkir_total' => 'nullable|integer',
            'teguran_hari' => 'nullable|integer',
            'teguran_penalty' => 'nullable|integer',
            'teguran_total' => 'nullable|integer'
        ]);

        // Simpan data ke dalam database
        TrskpispvModel::create($validated);
        
        // Redirect atau tampilkan pesan sukses
        return redirect()->route('Trskpispv.index')->with('success', 'Data penilaian berhasil disimpan!');
    }
}
