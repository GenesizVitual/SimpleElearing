<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FileSoal extends Model
{
    //
    protected $table="tbl_file_soal";

    protected $fillable = ['id_tema_soal','nama_file'];

}
