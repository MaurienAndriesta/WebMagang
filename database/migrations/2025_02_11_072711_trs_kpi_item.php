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
            $table->id(); // Primary key auto-increment
            $table->unsignedBigInteger('id_kpi'); // Foreign key ke KPI utama
            $table->unsignedBigInteger('id_penilaian'); // Foreign key ke kriteria penilaian
            $table->text('catatan')->nullable(); // Catatan/feedback dari penilai
            $table->decimal('nilai_spv', 5, 2)->nullable(); // Nilai dari Supervisor
            $table->decimal('nilai_manager', 5, 2)->nullable(); // Nilai dari Manager
            

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
        //
    }
};
