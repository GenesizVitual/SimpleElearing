<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WaliSiswa extends Model
{
    //
    protected $table = "tbl_wali_murid";

    protected $fillable = ['nama_pengguna','password','id_siswa'];

    public function linkToSiswa(){
        return $this->belongsTo('App\Model\Siswa','id_siswa');
    }
}
