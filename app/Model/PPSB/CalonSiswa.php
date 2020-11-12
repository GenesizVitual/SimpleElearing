<?php

namespace App\Model\PPSB;

use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    //
    protected $table = 'tbl_calon_siswa';

    protected $fillable=[
        'id_user',
        'nama',
        'nisn',
        'tempat_lahir',
        'tgl_lahir',
        'anak_ke',
        'dari',
        'jenis_kelamin',
        'asal_sekolah',
        'no_kartu_keluarga',
        'no_kps',
        'no_kip',
        'prestasi_akademik',
        'prestasi_non_akademik',
    ];

}
