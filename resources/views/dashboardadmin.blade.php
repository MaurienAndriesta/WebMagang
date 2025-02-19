<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .header {
            background-color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }
        .header img {
            height: 40px;
        }
        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .nav-buttons a, .nav-buttons button, .nav-buttons select {
            font-weight: bold;
            font-size: 16px;
            border: none;
            background: transparent;
            cursor: pointer;
            color: black;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header .logout-button {
            background-color: red;
            color:black;
            border: none;
            padding: 5px 15px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        .logout-button:hover{
            background-color: #D80909;
        }
        .main-content {
            padding: 20px;
        }
        .banner {
            background-color: #2A7296;
            display: flex;
            align-items: center;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex-direction: row-reverse; /* Membuat gambar di sebelah kanan */
        }
        .banner img {
            width: 67%;
            height: auto;
        }
        .banner-text {
            flex: 1;
            padding: 20px;
            max-width: 33%;
        }
        .banner-text h1 {
            color: white;
            line-height: 1.0;
            margin: 0;
            font-size: 48px;
        }
        .banner-text h2 {
            color: white;
            font-size: 20px;
            line-height: 5;
            margin: 0 0 10px;
        }
        .banner-text h2 span { /* Style khusus untuk "Unleashing" */
            color: #d5d5d5;
        }
        .indicators {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 10px;
        }
        .indicator {
            background-color: #4E9F9E;
            padding: 20px;
            width: 220px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .indicator h3 {
            margin-top: 0;
            color: black;
            font-size: 24px;
        }
        .indicator p {
            font-size: 14px;
            color: black;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="img/LOGO.jpg" alt="PLN Icon Plus Logo">
        </div>
        <div class="nav-buttons">
            <button class="home-button" onclick="window.location.href='{{ url('/dashboardadmin') }}'">Home</button>
            <select class="master-data-select" onchange="location = this.value;"> <option value="" disabled selected>Master Data</option>
                <option value="{{ url('/md_pegawai') }}">Pegawai</option>
                <option value="{{ url('/md_penilaian') }}">Penilaian</option>
                <option value="{{ url('/md_bidang') }}">Bidang</option>
                <option value="{{ url('/md_subbidang') }}">Sub Bidang</option>
                <option value="{{ url('/md_pengguna') }}">Pengguna</option>
                <option value="{{ url('/md_skalapenilaian') }}">Skala Penilaian</option>
                <option value="{{ url('/md_nilaiakhir') }}">Nilai Akhir</option>
            </select>
            <button class="kpi-button" onclick="window.location.href='{{ url('/Kpi_admin') }}'">KPI</button>
            <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>
        </div>
    </div>
    <div class="main-content">
            <div class="banner">
                <img src="img/teampln.jpg" alt="Team Photo">
                <div class="banner-text">
                    <h1>Evaluasi TKO</h1>
                    <h1>PLN Icon Plus</h1>
                    <h2><span>Unleashing</span> Beyond kWh</h2>
                </div>
            </div>
            <h1 style="text-align: left; color: #2A7296; margin-bottom: 30px;">Indikator Penilaian</h1>
                <div class="indicators">
                    <div class="indicator">
                        <h3>Pemenuhan Target Kerja</h3>
                        <p>Kemampuan memulai & menggunakan berbagai upaya untuk mencapai sasaran kerja, serta bertindak melebihi apa yang diharapkan untuk menyelesaikan masalah atau meningkatkan hasil kerja tanpa menimbulkan masalah baru</p>
                    </div>
                    <div class="indicator">
                        <h3>Kualitas Kerja</h3>
                        <p>Kemampuan unjuk kualitas & mutu yang prima dalam melaksanakan tugas-tugasnya, meliputi: ketepatan, kelengkapan dan kerapian</p>
                    </div>
                    <div class="indicator">
                        <h3>Kepatuhan</h3>
                        <p>Kesadaran untuk menyelesaikan pekerjaan dengan tuntas sesuai tugas & tanggung jawabnya</p>
                    </div>
                    <div class="indicator">
                        <h3>Kerjasama/Team Work</h3>
                        <p>Kemampuan berpartisipasi aktif, bekerjasama dengan rekan kerja & menciptakan kolaborasi positif yang mendukung keberhasilan tugas kelompok </p>
                    </div>
                    <div class="indicator">
                        <h3>Inisiatif</h3>
                        <p>Kemampuan bertindak melebihi yang dibutuhkan atau dituntut dari pekerjaan tanpa menunggu perintah terlebih dahulu</p>
                    </div>
                </div>
        </div>
</body>
</html>