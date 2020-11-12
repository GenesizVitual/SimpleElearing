<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\MataPelajaran as tbl_mata_pelajaran;
class MataPelajaran extends Controller
{
    //
    public function index()
    {
        $data = [
            'data'=> tbl_mata_pelajaran::all()
        ];
        return view('Elearning.mata_pelajaran.content', $data);
    }

    public function store(Request $req){
        $this->validate($req,[
            'mata_pelajaran'=> 'required'
        ]);

        $model = new tbl_mata_pelajaran();
        $model->mata_pelajaran = $req->mata_pelajaran;

        if($model->save()){
            return redirect()->back()->with('message_success', 'Mata Pelajaran telah ditambahkan');
        }else{
            return redirect()->back()->with('message_error', 'Mata Pelajaran telah ditambahkan');
        }
    }

    public function edit($id){
        $model = tbl_mata_pelajaran::findOrFail($id);
        return response()->json($model);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'mata_pelajaran'=> 'required'
        ]);

        $model = tbl_mata_pelajaran::findOrFail($id);
        $model->mata_pelajaran = $req->mata_pelajaran;

        if($model->save()){
            return redirect()->back()->with('message_success', 'Mata Pelajaran telah diubah');
        }else{
            return redirect()->back()->with('message_error', 'Mata Pelajaran telah diubah');
        }
    }

    public function destroy(Request $req, $id){
        $model = tbl_mata_pelajaran::findOrFail($id);
        if($model->delete()){
            return redirect()->back()->with('message_success', 'Mata Pelajaran telah dihapus');
        }else{
            return redirect()->back()->with('message_error', 'Mata Pelajaran telah dihapus');
        }
    }
}
