<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trskpispv extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'bidang',
        'masakerja',
        'nama_penilai',
        'periode_penilaian',
        'tanggal_penilaian',
        'sub_dir',
        'kelebihan',
        'improvement',
        'items', // Penilaian Kinerja
        'datang_lambat_hari',
        'datang_lambat_penalty',
        'datang_lambat_total',
        'mangkir_hari',
        'mangkir_penalty',
        'mangkir_total',
        'teguran_hari',
        'teguran_penalty',
        'teguran_total',
    ];
}
