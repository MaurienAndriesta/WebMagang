<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiPenilaian extends Model
{
    use HasFactory;

    protected $table = 'trs_kpi';
    protected $fillable = ['kriteria_id', 'nilai_spv', 'nilai_manager', 'bobot', 'score', 'total_score', 'total_kedisiplinan'];

    // Hitung score secara otomatis
    public function hitungScore()
    {
        return ($this->nilai_spv + $this->nilai_manager) * $this->bobot;
    }
}
