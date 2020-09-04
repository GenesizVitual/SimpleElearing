<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiswaUjian extends Model
{
    //
    protected $table = "tbl_siswa_ujian";

    protected $fillable = ['id_tema_soal','id_siswa','status','waktu_mulai'];

    public function linkToSiswa(){
        return $this->hasOne('App\Model\Siswa', 'id','id_siswa');
    }
}
