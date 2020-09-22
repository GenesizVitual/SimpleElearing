<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    //

    protected $table = 'tbl_jawaban_siswa';
    protected $fillable = ['id_kunci_jawaban','id_siswa_ujian','id_siswa','jawaban','no_urut'];

    public function linkToKunciJawaban(){
        return $this->belongsTo('App\Model\KunciJawaban','id_kunci_jawaban');
    }

}
