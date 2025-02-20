<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Gunakan Authenticatable

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'md_pengguna'; // Tabel yang digunakan
    protected $primaryKey = 'id'; // Primary key

    protected $fillable = ['id_pegawai', 'username', 'password', 'role']; // Kolom yang bisa diisi

    protected $hidden = ['password', 'remember_token']; // Kolom yang disembunyikan
    // app/Models/User.php
    public function pegawai()
    {
        return $this->belongsTo(MdPegawai::class, 'id_pegawai'); // Sesuaikan nama kolom foreign key
        }
}