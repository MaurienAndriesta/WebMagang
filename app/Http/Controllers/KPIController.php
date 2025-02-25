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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class KPIController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userRole = $user->role;
        $pegawai = MdPegawai::find($user->id_pegawai);  // Pastikan relasi ini ada

        $kpis = TrsKpi::with(['pegawai', 'penilai'])->orderBy('created_at', 'desc');

        if ($request->has('search')) { // Tambahkan pencarian hanya jika bukan staff
            $kpis = $kpis->whereHas('pegawai', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            });
        }
        $kpis = $kpis->get();

        return view('kpi.index', compact('kpis', 'pegawai', 'userRole')); // Kirim $pegawai ke view
    }

    public function create()
    {
        $pegawai = MdPegawai::all();
        $penilaianItems = MdPenilaian::all();
        $user = Auth::user();
        $skalaPenilaian = MdSkalapenilaian::all(); // Ambil data skala penilaian
        $nilaiAkhirRentang = MdNilaiakhir::all();
        $hariSuratTeguran = TrsKpiItem::whereHas('penilaian', function ($query) {
            $query->where('nama', 'Surat Teguran');
        })
        ->where('id_kpi', $kpi->id ?? null) // Ambil berdasarkan KPI jika edit
        ->value('hari') ?? 0; // Jika tidak ada, default 0
        return view('kpi.create', compact('pegawai', 'penilaianItems', 'user', 'skalaPenilaian', 'nilaiAkhirRentang', 'hariSuratTeguran')); // Pass ke view

    }

    public function editspv(TrsKpi $kpi)
    {
        // dd($kpi);
        $pegawai = MdPegawai::all();
    $penilaianItems = MdPenilaian::all();
    $skalaPenilaian = MdSkalapenilaian::all();
    $nilaiAkhirRentang = MdNilaiAkhir::all();
    $user = Auth::user();

    // Pastikan $kpi->pegawai tidak null
    if (!$kpi->pegawai) {
        abort(404, 'Pegawai tidak ditemukan.');
    }
    $userRole = Auth::user()->role;
    if ($userRole == 'spv' && $kpi->status_kpi == 'Review Manager') {
        abort(403, 'Anda tidak dapat mengedit KPI yang sudah dalam status Review Manager.');
    }

    $namaAtasan = $kpi->penilai ? $kpi->penilai->nama : '-'; // Gunakan relasi penilai untuk mengambil nama atasan
    $hariSuratTeguran = TrsKpiItem::whereHas('penilaian', function ($query) {
        $query->where('nama', 'Surat Teguran');
    })
    ->where('id_kpi', $kpi->id ?? null) // Ambil berdasarkan KPI jika edit
    ->value('hari') ?? 0; // Jika tidak ada, default 0


    return view('kpi.editspv', compact('kpi', 'pegawai', 'penilaianItems', 'skalaPenilaian', 'nilaiAkhirRentang', 'namaAtasan', 'user', 'hariSuratTeguran'));


    }

    public function editmanager(TrsKpi $kpi)
    {
        $pegawai = MdPegawai::all();
    $penilaianItems = MdPenilaian::all();
    $skalaPenilaian = MdSkalapenilaian::all();
    $nilaiAkhirRentang = MdNilaiAkhir::all();
    $user = Auth::user();

    // Pastikan $kpi->pegawai tidak null
    if (!$kpi->pegawai) {
        abort(404, 'Pegawai tidak ditemukan.');
    }
    $userRole = Auth::user()->role;
    if ($userRole == 'manager' && $kpi->status_kpi == 'Approved') {
        abort(403, 'Anda tidak dapat mengedit KPI yang sudah dalam status Approved.');
    }

    $namaAtasan = $kpi->penilai ? $kpi->penilai->nama : '-'; // Gunakan relasi penilai untuk mengambil nama atasan
    $hariSuratTeguran = TrsKpiItem::whereHas('penilaian', function ($query) {
        $query->where('nama', 'Surat Teguran');
    })
    ->where('id_kpi', $kpi->id ?? null) // Ambil berdasarkan KPI jika edit
    ->value('hari') ?? 0; // Jika tidak ada, default 0


    return view('kpi.editmanager', compact('kpi', 'pegawai', 'penilaianItems', 'skalaPenilaian', 'nilaiAkhirRentang', 'namaAtasan', 'user', 'hariSuratTeguran'));

    }

    public function final(TrsKpi $kpi)
    {
        $pegawai = MdPegawai::all();
    $penilaianItems = MdPenilaian::all();
    $skalaPenilaian = MdSkalapenilaian::all();
    $nilaiAkhirRentang = MdNilaiAkhir::all();
    $user = Auth::user();

    // Pastikan $kpi->pegawai tidak null
    if (!$kpi->pegawai) {
        abort(404, 'Pegawai tidak ditemukan.');
    }
    $userRole = Auth::user()->role;

    $namaAtasan = $kpi->penilai ? $kpi->penilai->nama : '-'; // Gunakan relasi penilai untuk mengambil nama atasan
    $hariSuratTeguran = TrsKpiItem::whereHas('penilaian', function ($query) {
        $query->where('nama', 'Surat Teguran');
    })
    ->where('id_kpi', $kpi->id ?? null) // Ambil berdasarkan KPI jika edit
    ->value('hari') ?? 0; // Jika tidak ada, default 0

    return view('kpi.final', compact('kpi', 'pegawai', 'penilaianItems', 'skalaPenilaian', 'nilaiAkhirRentang', 'namaAtasan', 'user', 'hariSuratTeguran'));

    }

    public function store(Request $request)
{
    // $isExistData = TrsKpi::where('id_pegawai', $request->id_pegawai)
    //                         ->where('tahun', $request->tahun)
    //                         ->where('semester', $request->semester)
    //                         ->exists();

    // if ($isExistData) {
    //     return redirect()->back()->withErrors(['id_pegawai' => 'Data KPI untuk pegawai, tahun, dan semester ini sudah ada.']);
    // }

     // Debugging: Cek data yang diterima
     Log::info('Data yang diterima:', $request->all());
     try {
     $validatedData = $request->validate([
        'id_pegawai' => 'required|uuid|exists:md_pegawai,id',
        'id_penilai' => 'required|uuid|exists:md_pegawai,id',
        'tahun' => [
        'required',
        'numeric',
        Rule::unique('trs_kpi')->where(function ($query) use ($request) {
            return $query->where('id_pegawai', $request->id_pegawai)
                         ->where('semester', $request->semester);
            })
        ],
        'semester' => 'required|in:1,2',
        'tanggal_penilaian' => 'required|date|before_or_equal:today',
        'items.*.nilai_spv' => 'sometimes|nullable|numeric',
        'items.*.nilai_manager' => 'sometimes|nullable|numeric',
        'items.*.catatan' => 'nullable|string',
        'kedisiplinan.*.hari' => 'sometimes|nullable|numeric',
        'improvement' => 'nullable|string',
        'kelebihan' => 'nullable|string',
        'nilai_akhir' => 'sometimes|nullable|numeric',
        'grade' => 'sometimes|nullable|string',
        'status_kpi' => 'required|in:Review SPV,Review Manager,Approved',
    ]);
     }catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validasi gagal:', $e->errors());
        return redirect()->back()->withErrors($e->errors());
    }
    // Debugging: Cek data yang divalidasi
    Log::info('Data yang divalidasi:', $validatedData);
    Log::info('ID Penilai yang akan disimpan:', ['id_penilai' => $validatedData['id_penilai']]);

    try {
        // Simpan data ke tabel trs_kpi
        $kpi = TrsKpi::create([
            'id' => Str::uuid(),
            'id_pegawai' => $validatedData['id_pegawai'],
            'tahun' => $validatedData['tahun'],
            'semester' => $validatedData['semester'],
            'tanggal_penilaian' => $validatedData['tanggal_penilaian'],
            'improvement' => $validatedData['improvement'],
            'kelebihan' => $validatedData['kelebihan'],
            'nilai_akhir' => $validatedData['nilai_akhir'],
            'grade' => $validatedData['grade'],
            'status_kpi' => $validatedData['status_kpi'],
            'id_penilai' => $validatedData['id_penilai'],
        ]);

        // Debugging: Cek apakah data berhasil disimpan
        Log::info('Data KPI berhasil disimpan:', $kpi->toArray());

        // Simpan data ke tabel trs_kpi_item (items)
        foreach ($request->input('items', []) as $itemId => $itemData) {

            TrsKpiItem::create([
                'id' => Str::uuid(),
                'id_kpi' => $kpi->id,
                'id_penilaian' => $itemId,
                'nilai_spv' => $itemData['nilai_spv'],
                'nilai_manager' => $itemData['nilai_manager'],
                'catatan' => $itemData['catatan'],
            ]);
        }

        // Simpan data ke tabel trs_kpi_item (kedisiplinan)
        foreach ($request->input('kedisiplinan', []) as $itemId => $itemData) {
            $dt = TrsKpiItem::create([
                'id_kpi' => $kpi->id,
                'id_penilaian' => $itemId,
                'hari' => $itemData['hari'],
            ]);
        }

        return redirect()->route('kpi.index')->with('success', 'KPI berhasil dibuat.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Tampilkan pesan kesalahan
        return redirect()->back()->withErrors($e->validator->errors());
    } catch (\Exception $e) {
        Log::error('Kesalahan saat menyimpan KPI:', ['error' => $e->getMessage()]);
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}

public function update(Request $request, $id)
    {
    //     $isExistData = TrsKpi::where('id_pegawai', $request->id_pegawai)
    //                         ->where('tahun', $request->tahun)
    //                         ->where('semester', $request->semester)
    //                         ->exists();

    // if ($isExistData) {
    //     return redirect()->back()->withErrors(['id_pegawai' => 'Data KPI untuk pegawai, tahun, dan semester ini sudah ada.']);
    // }
        $user = Auth::user();
    $userRole = $user->role;
        Log::info('Data yang diterima untuk update KPI:', $request->all());
        Log::info('Status KPI yang dikirimkan:', ['status_kpi' => $request->status_kpi]);

        try {
            $validatedData = $request->validate([
            'id_pegawai' => 'required|uuid|exists:md_pegawai,id',
            'id_penilai' => 'required|uuid|exists:md_pegawai,id',
            'tahun' => [
            'required',
            'numeric',
            Rule::unique('trs_kpi')->where(function ($query) use ($request) {
                return $query->where('id_pegawai', $request->id_pegawai)
                            ->where('semester', $request->semester);
                })->ignore($id),
            ],
            'semester' => 'required|in:1,2',
            'tanggal_penilaian' => 'required|date|before_or_equal:today',
            'items.*.nilai_spv' => 'sometimes|nullable|numeric',
            'items.*.nilai_manager' => 'sometimes|nullable|numeric',
            'items.*.catatan' => 'nullable|string',
            'kedisiplinan.*.hari' => 'sometimes|nullable|numeric',
            'improvement' => 'nullable|string',
            'kelebihan' => 'nullable|string',
            'nilai_akhir' => 'sometimes|nullable|numeric',
            'grade' => 'sometimes|nullable|string',
            'status_kpi' => 'required|in:Review SPV,Review Manager,Approved',
        ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validasi gagal:', $e->errors());
        return redirect()->back()->withErrors($e->errors());
        }
        // Debugging: Cek data yang divalidasi
        Log::info('Data yang divalidasi:', $validatedData);

        try {
        $kpi = TrsKpi::findOrFail($id); // Pastikan KPI ditemukan
        Log::info('KPI ditemukan untuk update:', ['kpi_id' => $kpi->id]);

        if ($userRole == 'spv' && $kpi->status_kpi == 'Review Manager') {
            return redirect()->route('kpi.index')->with('error', 'Anda tidak dapat mengedit KPI yang sudah dalam status Review Manager.');
        }
        if ($userRole == 'manager' && $kpi->status_kpi == 'Approved') {
            return redirect()->route('kpi.index')->with('error', 'Anda tidak dapat mengedit KPI yang sudah dalam status Approved.');
        }

        $kpi->update([
            'id_pegawai' => $request->id_pegawai,
            'id_penilai' => $request->id_penilai,
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'improvement' => $request->improvement,
            'kelebihan' => $request->kelebihan,
            'nilai_akhir' => $request->nilai_akhir,
            'grade' => $request->grade,
            'status_kpi' => $request->status_kpi,
            'updated_by' => auth()->id()
        ]);

        // Update atau buat item KPI
        foreach ($request->input('items', []) as $itemId => $itemData) {
            $kpiItem = TrsKpiItem::where('id_kpi', $kpi->id)
                                   ->where('id_penilaian', $itemId)
                                   ->firstOrNew(); // firstOrNew untuk membuat baru jika belum ada


            $kpiItem->nilai_spv = $itemData['nilai_spv'];
            $kpiItem->nilai_manager = $itemData['nilai_manager'];
            $kpiItem->catatan = $itemData['catatan'];

            $kpiItem->save();
        }

        // Update atau buat data kedisiplinan
        foreach ($request->input('kedisiplinan', []) as $itemId => $itemData) {

            $kpiItem = TrsKpiItem::where('id_kpi', $kpi->id)
                                ->where('id_penilaian', $itemId)
                                ->firstOrNew(); // firstOrCreate untuk membuat baru jika belum ada


            $kpiItem->hari = $itemData['hari'];
            $kpiItem->save();
        }

        return redirect()->route('kpi.index')->with('success', 'Penilaian berhasil diperbarui.');
    }catch (\Exception $e) {
        Log::error('Kesalahan saat memperbarui KPI: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui KPI. Silakan coba lagi.']);
    }
}

public function downloadPDF($id)
{
    // Ambil data KPI berdasarkan ID
    $kpi = TrsKpi::with(['pegawai', 'kpiItems.penilaian'])->findOrFail($id);

    // Siapkan data untuk view
    $data = [
        'kpi' => $kpi,
        'pegawai' => $kpi->pegawai,
        'penilaianItems' => MdPenilaian::all(), // Ambil semua penilaian items
        'skalaPenilaian' => MdSkalapenilaian::all(), // Ambil semua skala penilaian
        'nilaiAkhirRentang' => MdNilaiakhir::all(), // Ambil rentang nilai akhir
    ];

    // Generate PDF
    $pdf = PDF::loadView('kpi.pdf', $data);

    // Download PDF
    return $pdf->download('kpi.pdf');
}


    public function destroy($id)
    {
        $kpi = TrsKpi::findOrFail($id);
        $kpi->update(['deleted_by' => auth()->id()]);
        $kpi->delete();

        return redirect()->route('kpi.index')->with('success', 'Data kpi berhasil dihapus');
    }
}