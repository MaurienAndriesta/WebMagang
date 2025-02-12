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
        Schema::create('md_bidang', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key, auto-increment
            $table->string('nama'); // Kolom Nama untuk menyimpan nama pengguna
            
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
