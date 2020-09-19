<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DaftarSoal extends Model
{
    //
    protected $table = 'tbl_daftar_soal';

    protected $fillable = ['id_guru','id_tema_soal','soal','gambar','waktu_kerja','no_urut'];

    public function linkToPilihan(){
        return $this->hasMany('App\Model\Pilihan','id_daftar_soal','id');
    }

    public function linkToJawaban()
    {
        return $this->hasOne('App\Model\KunciJawaban','id_daftar_soal','id');
    }
}
