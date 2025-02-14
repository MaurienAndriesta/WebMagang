<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MdSubbidang extends Model
{
    use SoftDeletes;

    protected $table = 'md_subbidang'; // Nama tabel di database

    protected $fillable = [
        'id', // Tambahkan id agar bisa diisi manual
        'unit_id',
        'nama',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $incrementing = false; // Matikan auto-increment
    protected $keyType = 'string'; // Set tipe primary key ke string (UUID)

    // Event untuk mengisi id dengan UUID sebelum data dibuat
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

    // Relasi ke tabel md_bidang
    public function bidang()
    {
        return $this->belongsTo(MdBidang::class, 'unit_id');
    }
}