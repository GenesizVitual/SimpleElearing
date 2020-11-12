<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblAuthority extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_authority', function (Blueprint $table) {
            $table->id();
            $table->string('username',100)->unique();
            $table->string('password');
            $table->string('see_password');
            $table->enum('authority',[0,1,2])->comment('0=kepala sekolah, 1=staf sekolah, 2=-');
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
        Schema::dropIfExists('tbl_authority');
    }
}
