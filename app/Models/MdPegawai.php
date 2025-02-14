<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MdPegawai extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'md_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_atasan',
        'id_bidang',
        'id_subbidang',
        'nama',
        'jabatan',
        'masakerja',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Relasi ke Atasan
    public function atasan()
    {
        return $this->belongsTo(MdPegawai::class, 'id_atasan');
    }

    // Relasi ke Bidang
    public function bidang()
    {
        return $this->belongsTo(MdBidang::class, 'id_bidang');
    }

    // Relasi ke Subbidang
    public function subbidang()
    {
        return $this->belongsTo(MdSubbidang::class, 'id_subbidang');
    }
}
