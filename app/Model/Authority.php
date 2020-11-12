<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    //

    protected $table ='tbl_authority';
    protected $fillable =  ['username','password','see_password','authority'];
}
