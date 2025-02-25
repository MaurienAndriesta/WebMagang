<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penilaian Kinerja Tahunan TKO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.5;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .logo {
            height: 50px;
            margin-right: 20px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin: 30px 0;
        }
        .info-section {
            display: flex;
            margin-bottom: 20px;
        }
        .info-left, .info-right {
            width: 50%;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .scale-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        td {
            vertical-align: top;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .signature {
            text-align: right;
            margin-top: 30px;
        }
        .signature-box {
            border: 1px solid black;
            width: 150px;
            height: 100px;
            margin-left: auto;
            margin-top: 10px;
        }
        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="img/LOGO.jpg" alt="PLN Icon Plus" class="logo">
    </div>

    <h2 class="title">LAPORAN PENILAIAN KINERJA TAHUNAN TKO</h2>

    <div class="info-section">
        <div class="info-left">
            <div class="section-title">PEKERJA</div>
            <p>Nama: {{ $pegawai->nama }}</p>
            <p>Jabatan: {{ $pegawai->jabatan }}</p>
            <p>Bidang: {{ $pegawai->bidang->nama }}</p>
            <p>Masa Kerja: {{ $pegawai->masakerja }}</p>
        </div>
        <div class="info-right">
            <div class="section-title">PENILAI</div>
            <p>Nama (Atasan Langsung): {{ $pegawai->atasan->nama ?? '-' }}</p>
            <p>Periode Penilaian: {{ $kpi->tahun . ', ' . $kpi->semester }}</p>
            <p>Tanggal Penilaian: {{ $kpi->tanggal_penilaian }}</p>
            <p>Sub Bidang: {{ $pegawai->subbidang->nama }}</p>
        </div>
    </div>

    <div class="scale-section">
        <div>
            <div>Skala Penilaian :</div>
            <div>5 = Sangat baik</div>
            <div>4 = Baik</div>
            <div>3 = Cukup</div>
            <div>2 = Kurang</div>
            <div>1 = Sangat Kurang</div>
        </div>
        <div>
            <div>Nilai Akhir :</div>
            <div>A = 421 - 500</div>
            <div>B = 341 - 420</div>
            <div>C = 261 - 340</div>
            <div>D = < 261</div>
            <br>
            <div>B = Bobot</div>
            <div>N = Nilai</div>
        </div>
    </div>

    <div class="section-title">KRITERIA PENILAIAN</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kriteria</th>
                <th rowspan="2">B</th>
                <th colspan="2">N</th>
                <th rowspan="2">Score</th>
                <th rowspan="2">Contoh Perilaku</th>
            </tr>
            <tr>
                <th>SPV</th>
                <th>Manajer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penilaianItems->where('kategori', 'Kriteria Penilaian') as $item)
                @php
                    $kpiItem = $kpi->kpiItems->where('id_penilaian', $item->id)->first();
                @endphp
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="center">{{ $item->bobot }}</td>
                    <td class="center">{{ $kpiItem ? $kpiItem->nilai_spv : '-' }}</td>
                    <td class="center">{{ $kpiItem ? $kpiItem->nilai_manager : '-' }}</td>
                    <td class="center">{{ $kpiItem ? $kpiItem->score : '-' }}</td>
                    <td>{{ $kpiItem ? $kpiItem->catatan : '-' }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="center">Jumlah</td>
                <td class="center">{{ $kpi->total_score }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">PENILAIAN KEDISIPLINAN</div>
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Hari</th>
                <th>Penalty Score</th>
                <th>Total</th>
                <th>Grade</th>
                <th>Score Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php $jumlahKedisiplinan = $penilaianItems->where('kategori', 'Penilaian Kedisiplinan')->count(); @endphp
            @foreach ($penilaianItems->where('kategori', 'Penilaian Kedisiplinan') as $item)
                @php
                    $kpiItemKedisiplinan = $kpi->kpiItems->where('id_penilaian', $item->id)->first();
                @endphp
            <tr>
                <td>{{ $item->nama }}</td>
                <td style="text-align: center">{{ $kpiItemKedisiplinan ? $kpiItemKedisiplinan->hari : '-' }}</td>
                <td style="text-align: center">{{ $kpiItemKedisiplinan ? $kpiItemKedisiplinan->penalty_score : '-' }}</td>
                 @if ($loop->first)
                    <td rowspan="{{ $jumlahKedisiplinan }}" style="text-align: center">{{ $kpi->total_penalty_score }}</td>
                    <td rowspan="{{ $jumlahKedisiplinan }}" style="text-align: center">{{ $kpi->grade }}</td>
                    <td rowspan="{{ $jumlahKedisiplinan }}" style="text-align: center">{{ $kpi->nilai_akhir }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Kelebihan :</div>
    <div style="min-height: 60px; border: 1px solid #ddd; padding: 10px; margin-bottom: 20px;">
        {{ $kpi->kelebihan }}
    </div>

    <div class="section-title">Improvement :</div>
    <div style="min-height: 60px; border: 1px solid #ddd; padding: 10px; margin-bottom: 20px;">
        {{ $kpi->improvement }}
    </div>

    <div class="signature">
        <div>TTD Manajer</div>
        <div class="signature-box"></div>
    </div>
</body>
</html>