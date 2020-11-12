<?php

namespace App\Http\Controllers\PPSB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\Model\PPSB\CalonSiswa;
use App\Model\PPSB\KategoriSiswa;

class Formulir extends Controller
{
    // Formulir Siswa
    public function index(){
        try{
            Session::put('menu','formulir_siswa');
            $data_user = User::findOrFail(Session::get('id_pendaftar'));
            return view('PPSB.Formulir.content', ['data'=> $data_user]);
        }catch (Throwable $e){
            return false;
        }
    }

    public function kategori_siswa(Request $req){
        try{
            $asrama = 'off';
            $ciber = 'off';
            $semi_ciber = 'off';

            if(!empty($req->asrama)){
                $asrama = $req->asrama;
            }

            if(!empty($req->ciber)){
                $ciber = $req->ciber;
            }

            if(!empty($req->semi_ciber)){
                $semi_ciber = $req->semi_ciber;
            }

            $model = KategoriSiswa::updateOrCreate(
                ['id_user'=> Session::get('id_pendaftar')],
                [
                    'asrama'=> $asrama,
                    'ciber'=> $ciber,
                    'semi_ciber'=> $semi_ciber,
                ]
            );

            if($model){
                return redirect()->back()->with('message_success','Kategori calon siswa telah disimpan');
            }else{
                return redirect()->back()->with('message_error','Kategori calon siswa  gagal disimpan');
            }

        }catch (Throwable $e){
            return false;
        }
    }

    public function store(Request $req){
        try{
            $this->validate($req,[
                "nama" => "required",
                "tempat_lahir" => "required",
                "tgl_lahir" => "required",
                "anak_ke" => "required",
                "dari" => "required",
                "jenis_kelamin" => "required",
                "asal_sekolah" => "required",
                "no_kartu_keluarga" => "required",
            ]);

            $model = CalonSiswa::updateOrCreate(
                ['id_user'=> Session::get('id_pendaftar')],
                [
                    'nama'=> $req->nama,
                    'nisn'=>$req->nisn,
                    'tempat_lahir'=>$req->tempat_lahir,
                    'tgl_lahir'=>$req->tgl_lahir,
                    'anak_ke'=>$req->anak_ke,
                    'dari'=>$req->dari,
                    'jenis_kelamin'=>$req->jenis_kelamin,
                    'asal_sekolah'=>$req->asal_sekolah,
                    'no_kartu_keluarga'=> $req->no_kartu_keluarga,
                    'no_kps'=> $req->no_kps,
                    'no_kip'=>$req->no_kip,
                    'prestasi_akademik'=>$req->prestasi_akademik,
                    'prestasi_non_akademik'=>$req->prestasi_akademik,
                ]
            );

            if($model){
                return redirect()->back()->with('message_success','Data calon siswa telah berhasil disimpan');
            }else{
                return redirect()->back()->with('message_error','Data calon siswa gagal disimpan');
            }

        }catch (Throwable $e){
            return false;
        }

    }
}
