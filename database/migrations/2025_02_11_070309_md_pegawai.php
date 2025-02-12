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
        Schema::create('md_pegawai', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->unsignedBigInteger('id_atasan')->nullable(); // Foreign key ke pegawai lain
            $table->unsignedBigInteger('id_bidang'); // Foreign key ke tabel md_bidang
            $table->unsignedBigInteger('id_subbidang'); // Foreign key ke tabel md_subbidang
            $table->string('nama'); // Nama Pegawai
            $table->string('jabatan'); // Jabatan Pegawai
            $table->integer('masakerja'); // Masa Kerja dalam tahun
            $table->enum('status', ['aktif', 'non-aktif']); // Status Pegawai (aktif/non-aktif)
        

            // Menambahkan foreign key dengan constraints yang benar
            $table->foreign('id_atasan')->references('id')->on('md_pegawai')->onDelete('set null');
            $table->foreign('id_bidang')->references('id')->on('md_bidang')->onDelete('restrict');
            $table->foreign('id_subbidang')->references('id')->on('md_subbidang')->onDelete('restrict');
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
