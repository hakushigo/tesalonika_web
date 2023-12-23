<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinBermalamTable extends Migration
{
    public function up()
    {
        Schema::create('izin_bermalam', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_berangkat');
            $table->dateTime('tanggal_kembali');
            $table->string('keperluan_ib');
            $table->string('tempat_tujuan');
            $table->string('mahasiswa');
            $table->string('status')->default('pending');
            $table->date('tanggal_approve')->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('izin_bermalam');
    }
}
