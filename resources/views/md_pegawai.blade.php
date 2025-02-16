<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Pegawai</title>
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
                <option value="#">Pengguna</option>
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
            Data Pegawai
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <form method="GET" action="{{ route('pegawai.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Cari Pegawai..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary ms-2">Cari</button>
                </form>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Pegawai</button>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Atasan</th>
                        <th>Bidang</th>
                        <th>Subbidang</th>
                        <th>Masa Kerja</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawaiList as $index => $pegawai)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pegawai->nama }}</td>
                            <td>{{ $pegawai->jabatan }}</td>
                            <td>{{ $pegawai->atasan->nama ?? '-' }}</td> <!-- Tampilkan Nama Atasan -->
                            <td>{{ $pegawai->bidang->nama ?? '-' }}</td>
                            <td>{{ $pegawai->subbidang->nama ?? '-' }}</td>
                            <td>{{ $pegawai->masakerja }} Tahun</td>
                            <td>{{ ucfirst($pegawai->status) }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $pegawai->id }}">Edit</button>
                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                         <!-- Modal Edit -->
                         <div class="modal fade" id="editModal{{ $pegawai->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Pegawai</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" name="nama" value="{{ $pegawai->nama }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Jabatan</label>
                                                <input type="text" class="form-control" name="jabatan" value="{{ $pegawai->jabatan }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Masa Kerja (Tahun)</label>
                                                <input type="number" class="form-control" name="masakerja" value="{{ $pegawai->masakerja }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label>Status</label>
                                                <select class="form-control" name="status" required>
                                                    <option value="aktif" {{ $pegawai->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="non-aktif" {{ $pegawai->status == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Atasan</label>
                                                <select class="form-control" name="id_atasan">
                                                    <option value="">Tidak Ada</option>
                                                    @foreach($pegawaiList as $atasan)
                                                        <option value="{{ $atasan->id }}" {{ $pegawai->id_atasan == $atasan->id ? 'selected' : '' }}>{{ $atasan->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Bidang</label>
                                                <select class="form-control" name="id_bidang" required>
                                                    @foreach($bidangList as $bidang)
                                                        <option value="{{ $bidang->id }}" {{ $pegawai->id_bidang == $bidang->id ? 'selected' : '' }}>{{ $bidang->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Subbidang</label>
                                                <select class="form-control" name="id_subbidang" required>
                                                    @foreach($subbidangList as $subbidang)
                                                        <option value="{{ $subbidang->id }}" {{ $pegawai->id_subbidang == $subbidang->id ? 'selected' : '' }}>{{ $subbidang->nama }}</option>
                                                    @endforeach
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
                            <td colspan="9" class="text-center">Data tidak ditemukan</td>
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
                <h5 class="modal-title">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label>Nama Pegawai</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" required>
                    </div>

                    <div class="mb-3">
                        <label>Masa Kerja (Tahun)</label>
                        <input type="number" class="form-control" name="masakerja" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option value="aktif">Aktif</option>
                            <option value="non-aktif">Non-Aktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Atasan</label>
                        <select class="form-control" name="id_atasan">
                            <option value="">Tidak Ada</option>
                            @foreach($atasanList as $atasan)
                            <option value="{{ $atasan->id }}">{{ $atasan->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Bidang</label>
                        <select class="form-control" name="id_bidang" required>
                            <option value="">Pilih Bidang</option>
                            @foreach($bidangList as $bidang)
                                <option value="{{ $bidang->id }}">{{ $bidang->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Subbidang</label>
                        <select class="form-control" name="id_subbidang" required>
                            <option value="">Pilih Subbidang</option>
                            @foreach($subbidangList as $subbidang)
                                <option value="{{ $subbidang->id }}">{{ $subbidang->nama }}</option>
                            @endforeach
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