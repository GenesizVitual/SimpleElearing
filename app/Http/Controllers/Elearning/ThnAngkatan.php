<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ThnAnggaran;
class ThnAngkatan extends Controller
{
    //

    public function index(){
        $StartingDate = date('Y-m-d');  // todays date as a timestamp
        $thn_depan = date("Y-m-d", strtotime(date("Y-m-d", strtotime($StartingDate)) . " + 1 years"));
        $thn_lalu  = date("Y-m-d", strtotime(date("Y-m-d", strtotime($thn_depan)) . " - 1 years"));
        $data = [
            'thn_lalu'=>date('Y',strtotime($thn_lalu)),
            'thn_depan'=>date('Y',strtotime($thn_depan)),
            'data'=>ThnAnggaran::all()
        ];

        return view('Elearning.tahun_angkatan.content', $data);
    }

    public function store(Request $req){
       $this->validate($req,[
            'thn_lalu'=> 'required',
            'thn_depan'=> 'required',
            'status'=> 'required',
        ]);

       $model = new ThnAnggaran();
       $model->thn_lalu = $req->thn_lalu;
       $model->thn_depan = $req->thn_depan;
       $model->status = $req->status;
       if($model->save()){
           return redirect()->back()->with('message_success', 'Tahun angkatan telah ditambahkan');
       }else{
           return redirect()->back()->with('message_error', 'Tahun angkatan gagal ditambahkan');
       }
    }

    public function edit($id){
        $model = ThnAnggaran::findOrFail($id);
        return response()->json($model);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'thn_lalu'=> 'required',
            'thn_depan'=> 'required',
            'status'=> 'required',
        ]);

        $model = ThnAnggaran::findOrFail($id);
        $model->thn_lalu = $req->thn_lalu;
        $model->thn_depan = $req->thn_depan;
        $model->status = $req->status;
        if($model->save()){
            return redirect()->back()->with('message_success', 'Tahun angkatan telah diubah');
        }else{
            return redirect()->back()->with('message_error', 'Tahun angkatan gagal diubah');
        }
    }

    public function destroy(Request $req, $id){
        $model = ThnAnggaran::findOrFail($id);
        if($model->delete()){
            return redirect()->back()->with('message_success', 'Tahun angkatan telah dihapus');
        }else{
            return redirect()->back()->with('message_error', 'Tahun angkatan gagal dihapus');
        }
    }
}
