<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    //
    protected $table="tbl_tema_soal";

    protected $fillable = ['id_guru','judul_soal','jenis_kelas','kelas','token','status'];

    public function linkToGuru(){
        return $this->belongsTo('App\Model\Guru', 'id_guru');
    }

    public function linkToFileSoal(){
        return $this->hasOne('App\Model\FileSoal','id_tema_soal','id');
    }
}
