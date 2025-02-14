<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MdBidang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'md_bidang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id', 'nama', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'
    ];

    protected $dates = ['deleted_at']; // Agar Laravel mengenali deleted_at

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}