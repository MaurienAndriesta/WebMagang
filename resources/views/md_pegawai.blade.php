<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Pegawai</title>
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
        .status-icon {
            margin-left: 5px; /* Adjust spacing as needed */
        }
        .status-icon-aktif{
             color: green;
        }
        .status-icon-non-aktif{
            color: red;
        }

    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="img/LOGO.jpg" alt="PLN Icon Plus">
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
            <button class="kpi-button" onclick="window.location.href='{{ url('/kpimanager') }}'">KPI</button>
            <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>
        </div>
    </div>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                Master Data Pegawai
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="inner-card">  <!-- Inner card added here -->
                    <div class="d-flex justify-content-between mb-3">
                        <form method="GET" action="{{ route('pegawai.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
                        </form>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            + Tambah
                        </button>
                    </div>
                </div>  <!-- End of inner card -->

                <!-- Table -->
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Atasan</th>
                            <th>Bidang</th>
                            <th>Subbidang</th>
                            <th>Masa Kerja</th>
                            <th>Status Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pegawaiList as $pegawai)
                    <tr>
                        <td class="center-text">{{ $loop->iteration }}</td>
                        <td>{{ $pegawai->nama }}</td>
                        <td>{{ $pegawai->jabatan }}</td>
                        <td>{{ $pegawai->atasan->nama ?? '-' }}</td> <!-- Tampilkan Nama Atasan -->
                        <td>{{ $pegawai->bidang->nama ?? '-' }}</td>
                        <td>{{ $pegawai->subbidang->nama ?? '-' }}</td>
                        <td>{{ $pegawai->masakerja }} Tahun</td>
                        <td>
                        <i class="bi bi-{{ trim(strtolower($pegawai->status)) === 'aktif' ? 'check-lg status-icon-aktif' : 'x-lg status-icon-non-aktif' }}"></i>
                            {{ ucfirst($pegawai->status) }}

                            <div class="action-icons">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $pegawai->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="editModal{{ $pegawai->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Pegawai</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
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

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>



                <!-- Pagination -->
                {{ $pegawaiList->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('pegawai.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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