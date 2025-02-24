<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penilaian Kinerja Tahunan TKO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .logo {
            width: 120px;
            height: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .scale-info {
            float: right;
            width: 200px;
            margin-bottom: 20px;
        }
        .signature-box {
            border: 1px solid #000;
            width: 200px;
            height: 100px;
            float: right;
            margin-top: 20px;
            text-align: center;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/LOGO.jpg') }}" class="logo">
        <h1 class="title">LAPORAN PENILAIAN KINERJA TAHUNAN TKO</h1>
    </div>

    <div class="info-grid">
        <div>
            <h3>PEKERJA</h3>
            <div class="info-item">
                <strong>Nama:</strong> {{ $employee->name ?? '________________' }}
            </div>
            <div class="info-item">
                <strong>Jabatan:</strong> {{ $employee->position ?? '________________' }}
            </div>
            <div class="info-item">
                <strong>Bidang:</strong> {{ $employee->department ?? '________________' }}
            </div>
            <div class="info-item">
                <strong>Masa Kerja:</strong> {{ $employee->work_period ?? '________________' }}
            </div>
        </div>
        
        <div>
            <h3>PENILAI</h3>
            <div class="info-item">
                <strong>Nama (Atasan Langsung):</strong> {{ $assessor->name ?? '________________' }}
            </div>
            <div class="info-item">
                <strong>Periode Penilaian:</strong> {{ $assessment_period ?? '________________' }}
            </div>
            <div class="info-item">
                <strong>Tanggal Penilaian:</strong> {{ $assessment_date ?? '________________' }}
            </div>
            <div class="info-item">
                <strong>Sub Dir:</strong> {{ $sub_dir ?? '________________' }}
            </div>
        </div>
    </div>

    <div class="scale-info">
        <strong>Skala Penilaian:</strong><br>
        5 = Sangat baik<br>
        4 = Baik<br>
        3 = Cukup<br>
        2 = Kurang<br>
        1 = Sangat Kurang<br><br>
        <strong>Nilai Akhir:</strong><br>
        A = 421 - 500<br>
        B = 341 - 420<br>
        C = 261 - 340<br>
        D = < 261
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kriteria</th>
                <th>B</th>
                <th colspan="2">N</th>
                <th>Score</th>
                <th>Contoh Perilaku</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>SPV</th>
                <th>Manajer</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Pemenuhan Target Kerja</td>
                <td>20</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Kualitas Kerja</td>
                <td>20</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Kepatuhan</td>
                <td>20</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Kerjasama/Team Work</td>
                <td>20</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Inisiatif</td>
                <td>20</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

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
            <tr>
                <td>Datang Lambat</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Mangkir</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Surat Teguran</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div>
        <strong>Kelebihan:</strong>
        <p>{{ $strengths ?? '_________________________________________________________________' }}</p>
    </div>

    <div>
        <strong>Improvement:</strong>
        <p>{{ $improvements ?? '_________________________________________________________________' }}</p>
    </div>

    <div class="signature-box">
        <p>TTD Manajer</p>
    </div>
</body>
</html>