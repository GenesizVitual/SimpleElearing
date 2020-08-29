<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('password');
            $table->string('see_password');

            $table->string('nama');
            $table->string('kelas');
            $table->string('jenis_kelas');
            $table->string('angkatan');
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
        Schema::dropIfExists('tbl_siswa');
    }
}
