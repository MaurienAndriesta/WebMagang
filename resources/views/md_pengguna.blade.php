<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
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
            <select class="master-data-select" aria-label="Master Data Menu">
                <option>Master Data</option>
                <option value="#">Karyawan</option>
                <option value="#">Penilaian</option>
                <option value="#">Bidang</option>
                <option value="#">Sub Bidang</option>
                <option value="#">Pengguna</option>
                <option value="#">Skala Penilaian</option>
                <option value="#">Nilai Akhir</option>
            </select>
            <button class="kpi-button" onclick="window.location.href='{{ url('/kpi') }}'">KPI</button>
            <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>
        </div>
    </div>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Data Pengguna
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <form method="GET" action="{{ route('pengguna.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Cari Pengguna..." value="{{ request('search') }}" aria-label="Search for pengguna">
                    <button type="submit" class="btn btn-outline-secondary ms-2">Cari</button>
                </form>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Pengguna</button>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penggunaList as $index => $pengguna)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pengguna->pegawai->nama ?? '-' }}</td>
                            <td>{{ $pengguna->username }}</td>
                            <td>{{ ucfirst($pengguna->role) }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $pengguna->id }}" aria-label="Edit pengguna">Edit</button>
                                <form action="{{ route('pengguna.destroy', $pengguna->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" aria-label="Delete pengguna">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $pengguna->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Pengguna</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="username{{ $pengguna->id }}">Username</label>
                                                <input type="text" class="form-control" name="username" value="{{ $pengguna->username }}" id="username{{ $pengguna->id }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="role{{ $pengguna->id }}">Role</label>
                                                <select class="form-control" name="role" id="role{{ $pengguna->id }}">
                                                    <option value="admin" {{ $pengguna->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="staff" {{ $pengguna->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-warning">Update</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_pegawai">Pegawai</label>
                        <select class="form-control" name="id_pegawai" id="id_pegawai" required>
                            <option value="">Pilih Pegawai</option>
                            @foreach($pegawaiList as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="manager">Manager</option>
                            <option value="supervisor">Spv</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
