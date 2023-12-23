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
        Schema::create('izin_keluar', function (Blueprint $table) {
            $table->id();
            $table->dateTime('rencana_berangkat');
            $table->dateTime('rencana_kembali');
            $table->string('keperluan_ik');
            $table->string('mahasiswa');
            $table->string('status')->default("pending")->nullable();
            $table->date('tanggal_approve')->nullable();
            $table->timestamps();
    
            $table->foreign('mahasiswa')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_keluar');
    }
};
