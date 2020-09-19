<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Soal as tbl_soal;
use App\Model\SiswaUjian;
use App\Model\JawabanSiswa;
use App\Model\KunciJawaban;
use Session;

class Ujian extends Controller
{
    //
    public function index(){
        $session_kode_siswa = Session::get('kode');
        $session_id_siswa = Session::get('id_siswa');
        $data = [
          'kode'=> $session_kode_siswa,
          'id_siswa' => $session_id_siswa
        ];
        return view('Elearning.Ujian.content', $data);
    }

//    public function ikut_ujian_lama(Request $req){
//        $this->validate($req,[
//            'id_siswa'=> 'required',
//            'kode_siswa'=> 'required',
//            'token'=> 'required',
//        ]);
//
//        $data_tema_ujian = tbl_soal::where('status','1')->where('kelas', Session::get('kelas'))->where('jenis_kelas', Session::get('jenis_kelas'))->where('token',$req->token);
//        if($data_tema_ujian->count() <= 0){
//            return redirect()->back()->with('message_info','Token ujian yang anda masukan salah atau ujian yang anda ikuti belum dimulai');
//        }
//        $mdoel_tema_ujian = $data_tema_ujian->first();
//        #ambil waktu total semua soal
//
//        $waktu_kerja = date('H:i:s',strtotime($mdoel_tema_ujian->time));
//        $get_hour = intval(date('H', strtotime($waktu_kerja)));
//        $get_minute = intval(date('i', strtotime($waktu_kerja)));
//        $waktu_sekarang = date('Y-m-d H:i:s', strtotime('+'.$get_hour.' hours +'.$get_minute.' minute'));
//
//        $model = SiswaUjian::firstOrCreate(
//            ['id_tema_soal'=> $mdoel_tema_ujian->id,'id_siswa'=>$req->id_siswa],
//            ['status'=> '1', 'waktu_mulai'=>date('Y-m-d H:i:s', strtotime($waktu_sekarang))]
//        );
//
//
//        if($model->status==1){
//            $date_format = date('Y/m/d H:i:s', strtotime($model->waktu_mulai));
//        }else{
//            $date_format = date('Y/m/d H:i:s');
//        }
//
//        if($model->status ==2){
//            $date_format = date('Y/m/d H:i:s');
//        }
//
//        $data = [
//            'data_ujian'=>$mdoel_tema_ujian,
//            'id_siswa'=> $req->id_siswa,
//            'id_tema_siswa'=> $mdoel_tema_ujian->id,
//            'id_siswa_ujian'=> $model->id,
//            'kode_siswa'=> $req->kode_siswa,
//            'count_down_time'=>strtotime($date_format),
//            'date'=> intval(date('d', strtotime($date_format))),
//            'month'=> intval(date('m', strtotime($date_format))),
//            'jam'=> intval(date('H', strtotime($date_format))),
//            'minute'=> intval(date('i', strtotime($date_format))),
//        ];
//
//
//        return view('Elearning.Ujian.view_dokumen', $data)->with('message_info','Ujian Telah dimulai, silahkan jawab sampai waktu habis');
//    }

