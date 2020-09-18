<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblPilihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pilihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_daftar_soal')->references('id')->on('tbl_daftar_soal')->onDelete('cascade');
            $table->enum('label',['-','a','b','c','d'])->default('-');
            $table->text('text');
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
        Schema::dropIfExists('tbl_pilihan');
    }
}
