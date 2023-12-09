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
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->string('keperluan_ib');
            $table->string('tempat_tujuan');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('status')->nullable();
            $table->date('tanggal_approve')->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('izin_bermalam');
    }
}
