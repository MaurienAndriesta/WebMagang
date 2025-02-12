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
        Schema::create('md_nilai_akhir', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->decimal('nilai_awal', 5, 2); // Nilai awal dengan 2 angka di belakang koma
            $table->decimal('nilai_akhir', 5, 2); // Nilai akhir dengan 2 angka di belakang koma
            
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
