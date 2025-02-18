<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrskpispvModel extends Model
{
    protected $table = 'penilaian_kinerja';
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
        'datang_lambat_hari',
        'datang_lambat_penalty',
        'datang_lambat_total',
        'mangkir_hari',
        'mangkir_penalty',
        'mangkir_total',
        'teguran_hari',
        'teguran_penalty',
        'teguran_total'
    ];
}
