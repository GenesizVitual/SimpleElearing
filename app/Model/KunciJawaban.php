<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KunciJawaban extends Model
{
    //
    protected $table='tbl_kunci_jawaban';

    protected $fillable=['id_tema_soal','jawaban','score','no_urut'];
}
