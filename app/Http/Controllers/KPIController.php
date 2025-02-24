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
use PDF;

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


        return view('kpi.create', compact('pegawai', 'penilaianItems', 'user', 'skalaPenilaian', 'nilaiAkhirRentang')); // Pass ke view

    }

    public function editspv(TrsKpi $kpi)
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
    if ($userRole == 'spv' && $kpi->status == 'Review Manager') {
        abort(403, 'Anda tidak dapat mengedit KPI yang sudah dalam status Review Manager.');
    }

    $namaAtasan = $kpi->penilai ? $kpi->penilai->nama : '-'; // Gunakan relasi penilai untuk mengambil nama atasan

    return view('kpi.editspv', compact('kpi', 'pegawai', 'penilaianItems', 'skalaPenilaian', 'nilaiAkhirRentang', 'namaAtasan', 'user'));


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
    if ($userRole == 'manager' && $kpi->status == 'Approved') {
        abort(403, 'Anda tidak dapat mengedit KPI yang sudah dalam status Approved.');
    }

    $namaAtasan = $kpi->penilai ? $kpi->penilai->nama : '-'; // Gunakan relasi penilai untuk mengambil nama atasan

    return view('kpi.editmanager', compact('kpi', 'pegawai', 'penilaianItems', 'skalaPenilaian', 'nilaiAkhirRentang', 'namaAtasan', 'user'));


    }

    public function store(Request $request)
{
     // Debugging: Cek data yang diterima
     Log::info('Data yang diterima:', $request->all());
     try {
     $validatedData = $request->validate([
        'id_pegawai' => 'required|uuid|exists:md_pegawai,id',
        'id_penilai' => 'required|uuid|exists:md_pegawai,id',
        'tahun' => 'required|numeric',
        'semester' => 'required|in:1,2',
        'items.*.nilai_spv' => 'sometimes|nullable|numeric',
        'items.*.nilai_manager' => 'sometimes|nullable|numeric',
        'items.*.catatan' => 'nullable|string',
        'kedisiplinan.*.nilai_spv' => 'sometimes|nullable|numeric',
        'improvement' => 'nullable|string',
        'kelebihan' => 'nullable|string',
        'nilai_akhir' => 'sometimes|nullable|numeric',
        'grade' => 'sometimes|nullable|string',
        'status' => 'required|in:Review SPV, Review Manager, Approved',
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
            'improvement' => $validatedData['improvement'],
            'kelebihan' => $validatedData['kelebihan'],
            'nilai_akhir' => $validatedData['nilai_akhir'],
            'grade' => $validatedData['grade'],
            'status' => $validatedData['status'],
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
            TrsKpiItem::create([
                'id_kpi' => $kpi->id,
                'id_penilaian' => $itemId,
                'nilai_spv' => $itemData['nilai_spv'],
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
        $user = Auth::user();
    $userRole = $user->role;
        Log::info('Data yang diterima untuk update KPI:', $request->all());
        Log::info('Status KPI yang dikirimkan:', ['status' => $request->status]);

        try {
            $validatedData = $request->validate([
            'id_pegawai' => 'required|uuid|exists:md_pegawai,id',
            'id_penilai' => 'required|uuid|exists:md_pegawai,id',
            'tahun' => 'required|numeric',
            'semester' => 'required|in:1,2',
            'items.*.nilai_spv' => 'nullable|numeric',
            'items.*.nilai_manager' => 'nullable|numeric',
            'items.*.catatan' => 'nullable|string',
            'kedisiplinan.*.nilai_spv' => 'sometimes|nullable|numeric',
            'improvement' => 'nullable|string',
            'kelebihan' => 'nullable|string',
            'nilai_akhir' => 'sometimes|nullable|numeric',
            'grade' => 'sometimes|nullable|string',
            'status' => 'required|in:Review SPV,Review Manager,Approved',
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

        if ($userRole == 'spv' && $kpi->status == 'Review Manager') {
            return redirect()->route('kpi.index')->with('error', 'Anda tidak dapat mengedit KPI yang sudah dalam status Review Manager.');
        }
        if ($userRole == 'manager' && $kpi->status == 'Approved') {
            return redirect()->route('kpi.index')->with('error', 'Anda tidak dapat mengedit KPI yang sudah dalam status Approved.');
        }

        $kpi->update([
            'id_pegawai' => $request->id_pegawai,
            'id_penilai' => $request->id_penilai,
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'improvement' => $request->improvement,
            'kelebihan' => $request->kelebihan,
            'nilai_akhir' => $request->nilai_akhir,
            'grade' => $request->grade,
            'status' => $request->status,
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


            $kpiItem->nilai_spv = $itemData['nilai_spv'];
            $kpiItem->save();
        }

        return redirect()->route('kpi.index')->with('success', 'Penilaian berhasil diperbarui.');
    }catch (\Exception $e) {
        Log::error('Kesalahan saat memperbarui KPI: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui KPI. Silakan coba lagi.']);
    }
}

    public function download(TrsKpi $kpi)
    {
        // Pastikan status KPI sudah 'Approved'
        if ($kpi->status != 'Approved') {
            abort(403, 'Laporan hanya bisa diunduh setelah penilaian disetujui.');
        }

        // Generate PDF menggunakan library seperti dompdf
        $pdf = PDF::loadView('kpi.report', compact('kpi')); // Buat view kpi.report
        return $pdf->download('laporan_kpi_'.$kpi->id.'.pdf');
    }

    public function pegawai(Request $request){
        $user = Auth::user();
        $role = Auth::user()->role;
        $pegawai = MdPegawai::find($user->id_pegawai);  // Pastikan relasi ini ada

        $kpis = TrsKpi::with(['pegawai', 'pegawai.bidang', 'penilai'])->orderBy('created_at', 'desc');

        if ($role == 'staff') {
            $kpis = $kpis->where('id_pegawai', $pegawai->id);
        }
        $kpis = $kpis->get();

        return view('kpi.pegawai', compact('kpis', 'pegawai')); // Kirim $pegawai ke view
    }

    public function destroy($id)
    {
        $kpi = TrsKpi::findOrFail($id);
        $kpi->update(['deleted_by' => auth()->id()]);
        $kpi->delete();

        return redirect()->route('kpi.index')->with('success', 'Data kpi berhasil dihapus');
    }
}

