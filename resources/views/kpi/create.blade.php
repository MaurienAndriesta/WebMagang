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

    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="img/LOGO.jpg" alt="PLN Icon Plus">
        </div>
        <div class="nav-buttons">
            <button class="home-button" onclick="window.location.href='{{ url('/dashboardspv') }}'">Home</button>
            <button class="kpi-button" onclick="window.location.href='{{ url('/kpi') }}'">KPI</button>
            <button class="logout-button" onclick="window.location.href='{{ url('/') }}'">Logout</button>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                FORM PENILAIAN KINERJA TAHUNAN TKO
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

            <form method="POST" action="{{ route('kpi.store') }}">
                @csrf

                {{-- Identitas Pekerja --}}
                <label for="id_pegawai">Nama :</label>
                <select name="id_pegawai" id="id_pegawai" class="form-control">
                    @foreach($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->jabatan }} - {{ $p->bidang->nama }})</option>
                    @endforeach
                </select>

                {{-- Identitas Penilai --}}
                <label for="id_penilai">Nama Penilai : </label>
                <input type="text" name="id_penilai" value="{{ $user->pegawai->nama }}"  readonly> 


                {{-- Periode, Tanggal, Sub Bidang --}}
                <label for="periode">Periode Penilaian: </label>
                <input type="text" name="periode" id="periode" class="form-control"> <label for="tanggal">Tanggal Penilaian: </label>
                <input type="date" name="tanggal" id="tanggal" class="form-control">
                <label for="sub_bidang">Sub Bidang: </label>
                <input type="text" name="sub_bidang" id="sub_bidang" class="form-control">

                {{-- Kriteria Penilaian (Tabel 1) --}}
                <h3>Kriteria Penilaian</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kriteria</th>
                            <th>Bobot</th>
                            <th>SPV</th>
                            <th>Manager</th>
                            <th>Score</th>
                            <th>Contoh Perilaku</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penilaianItems->where('kategori', 'Kriteria Penilaian') as $item)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td style="text-align: center">{{ $item->bobot }}</td>
                                    <td>
                                        <select name="items[{{ $item->id }}][nilai_spv]" class="form-control nilai_spv" data-bobot="{{ $item->bobot }}">
                                            <option value="">Pilih Nilai SPV</option>
                                            @foreach ($skalaPenilaian as $skala)
                                                <option value="{{ $skala->angka }}">{{ $skala->angka }} - {{ $skala->keterangan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="items[{{ $item->id }}][nilai_manager]" class="form-control nilai_manager" data-bobot="{{ $item->bobot }}">
                                            <option value="">Pilih Nilai Manager</option>
                                            @foreach ($skalaPenilaian as $skala)
                                                <option value="{{ $skala->angka }}">{{ $skala->angka }} - {{ $skala->keterangan }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="items[{{ $item->id }}][score]" class="form-control score" data-bobot="{{ $item->bobot }}" readonly></td>
                                    <td><textarea name="items[{{ $item->id }}][catatan]"></textarea></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" style="text-align: center;"><strong>Jumlah</strong></td>
                                <td><input type="number" name="total_score" id="totalScore" class="form-control" readonly></td><td></td>
                            </tr>
                        </tbody>
                </table>

                {{-- Penilaian Kedisiplinan (Tabel 2) --}}
                <h3>Penilaian Kedisiplinan</h3>
                <table>
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
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td><input type="number" name="kedisiplinan[{{ $item->id }}][hari]" class="form-control hari" data-bobot="{{ $item->bobot }}"></td>
                                    <td><input type="number" name="kedisiplinan[{{ $item->id }}][penalty_score]" class="form-control penalty-score" data-bobot="{{ $item->bobot }}" readonly></td>
                                    @if ($loop->first)  {{-- Hanya tampilkan di baris pertama --}}
                                    <td rowspan="{{ $jumlahKedisiplinan + 3}}" style="vertical-align : middle;text-align:center;">  {{-- rowspan dinamis --}}
                                        <input type="number" name="total_penalty_score" id="totalPenaltyScore" class="form-control" readonly>

                                    </td>

                                    <td rowspan="{{ $jumlahKedisiplinan + 3}}"  style="vertical-align : middle;text-align:center;"><input type="text" name="grade" id="grade" class="form-control" readonly></td>
                                    <td rowspan="{{ $jumlahKedisiplinan + 3}}" style="vertical-align : middle;text-align:center;" ><input type="number" name="nilai_akhir" id="nilaiAkhir" class="form-control" readonly></td>

                                @endif
                                </tr>

                            @endforeach

                    </tbody>
                </table>

                {{-- Kelebihan dan Improvement --}}
                <label for="kelebihan">Kelebihan:</label>
                <textarea name="kelebihan" id="kelebihan" class="form-control"></textarea>

                <label for="improvement">Improvement:</label>
                <textarea name="improvement" id="improvement" class="form-control"></textarea>

                <div class="footer">
                    <button type="submit" class="btn btn-warning" name="ajukan" value="1">Ajukan</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
            </div>
        </div>
    </div>
            <script>
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
                let grade = '';

                if (nilaiAkhir < 0) {
                    grade = 'Nilai Tidak Valid';
                } else {
                    @foreach($nilaiAkhirRentang as $rentang)
                        if (nilaiAkhir >= {{ $rentang->nilai_awal }} && nilaiAkhir <= {{ $rentang->nilai_akhir }}) {
                            grade = '{{ $rentang->grade }}';
                        }
                    @endforeach
                }

                document.getElementById('grade').value = grade;
            }

            // Panggil fungsi updateGrade() setiap kali nilai akhir berubah
            nilaiAkhirInput.addEventListener('input', updateGrade);


            </script>

            <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>