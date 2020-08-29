<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    //
    protected $table = 'tbl_siswa';

    protected $fillable = ['kode','password','see_password','nama','kelas','jenis_kelas','angkatan'];
}
