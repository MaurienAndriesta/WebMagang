<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class MdPengguna extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'md_pengguna';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pegawai',
        'username',
        'password',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $hidden = ['password'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    public function setPasswordAttribute($value)
    {
        if (!empty($value) && !Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
