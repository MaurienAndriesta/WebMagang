<?php

namespace App\Http\Controllers;

use App\Models\TrsKpi;
use App\Models\MdPegawai;
use App\Models\MdPenilaian;
use App\Models\TrsKpiItem;
use App\Models\MdSkalapenilaian;
use App\Models\MdNilaiakhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class KPIController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userRole = $user->role;
        $pegawai = MdPegawai::find($user->id_pegawai);  // Pastikan relasi ini ada

        $kpis = TrsKpi::with(['pegawai', 'pegawai.bidang', 'penilai'])->orderBy('created_at', 'desc')->get();

        if ($pegawai->jabatan == 'Staff') {
            $kpis = $kpis->where('id_pegawai', $pegawai->id);
        } elseif ($request->has('search')) { // Tambahkan pencarian hanya jika bukan staff
            $kpis = $kpis->whereHas('pegawai', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            });
        }


        return view('kpi.index', compact('kpis', 'pegawai', 'userRole')); // Kirim $pegawai ke view
    }

    public function create()
    {
        $pegawai = MdPegawai::all();
        $penilaianItems = MdPenilaian::all();
        $user = Auth::user();
        $skalaPenilaian = MdSkalapenilaian::all(); // Ambil data skala penilaian
        $nilaiAkhirRentang = MdNilaiakhir::all();



        return view('kpi.create', compact('pegawai', 'penilaianItems', 'user', 'skalaPenilaian', 'nilaiAkhirRentang')); // Pass ke view

    }


    public function store(Request $request)
{
    $user = Auth::user();
    $pegawai = MdPegawai::find($user->id_pegawai);

    $validatedData = $request->validate([
        'id_pegawai' => 'required',
        'tahun' => 'required|numeric',
        'semester' => 'required|in:1,2',
        'items.*.nilai_spv' => 'sometimes|nullable|numeric',
        'items.*.nilai_manager' => 'sometimes|nullable|numeric',
        'items.*.catatan' => 'nullable|string',
        'kedisiplinan.*.hari' => 'sometimes|nullable|numeric',
        'kedisiplinan.*.penalty_score' => 'sometimes|nullable|numeric',
        'improvement' => 'nullable|string',
        'kelebihan' => 'nullable|string',
        'total_penalty_score' => 'nullable|numeric', // Validasi total penalty score
        'nilai_akhir' => 'required|numeric|min:0', // Validasi nilai akhir
        'grade' => 'required|string|max:2',
        'status' => 'required|string',

    ]);
    try {
        // Simpan data ke tabel trs_kpi
        $kpi = TrsKpi::create([
            'id_pegawai' => $validatedData['id_pegawai'],
            'tahun' => $validatedData['tahun'],
            'semester' => $validatedData['semester'],
            'improvement' => $validatedData['improvement'],
            'kelebihan' => $validatedData['kelebihan'],
            'nilai_akhir' => $validatedData['nilai_akhir'],
            'grade' => $validatedData['grade'],
            'status' => $validatedData['status'],
            'total_penalty_score' => $validatedData['total_penalty_score'],
            'id_penilai' => $user->id_pegawai, // Pastikan ada kolom id_penilai di tabel trs_kpi
        ]);


        // Simpan data ke tabel trs_kpi_item (items)
        foreach ($request->input('items', []) as $itemId => $itemData) {

            TrsKpiItem::create([
                'idKpi' => $kpi->id,
                'id_penilaian' => $itemId,
                'nilai_spv' => $itemData['nilai_spv'],
                'nilai_manager' => $itemData['nilai_manager'],
                'catatan' => $itemData['catatan'],
                'score' => $itemData['score'],
            ]);
        }

        // Simpan data ke tabel trs_kpi_item (kedisiplinan)
        foreach ($request->input('kedisiplinan', []) as $itemId => $itemData) {
            TrsKpiItem::create([
                'idKpi' => $kpi->id,
                'id_penilaian' => $itemId,
                'hari' => $itemData['hari'],
                'penalty_score' => $itemData['penalty_score'],
            ]);
        }


        return redirect()->route('kpi.index')->with('success', 'KPI berhasil dibuat.');

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
          // return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
    }
}

    public function inputNilai(TrsKpi $kpi)
    {
        $penilaianItems = MdPenilaian::all();
        $user = Auth::user();
        $pegawai = MdPegawai::find($user->id_pegawai);

        // Akses item KPI melalui relasi:
        $existingItems = $kpi->kpiItems; // Mengambil semua item yang terkait dengan KPI ini

        // Authorization using policies (recommended)
        //$this->authorize('update', $kpi);

         // Manual authorization (less recommended, but shown here for clarity)
        if (! (($pegawai->jabatan == 'SPV' && $kpi->status == 'Review SPV') ||
            ($pegawai->jabatan == 'Manager' && $kpi->status == 'Review Manager')) )
        {
            abort(403, 'Unauthorized');
        }



        return view('kpi.input_nilai', compact('kpi', 'penilaianItems', 'pegawai'));
    }


    public function ajukan(TrsKpi $kpi)
    {
        // Authorize SPV
        $user = Auth::user();
        $pegawai = MdPegawai::find($user->id_pegawai);
        if ($pegawai->jabatan != 'SPV' || $kpi->status != 'Review SPV') {
            abort(403);
        }

        $kpi->status = 'Review Manager';
        $kpi->save();

        return redirect()->route('kpi.index')->with('success', 'KPI diajukan.');
    }


    public function approve(TrsKpi $kpi)
    {
        // Authorize Manager
        $user = Auth::user();
        $pegawai = MdPegawai::find($user->id_pegawai);
        if ($pegawai->jabatan != 'Manager' || $kpi->status != 'Review Manager') {
            abort(403);
        }


        $kpi->status = 'Approved';
        $kpi->save();

        return redirect()->route('kpi.index')->with('success', 'KPI disetujui.');
    }

    public function download(TrsKpi $kpi)
    {
        // Check if Approved (and potentially authorize based on user role)
        if ($kpi->status !== 'Approved') {
            abort(403, 'KPI belum disetujui.');
        }

        $pdf = PDF::loadView('kpi.report', compact('kpi')); // Create your 'kpi.report' view
        return $pdf->download('laporan_kpi_' . $kpi->id . '.pdf');
    }

}
