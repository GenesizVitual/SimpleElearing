<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ThnAnggaran extends Model
{
    //
    protected $table = 'tbl_thn_angkatan';

    protected $fillable = ['thn_lalu','thn_depan','status'];

}
