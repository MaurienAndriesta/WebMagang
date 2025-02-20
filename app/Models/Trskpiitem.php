<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TrsKpiItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trs_kpi_item';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['idKpi', 'id_penilaian', 'catatan', 'nilai_spv', 'nilai_manager', 'created_by', 'updated_by', 'deleted_by'];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }


    public function kpi()
    {
        return $this->belongsTo(TrsKpi::class, 'idKpi'); // Relasi ke TrsKpi
    }

    public function penilaian()
    {
        return $this->belongsTo(MdPenilaian::class, 'id_penilaian'); // Relasi ke MdPenilaian
    }
}