<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    //

    protected $table = 'tbl_pilihan';

    protected $fillable = ['id_daftar_soal','label','text','waktu_kerja','gambar'];


}
