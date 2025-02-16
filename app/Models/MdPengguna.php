<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MdPengguna extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, HasUuids;

    protected $table = 'md_pengguna';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_pegawai',
        'username',
        'password',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $hidden = ['password'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(MdPegawai::class, 'id_pegawai');
    }

    /**
     * Override getAuthIdentifierName untuk autentikasi Laravel
     */
    public function getAuthIdentifierName()
    {
        return 'id'; 
    }

    /**
     * Hash password sebelum disimpan ke database.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value) && Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
