@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">FORM PENILAIAN KINERJA TAHUNAN</h2>

    <form action="{{ route('trs_kpi.store') }}" method="POST">
        @csrf
        
        <div class="card mb-4">
            <div class="card-header">IDENTITAS PEGAWAI</div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Pegawai</label>
                    <select name="id_pegawai" class="form-control">
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Penilai</label>
                    <select name="id_penilai" class="form-control">
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tahun</label>
                    <input type="text" name="tahun" class="form-control" placeholder="YYYY">
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" class="form-control">
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
