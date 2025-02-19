<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data KPI Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .header-blue {
            background-color: #1e6ba3;
            color: white;
        }
        .navbar-brand img {
            height: 2.5rem;
        }
        .btn-search {
            border-radius: 0 5px 5px 0;
        }
        .btn-tambah {
            background-color: #1e6ba3;
            color: white;
            padding: 6px 20px;
            border-radius: 5px;
        }
        .badge-approve {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .badge-review-manager {
            background-color: #fd7e14;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="img/LOGO.jpg" alt="PLN Icon Plus Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="kpi.php">KPI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger text-white px-3" href="logout.php">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-header header-blue text-center">
                    <h4>DATA KPI PEGAWAI</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search">
                                <button class="btn btn-search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-tambah">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Bidang</th>
                                    <th>Status KPI</th> <!-- Kolom Status KPI -->
                                    <th>Detail</th> <!-- Kolom Aksi -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pegawaiList as $pegawai)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $pegawai->nama }}</td>
                                        <td>{{ $pegawai->jabatan }}</td>
                                        <td>{{ $pegawai->bidang->nama }}</td>
                                        <td>
                                            @if($pegawai->latestKpi)
                                                @php
                                                    $status = $pegawai->latestKpi->status_kpi;
                                                @endphp
                                                <span class="badge badge-{{ 
                                                    $status == 'Approved' ? 'approve' : 
                                                    ($status == 'Review Manager' ? 'review-manager' : 
                                                    ($status == 'Review SPV' ? 'warning' : 'secondary')) }}">
                                                    {{ $status }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">Belum Ada Status</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('/Trskpispv' . $pegawai->id) }}" class="btn btn-sm btn-warning">
                                                ✏
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $pegawaiList->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>