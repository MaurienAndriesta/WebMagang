<?php

namespace App\Http\Controllers;

use App\Models\Kpi_manager;
use App\Models\TrsKpi;
use App\Models\Trskpiitem;
use App\Models\MdNilaiAkhir;
use App\Models\Trskpimanager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Kpi_managerController extends Controller
{
    public function index()
    {
        $kpis = Trskpimanager::orderBy('created_at', 'desc')->paginate(10);
        return view('trs_kpi', compact('kpis'));
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

        $kpi = new Trskpimanager();
        $kpi->id_pegawai = $request->id_pegawai;
        $kpi->id_penilai = $request->id_penilai;
        $kpi->tahun = $request->tahun;
        $kpi->semester = $request->semester;
        $kpi->status_kpi = 'review_spv';
        $kpi->created_by = Auth::id();
        $kpi->save();

        foreach ($request->items as $item) {
            TrskpiItem::create([
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
        $kpi = Trskpimanager::findOrFail($id);
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

        $kpi = Trskpimanager::findOrFail($id);

        foreach ($request->items as $item) {
            $kpiItem = TrskpiItem::findOrFail($item['id']);
            $kpiItem->nilai_manager = $item['nilai_manager'];
            $kpiItem->updated_by = Auth::id();
            $kpiItem->save();
        }

        $total_spv = $kpi->kpiItems()->sum('nilai_spv');
        $total_manager = $kpi->kpiItems()->sum('nilai_manager');
        $total_items = $kpi->kpiItems()->count();

        $nilai_akhir = (($total_spv + $total_manager) / (2 * $total_items));
        $grade = $this->tentukanGrade($nilai_akhir);

        $kpi->nilai_akhir = $nilai_akhir;
        $kpi->grade = $grade;
        $kpi->status_kpi = 'approved';
        $kpi->updated_by = Auth::id();
        $kpi->save();

        return redirect()->route('kpi.index')->with('success', 'Penilaian Manager berhasil disimpan');
    }
}