    public function ikut_ujian(Request $req){
        $this->validate($req,[
            'id_siswa'=> 'required',
            'kode_siswa'=> 'required',
            'token'=> 'required',
        ]);

        $data_tema_ujian = tbl_soal::where('status','1')->where('kelas', Session::get('kelas'))->where('jenis_kelas', Session::get('jenis_kelas'))->where('token',$req->token);
        if($data_tema_ujian->count() <= 0){
            return redirect()->back()->with('message_info','Token ujian yang anda masukan salah atau ujian yang anda ikuti belum dimulai');
        }
        $mdoel_tema_ujian = $data_tema_ujian->first();
        #ambil waktu total semua soal

        $waktu_sekarang = date('Y-m-d H:i:s');

        $model = SiswaUjian::firstOrCreate(
            ['id_tema_soal'=> $mdoel_tema_ujian->id,'id_siswa'=>$req->id_siswa],
            ['status'=> '1', 'waktu_mulai'=>date('Y-m-d H:i:s', strtotime($waktu_sekarang))]
        );


        if($model->status==1){
            $date_format = date('Y/m/d H:i:s', strtotime($model->waktu_mulai));
        }else{
            $date_format = date('Y/m/d H:i:s');
        }

        if($model->status ==2){
            $date_format = date('Y/m/d H:i:s');
        }


        $data = [
            'data_ujian'=>$this->suffle_soal($mdoel_tema_ujian),
            'id_siswa'=> $req->id_siswa,
            'id_tema_siswa'=> $mdoel_tema_ujian->id,
            'id_siswa_ujian'=> $model->id,
            'kode_siswa'=> $req->kode_siswa,
            'count_down_time'=>strtotime($date_format),
            'date'=> intval(date('d', strtotime($date_format))),
            'month'=> intval(date('m', strtotime($date_format))),
            'jam'=> intval(date('H', strtotime($date_format))),
            'minute'=> intval(date('i', strtotime($date_format))),
        ];

        return view('Elearning.Ujian.view_dokumen', $data)->with('message_info','Ujian Telah dimulai, silahkan jawab sampai waktu habis');
    }

    public function suffle_soal($model){
        $data = $model->linkToDaftarSoal;
        $array = [];
        foreach ($data as $data_soal){
            $row = [];
            if(empty($data_soal->linkToJawaban->linkToKunciJabawan)){
                $row[] = $data_soal->soal;
                $row[] = $data_soal->waktu_kerja;
                $row[] = $data_soal->no_urut;
                $row[] = $data_soal->linkToPilihan;
                $array[] = $row;
            }
        }
        $suffle_array = shuffle($array);
//        $new_array=array_rand($array, 2);
        return $array;
    }


    public function jawab_ujian(Request $req){

        $this->validate($req,[
            'id_kunci_jabawan'=>'required',
            'id_siswa'=>'required',
            'jawaban'=>'required',
            'id_ujian'=>'required',
            'no_urut'=>'required',
            '_method'=>'required',
            '_token'=>'required',
        ]);

        $model = JawabanSiswa::updateOrCreate(
            ['id_kunci_jawaban'=> $req->id_kunci_jabawan,'id_siswa_ujian'=>$req->id_ujian,'id_siswa'=>$req->id_siswa,'no_urut'=>$req->no_urut],
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

        return response()->json(['status'=>'info','message'=>'Waktu Pengerjaan Soal Telah Selesai, Anda akan dialihkan ke halaman nilai','status_button'=>$model->status]);
    }


    public function nilai_ujian(Request $req){
        $this->validate($req,[
            'id_siswa'=> 'required',
            'id_tema_soal'=> 'required',
            '_token'=> 'required',
        ]);

        $model = KunciJawaban::all()->where('id_tema_soal',$req->id_tema_soal)->sortBy('no_urut');
        $row = array();
        $jawaban_benar_score=0;
        $jawaban_benar=0;
        $jawaban_score=0;
        $jawaban_salah=0;

        $total_score = 0;

        foreach ($model as $data){
            $data_jabawan_siswa = $data->linkToKunciJabawan->where('no_urut', $data->no_urut)->where('id_siswa', $req->id_siswa)->first();
            if($data_jabawan_siswa->jawaban == $data->jawaban){
                $jawaban_score +=  $data->score;
                $jawaban_benar_score +=  $data->score;
                $jawaban_benar +=  1;
                $total_score += $data->score;
            }else{
                $jawaban_salah += 1;
                $total_score += $data->score;
            }
        }

        $data = [
            'jawaban_benar'=> $jawaban_benar,
            'jawaban_salah'=> $jawaban_salah,
            'jawaban_score'=> abs($jawaban_benar_score),
        ];

        return response()->json($data);
    }

}
