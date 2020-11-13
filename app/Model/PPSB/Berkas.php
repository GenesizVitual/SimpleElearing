<?php

namespace App\Model\PPSB;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    //
    protected $table='tbl_berkas';

    protected $fillable=['deskripsi','format_berkas','ukuran_berkas'];
}
