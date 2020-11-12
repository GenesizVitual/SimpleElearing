<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblOrangTua extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_orang_tua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('users');
            $table->string('nama_ayah');
            $table->string('no_ktp_ayah');
            $table->string('pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('alamat_ayah');
            $table->string('desa_ayah');
            $table->string('provinsi_ayah');
            $table->string('kecamatan_ayah');
            $table->string('no_hp_ayah');
            $table->string('nama_ibu');
            $table->string('no_ktp_ibu');
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('alamat_ibu');
            $table->string('desa_ibu');
            $table->string('provinsi_ibu');
            $table->string('kecamatan_ibu');
            $table->string('no_hp_ibu');
            $table->enum('total_penghasilan',['0', '1', '2', '3', '4', '5']);
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
        Schema::dropIfExists('tbl_orang_tua');
    }
}
