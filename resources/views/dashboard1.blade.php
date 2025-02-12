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
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            height: 50px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header button {
            background-color: #2A7296;
            color:white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
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
            line-height: 1.6;
            margin: 0;
            
        }
        .banner-text h2 {
        
            color: white;
            font-size: 20px;
            margin: 0 0 10px;
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
        .indicator h3 {
            margin-top: 0;
            color: black;
            font-size: 16px;
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
        <img src="img/LOGO.jpg" alt="PLN Icon Plus Logo">
        <button onclick="window.location.href='{{ url('/login') }}'">Login</button>

    </div>
    <div class="main-content">
        <div class="banner">
            <img src="img/teampln.jpg" alt="Team Photo">
            <div class="banner-text">
                <h1>Evaluasi TKO
                PLN Icon Plus</h1>
                <h2>
                Unleashing Beyond kWh
    </h2>
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
