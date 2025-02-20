<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KpiPenilaian;
use App\Models\MdPenilaian;

class KpiPenilaianController extends Controller
{
    public function index()
    {
        $kriteria = MdPenilaian::all(); // Ambil semua kriteria penilaian
        return view('penilaian.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items.*.kriteria_id'  => 'required|exists:md_penilaian,id',
            'items.*.nilai_spv'    => 'required|integer|min:1|max:5',
            'items.*.nilai_manager'=> 'required|integer|min:1|max:5',
        ]);

        foreach ($request->items as $item) {
            $bobot = MdPenilaian::find($item['kriteria_id'])->bobot;
            $score = ($item['nilai_spv'] + $item['nilai_manager']) * $bobot;

            KpiPenilaian::create([
                'kriteria_id'  => $item['kriteria_id'],
                'nilai_spv'    => $item['nilai_spv'],
                'nilai_manager'=> $item['nilai_manager'],
                'bobot'        => $bobot,
                'score'        => $score,
            ]);
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan!');
    }
}
