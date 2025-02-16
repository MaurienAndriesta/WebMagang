<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MdNilaiakhir extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'md_nilai_akhir';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nilai_awal', 'nilai_akhir', 'grade', 'created_by'];

    protected static function boot()
{
    parent::boot();
    static::creating(function ($model) {
        if (!$model->id) {
            $model->id = (string) Str::uuid();
        }
    });
}

}