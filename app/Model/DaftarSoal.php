<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DaftarSoal extends Model
{
    //
    protected $table = 'tbl_daftar_soal';

    protected $fillable = ['id_guru','id_tema_soal','soal','gambar','waktu_kerja','no_urut'];
}
