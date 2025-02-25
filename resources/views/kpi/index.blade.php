<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penilaian Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
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
        .card-header {
            background-color: #2A7296;
            color: white;
            text-align: center;
        }
        .btn-primary {
            background-color: #2A7296;
            border-color: #2A7296;
        }
        .btn-primary:hover {
            background-color: #235d7c;
            border-color: #235d7c;
        }
        .card {
            background-color: #F4F2F2;
        }
        .inner-card {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .inner-card .form-control {
            min-width: 400px;
            min-height: 40px;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }

        td {
            text-align: left;
            padding: 8px;
            border: 1px solid;
        }
        tr:nth-child(even){background-color: white}
        tr:nth-child(odd){background-color: #CAEDFB}
        tr:hover {background-color: #b1b3b3;}
        th {
            background-color: #2A7296;
            color: white;
            text-align: center;
            padding: 8px;
            border: 1px solid;
            border-color: black;
        }
        /* Styles for action icons (edit and delete) */
        .action-icons {
            visibility: hidden;
            display: flex;
            gap: 10px;
            position: absolute;
            top: 50%;
            right: 10px; /* Position to the right */
            transform: translateY(-50%); /* Only vertical centering needed */
            opacity: 0;
            transition: opacity 0.3s ease;
        }
         /* Show icons on row hover */
         tr:hover .action-icons {
            visibility: visible;
            opacity: 1; /* Make icons opaque on hover */
        }
        /* Style the icon buttons */
        .action-icons button { /* Style the icon buttons */
            background: none;  /* Remove default button background */
            border: none;       /* Remove default button border */
            padding: 0;         /* Remove default button padding */
            cursor: pointer;    /* Make it look clickable */
            font-size: 1.2rem;  /* Adjust icon size as needed */
            color: #2A7296;       /* Set icon color */
        }
        .action-icons .btn-outline-danger {
            color: red;  /* Override color for delete button */
        }
        td {
            position: relative; /* Necessary for absolute positioning of icons */
        }
        .center-text {
            text-align: center;
        }

    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="img/LOGO.jpg" alt="PLN Icon Plus">
        </div>
        <div class="nav-buttons">
    @php
        $homeUrl = '/';
        if (auth()->check()) {
            switch (auth()->user()->role) {
                case 'spv':
                    $homeUrl = '/dashboardspv';
                    break;
                case 'manager':
                    $homeUrl = '/dashboardmanager';
                    break;
                case 'admin':
                    $homeUrl = '/dashboardadmin';
                    break;
                case 'staff':
                    $homeUrl = '/dashboardpegawai';
                    break;
            }
        }
    @endphp

    <button class="home-button" onclick="window.location.href='{{ url($homeUrl) }}'">Home</button>
    <button class="kpi-button" onclick="window.location.href='{{ url('/kpi') }}'">KPI</button>
    <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>
</div>
    </div>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                DATA PENILAIAN KARYAWAN
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="inner-card">  <!-- Inner card added here -->
                    <div class="d-flex justify-content-between mx-auto">
                        <form method="GET" action="{{ route('kpi.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-white ms-0"><i class="bi bi-search"></i></button>
                        </form>
                        @if ($userRole == 'supervisor')
                        <button class="btn btn-primary" onclick="window.location.href='{{ route('kpi.create') }}'">
                            + Tambah
                        </button>
                        @endif
                    </div>
                </div>  <!-- End of inner card -->

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
                    @forelse ($kpis as $kpi)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ $kpi->pegawai->nama }}</td>
                            <td>{{ $kpi->pegawai->jabatan }}</td>
                            <td>{{ $kpi->pegawai->bidang->nama }}</td>
                            <td>{{ $kpi->status }}
                                <div class="action-icons">
                                    @if ($userRole == 'supervisor' && $kpi->status == 'Review SPV')
                                        <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='{{ route('kpi.editspv', $kpi->id) }}'">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif
                                    @if ($userRole == 'manager' && $kpi->status == 'Review Manager')
                                        <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='{{ route('kpi.editmanager', $kpi->id) }}'">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif
                                    @if ($kpi->status == 'Approved')
                                        <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='{{ route('kpi.final', $kpi->id) }}'">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    @endif
                                    @if (($userRole == 'supervisor' && $kpi->status == 'Review SPV') || ($userRole == 'manager' && $kpi->status == 'Review Manager'))
                                        <form action="{{ route('kpi.destroy', $kpi->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Data Tidak Ditemukan</td> </div>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>