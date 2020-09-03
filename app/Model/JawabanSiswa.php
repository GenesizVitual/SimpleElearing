<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    //

    protected $table = 'tbl_jawaban_siswa';
    protected $fillable = ['id_kunci_jawaban','id_siswa','jawaban','no_urut'];


}
