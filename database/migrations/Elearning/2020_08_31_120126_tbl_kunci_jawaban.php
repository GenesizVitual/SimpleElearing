<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblKunciJawaban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_kunci_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tema_soal')->references('id')->on('tbl_tema_soal');
            $table->enum('jawaban',['-','a','b','c','d','e'])->default('-');
            $table->decimal('score',12,2);
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
        Schema::dropIfExists('tbl_kunci_jawaban');
    }
}
