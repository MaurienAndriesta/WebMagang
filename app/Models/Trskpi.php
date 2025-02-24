<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Trskpi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trs_kpi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'id_pegawai', 'id_penilai', 'nilai_akhir', 'status',
                                'grade', 'improvement', 'kelebihan', 'semester', 'tahun',
                                'created_by', 'updated_by', 'deleted_by'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function kpiItems()
    {
        return $this->hasMany(TrsKpiItem::class, 'id_kpi');
    }

    public function pegawai()
    {
        return $this->belongsTo(MdPegawai::class, 'id_pegawai');
    }

    public function bidang()
    {
        return $this->belongsTo(MdBidang::class, 'id_bidang'); // Sesuaikan nama kolom jika berbeda
    }

    public function penilai()
    {
        return $this->belongsTo(MdPegawai::class, 'id_penilai');
    }

}
