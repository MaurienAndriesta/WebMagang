<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MdPegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'md_pegawai';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'id_atasan', 'id_bidang', 'id_subbidang', 'nama', 'jabatan', 'masakerja', 'status',
        'created_by', 'updated_by', 'deleted_by'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function bidang()
    {
        return $this->belongsTo(MdBidang::class, 'id_bidang');
    }

    public function subbidang()
    {
        return $this->belongsTo(MdSubBidang::class, 'id_subbidang');
    }

    public function atasan()
    {
        return $this->belongsTo(MdPegawai::class, 'id_atasan');
    }

    public function latestKpi()
{
    return $this->hasOne(Kpi_spv::class, 'id_pegawai');  // Menggunakan 'id_pegawai' sebagai foreign key
}
}