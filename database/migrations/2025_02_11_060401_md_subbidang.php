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
        Schema::create('md_subbidang', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key, auto-increment
            $table->unsignedBigInteger('unit_id'); // Kolom Unit ID sebagai foreign key
            $table->string('nama'); // Kolom Nama untuk menyimpan nama subbidang
        
            

            // Menambahkan foreign key ke tabel unit (jika ada tabel 'md_bidang')
            $table->foreign('unit_id')->references('id')->on('md_bidang')->onDelete('cascade');
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
