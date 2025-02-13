<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class MdPengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'md_pengguna'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'id'; // Primary key tabel

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Mutator: Hash password hanya jika belum di-hash
    public function setPasswordAttribute($value)
    {
        if (!Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}
