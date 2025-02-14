<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MdPegawai;
use App\Models\MdBidang;
use App\Models\MdSubbidang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MdPegawaiController extends Controller
{
    public function index()
    {
        $pegawais = MdPegawai::with(['atasan', 'bidang', 'subbidang'])->paginate(10);
        return view('md_pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        $bidangs = MdBidang::all();
        $subbidangs = MdSubbidang::all();
        $atasans = MdPegawai::all();
        return view('md_pegawai.create', compact('bidangs', 'subbidangs', 'atasans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masakerja' => 'required|integer|min:0',
            'status' => 'required|in:aktif,non-aktif',
            'id_bidang' => 'required|exists:md_bidang,id',
            'id_subbidang' => 'required|exists:md_subbidang,id',
            'id_atasan' => 'nullable|exists:md_pegawai,id'
        ]);

        MdPegawai::create([
            'id' => Str::uuid(),
            'id_atasan' => $request->id_atasan,
            'id_bidang' => $request->id_bidang,
            'id_subbidang' => $request->id_subbidang,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'masakerja' => $request->masakerja,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pegawai = MdPegawai::findOrFail($id);
        $bidangs = MdBidang::all();
        $subbidangs = MdSubbidang::all();
        $atasans = MdPegawai::all();
        return view('md_pegawai.edit', compact('pegawai', 'bidangs', 'subbidangs', 'atasans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'masakerja' => 'required|integer|min:0',
            'status' => 'required|in:aktif,non-aktif',
            'id_bidang' => 'required|exists:md_bidang,id',
            'id_subbidang' => 'required|exists:md_subbidang,id',
            'id_atasan' => 'nullable|exists:md_pegawai,id'
        ]);

        $pegawai = MdPegawai::findOrFail($id);
        $pegawai->update([
            'id_atasan' => $request->id_atasan,
            'id_bidang' => $request->id_bidang,
            'id_subbidang' => $request->id_subbidang,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'masakerja' => $request->masakerja,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pegawai = MdPegawai::findOrFail($id);
        $pegawai->update(['deleted_by' => Auth::id()]);
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}
