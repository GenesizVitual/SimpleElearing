<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblCalonSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('users');
            $table->string('nama');
            $table->string('nisn');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->integer('anak_ke');
            $table->integer('dari');
            $table->enum('jenis_kelamin',['-','L','P'])->default('-');
            $table->string('asal_sekolah');
            $table->string('no_kartu_keluarga');
            $table->string('no_kps');
            $table->string('no_kip');
            $table->text('prestasi_akademik');
            $table->text('prestasi_non_akademik');
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
        Schema::dropIfExists('tbl_calon_siswa');
    }
}
