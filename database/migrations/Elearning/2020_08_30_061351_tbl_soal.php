<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblSoal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tema_soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guru')->references('id')->on('tbl_guru')->onDelete('cascade');
            $table->string('judul_soal');
            $table->string('jenis_kelas');
            $table->string('kelas');
            $table->string('token');
            $table->enum('status',['0','1'])->default(0)->comment('0=tidak aktif, 1=aktif');
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
        Schema::dropIfExists('tbl_tema_soal');
    }
}
