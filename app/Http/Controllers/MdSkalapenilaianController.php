<?php

namespace App\Http\Controllers;

use App\Models\MdSkalapenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MdSkalapenilaianController extends Controller
{
    // Menampilkan daftar skala penilaian
    public function index(Request $request)
    {
        $query = MdSkalapenilaian::query();

        if ($request->has('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        $skalaList = $query->orderBy('created_at', 'asc')->paginate(10);
        return view('md_skalapenilaian', compact('skalaList'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'angka' => 'required|integer|unique:md_skalapenilaian',
            'keterangan' => 'required|string|max:255',
        ]);

        $skala = new MdSkalapenilaian();
        $skala->id = (string) Str::uuid();
        $skala->angka = $request->angka;
        $skala->keterangan = $request->keterangan;
        $skala->created_by = Auth::id();
        $skala->save();

        return redirect()->route('skala-penilaian.index')->with('success', 'Skala Penilaian berhasil ditambahkan');
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $request->validate([
            'angka' => 'required|integer|unique:md_skalapenilaian,angka,' . $id,
            'keterangan' => 'required|string|max:255',
        ]);

        $skala = MdSkalapenilaian::findOrFail($id);
        $skala->angka = $request->angka;
        $skala->keterangan = $request->keterangan;
        $skala->updated_by = Auth::id();
        $skala->save();

        return redirect()->route('skala-penilaian.index')->with('success', 'Skala Penilaian berhasil diperbarui');
    }

    // Menghapus data (soft delete)
    public function destroy($id)
    {
        $skala = MdSkalapenilaian::findOrFail($id);
        $skala->deleted_by = Auth::id();
        $skala->save();
        $skala->delete();

        return redirect()->route('skala-penilaian.index')->with('success', 'Skala Penilaian berhasil dihapus');
    }
}