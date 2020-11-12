<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    //
    protected $table = 'tbl_siswa';

    protected $fillable = ['kode','password','see_password','nama','kelas',
        'label_kelas',
        'jenis_kelas','angkatan'];

    public function linkToWalisiswa(){
        return $this->hasOne('App\Model\WaliSiswa','id_siswa','id');
    }
}
