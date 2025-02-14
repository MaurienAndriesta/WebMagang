<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MdPenilaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'md_penilaian';
    protected $fillable = ['nama', 'bobot', 'kategori', 'created_by', 'updated_by', 'deleted_by'];
}
