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
        Schema::create('md_pengguna', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->unsignedBigInteger('id_pegawai'); // Foreign key ke md_pegawai
            $table->string('username')->unique(); // Username unik
            $table->string('password'); // Password yang di-hash
            

            // Foreign key ke md_pegawai
            $table->foreign('id_pegawai')->references('id')->on('md_pegawai')->onDelete('cascade');
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
