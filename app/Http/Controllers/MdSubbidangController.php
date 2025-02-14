<?php

namespace App\Http\Controllers;

use App\Models\MdSubbidang;
use App\Models\MdBidang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MdSubbidangController extends Controller
{
    // Menampilkan daftar subbidang
    public function index(Request $request)
    {
        $query = MdSubbidang::with('bidang');
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        $subbidangs = $query->paginate(10);
        $bidangs = MdBidang::all(); // Ambil semua bidang
    
        return view('md_subbidang', compact('subbidangs', 'bidangs'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'unit_id' => 'required|exists:md_bidang,id'
        ]);

        MdSubbidang::create([
            'id' => (string) Str::uuid(),
            'unit_id' => $request->unit_id,
            'nama' => $request->nama,
            'created_by' => auth()->id()
        ]);

        return redirect()->route('subbidang.index')->with('success', 'Subbidang berhasil ditambahkan');
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'unit_id' => 'required|exists:md_bidang,id'
        ]);

        $subbidang = MdSubbidang::findOrFail($id);
        $subbidang->update([
            'nama' => $request->nama,
            'unit_id' => $request->unit_id,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('subbidang.index')->with('success', 'Subbidang berhasil diperbarui');
    }

    // Menghapus data
    public function destroy($id)
    {
        $subbidang = MdSubbidang::findOrFail($id);
        $subbidang->update(['deleted_by' => auth()->id()]); // Simpan siapa yang menghapus
        $subbidang->delete(); // Soft delete

        return redirect()->route('subbidang.index')->with('success', 'Subbidang berhasil dihapus');
    }
}