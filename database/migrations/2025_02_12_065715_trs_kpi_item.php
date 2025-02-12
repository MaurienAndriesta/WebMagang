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
        Schema::create('trs_kpi_item', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai primary key
            $table->uuid('id_kpi'); // Foreign key ke KPI utama
            $table->uuid('id_penilaian'); // Foreign key ke kriteria penilaian
            $table->text('catatan')->nullable(); // Catatan/feedback dari penilai
            $table->decimal('nilai_spv', 5, 2)->nullable(); // Nilai dari Supervisor
            $table->decimal('nilai_manager', 5, 2)->nullable(); // Nilai dari Manager

            // Kolom Audit
            $table->timestamps(); // Menambahkan created_at & updated_at
            $table->uuid('created_by')->nullable(); // Pengguna yang membuat
            $table->uuid('updated_by')->nullable(); // Pengguna yang mengupdate
            $table->uuid('deleted_by')->nullable(); // Pengguna yang menghapus
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete

            // Foreign key ke trs_kpi
            $table->foreign('id_kpi')->references('id')->on('trs_kpi')->onDelete('cascade');
            // Foreign key ke md_penilaian
            $table->foreign('id_penilaian')->references('id')->on('md_penilaian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_kpi_item');
    }
};
