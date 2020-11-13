<?php

namespace App\Http\Controllers\PPSB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\Model\PPSB\Berkas;
use File;
use App\Model\PPSB\UploadBerkas as model_upload_berkas;


class UploadBerkas extends Controller
{
    //
    public function index(){
        try{
            Session::put('menu','upload_berkas');
            $data_user = User::findOrFail(Session::get('id_pendaftar'));
            $data_berkas = Berkas::all();
            return view('PPSB.Formulir.content', ['data'=> $data_user, 'berkas'=>$data_berkas]);
        }catch (Throwable $e){
            return false;
        }
    }

    public function store(Request $req){

        $this->validate($req,[
            'id_berkas'=> 'required',
            'berkas'=> 'required|max:50000|mimes:pdf,jpg,jpeg,png',
        ]);

        $file = $req->berkas;
        $model_pendaftar = User::findOrFail(Session::get('id_pendaftar'));
        $directory = public_path('berkas').'/'.$model_pendaftar->username.'-'.$model_pendaftar->id;

        if(!file_exists($directory))
        {
            File::makeDirectory($directory, 0777, true, true);
        }


        $model = model_upload_berkas::where('id_user', Session::get('id_pendaftar'))->where('id_berkas', $req->id_berkas)->first();
        $uniqueFileName = uniqid() .'-'. $file->getClientOriginalName();

        if(empty($model)){

            $model_upload = model_upload_berkas::updateOrCreate(
                ['id_user'=>Session::get('id_pendaftar'), 'id_berkas'=>$req->id_berkas],
                [
                    'nama_file'=>$uniqueFileName
                ]
            );

            if($model_upload){
                $file->move($directory,$uniqueFileName);
                return redirect()->back()->with('message_success', 'Upload berhasil diupload');
            }
        }else{

            if(file_exists($directory.'/'.$model->nama_file)){
                unlink($directory.'/'.$model->nama_file);
            }

            $model_upload = model_upload_berkas::updateOrCreate(
                ['id_user'=>Session::get('id_pendaftar'), 'id_berkas'=>$req->id_berkas],
                [
                    'nama_file'=>$uniqueFileName
                ]
            );

            if($model_upload){
                $file->move($directory,$uniqueFileName);
                return redirect()->back()->with('message_success', 'Upload berhasil diupload');
            }

        }

    }
}
