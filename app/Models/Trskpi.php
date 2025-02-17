<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrsKpi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trs_kpi';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id', 'id_pegawai', 'id_penilai', 'nilai_akhir', 'grade', 'kelebihan', 
        'improvement', 'tahun', 'semester', 'status_kpi', 'created_by', 'updated_by', 'deleted_by'
    ];
}
