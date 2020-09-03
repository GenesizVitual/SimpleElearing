<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\KunciJawaban as tbl_kunci_jabawan;
class KunciJawaban extends Controller
{
    //
    public $option = ['a','b','c','d','e'];

    public function show($id){
        $data = [
            'id_tema_soal'=> $id,
            'tbl_kunci_jawaban'=> tbl_kunci_jabawan::all()->where('id_tema_soal',$id),
            'banyak_soal'=>0,
            'option'=>$this->option
        ];
        return view('Elearning.KunciJawaban.content', $data);
    }


    public function create(Request $req)
    {
        $this->validate($req,[
            'banyak_soal'=> 'required',
            'id_tema_soal'=> 'required',
        ]);
        $data=array('banyak_soal'=> $req->banyak_soal,
            'id_tema_soal'=>$req->id_tema_soal,
            'tbl_kunci_jawaban'=> tbl_kunci_jabawan::all()->where('id_tema_soal',$req->id_tema_soal),
            'option'=> $this->option);
        return view('Elearning.KunciJawaban.content',$data);
    }

    public function store(Request $req){
        $this->validate($req,[
            'id_kunci_jawaban'=> 'required',
        ]);
//        dd($req->all());
        foreach ($req->no_urut as $index=>$no_urut){
            $model = tbl_kunci_jabawan::updateOrCreate(
                ['id_tema_soal'=> $req->id_kunci_jawaban,'no_urut'=> $no_urut],
                ['jawaban'=> $req->input('kunci_jabawan_'.$no_urut),'score'=>$req->skor_jabawan[$index]]
            );
        }
        return redirect('kunci-jawaban/'.$req->id_kunci_jawaban)->with('message_info','Kunci Jabawan telah dibuat');
    }
}
