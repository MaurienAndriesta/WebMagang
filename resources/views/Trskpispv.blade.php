<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian Kinerja Tahunan TKO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-header {
            background-color: #1372c7;
            color:#F4F2F2;
            padding: 10px 15px;
            display: flex;
            align-items: center;
        }
        .form-header a {
            color: #F4F2F2;
            margin-right: 15px;
        }
        .form-header h5 {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="img/LOGO.jpg" alt="PLN Icon Plus" height="30">
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="masterDataDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Master Data
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="masterDataDropdown">
                                <li><a class="dropdown-item" href="#">Pegawai</a></li>
                                <li><a class="dropdown-item" href="#">Kriteria Penilaian</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">KPI</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <button class="btn btn-danger">Logout</button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="card mb-4 mt-4">
            <div class="form-header">
                <a href="#"><i class="fas fa-arrow-left"></i></a>
                <h5>FORM PENILAIAN KINERJA TAHUNAN TKO</h5>
            </div>
            <div class="card-body">
                <form id="kpiForm" method="POST" action="#">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">IDENTITAS PEKERJA</h6>
                            <div class="row mb-2">
                                <label class="col-md-3">Nama</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nama" value="{{ old('nama', $pegawai->nama) }}" readonly>
    
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3">Jabatan</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" readonly>

                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3">Bidang</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                <input type="text" class="form-control" name="bidang" value="{{ old('id_bidang', $pegawai->bidang->nama) }}" readonly>


                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3">Masa kerja</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="masakerja" value= "{{ old('masakerja', $pegawai->masakerja) }}" readonly>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="fw-bold">IDENTITAS PENILAI</h6>
                            <div class="row mb-2">
                                <label class="col-md-3">Nama (Atasan Langsung)</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nama_penilai" value="{{ old('nama', $atasan) }}" readonly>

                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3">Periode Penilaian</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="periode_penilaian" value="{{ old('semester', $atasan) }}">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3">Tanggal Penilaian</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="tanggal_penilaian">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3">Sub Dir</label>
                                <div class="col-md-1">:</div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="sub_dir" >
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3">KRITERIA PENILAIAN</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Kriteria</th>
                                    <th width="10%">Bobot</th>
                                    <th width="10%">Nilai SPV</th>
                                    <th width="10%">Nilai Manager</th>
                                    <th width="15%">Score</th>
                                    <th width="20%">Contoh Perilaku</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Pemenuhan Target Kerja</td>
                                    <td class="text-center">20</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[0][nilai_spv]" min="1" max="5">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[0][nilai_manager]" min="1" max="5" readonly>
                                    </td>
                                    <td class="text-center"> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Kualitas Kerja</td>
                                    <td class="text-center">20</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[1][nilai_spv]" min="1" max="5">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[1][nilai_manager]" min="1" max="5" readonly>
                                    </td>
                                    <td class="text-center"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Kepatuhan</td>
                                    <td class="text-center">20</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[2][nilai_spv]" min="1" max="5">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[2][nilai_manager]" min="1" max="5" readonly>
                                    </td>
                                    <td class="text-center"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Kerjasama/ Team Work</td>
                                    <td class="text-center">20</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[3][nilai_spv]" min="1" max="5">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[3][nilai_manager]" min="1" max="5" readonly>
                                    </td>
                                    <td class="text-center"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Inisiatif</td>
                                    <td class="text-center">20</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[4][nilai_spv]" min="1" max="5">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="items[4][nilai_manager]" min="1" max="5" readonly>
                                    </td>
                                    <td class="text-center"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Jumlah</td>
                                    <td class="text-center"></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="fw-bold mb-3">PENILAIAN KEDISIPLINAN</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Hari</th>
                                    <th>Penalty Score</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                    <th>Score Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Datang Lambat</td>
                                    <td><input type="number" class="form-control form-control-sm" name="datang_lambat_hari"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="datang_lambat_penalty"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="datang_lambat_total"></td>
                                    <td rowspan="3" class="align-middle text-center"></td>
                                    <td rowspan="3" class="align-middle text-center"></td>
                                </tr>
                                <tr>
                                    <td>Mangkir</td>
                                    <td><input type="number" class="form-control form-control-sm" name="mangkir_hari"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="mangkir_penalty"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="mangkir_total"></td>
                                </tr>
                                <tr>
                                    <td>Surat Teguran</td>
                                    <td><input type="number" class="form-control form-control-sm" name="teguran_hari"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="teguran_penalty"></td>
                                    <td><input type="number" class="form-control form-control-sm" name="teguran_total"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kelebihan</label>
                                <textarea class="form-control" name="kelebihan" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Improvement</label>
                                <textarea class="form-control" name="improvement" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-center">Catatan:</h6>
                                    <p class="card-text">Kriteria yang mendapat Surat Peringatan atau sedang menjalani masa hukuman tidak berhak mendapat Final Grade "B"</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success me-2">Simpan</button>
                        <button type="button" class="btn btn-primary me-2">Ajukan</button>
                        <button type="button" class="btn btn-info me-2">Download</button>
                        <button type="button" class="btn btn-secondary">Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>