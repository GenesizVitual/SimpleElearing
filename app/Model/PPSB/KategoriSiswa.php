<?php

namespace App\Model\PPSB;

use Illuminate\Database\Eloquent\Model;

class KategoriSiswa extends Model
{
    //
    protected $table='tbl_kategori_siswa';
    protected $fillable=['id_user','asrama','ciber','semi_ciber'];
}
