<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'see_password', 'level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function LinkToCalonSiswa(){
        return $this->hasOne('App\Model\PPSB\CalonSiswa','id_user','id');
    }

    public function LinkToOrangTua(){
        return $this->hasOne('App\Model\PPSB\OrangTua','id_user','id');
    }

    public function LinkToKategoriSiswa(){
        return $this->hasOne('App\Model\PPSB\KategoriSiswa','id_user','id');
    }

    public function LinkToBerkas(){
        return $this->hasMany('App\Model\PPSB\UploadBerkas','id_user','id');
    }
}
