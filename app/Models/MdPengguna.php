<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MdPengguna extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'md_pengguna';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pegawai', 'username', 'password', 'role', 'created_by', 'updated_at', 'created_at'
    ];

    protected $hidden = ['password'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
            $model->created_by = auth()->id() ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id() ?? null;
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->id() ?? null;
            $model->save();
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(MdPegawai::class, 'id_pegawai');
    }
}
