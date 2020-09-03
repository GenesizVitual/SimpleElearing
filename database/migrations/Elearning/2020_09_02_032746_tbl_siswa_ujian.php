<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblSiswaUjian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_siswa_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tema_soal')->references('id')->on('tbl_tema_soal')->onDelete('cascade');
            $table->foreignId('id_siswa')->references('id')->on('tbl_siswa')->onDelete('cascade');
            $table->enum('status',['0','1'])->comment('0=belum mulai, 1=sudah selesai');
            $table->dateTime('waktu_mulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_siswa_ujian');
    }
}
