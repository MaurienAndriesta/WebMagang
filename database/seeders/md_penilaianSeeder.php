<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class md_penilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('md_penilaian')->insert([
            [
                'id' => Str::uuid(),
                'nama' => 'Pemenuhan Target Kerja',
                'bobot' => 20,
                'kategori' => 'kriteria penilaian',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kualitas Kerja',
                'bobot' => 20,
                'kategori' => 'kriteria penilaian',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kepatuhan',
                'bobot' => 20,
                'kategori' => 'kriteria penilaian',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Kerjasama/ Team Work',
                'bobot' => 20,
                'kategori' => 'kriteria penilaian',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Inisiatif',
                'bobot' => 20,
                'kategori' => 'kriteria penilaian',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Datang Lambat',
                'bobot' => 0.4,
                'kategori' => 'penilaian kedisiplinan',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Mangkir',
                'bobot' => 5,
                'kategori' => 'penilaian kedisiplinan',
                'created_by' => Str::uuid(),

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Surat Teguran',
                'bobot' => 30,
                'kategori' => 'penilaian kedisiplinan',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
