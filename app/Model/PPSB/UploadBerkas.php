<?php

namespace App\Model\PPSB;

use Illuminate\Database\Eloquent\Model;

class UploadBerkas extends Model
{
    //
    protected $table = "tbl_upload_berkas";

    protected $fillable = ['id_user','id_berkas','nama_file'];

    public function LinkToUsers(){
        return $this->belongsTo('App\User','id_user');
    }
}
