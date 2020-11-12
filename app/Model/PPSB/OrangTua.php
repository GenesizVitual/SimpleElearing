<?php

namespace App\Model\PPSB;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    //
    protected $table = 'tbl_orang_tua';
    protected $fillable=[
        'id_user',
        "nama_ayah",
        "no_ktp_ayah",
        "pendidikan_ayah",
        "pekerjaan_ayah",
        "alamat_ayah",
        "desa_ayah",
        "provinsi_ayah",
        "kecamatan_ayah",
        "no_hp_ayah",
        "nama_ibu",
        "no_ktp_ibu",
        "pendidikan_ibu",
        "pekerjaan_ibu",
        "alamat_ibu",
        "desa_ibu",
        "provinsi_ibu",
        "kecamatan_ibu",
        "no_hp_ibu",
        "total_penghasilan",
    ];
}
