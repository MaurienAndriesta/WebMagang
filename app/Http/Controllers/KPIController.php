<?php

// app/Http/Controllers/KpiController.php
namespace App\Http\Controllers;

use App\Models\TrsKpi;
use App\Models\TrsKpiItem;
use App\Models\MdNilaiAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KpiController extends Controller
{
    public function index()
    {
        $kpis = TrsKpi::orderBy('created_at', 'desc')->paginate(10);
        return view('penilaian_spv', compact('kpis'));
    }

    private function tentukanGrade($nilai)
    {
        $grade = MdNilaiAkhir::where('nilai_awal', '<=', $nilai)
                             ->where('nilai_akhir', '>=', $nilai)
                             ->first();

        return $grade ? $grade->grade : 'E';
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|uuid',
            'id_penilai' => 'required|uuid',
            'tahun' => 'required|numeric',
            'semester' => 'required|in:1,2',
            'items' => 'required|array',
            'items.*.id_penilaian' => 'required|uuid',
            'items.*.nilai_spv' => 'required|numeric|min:0|max:100',
        ]);

        $kpi = new TrsKpi();
        $kpi->id_pegawai = $request->id_pegawai;
        $kpi->id_penilai = $request->id_penilai;
        $kpi->tahun = $request->tahun;
        $kpi->semester = $request->semester;
        $kpi->status_kpi = 'review_spv';
        $kpi->created_by = Auth::id();
        $kpi->save();

        foreach ($request->items as $item) {
            TrsKpiItem::create([
                'id_kpi' => $kpi->id,
                'id_penilaian' => $item['id_penilaian'],
                'nilai_spv' => $item['nilai_spv'],
                'created_by' => Auth::id(),
            ]);
        }

        return redirect()->route('kpi.index')->with('success', 'KPI berhasil disimpan');
    }

    public function submitToManager($id)
    {
        $kpi = TrsKpi::findOrFail($id);
        $kpi->status_kpi = 'review_manager';
        $kpi->save();

        return redirect()->route('kpi.index')->with('success', 'KPI diajukan ke Manager');
    }

    public function managerEvaluate(Request $request, $id)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|uuid',
            'items.*.nilai_manager' => 'required|numeric|min:0|max:100',
        ]);

        $kpi = TrsKpi::findOrFail($id);

        foreach ($request->items as $item) {
            $kpiItem = TrsKpiItem::findOrFail($item['id']);
            $kpiItem->nilai_manager = $item['nilai_manager'];
            $kpiItem->updated_by = Auth::id();
            $kpiItem->save();
        }

        $total_spv = $kpi->kpiItems()->sum('nilai_spv');
        $total_manager = $kpi->kpiItems()->sum('nilai_manager');
        $total_items = $kpi->kpiItems()->count();

        // Hitung nilai akhir
        $nilai_akhir = (($total_spv + $total_manager) / (2 * $total_items));
        $kpi->nilai_akhir = $nilai_akhir;
        $kpi->grade = $this->tentukanGrade($nilai_akhir);
        $kpi->status_kpi = 'approved';
        $kpi->updated_by = Auth::id();
        $kpi->save();

        return redirect()->route('penilaian_spv.index')->with('success', 'Penilaian Manager berhasil disimpan');
    }
}