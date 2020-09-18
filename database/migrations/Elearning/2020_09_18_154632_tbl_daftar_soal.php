<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblDaftarSoal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_daftar_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guru')->references('id')->on('tbl_guru')->onDelete('cascade');
            $table->foreignId('id_tema_soal')->references('id')->on('tbl_tema_soal')->onDelete('cascade');
            $table->text('soal');
            $table->string('gambar');
            $table->dateTime('waktu_kerja');
            $table->integer('no_urut');
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
        Schema::dropIfExists('tbl_daftar_soal');
    }
}
