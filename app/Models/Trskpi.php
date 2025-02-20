<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TrsKpi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trs_kpi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pegawai', 'id_penilai', 'nilai_akhir', 'grade', 
        'kelebihan', 'improvement', 'tahun', 'semester', 'status_kpi', 
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // Relasi ke Pegawai
    public function pegawai()
    {
        return $this->belongsTo(MdPegawai::class, 'id_pegawai');
    }
    
}