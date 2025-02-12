<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class md_skala_penilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('md_skala_penilaian')->insert([
            [
                'id' => Str::uuid(),
                'angka' => 1,
                'keterangan' => 'Sangat Kurang',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'angka' => 2,
                'keterangan' => 'Kurang',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'angka' => 3,
                'keterangan' => 'Cukup',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'angka' => 4,
                'keterangan' => 'Baik',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'angka' => 5,
                'keterangan' => 'Sangat Baik',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
