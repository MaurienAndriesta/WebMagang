<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class md_subbidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('md_subbidang')->insert([
            [
                'id' => Str::uuid(),
                'nama' => 'Aplikasi PLN - Korporat 1',
                'unit_id' => 'a8903872-8ea7-4648-8058-f629b9a7e244',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Aplikasi PLN - Korporat 2',
                'unit_id' => 'a8903872-8ea7-4648-8058-f629b9a7e244',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Aplikasi PLN - Pelayanan Pelanggan',
                'unit_id' => 'a8903872-8ea7-4648-8058-f629b9a7e244',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
