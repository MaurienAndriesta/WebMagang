<?php

namespace App\Http\Controllers;

use App\Models\Trskpimanager;
use Illuminate\Http\Request;

class TrskpimanagerController extends Controller
{
    // Tampilkan form
    public function index()
    {
        return view('Trskpimanager.index');
    }

    // Proses penyimpanan penilaian
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'bidang' => 'required|string',
            'masakerja' => 'required|string',
            'nama_penilai' => 'required|string',
            'periode_penilaian' => 'required|string',
            'tanggal_penilaian' => 'required|date',
            'sub_dir' => 'required|string',
            'kelebihan' => 'nullable|string',
            'improvement' => 'nullable|string',
            'items' => 'required|array',
            'datang_lambat_hari' => 'nullable|integer',
            'datang_lambat_penalty' => 'nullable|integer',
            'datang_lambat_total' => 'nullable|integer',
            'mangkir_hari' => 'nullable|integer',
            'mangkir_penalty' => 'nullable|integer',
            'mangkir_total' => 'nullable|integer',
            'teguran_hari' => 'nullable|integer',
            'teguran_penalty' => 'nullable|integer',
            'teguran_total' => 'nullable|integer',
        ]);

        Trskpimanager::create($data);

        return redirect()->route('Trskpimanager.index')->with('success', 'Data berhasil disimpan');
    }
}
