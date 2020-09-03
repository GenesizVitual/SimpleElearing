<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblJawabanSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_jawaban_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kunci_jawaban')->references('id')->on('tbl_kunci_jawaban')->onDelete('cascade');
            $table->foreignId('id_siswa')->references('id')->on('tbl_siswa')->onDelete('cascade');
            $table->enum('jawaban',['-','a','b','c','d','e'])->default('-');
            $table->integer('no_urut')->unsigned();
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
        Schema::dropIfExists('tbl_jawaban_siswa');
    }
}
