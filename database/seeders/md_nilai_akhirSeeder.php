<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class md_nilai_akhirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('md_nilai_akhir')->insert([
            [
                'id' => Str::uuid(),
                'nilai_awal' => 421,
                'nilai_akhir' => 500,
                'grade' => 'A',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nilai_awal' => 341,
                'nilai_akhir' => 420,
                'grade' => 'B',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nilai_awal' => 261,
                'nilai_akhir' => 340,
                'grade' => 'C',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nilai_awal' => 1,
                'nilai_akhir' => 260,
                'grade' => 'D',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
