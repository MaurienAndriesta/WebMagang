<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penilaian Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-approve { background-color: #28a745; color: white; padding: 5px 10px; border-radius: 5px; }
        .status-review-manager { background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 5px; }
        .status-review-spv { background-color: #ff5722; color: white; padding: 5px 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">DATA PENILAIAN KARYAWAN</h2>
        <button class="btn btn-primary mb-3">+ Tambah</button>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Bidang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $index => $employee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ $employee->department }}</td>
                        <td>
                            @if ($employee->status == 'approve')
                                <span class="status-approve">Approve</span>
                            @elseif ($employee->status == 'review_manager')
                                <span class="status-review-manager">Review Manager</span>
                            @elseif ($employee->status == 'review_spv')
                                <span class="status-review-spv">Review SPV</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-secondary">Edit</button>
                            <button class="btn btn-danger">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
