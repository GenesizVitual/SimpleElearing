<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class  Soal extends Model
{
    //
    protected $table="tbl_tema_soal";

    protected $fillable = ['id_guru','judul_soal','jenis_kelas','id_thn_angkatan','id_mata_pelajaran','semester','kelas','token','time','status_waktu','status','status_lagunge'];

    public function linkToGuru(){
        return $this->belongsTo('App\Model\Guru', 'id_guru');
    }

    public function linkToFileSoal(){
        return $this->hasOne('App\Model\FileSoal','id_tema_soal','id');
    }

    public function linkToSiswaUjian(){
        return $this->hasMany('App\Model\SiswaUjian','id_tema_soal','id');
    }

    public function linkOneToSiswaUjian(){
        return $this->hasOne('App\Model\SiswaUjian','id_tema_soal','id');
    }

    public function listToKunciJawaban(){
        return $this->hasMany('App\Model\KunciJawaban','id_tema_soal', 'id');
    }

    public function linkToDaftarSoal(){
        return $this->hasMany('App\Model\DaftarSoal','id_tema_soal','id');
    }

    public function linkToMataPelajaran(){
        return $this->belongsTo('App\Model\MataPelajaran','id_mata_pelajaran');
    }
}
