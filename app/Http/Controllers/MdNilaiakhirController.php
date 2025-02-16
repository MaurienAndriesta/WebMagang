<?php

namespace App\Http\Controllers;

use App\Models\MdNilaiakhir;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MdNilaiAkhirController extends Controller
{
    // Menampilkan daftar nilai akhir
    public function index(Request $request)
    {
        $query = MdNilaiakhir::query();

        if ($request->has('search')) {
            $query->where('grade', 'like', '%' . $request->search . '%');
        }

        $nilaiAkhirList = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('md_nilaiakhir', compact('nilaiAkhirList'));
    }

    // Menyimpan data baru
    public function store(Request $request)
{

    $request->validate([
        'nilai_awal' => 'required|numeric|min:1',
        'nilai_akhir' => 'required|numeric|min:1',
        'grade' => 'required|string|max:2',
    ]);

    $nilaiAkhir = new MdNilaiakhir();
    $nilaiAkhir->nilai_awal = $request->input('nilai_awal');
    $nilaiAkhir->nilai_akhir = $request->input('nilai_akhir');
    $nilaiAkhir->grade = $request->input('grade');
    $nilaiAkhir->created_by = Auth::check() ? Auth::id() : null;
    $nilaiAkhir->save();
    

    return redirect()->route('nilai-akhir.index')->with('success', 'Nilai Akhir berhasil ditambahkan');
}

    

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_awal' => 'required|numeric|min:0|max:100',
            'nilai_akhir' => 'required|numeric|min:0|max:100',
            'grade' => 'required|string|max:2',
        ]);

        $nilaiAkhir = MdNilaiakhir::findOrFail($id);
        $nilaiAkhir->nilai_awal = $request->nilai_awal;
        $nilaiAkhir->nilai_akhir = $request->nilai_akhir;
        $nilaiAkhir->grade = $request->grade;
        $nilaiAkhir->updated_by = Auth::check() ? Auth::id() : null;
        $nilaiAkhir->save();

        return redirect()->route('nilai-akhir.index')->with('success', 'Nilai Akhir berhasil diperbarui');
    }

    // Menghapus data (soft delete)
    public function destroy($id)
    {
        $nilaiAkhir = MdNilaiakhir::findOrFail($id);
        $nilaiAkhir->deleted_by = Auth::check() ? Auth::id() : null;
        $nilaiAkhir->save();
        $nilaiAkhir->delete();

        return redirect()->route('nilai-akhir.index')->with('success', 'Nilai Akhir berhasil dihapus');
    }
}