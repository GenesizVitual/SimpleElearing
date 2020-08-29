<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Excel;
use App\Model\Siswa as tbl_siswa;

class Siswa extends Controller
{
    //

    public function index(){
        $data = tbl_siswa::all();
        $array = [
            'data'=> $data,
        ];
        return view('Elearning.Siswa.content', $array);
    }

    public function edit($id){
        $model = tbl_siswa::select('kode','nama','kelas','jenis_kelas','angkatan')->findOrFail($id);
        return response()->json($model);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
           'angkatan'=> 'required',
           'kode'=> 'required|unique:tbl_siswa,kode',
           'password'=> 'required',
           'nama'=> 'required',
           'kelas'=> 'required',
           'jenis_kelas'=> 'required',
        ]);

        $model = tbl_siswa::findOrFail($id);
        $model->angkatan = $req->angkatan;
        $model->kode = $req->kode;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        $model->nama = $req->nama;
        $model->kelas = $req->kelas;
        $model->jenis_kelas = $req->jenis_kelas;
        if($model->save()){
            return redirect()->back()->with('message_success','Anda telah mengubah data siswa :'.$model->nama);
        }else{
            return redirect()->back()->with('message_error','gagal, mengubah data siswa');
        }
    }

    public function destroy(Request $req, $id)
    {
        $this->validate($req,[
             '_token'=> 'required',
        ]);

        $model = tbl_siswa::findOrFail($id);
        if($model->delete()){
            return redirect()->back()->with('message_success','Anda telah menghapus data siswa :'.$model->nama);
        }else{
            return redirect()->back()->with('message_error','gagal, menghapus data siswa');
        }
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $req)
    {
        $this->validate($req,[
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($req->hasFile('file')) {
            $file = $req->file('file'); //GET FILE
            Excel::import(new SiswaImport, $file);
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
