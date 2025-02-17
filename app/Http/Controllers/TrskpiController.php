<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrsKpi;
use App\Models\MdPegawai; // Jika pegawai disimpan di tabel users
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TrsKpiController extends Controller
{
    public function create()
    {
        $employees = MdPegawai::all(); // Sesuaikan dengan model pegawai
        return view('trs_kpi.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pegawai' => 'required|uuid',
            'id_penilai' => 'required|uuid',
            'tahun' => 'required|digits:4',
            'semester' => 'required|in:1,2',
            'kelebihan' => 'nullable|string',
            'improvement' => 'nullable|string',
            'target_completion_score' => 'required|numeric|min:0|max:5',
            'work_quality_score' => 'required|numeric|min:0|max:5',
            'obedience_score' => 'required|numeric|min:0|max:5',
            'teamwork_score' => 'required|numeric|min:0|max:5',
            'initiative_score' => 'required|numeric|min:0|max:5',
        ]);

        // Hitung nilai akhir (asumsi total bobot 100)
        $nilai_akhir = (
            $validated['target_completion_score'] +
            $validated['work_quality_score'] +
            $validated['obedience_score'] +
            $validated['teamwork_score'] +
            $validated['initiative_score']
        ) * 4;

        // Tentukan Grade
        $grade = $this->calculateGrade($nilai_akhir);

        TrsKpi::create([
            'id' => Str::uuid(),
            'id_pegawai' => $validated['id_pegawai'],
            'id_penilai' => $validated['id_penilai'],
            'nilai_akhir' => $nilai_akhir,
            'grade' => $grade,
            'kelebihan' => $validated['kelebihan'],
            'improvement' => $validated['improvement'],
            'tahun' => $validated['tahun'],
            'semester' => $validated['semester'],
            'status_kpi' => 'review_spv',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('trs_kpi.create')->with('success', 'Penilaian berhasil disimpan!');
    }

    private function calculateGrade($score)
    {
        if ($score >= 80) return 'A';
        if ($score >= 70) return 'B';
        if ($score >= 60) return 'C';
        return 'D';
    }
}
