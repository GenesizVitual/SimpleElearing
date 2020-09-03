<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Soal as tbl_soal;
use App\Model\SiswaUjian;
use App\Model\JawabanSiswa;

class Ujian extends Controller
{
    //
    public function index(){
        $session_kode_siswa = '2020001201';
        $session_id_siswa = '1';
        $data = [
          'kode'=> $session_kode_siswa,
          'id_siswa' => $session_id_siswa
        ];
        return view('Elearning.Ujian.content', $data);
    }

    public function ikut_ujian(Request $req){
        $this->validate($req,[
            'id_siswa'=> 'required',
            'kode_siswa'=> 'required',
            'token'=> 'required',
        ]);

        $data_tema_ujian = tbl_soal::where('status','1')->where('token',$req->token);
        if($data_tema_ujian->count() <= 0){
            return redirect()->back()->with('message_info','Token ujian yang anda masukan salah atau ujian yang anda ikuti belum dimulai');
        }
        $mdoel_tema_ujian = $data_tema_ujian->first();
        $model = SiswaUjian::updateOrCreate(
            ['id_tema_soal'=> $mdoel_tema_ujian->id,'id_siswa'=>$req->id_siswa],
            ['status'=> '1']
        );

        if(empty(strtotime($model->waktu_mulai))) {
            $waktu_sekaran = strtotime($mdoel_tema_ujian->time);
        }else{
            $waktu_sekaran = strtotime($model->waktu_mulai);
        }

        $date_format = date('H:i:s', $waktu_sekaran);

        $data = [
            'data_ujian'=>$mdoel_tema_ujian,
            'id_siswa'=> $req->id_siswa,
            'id_tema_siswa'=> $mdoel_tema_ujian->id,
            'kode_siswa'=> $req->kode_siswa,
            'count_down_time'=>$waktu_sekaran,
            'jam'=> intval(date('H', strtotime($date_format))),
            'minute'=> intval(date('i', strtotime($date_format)))
        ];


        return view('Elearning.Ujian.view_dokumen', $data)->with('message_info','Ujian Telah dimulai, silahkan jawab sampai waktu habis');
    }

    public function jawab_ujian(Request $req){

        $this->validate($req,[
            'id_kunci_jabawan'=>'required',
            'id_siswa'=>'required',
            'jawaban'=>'required',
            'no_urut'=>'required',
            '_method'=>'required',
            '_token'=>'required',
        ]);

        $model = JawabanSiswa::updateOrCreate(
            ['id_kunci_jawaban'=> $req->id_kunci_jabawan,'id_siswa'=>$req->id_siswa,'no_urut'=>$req->no_urut],
            ['jawaban'=> $req->jawaban]
        );

        if($model){
            return response()->json(['status'=>'success','message'=>'Anda telah memilih jawaban:'.$req->jawaban.' di soal no:'.$req->no_urut]);
        }else{
            return response()->json(['status'=>'error','message'=>'Gagal, mengisi jawaban pastikan jaringan anda lancar']);
        }

    }

    public function updateWaktuUjian(Request $req)
    {
        $this->validate($req,[
            'id_siswa'=> 'required',
            'id_tema_soal'=> 'required',
            '_token'=> 'required',
            'time'=> 'required',
        ]);

        $model = SiswaUjian::updateOrCreate(
            ['id_tema_soal'=> $req->id_tema_soal,'id_siswa'=>$req->id_siswa],
            ['status'=> '1','waktu_mulai'=>$req->time]
        );

        return response()->json(['sisa_waktu'=>$model->waktu_mulai]);
    }

    public function updateStatusUjian(Request $req)
    {
        $this->validate($req,[
            'id_siswa'=> 'required',
            'id_tema_soal'=> 'required',
            '_token'=> 'required',
        ]);

        $model = SiswaUjian::updateOrCreate(
            ['id_tema_soal'=> $req->id_tema_soal,'id_siswa'=>$req->id_siswa],
            ['status'=> '2']
        );

        return response()->json(['status'=>'info','message'=>'Waktu Pengerjaan Soal Telah Selesai, Anda akan dialihkan ke halaman nilai']);
    }
}
