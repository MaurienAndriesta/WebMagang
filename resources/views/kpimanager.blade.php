
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penilaian Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header img {
            height: 50px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .header button {
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
        }
        .header .home-button {
            background-color: transparent;
            color: black;
        }
        .header .kpi-button {
            background-color: transparent;
            color: black;
        }
        .header .logout-button {
            background-color: red;
        }
        .main-content {
            padding: 20px;
        }
        .banner img {
            width: 67%;
            height: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .status-open {
            color: #ff9800;
        }
        .status-draft {
            color: #2196f3;
        }
        .status-review {
            color: #4caf50;
        }
        .status-approve {
            color: #8bc34a;
        }
        .eye-icon {
            cursor: pointer;
            color: #000;
            font-size: 18px;
        }
        </style>
</head>
<body>
    <div class="header">
        <img src="img/LOGO.jpg" alt="PLN Icon Plus Logo">
        <div class="nav-buttons">
        <button class="home-button" onclick="window.location.href='{{ url('/dashboardmanager') }}'">Home</button>
        <button class="kpi-button" onclick="window.location.href='{{ url('/kpimanager') }}'">KPI</button>
        <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>

    <h1>DATA PENILAIAN KARYAWAN</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Bidang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Ahmad Suryanto</td>
                <td>Manager</td>
                <td>Keuangan</td>
                <td class="status-open">Open</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Rini Oktaviani</td>
                <td>Staff</td>
                <td>Pemasaran</td>
                <td class="status-draft">Draft</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Budi Santoso</td>
                <td>Supervisor</td>
                <td>Produksi</td>
                <td class="status-review">Review Manager</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Siti Nurhaliza</td>
                <td>Analis</td>
                <td>Riset & Pengembangan</td>
                <td class="status-approve">Approve</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Dwi Hartono</td>
                <td>Staff</td>
                <td>Keuangan</td>
                <td class="status-open">Open</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Lina Marlina</td>
                <td>Manager</td>
                <td>Sumber Daya Manusia</td>
                <td class="status-review">Review Manager</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Eko Prasetyo</td>
                <td>Supervisor</td>
                <td>Pemasaran</td>
                <td class="status-draft">Draft</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Anita Susanti</td>
                <td>Analis</td>
                <td>Produksi</td>
                <td class="status-approve">Approve</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Agus Salim</td>
                <td>Staff</td>
                <td>Riset & Pengembangan</td>
                <td class="status-open">Open</td>
            </tr>
            <tr>
                <td>10</td>
                <td>Maya Puspita</td>
                <td>Supervisor</td>
                <td>Keuangan</td>
                <td class="status-review">Review Manager</td>
            </tr>
        </tbody>
    </table>

</body>
</html>