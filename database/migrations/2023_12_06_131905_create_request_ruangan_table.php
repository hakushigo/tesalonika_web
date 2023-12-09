<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_ruangan', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time'); //tanggal untuk memakai ruangan
            $table->dateTime('end_time'); //tanggal berakhir pemakaian ruangan
            $table->string("keterangan");
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('ruangan_id');
            $table->dateTime('tanggal_terima')->nullable();
            $table->string('status')->nullable(); // Kolom status sebagai string

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade');

            $table->timestamps();
            //DB::statement("ALTER TABLE requests ADD CONSTRAINT approve_status CHECK (status = 'approved' OR (status IS NULL AND tanggal_terima IS NULL))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_ruangan');
    }
};
