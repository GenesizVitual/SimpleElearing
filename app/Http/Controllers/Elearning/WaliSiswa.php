<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Siswa;
use App\Model\WaliSiswa as tbl_wali;


class WaliSiswa extends Controller
{
    //
    public function index(){
        $data = [
            'siswa'=> Siswa::all(),
            'data'=> tbl_wali::all()
        ];
        return view('Elearning.wali_siswa.content', $data);
    }

    public function store(Request $req){
        $this->validate($req,[
            'nama_pengguna'=> 'required',
            'password'=> 'required',
            'id_siswa'=> 'required|unique:tbl_wali_murid,id_siswa',
        ]);

        $model = new tbl_wali();
        $model->nama_pengguna = $req->nama_pengguna;
        $model->password = $req->password;
        $model->id_siswa = $req->id_siswa;
        if($model->save()){
           return redirect()->back()->with('message_success','Anda telah menambahkan wali siswa');
        }else{
            return redirect()->back()->with('message_error','Gagal, menambahkan wali kelas');
        }
    }

    public function edit($id){
        $data = tbl_wali::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'nama_pengguna'=> 'required',
            'password'=> 'required',
            'id_siswa'=> 'required',
        ]);

        $model = tbl_wali::findOrFail($id);
        $model->nama_pengguna = $req->nama_pengguna;
        $model->password = $req->password;
        $model->id_siswa = $req->id_siswa;
        if($model->save()){
            return redirect('wali-siswa')->with('message_success','Anda telah mengubah wali siswa');
        }else{
            return redirect()->back()->with('message_error','Gagal, mengubah wali kelas');
        }
    }

    public function destroy(Request $req, $id){
        $model = tbl_wali::findOrFail($id);
        if($model->delete()){
            return redirect()->back()->with('message_success','Anda telah mengubah wali siswa');
        }else{
            return redirect()->back()->with('message_error','Gagal, mengubah wali kelas');
        }
    }
}
