<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\GuruImport;
use App\Model\Guru as tbl_guru;
use Excel;

class Guru extends Controller
{
    //
    public function index()
    {
        $model = tbl_guru::orderBy('kode','asc')->paginate(50);
        return view('Elearning.Guru.content', array('data'=>$model));
    }

    public function import(Request $req)
    {
        $this->validate($req,[
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($req->hasFile('file')) {
            $file = $req->file('file'); //GET FILE
            Excel::import(new GuruImport, $file);
            return redirect()->back()->with('message_success',' Import data guru telah selesai');
        }
        return redirect()->back()->with('message_error',' Gagal, import data guru.');
    }

    public function store(Request $req){
        $this->validate($req,[
            'kode'=> 'required|unique:tbl_guru,kode',
            'password'=> 'required',
            'nama'=> 'required',
        ]);

        $model = new tbl_guru();
        $model->kode = $req->kode;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        $model->nama = $req->nama;
        if($model->save()){
            return redirect()->back()->with('message_success','Anda telah menambah data guru :'.$model->nama);
        }else{
            return redirect()->back()->with('message_error','gagal, menambah data guru');
        }
    }

    public function edit($id){
        $model = tbl_guru::select('kode','nama')->findOrFail($id);
        return response()->json($model);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'kode'=> 'required|unique:tbl_guru,kode',
            'password'=> 'required',
            'nama'=> 'required',
        ]);

        $model = tbl_guru::findOrFail($id);
        $model->kode = $req->kode;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        $model->nama = $req->nama;
        if($model->save()){
            return redirect()->back()->with('message_success','Anda telah mengubah data guru :'.$model->nama);
        }else{
            return redirect()->back()->with('message_error','gagal, mengubah data guru');
        }
    }

    public function destroy(Request $req, $id){
        $this->validate($req,[
            '_token'=> 'required',
            '_method'=> 'required',
        ]);

        $model = tbl_guru::findOrFail($id);
        if($model->delete()){
            return redirect()->back()->with('message_success','Anda telah menghapus data guru :'.$model->nama);
        }else{
            return redirect()->back()->with('message_error','gagal, menghapus data guru');
        }
    }
}
