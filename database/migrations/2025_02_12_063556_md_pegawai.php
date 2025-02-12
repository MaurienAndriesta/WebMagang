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
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai primary key
            $table->uuid('id_pengguna')->nullable();
            $table->uuid('id_atasan')->nullable(); // Foreign key ke pegawai lain
            $table->uuid('id_bidang'); // Foreign key ke tabel md_bidang
            $table->uuid('id_subbidang'); // Foreign key ke tabel md_subbidang
            $table->string('nama'); // Nama Pegawai
            $table->string('jabatan'); // Jabatan Pegawai
            $table->integer('masakerja'); // Masa Kerja dalam tahun
            $table->enum('status', ['aktif', 'non-aktif']); // Status Pegawai (aktif/non-aktif)

            // Kolom Audit
            $table->timestamps(); // Menambahkan created_at & updated_at
            $table->uuid('created_by')->nullable(); // Pengguna yang membuat
            $table->uuid('updated_by')->nullable(); // Pengguna yang mengupdate
            $table->uuid('deleted_by')->nullable(); // Pengguna yang menghapus
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete

            // Menambahkan foreign key dengan constraints yang benar
            $table->foreign('id_pengguna')->references('id')->on('md_pengguna')->onDelete('set null');
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
        Schema::dropIfExists('md_pegawai');
    }
};
