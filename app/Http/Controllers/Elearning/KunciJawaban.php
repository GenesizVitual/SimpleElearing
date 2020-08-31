<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\KunciJawaban as tbl_kunci_jabawan;
class KunciJawaban extends Controller
{
    //
    public $option = ['a','b','c','d','e'];

    public function create(Request $req)
    {
        $this->validate($req,[
            'banyak_soal'=> 'required',
            'id_tema_soal'=> 'required',
        ]);
        return view('Elearning.KunciJawaban.content',
            array('banyak_soal'=> $req->banyak_soal,'id_tema_soal'=>$req->id_tema_soal,'option'=> $this->option)
        );
    }

    public function store(Request $req){
        $this->validate($req,[
            'id_kunci_jawaban'=> 'required',
        ]);

        foreach ($req->no_urut as $index=>$no_urut){
            $model = tbl_kunci_jabawan::updateOrCreate(
                ['id_tema_soal'=> $req->id_kunci_jawaban,'no_urut'=> $no_urut],
                ['jawaban'=> $req->kunci_jabawan.'_'.$index,'score'=>$req->skor_jabawan[$index]]
            );
        }
        return redirect()->back()->with('message_info','Kunci Jabawan telah dibuat');
    }
}
