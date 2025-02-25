<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM PENILAIAN KINERJA TAHUNAN TKO</title>
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
        .table-borderless thead tr {
            background-color: transparent !important; /* !important untuk override style bawaan Bootstrap */
        }

        .table-borderless thead tr:hover {
            background-color: transparent !important; /* !important untuk override style bawaan Bootstrap */
        }
        .table-borderless thead th {
            color: black;
            text-align: left;
            padding: 8px;
            border: none;
        }
        /* Style untuk tabel identitas */
        .table-borderless tbody tr {
            background-color: transparent !important; /* !important untuk override style bawaan Bootstrap */
        }

        .table-borderless tbody tr:hover {
            background-color: transparent !important; /* !important untuk override style bawaan Bootstrap */
        }

        .table-borderless {
            background-color: transparent;
        }
        .table-borderless tbody td {
            text-align: left;
            padding: 8px;
            border: none;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="{{ asset('img/LOGO.jpg') }}" alt="PLN Icon Plus">
        </div>
        <div class="nav-buttons">
            <button class="home-button" onclick="window.location.href='{{ url('/dashboardmanager') }}'">Home</button>
            <button class="kpi-button" onclick="window.location.href='{{ url('/kpi') }}'">KPI</button>
            <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <button type="button" class="btn btn-lg me-2" onclick="window.location.href='{{ url('/kpi') }}'"> <i class="bi bi-arrow-left-circle" style="color: white;"></i> </button>
                <h5 class="text-center flex-grow-1">FORM PENILAIAN KINERJA TAHUNAN TKO</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('kpi.update', $kpi->id) }}" method="POST" >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="status" value="Review Manager">
                        <table class="table table-borderless" style="width: 100%;">
                            <colgroup>
                                <col span="1" style="width: 15%;">
                                <col span="1" style="width: 2%;">
                                <col span="1" style="width: 30%;">
                                <col span="1" style="width: 20%;">
                                <col span="1" style="width: 2%;">
                                <col span="1" style="width: 25%;">
                                <col span="1" style="width: 5%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th colspan="3">IDENTITAS PEKERJA</th>
                                    <th colspan="4">IDENTITAS PENILAI</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Nama Pekerja</td>
                                    <td>:</td>
                                    <td>
                                        <select name="id_pegawai" id="id_pegawai" class="form-control" onchange="updateDetails()">
                                            @foreach ($pegawai->where('jabatan', 'Staff') as $p)
                                                <option value="{{ $p->id }}" data-jabatan="{{ $p->jabatan }}" data-bidang="{{ $p->bidang->nama }}" data-subbidang="{{ $p->subbidang->nama }}" data-masakerja="{{ $p->masakerja }}" data-atasan="{{ $p->atasan ? $p->atasan->id : '' }}" {{ $kpi->id_pegawai == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                <td>Nama (Atasan Langsung)</td>
                                <td>:</td>
                                <td colspan="2">
                                    <select name="id_penilai" id="id_penilai" class="form-control">
                                        <!-- Opsi akan diisi oleh JavaScript -->
                                    </select>
                                </td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="jabatan" id="jabatan" class="form-control" readonly>
                                    </td>
                                    <td>Periode Penilaian</td>
                                    <td>:</td>
                                    <td><input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" min="2000" placeholder="Masukan Tahun" value="{{ $kpi->tahun }}" required></td>
                                    @error('tahun')
                                    <div class="text-danger">{{ 'Periode penilaian untuk pegawai ini sudah ada' }}</div>
                                    @enderror
                                    <td><select name="semester" id="semester" class="form-control" aria-placeholder="Semester" required>
                                        <option value="1" {{ $kpi->semester == 1 ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $kpi->semester == 2 ? 'selected' : '' }}>2</option>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bidang</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="bidang" id="bidang" class="form-control" readonly>
                                    </td>
                                    <td>Tanggal Penilaian</td>
                                    <td>:</td>
                                    <td colspan="2"><input type="date" name="tanggal_penilaian" id="tanggal" class="form-control" value="{{ $kpi->tanggal_penilaian }}" required></td>
                                </tr>
                                <tr>
                                    <td>Masa Kerja</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="masa_kerja" id="masa_kerja" class="form-control" readonly>
                                    </td>
                                    <td>Sub Bidang</td>
                                    <td>:</td>
                                    <td colspan="2"><input type="text" name="sub_bidang" id="sub_bidang" class="form-control" readonly></td>
                                </tr>
                            </tbody>
                        </table>

                {{-- Kriteria Penilaian (Tabel 1) --}}
                <h3>Kriteria Penilaian</h3>
                <table>
                    <thead style="width: 100%">
                        <colgroup>
                            <col span="1" style="width: 5%;">
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 7%;">
                            <col span="1" style="width: 17%;">
                            <col span="1" style="width: 17%;">
                            <col span="1" style="width: 10%;">
                            <col span="1" style="width: 19%;">
                        </colgroup>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kriteria</th>
                            <th rowspan="2">Bobot</th>
                            <th colspan="2">Nilai</th>
                            <th rowspan="2">Score</th>
                            <th rowspan="2">Contoh Perilaku</th>
                        </tr>
                        <tr>
                            <th>SPV</th>
                            <th>Manager</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penilaianItems->where('kategori', 'Kriteria Penilaian') as $item)
                            @php
                                $kpiItem = $kpi->kpiItems->where('id_penilaian', $item->id)->first();
                            @endphp
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td style="text-align: center">{{ $item->bobot }}</td>
                                    <td>
                                        <input type="hidden" name="items[{{ $item->id }}][nilai_spv]" value="{{ $kpiItem->nilai_spv ?? '' }}">
                                        <select name="items[{{ $item->id }}][nilai_spv]" class="form-control nilai_spv" data-bobot="{{ $item->bobot }}" disabled>
                                            <option style="text-align: center" value="">Pilih Nilai SPV</option>
                                            @foreach ($skalaPenilaian as $skala)
                                                <option value="{{ $skala->angka }}" {{ $kpiItem && $kpiItem->nilai_spv == $skala->angka ? 'selected' : '' }}>{{ $skala->angka }} - {{ $skala->keterangan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="items[{{ $item->id }}][nilai_manager]" class="form-control nilai_manager" data-bobot="{{ $item->bobot }}">
                                            <option style="text-align: center" value="">Pilih Nilai Manager</option>
                                            @foreach ($skalaPenilaian as $skala)
                                                <option value="{{ $skala->angka }}" {{ $kpiItem && $kpiItem->nilai_manager == $skala->angka ? 'selected' : '' }}>{{ $skala->angka }} - {{ $skala->keterangan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input  style="text-align: center" type="number" name="items[{{ $item->id }}][score]" class="form-control score" data-bobot="{{ $item->bobot }}" value="{{ $item->bobot * ($kpiItem->nilai_spv + $kpiItem->nilai_manager)/2 }}" readonly></td>
                                    <td><textarea style="width: 100%" name="items[{{ $item->id }}][catatan]">{{ $kpiItem ? $kpiItem->catatan : '' }}</textarea></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align: center;"><strong>Jumlah</strong></td>
                                <td><input style="text-align: center" type="number" name="total_score" id="totalScore" class="form-control" readonly></td><td></td>
                            </tr>
                        </tbody>
                </table>

                {{-- Penilaian Kedisiplinan (Tabel 2) --}}
                <h3>Penilaian Kedisiplinan</h3>
                <table style="width: 100%;">
                    <colgroup>
                        <col span="1" style="width: 35%;">
                        <col span="1" style="width: 15%;">
                        <col span="1" style="width: 15%;">
                        <col span="1" style="width: 12%;">
                        <col span="1" style="width: 12%;">
                        <col span="1" style="width: 12%;">
                    </colgroup>

                    {{-- ... (header dan body tabel) --}}
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
                    @php $jumlahKedisiplinan = $penilaianItems->where('kategori', 'Penilaian Kedisiplinan')->count(); @endphp

                            @foreach ($penilaianItems->where('kategori', 'Penilaian Kedisiplinan') as $item)
                            @php
                            $kpiItemKedisiplinan = $kpi->kpiItems->where('id_penilaian', $item->id)->first();
                        @endphp
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        <input type="hidden" name="kedisiplinan[{{ $item->id }}][hari]" value="{{ $kpiItemKedisiplinan->hari ?? '' }}">
                                        <input style="text-align: center" type="number" name="kedisiplinan[{{ $item->id }}][hari]" class="form-control hari" data-bobot="{{ $item->bobot }}" value="{{ $kpiItemKedisiplinan ? $kpiItemKedisiplinan->hari : '0'}}" disabled> </td>
                                        <input type="hidden" id="hariSuratTeguran" value="{{ $hariSuratTeguran }}">
                                    <td>
                                        <input style="text-align: center" type="number" name="kedisiplinan[{{ $item->id }}][penalty_score]" class="form-control penalty-score" data-bobot="{{ $item->bobot }}" value="{{ $item->bobot * $kpiItemKedisiplinan->hari }}" readonly></td>
                                    @if ($loop->first)  {{-- Hanya tampilkan di baris pertama --}}
                                    <td rowspan="{{ $jumlahKedisiplinan + 3}}" style="vertical-align : middle;text-align:center;">  {{-- rowspan dinamis --}}
                                        <input style="text-align: center" type="number" name="total_penalty_score" id="totalPenaltyScore" class="form-control" value="{{ $kpi->total_penalty_score }}" readonly>

                                    </td>
                                    <input type="hidden" name="grade" value="{{ $kpi->grade }}">
                                    <td rowspan="{{ $jumlahKedisiplinan + 3}}"  style="vertical-align : middle;text-align:center;"><input style="text-align: center" type="text" name="grade" id="grade" class="form-control" value="{{ $kpi->grade }}" readonly></td>
                                    <input type="hidden" name="nilai_akhir" value="{{ $kpi->nilai_akhir }}">
                                    <td rowspan="{{ $jumlahKedisiplinan + 3}}" style="vertical-align : middle;text-align:center;" ><input style="text-align: center" type="number" name="nilai_akhir" id="nilaiAkhir" class="form-control" value="{{ $kpi->nilai_akhir }}" readonly></td>

                                @endif
                                </tr>

                            @endforeach

                    </tbody>
                </table>
                <table class="table table-borderless" style="width: 100%;">
                    <colgroup>
                        <col span="1" style="width: 40%;">
                        <col span="1" style="width: 45%;">
                        <col span="1" style="width: 15%;">
                    </colgroup>
                    {{-- Kelebihan dan Improvement --}}
                    <tr>
                        <td>Kelebihan:</td>
                        <td>Catatan:</td>
                    </tr>
                    <tr>
                        <td><textarea name="kelebihan" id="kelebihan" class="form-control"> {{ $kpi->kelebihan }} </textarea></td>
                        <td style="text-align: center">Pekerja yang mendapat Surat Teguran atau sedang menjalani masa hukuman tidak berhak mendapat Final Grade "B"</td>
                        <td style="align-content: flex-end"><button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button></td>
                    </tr>
                    <tr>
                        <td>Improvement:</td>
                        <td></td>
                        <td><button type="submit" class="btn btn-outline-success" style="color: white;background-color: #2ECC71" name="approve" value="1" onclick="return validateForm()"><i class="bi bi-check2-square" style="color: white"></i>  Approve</button></td>
                    </tr>
                    <tr>
                        <td><textarea name="improvement" id="improvement" class="form-control"> {{ $kpi->improvement }} </textarea></td>
                        <td></td> {{-- Sel kosong --}}
                        {{-- <td><button type="submit" class="btn btn-primary" name="download"><i class="bi bi-download"></i>  Download</button></td> --}}
                    </tr>

                </table>


            </form>
            </div>
        </div>
    </div>
            <script>
                 console.log()
                 const pegawaiData = @json($pegawai);
                function updateDetails() {
                    const selectedPegawaiId = document.getElementById('id_pegawai').value;
                    const penilaiSelect = document.getElementById('id_penilai');
                    const selectPegawai = document.getElementById('id_pegawai');
                    const jabatanInput = document.getElementById('jabatan');
                    const bidangInput = document.getElementById('bidang');
                    const subbidangInput = document.getElementById('sub_bidang');
                    const masaKerjaInput = document.getElementById('masa_kerja');

                    // Kosongkan dropdown penilai
                    penilaiSelect.innerHTML = '';

                    // Temukan pegawai yang dipilih
                    const selectedPegawai = pegawaiData.find(p => p.id === selectedPegawaiId);

                    // Jika pegawai memiliki atasan, tambahkan ke dropdown
                    if (selectedPegawai && selectedPegawai.id_atasan) {
                        const atasan = pegawaiData.find(p => p.id === selectedPegawai.id_atasan);
                        if (atasan) {
                            const option = document.createElement('option');
                            option.value = atasan.id;
                            option.textContent = atasan.nama;
                            penilaiSelect.appendChild(option);
                        }
                    }
                    const selectedOption = selectPegawai.options[selectPegawai.selectedIndex];

                    if (selectedOption) {
                        jabatanInput.value = selectedOption.dataset.jabatan || '';
                        bidangInput.value = selectedOption.dataset.bidang || '';
                        subbidangInput.value = selectedOption.dataset.subbidang || '';
                        masaKerjaInput.value = selectedOption.dataset.masakerja || '';


                    }else {
                        // Reset nilai jika tidak ada pegawai yang dipilih
                        jabatanInput.value = '';
                        bidangInput.value = '';
                        subbidangInput.value = '';
                        masaKerjaInput.value = '';


                    }
                }
                updateDetails();
                // Hitung score di tabel 1
                const nilaiSpvInputs = document.querySelectorAll('.nilai_spv');
                const nilaiManagerInputs = document.querySelectorAll('.nilai_manager');
                const scoreInputs = document.querySelectorAll('.score'); // Hapus deklarasi duplikat
                const totalScoreInput = document.getElementById('totalScore');
                const totalPenaltyScoreInput = document.getElementById('totalPenaltyScore');
                const nilaiAkhirInput = document.getElementById('nilaiAkhir');


                // Fungsi untuk update total score
                function updateTotalScore() {
                    let total = 0;
                    scoreInputs.forEach(input => {
                        total += parseFloat(input.value) || 0;
                    });
                    totalScoreInput.value = total;

                    // Update nilai akhir setelah total score berubah
                    updateNilaiAkhir();
                    updateGrade();
                }

                nilaiSpvInputs.forEach((input, index) => {
                    input.addEventListener('change', function() {
                        const nilaiSpv = parseFloat(this.value) || 0;
                        const nilaiManager = parseFloat(nilaiManagerInputs[index].value) || 0;
                        const bobot = parseFloat(this.dataset.bobot) || 0;

                        const score = (nilaiSpv + nilaiManager) / 2 * bobot;
                        scoreInputs[index].value = score;

                        updateTotalScore(); // Panggil fungsi updateTotalScore di sini
                    });
                });

                nilaiManagerInputs.forEach((input, index) => {
                    input.addEventListener('change', function() {
                        const nilaiSpv = parseFloat(nilaiSpvInputs[index].value) || 0;
                        const nilaiManager = parseFloat(this.value) || 0;
                        const bobot = parseFloat(this.dataset.bobot) || 0;

                        const score = (nilaiSpv + nilaiManager) / 2 * bobot;
                        scoreInputs[index].value = score;

                        updateTotalScore(); // Panggil fungsi updateTotalScore di sini
                    });
                });



                const hariInputs = document.querySelectorAll('.hari');
                const penaltyScoreInputs = document.querySelectorAll('.penalty-score');



                hariInputs.forEach((input, index) => {
                    input.addEventListener('input', function() {
                        const hari = parseFloat(this.value) || 0;
                        const bobot = parseFloat(this.dataset.bobot);
                        const penaltyScore = hari * bobot;
                        penaltyScoreInputs[index].value = penaltyScore;

                        updateTotalPenaltyScore(); // Update total penalty score
                    });
                });


                function updateTotalPenaltyScore() {
                    let totalPenalty = 0;
                    penaltyScoreInputs.forEach(input => {
                        totalPenalty += parseFloat(input.value) || 0;
                    });
                    totalPenaltyScoreInput.value = totalPenalty;

                    // Update nilai akhir setelah total penalty score berubah
                    updateNilaiAkhir();
                    updateGrade();
                }


            function updateNilaiAkhir() {
                const totalScore = parseFloat(totalScoreInput.value) || 0;
                const totalPenalty = parseFloat(totalPenaltyScoreInput.value) || 0;
                const nilaiAkhir = totalScore - totalPenalty;
                nilaiAkhirInput.value = nilaiAkhir;
            }
            function updateGrade() {
                const nilaiAkhir = parseFloat(nilaiAkhirInput.value) || 0;
                const hariSuratTeguran = parseInt(document.getElementById('hariSuratTeguran').value) || 0;
                let grade = '';

                // Tentukan grade berdasarkan nilai akhir
                if (nilaiAkhir <= 0) {
                    grade = 'Nilai Tidak Valid';
                } else {
                    @foreach($nilaiAkhirRentang as $rentang)
                        if (nilaiAkhir >= {{ $rentang->nilai_awal }} && nilaiAkhir <= {{ $rentang->nilai_akhir }}) {
                            grade = '{{ $rentang->grade }}';
                        }
                    @endforeach
                }
                // Jika pekerja memiliki Surat Teguran minimal 1 hari dan grade >= B, turunkan ke C
                if (hariSuratTeguran >= 1 && (grade === 'A' || grade === 'B')) {
                    grade = 'C';
                }

                document.getElementById('grade').value = grade;
            }

            // Panggil fungsi updateGrade() setiap kali nilai akhir berubah
            nilaiAkhirInput.addEventListener('input', updateGrade);

            function validateForm() {
                const nilaiManagerSelects = document.querySelectorAll('.nilai_manager');
                let hasEmptyNilaiManager = false;

                nilaiManagerSelects.forEach(select => {
                    if (select.value === '') {
                        hasEmptyNilaiManager = true;
                    }
                });

                if (hasEmptyNilaiManager) {
                    alert('Nilai Manager masih ada yang kosong. Mohon lengkapi terlebih dahulu.');
                    return false; // Mencegah form disubmit
                }


                document.getElementById('status').value = 'Approved'; // Set status_kpi menjadi 'Approved'



                return true; // Melanjutkan submit form

        }

        document.querySelectorAll('.hari').forEach(input => {
            input.addEventListener('input', function() {
                if (this.closest('tr').querySelector('td:first-child').innerText.trim() === "Surat Teguran") {
                    document.getElementById('hariSuratTeguran').value = parseInt(this.value) || 0;
                }
                updateGrade(); // Perbarui grade setiap kali input berubah
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
        updateTotalScore();
        updateTotalPenaltyScore()
        updateGrade() //panggil updateGrade() juga untuk menginisialisasi grade
        updateNilaiAkhir()


    });


            </script>

            <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>