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
        Schema::create('request_surat', function (Blueprint $table) {
            $table->id();
            $table->string('keperluansurat');
            $table->text('deskripsi');
            $table->dateTime('tanggal_pengajuan');
            $table->dateTime('tanggal_pengambilan');
            $table->string('mahasiswa');
            $table->string('status')->default(''); // Ubah ke default yang sesuai
            $table->dateTime('tanggal_approve')->nullable();
            $table->timestamps();
    
            $table->foreign('mahasiswa')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_surat');
    }
};
