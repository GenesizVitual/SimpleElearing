<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiswaUjian extends Model
{
    //
    protected $table = "tbl_siswa_ujian";

    protected $fillable = ['id_tema_soal','id_siswa','status','waktu_mulai'];

    public function linkToTemaSoal(){
        return $this->hasOne('App\Model\Soal','id','id_tema_soal');
    }

    public function linkToSiswa(){
        return $this->hasOne('App\Model\Siswa', 'id','id_siswa');
    }

    public function linkToJawabanSiswa(){
        return $this->hasMany('App\Model\JawabanSiswa','id_siswa_ujian','id');
    }

    public function linktoOnejawabansiswa(){
        return $this->hasOne('App\Model\JawabanSiswa','id_siswa_ujian','id');
    }
}
