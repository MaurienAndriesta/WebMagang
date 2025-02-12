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
        Schema::create('trs_kpi', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai primary key
            $table->uuid('id_pegawai'); // Foreign key ke pegawai yang dinilai
            $table->uuid('id_penilai'); // Foreign key ke pegawai yang menilai
            $table->decimal('nilai_akhir', 5, 2); // Nilai akhir KPI
            $table->string('grade'); // Grade dari hasil KPI
            $table->text('kelebihan')->nullable(); // Kelebihan pegawai
            $table->text('improvement')->nullable(); // Area yang perlu diperbaiki
            $table->year('tahun'); // Tahun penilaian
            $table->enum('semester', ['1', '2']); // Semester 1 atau 2

            // Kolom Audit
            $table->timestamps(); // Menambahkan created_at & updated_at
            $table->uuid('created_by')->nullable(); // Pengguna yang membuat
            $table->uuid('updated_by')->nullable(); // Pengguna yang mengupdate
            $table->uuid('deleted_by')->nullable(); // Pengguna yang menghapus
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete

            // Foreign key ke md_pegawai
            $table->foreign('id_pegawai')->references('id')->on('md_pegawai')->onDelete('cascade');
            $table->foreign('id_penilai')->references('id_atasan')->on('md_pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_kpi');
    }
};
