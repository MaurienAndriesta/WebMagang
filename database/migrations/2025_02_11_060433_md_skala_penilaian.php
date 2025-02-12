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
        Schema::create('md_skala_penilaian', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->integer('angka')->unique(); // Angka skala penilaian (unik)
            $table->string('keterangan'); // Keterangan skala penilaian
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
