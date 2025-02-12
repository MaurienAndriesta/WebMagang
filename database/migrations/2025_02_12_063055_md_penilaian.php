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
            $table->uuid('id')->primary(); // Menggunakan UUID sebagai primary key
            $table->string('nama'); // Nama kriteria penilaian
            $table->decimal('bobot', 5, 2); // Bobot penilaian (misal: 25.50 untuk 25.5%)
            $table->string('kategori'); // Kategori penilaian

            // Kolom Audit
            $table->timestamps(); // Menambahkan created_at & updated_at
            $table->uuid('created_by')->nullable(); // Pengguna yang membuat
            $table->uuid('updated_by')->nullable(); // Pengguna yang mengupdate
            $table->uuid('deleted_by')->nullable(); // Pengguna yang menghapus
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_penilaian');
    }
};
