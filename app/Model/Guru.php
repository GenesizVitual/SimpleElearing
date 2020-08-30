<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    //
    protected $table="tbl_guru";

    protected $fillable = ['kode','password','see_password','nama'];
}
