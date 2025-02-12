<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('md_penilaian', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->string('nama'); // Nama kriteria penilaian
            $table->decimal('bobot', 5, 2); // Bobot penilaian (misal: 25.50 untuk 25.5%)
            $table->string('kategori'); // Kategori penilaian
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
