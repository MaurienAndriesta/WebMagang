<?php

namespace App\Http\Controllers;

use App\Models\MdPegawai;
use App\Models\MdBidang;
use App\Models\MdSubBidang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MdPegawaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pegawaiList = MdPegawai::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'asc')
        ->paginate(10);

        $bidangList = MdBidang::all();
        $subbidangList = MdSubBidang::all();
        $atasanList = MdPegawai::where('jabatan', 'Manager')->get(); // Filter hanya Manager

        return view('md_pegawai', compact('pegawaiList', 'bidangList', 'subbidangList', 'atasanList'));
    }
    
    public function kpi(Request $request)
{
    $search = $request->input('search');
    $pegawaiList = MdPegawai::with(['latestKpi', 'bidang', 'subbidang']) // Memuat relasi yang diperlukan
        ->when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'asc')
        ->paginate(10);

    $bidangList = MdBidang::all();
    $subbidangList = MdSubBidang::all();
    $atasanList = MdPegawai::where('jabatan', 'Manager')->get(); // Filter hanya Manager
    
    return view('Halkpi', compact('pegawaiList', 'bidangList', 'subbidangList', 'atasanList'));
}

public function showFormPenilaian($id)
{
    $pegawai = MdPegawai::find($id);

    if (!$pegawai) {
        return redirect()->route('pegawai.index')->with('error', 'Pegawai tidak ditemukan.');
    }

    $atasan = MdPegawai::find($pegawai->id_atasan); // Ambil atasan jika ada

    return view('Halkpi', compact('pegawai', 'atasan'));
}

    public function create()
    {
        $bidangList = MdBidang::all();
        $subbidangList = MdSubBidang::all();
        $atasanList = MdPegawai::where('jabatan', 'Manager')->get(); // Filter hanya Manager
        return view('pegawai.create', compact('bidangList', 'subbidangList', 'atasanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masakerja' => 'required|integer',
            'status' => 'required|in:aktif,non-aktif',
            'id_bidang' => 'required|uuid|exists:md_bidang,id',
            'id_subbidang' => 'required|uuid|exists:md_subbidang,id',
            'id_atasan' => 'nullable|uuid|exists:md_pegawai,id',
        ]);

        MdPegawai::create([
            'id' => Str::uuid(),
            'id_bidang' => $request->id_bidang,
            'id_subbidang' => $request->id_subbidang,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'masakerja' => $request->masakerja,
            'status' => $request->status,
            'id_atasan' => $request->id_atasan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = MdPegawai::findOrFail($id);
        $bidangList = MdBidang::all();
        $subbidangList = MdSubBidang::all();
        $atasanList = MdPegawai::where('jabatan', 'Manager')->get(); // Filter hanya Manager
        return view('pegawai.edit', compact('pegawai', 'bidangList', 'subbidangList', 'atasanList'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = MdPegawai::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masakerja' => 'required|integer',
            'status' => 'required|in:aktif,non-aktif',
            'id_bidang' => 'required|uuid|exists:md_bidang,id',
            'id_subbidang' => 'required|uuid|exists:md_subbidang,id',
            'id_atasan' => 'nullable|uuid|exists:md_pegawai,id',
        ]);

        $pegawai->update([
            'id_bidang' => $request->id_bidang,
            'id_subbidang' => $request->id_subbidang,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'masakerja' => $request->masakerja,
            'status' => $request->status,
            'id_atasan' => $request->id_atasan,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = MdPegawai::findOrFail($id);
        $pegawai->update(['deleted_by' => auth()->id()]);
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}