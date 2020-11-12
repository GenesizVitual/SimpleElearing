<?php

namespace App\Http\Controllers\PPSB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\Model\PPSB\OrangTua;
class FormulirOrangTua extends Controller
{
    //
    public function index(){
        try{
            Session::put('menu','formulir_orang_tua');
            $data_user = User::findOrFail(Session::get('id_pendaftar'));
            return view('PPSB.Formulir.content', ['data'=> $data_user]);
        }catch (Throwable $e){
            return false;
        }
    }

    public function store(Request $req){
        try{
            $this->validate($req,[
                "nama_ayah"=>'required',
                "no_ktp_ayah"=>'required',
                "pendidikan_ayah"=>'required',
                "pekerjaan_ayah"=>'required',
                "alamat_ayah"=>'required',
                "desa_ayah"=>'required',
                "provinsi_ayah"=>'required',
                "kecamatan_ayah"=>'required',
                "no_hp_ayah"=>'required',
                "nama_ibu"=>'required',
                "no_ktp_ibu"=>'required',
                "pendidikan_ibu"=>'required',
                "pekerjaan_ibu"=>'required',
                "alamat_ibu"=>'required',
                "desa_ibu"=>'required',
                "provinsi_ibu"=>'required',
                "kecamatan_ibu"=>'required',
                "no_hp_ibu"=>'required',
                "total_penghasilan"=>'required',
            ]);

            $model = OrangTua::updateOrCreate(
                ['id_user'=> Session::get('id_pendaftar')],
                [
                    "nama_ayah"=>$req->nama_ayah,
                    "no_ktp_ayah"=>$req->no_ktp_ayah,
                    "pendidikan_ayah"=>$req->pendidikan_ayah,
                    "pekerjaan_ayah"=>$req->pekerjaan_ayah,
                    "alamat_ayah"=>$req->alamat_ayah,
                    "desa_ayah"=>$req->desa_ayah,
                    "provinsi_ayah"=>$req->provinsi_ayah,
                    "kecamatan_ayah"=>$req->kecamatan_ayah,
                    "no_hp_ayah"=>$req->no_hp_ayah,
                    "nama_ibu"=>$req->nama_ibu,
                    "no_ktp_ibu"=>$req->no_ktp_ibu,
                    "pendidikan_ibu"=>$req->pendidikan_ibu,
                    "pekerjaan_ibu"=>$req->pekerjaan_ibu,
                    "alamat_ibu"=>$req->alamat_ibu,
                    "desa_ibu"=>$req->desa_ibu,
                    "provinsi_ibu"=>$req->provinsi_ibu,
                    "kecamatan_ibu"=>$req->kecamatan_ibu,
                    "no_hp_ibu"=>$req->no_hp_ibu,
                    "total_penghasilan"=>$req->total_penghasilan
                ]
            );

            if($model){
                return redirect()->back()->with('message_success','Data identitas orang tua/wali telah berhasil disimpan');
            }else{
                return redirect()->back()->with('message_error','Data identitas orang tua/wali gagal disimpan');
            }
        }catch (Throwable $e){
            return false;
        }
    }
}
