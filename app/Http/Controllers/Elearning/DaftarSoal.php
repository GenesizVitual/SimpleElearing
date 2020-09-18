<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Model\DaftarSoal as tbl_soal;
use App\Model\Pilihan;
use App\Model\KunciJawaban;

class DaftarSoal extends Controller
{
    //
    public $option = ['a','b','c','d'];
    public function show($id_tema_soal)
    {
        $data_soal = tbl_soal::where('id_tema_soal',$id_tema_soal)
            ->where('id_guru', Session::get('id_guru'));
        $pangginate = $data_soal->paginate(20);
        $data= [
            'data_soal'=>$pangginate,
            'pilihan'=> $this->option,
            'id_tema_soal'=>$id_tema_soal,
            'no_urut'=> $data_soal->count('id')+1,
        ];

        return view('Elearning.DaftarSoal.content', $data);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'no_urut'=>'required',
            'id_tema_soal'=>'required',
            'soal'=>'required',
            'label'=>'required',
            'pilihan'=>'required',
            'jawaban'=>'required',
            'skor'=>'required',
            'waktu_kerja'=>'required',
        ]);



        $model = tbl_soal::updateOrCreate(
            ['id_guru'=>Session::get('id_guru'),'id_tema_soal'=>$req->id_tema_soal,'no_urut'=> $req->no_urut],
            ['soal'=>$req->soal,'waktu_kerja'=> $req->waktu_kerja]
        );

        if($model){
            foreach ($req->pilihan as $key => $text){
                $model_pilihan_soal = Pilihan::updateOrCreate(
                    ['id_daftar_soal'=> $model->id,'label'=>$req->label[$key]],
                    ['text'=>$text]
                );
            }

        }

        $model_kunci_jawaban =KunciJawaban::updateOrCreate(
            ['id_tema_soal'=>$req->id_tema_soal, 'id_daftar_soal'=>$model->id, 'no_urut'=>$req->no_urut],
            ['jawaban'=> $req->jawaban,'score'=> $req->skor]
        );

        return redirect()->back()->with('message_info','Soal No.'. $req->no_urut.' telah dibuat');
    }

}
