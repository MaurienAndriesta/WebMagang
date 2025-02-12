<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .header {
            background-color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            height: 50px;
        }
        .header .nav-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .header button {
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        .header .kpi-button {
            background-color: transparent;
            color: black;
        }
        .header .logout-button {
            background-color: red;
        }
        .master-data-select {
        background-color: transparent;
        color: black;
        font-weight: bold; /* Huruf tebal */
        font-size: 16px; /* Ukuran font lebih besar */
        padding: 10px 20px;
        cursor: pointer;
        border: none;
    }
    .master-data-select option {
        color: black;
        background-color: white;
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
            flex-direction: row-reverse;
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
        .banner-text h1, .banner-text h2 {
            color: white;
            line-height: 1.6;
            margin: 0;
        }
        .indicators {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .indicator {
            background-color: #4E9F9E;
            padding: 20px;
            width: 220px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .indicator h3, .indicator p {
            color: black;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="img/LOGO.jpg" alt="PLN Icon Plus Logo">
        <div class="nav-buttons">
            <select class="master-data-select" onchange="window.location.href=this.value">
                <option value="#" disabled selected>Master Data</option>
                <option value="#">Karyawan</option>
                <option value="#">Penilaian</option>
                <option value="#">Bidang</option>
                <option value="#">Sub Bidang</option>
                <option value="#">Pengguna</option>
                <option value="#">Skala Penilaian</option>
                <option value="#">Nilai Akhir</option>
            </select>
            <button class="kpi-button" onclick="window.location.href='{{ url('/kpi') }}'">KPI</button>
            <button class="logout-button" onclick="window.location.href='{{ url('/dashboard1') }}'">Logout</button>
        </div>
    </div>
    <div class="main-content">
        <div class="banner">
            <img src="img/teampln.jpg" alt="Team Photo">
            <div class="banner-text">
                <h1>Evaluasi TKO PLN Icon Plus</h1>
                <h2>Unleashing Beyond kWh</h2>
            </div>
        </div>
        <h1 style="text-align: left; color: #2A7296; margin-bottom: 30px;">Indikator Penilaian</h1>
        <div class="indicators">
            <div class="indicator">
                <h3>Pemenuhan Target Kerja</h3>
                <p>Kemampuan memulai & menggunakan berbagai upaya untuk mencapai sasaran kerja...</p>
            </div>
            <div class="indicator">
                <h3>Kualitas Kerja</h3>
                <p>Kemampuan unjuk kualitas & mutu yang prima dalam melaksanakan tugas...</p>
            </div>
            <div class="indicator">
                <h3>Kepatuhan</h3>
                <p>Kesadaran untuk menyelesaikan pekerjaan dengan tuntas sesuai tugas...</p>
            </div>
            <div class="indicator">
                <h3>Kerjasama/Team Work</h3>
                <p>Kemampuan berpartisipasi aktif, bekerjasama dengan rekan kerja...</p>
            </div>
            <div class="indicator">
                <h3>Inisiatif</h3>
                <p>Kemampuan bertindak melebihi yang dibutuhkan atau dituntut dari pekerjaan...</p>
            </div>
        </div>
    </div>
</body>
</html>