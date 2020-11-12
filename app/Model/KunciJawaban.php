<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KunciJawaban extends Model
{
    //
    protected $table='tbl_kunci_jawaban';

    protected $fillable=['id_tema_soal','id_daftar_soal','jawaban','score','no_urut'];

    public function linkToKunciJabawan(){
        return $this->hasOne('App\Model\JawabanSiswa','id_kunci_jawaban','id');
    }

    public function linkToJawabanByNoUrut(){
        return $this->hasOne('App\Model\JawabanSiswa','no_urut','no_urut');
    }
}
