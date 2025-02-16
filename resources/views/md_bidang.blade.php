<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Bidang</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .logout-button {
            background-color: red;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="img/LOGO.jpg" alt="PLN Icon Plus">
        </div>
        <div class="nav-buttons">
            <a href="{{ url('/dashboardadmin') }}">Home</a>
            <select class="master-data-select">
                <option>Master Data</option>
                <option value="{{ url('/md_pegawai') }}">Pegawai</option>
                <option value="{{ url('/md_penilaian') }}">Penilaian</option>
                <option value="{{ url('/md_bidang') }}">Bidang</option>
                <option value="{{ url('/md_subbidang') }}">Sub Bidang</option>
                <option value="{{ url('/md_pengguna') }}">Pengguna</option>
                <option value="{{ url('/md_skalapenilaian') }}">Skala Penilaian</option>
                <option value="{{ url('/md_nilaiakhir') }}">Nilai Akhir</option>
            </select>
            <button class="kpi-button" onclick="window.location.href='{{ url('/kpi') }}'">KPI</button>
            <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

    <!-- Content -->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Master Data Bidang
            </div>
            <div class="card-body">
                <!-- Alert -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Search and Add -->
                <div class="d-flex justify-content-between mb-3">
                    <form method="GET" action="{{ route('bidang.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-secondary ms-2">Cari</button>
                    </form>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        + Tambah
                    </button>
                </div>

                <!-- Table -->
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bidang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bidangs as $bidang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bidang->nama }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $bidang->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('bidang.destroy', $bidang->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $bidang->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('bidang.update', $bidang->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Bidang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama Bidang</label>
                                                    <input type="text" name="nama" class="form-control" value="{{ $bidang->nama }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                {{ $bidangs->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('bidang.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Bidang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Bidang</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

