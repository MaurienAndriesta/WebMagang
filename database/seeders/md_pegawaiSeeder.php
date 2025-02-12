<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class md_pegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('md_pegawai')->insert([
            [
                'id' => Str::uuid(),
                'id_pengguna' => null, // Kosong dulu, update nanti
                'id_bidang' => 'a8903872-8ea7-4648-8058-f629b9a7e244',
                'id_subbidang' => '9ed50bff-45c9-4c5f-8b0b-496677592b98',
                'id_atasan' => null,
                'nama' => 'Ahmad Riyadi',
                'jabatan' => 'Manager',
                'masakerja' => 5,
                'status' => 'aktif',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        DB::table('md_pegawai')->insert([
            [
                'id' => Str::uuid(),
                'id_pengguna' => null, // Kosong dulu, akan diisi nanti jika sudah ada pengguna
                'id_bidang' => 'a8903872-8ea7-4648-8058-f629b9a7e244',
                'id_subbidang' => '9ed50bff-45c9-4c5f-8b0b-496677592b98',
                'id_atasan' => '29e15512-19c1-43f3-bf67-6d908bd818ef',
                'nama' => 'Budi Santoso',
                'jabatan' => 'Supervisor',
                'masakerja' => 3,
                'status' => 'aktif',
                'created_by' => Str::uuid(), // Pastikan ini diisi dengan UUID yang valid
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
