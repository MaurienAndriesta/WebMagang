<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Nilai Akhir</title>
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
            <button class="logout-button" onclick="window.location.href='{{ url('/dashboard1') }}'">Logout</button>
        </div>
    </div>
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Master Data Nilai Akhir
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <form method="GET" action="{{ route('nilai-akhir.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Cari Grade..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary ms-2">Cari</button>
                </form>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah</button>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nilai Awal</th>
                        <th>Nilai Akhir</th>
                        <th>Grade</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilaiAkhirList as $nilai)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $nilai->nilai_awal }}</td>
                            <td>{{ $nilai->nilai_akhir }}</td>
                            <td>{{ $nilai->grade }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $nilai->id }}">Edit</button>
                                <form action="{{ route('nilai-akhir.destroy', $nilai->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $nilai->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('nilai-akhir.update', $nilai->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Nilai Akhir</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nilai Awal</label>
                                                <input type="number" name="nilai_awal" class="form-control" value="{{ $nilai->nilai_awal }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nilai Akhir</label>
                                                <input type="number" name="nilai_akhir" class="form-control" value="{{ $nilai->nilai_akhir }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Grade</label>
                                                <input type="text" name="grade" class="form-control" value="{{ $nilai->grade }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $nilaiAkhirList->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
    <form action="{{ route('nilai-akhir.store') }}" method="POST">
    @csrf
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah Nilai Akhir</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nilai Awal</label>
                <input type="number" name="nilai_awal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nilai Akhir</label>
                <input type="number" name="nilai_akhir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Grade</label>
                <input type="text" name="grade" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>