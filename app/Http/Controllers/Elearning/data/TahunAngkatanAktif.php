<?php
/**
 * Created by PhpStorm.
 * User: Fandiansyah
 * Date: 29/10/2020
 * Time: 15:20
 */

namespace App\Http\Controllers\Elearning\data;
use App\Model\ThnAnggaran;

class TahunAngkatanAktif
{
    public static $data;

    public static function CektanggalAktif(){

        $data = ThnAnggaran::where('status', '1')->first();
        if(empty($data)){
            return redirect()->back()->with('message_info','Tahun Angkatan belum diaktifkan');
        }
        self::$data = $data;
    }
}