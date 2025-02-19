<?php

namespace App\Http\Controllers;

use App\Models\MdPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MdPenilaianController extends Controller
{
    public function index(Request $request)
    {
        $query = MdPenilaian::query();

        // Handle search
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $penilaians = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('md_penilaian', compact('penilaians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric',
            'kategori' => 'required|in:Kriteria Penilaian,Penilaian Kedisiplinan'
        ]);

        $penilaian = new MdPenilaian();
        $penilaian->id = (string) Str::uuid();
        $penilaian->nama = $request->nama;
        $penilaian->bobot = $request->bobot;
        $penilaian->kategori = $request->kategori;
        $penilaian->created_by = auth()->id();
        $penilaian->save();

        return redirect()->route('penilaian.index')->with('success', 'Data bidang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric',
            'kategori' => 'required|in:Kriteria Penilaian,Penilaian Kedisiplinan'
        ]);

        $penilaian = MdPenilaian::findOrFail($id);
        $penilaian->update([
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'kategori' => $request->kategori,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil diupdate');
    }
    public function destroy($id)
    {
        $penilaian = MdPenilaian::findOrFail($id);
        $penilaian->update(['deleted_by' => auth()->id()]);
        $penilaian->delete();

        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil dihapus');
    }
}