<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Soal as tbl_soal;
use App\Model\SiswaUjian;
use App\Model\JawabanSiswa;
use App\Model\KunciJawaban;
use Illuminate\Support\Facades\DB;
use Session;

class Ujian extends Controller
{
    //
    private $id_daftar_soal;

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

    public function ikut_ujian(Request $req)
    {
        $this->validate($req, [
            'id_siswa' => 'required',
            'kode_siswa' => 'required',
            'token' => 'required',
        ]);

        $data_tema_ujian = tbl_soal::where('status', '1')->where('token', $req->token);
//        dd($data_tema_ujian->first());
        if($data_tema_ujian->count() <= 0){
            return redirect()->back()->with('message_info','Token ujian yang anda masukan salah atau ujian yang anda ikuti belum dimulai');
        }

        if (strcmp($data_tema_ujian->first()->jenis_kelas, 'Semua Jenis Kelas') != 0) {
            $data_tema_ujian->where('jenis_kelas', Session::get('jenis_kelas'));
        }


        if (strcmp($data_tema_ujian->first()->kelas, 'Semua Kelas') != 0) {
//                $kelas_split = explode(Session::get('kelas'), ' ');
             $data_tema_ujian->where('kelas', 'like', '%'.Session::get('kelas').'%');
        }

        $req->session()->put('id_tema_soal', $data_tema_ujian->first()->id);

        return redirect('jawaban-soal')->with('message_info','Ujian Telah dimulai, silahkan jawab sampai waktu habis');
//        return view('Elearning.Ujian.view_dokumen', $data)->with('message_info','Ujian Telah dimulai, silahkan jawab sampai waktu habis');
    }


    public function data_ujian($mdoel_tema_ujian, $id_daftar_soal=0){
        #ambil waktu total semua soal
//        dd($id_daftar_soal);

        if($mdoel_tema_ujian->status_waktu==0){
            $waktu_total_ujian = $mdoel_tema_ujian->time;
            $waktu_kerja = date('H:i:s',strtotime($waktu_total_ujian));
        }else{
            $waktu_total_ujian = DB::select('SELECT  SEC_TO_TIME( SUM( TIME_TO_SEC( waktu_kerja ) ) ) AS timeSum, SEC_TO_TIME( SUM( TIME_TO_SEC( waktu_kerja ) )/count(id) ) as waktu_rata_rata 
            FROM tbl_daftar_soal WHERE id_tema_soal='.$mdoel_tema_ujian->id);
            $waktu_kerja = date('H:i:s',strtotime($waktu_total_ujian[0]->timeSum));
        }

        $get_hour = intval(date('H', strtotime($waktu_kerja)));
        $get_minute = intval(date('i', strtotime($waktu_kerja)));

        $waktu_sekarang = date('Y-m-d H:i:s', strtotime('+'.$get_hour.' hours +'.$get_minute.' minute'));

        $model = SiswaUjian::firstOrCreate(
            ['id_tema_soal'=> $mdoel_tema_ujian->id,'id_siswa'=>Session::get('id_siswa')],
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
            'data_ujian'=>$this->suffle_soal($mdoel_tema_ujian,$model, $id_daftar_soal=$id_daftar_soal),
            'id_siswa'=> Session::get('id_siswa'),
            'id_tema_siswa'=> $mdoel_tema_ujian->id,
            'id_siswa_ujian'=> $model->id,
            'count_down_time'=>strtotime($date_format),
            'date'=> intval(date('d', strtotime($date_format))),
            'month'=> intval(date('m', strtotime($date_format))),
            'jam'=> intval(date('H', strtotime($date_format))),
            'minute'=> intval(date('i', strtotime($date_format))),
        ];

        return $data;

    }


    public function suffle_soal($model,$model_siswa_ujian, $id_daftar_soal){
        if($id_daftar_soal !=0){
            $data = $model->linkToDaftarSoal->where('id',$id_daftar_soal);
        }else{
            $data = $model->linkToDaftarSoal;
        }

        $array = [];
        foreach ($data as $data_soal){
            $row = [];
            if($model->status_waktu==1) {
                $waktu_kerja = date('H:i:s', strtotime($data_soal->waktu_kerja));
            }else{
                $waktu_kerja = date('H:i:s', strtotime($model->time));
            }
            $get_hour = intval(date('H', strtotime($waktu_kerja)));
            $get_minute = intval(date('i', strtotime($waktu_kerja)));
            $waktu_sekarang = date('Y-m-d H:i:s', strtotime('+'.$get_hour.' hours +'.$get_minute.' minute'));
//            $id_kunci_jawaban = $data_soal->linkToJawaban->linkToKunciJabawan->id_kunci_jawaban;
            $id_kunci_jawaban = $data_soal->linkToJawaban->id;
            $id_jawaban_siswa = JawabanSiswa::where('id_siswa', Session::get('id_siswa'))->where('id_kunci_jawaban',$id_kunci_jawaban)->first();

//            dd($id_jawaban_siswa);

                $row[] = $data_soal->soal;
                $row[] = $data_soal->waktu_kerja;
                $row[] = $data_soal->no_urut; //no_urut
                $row[] = $data_soal->linkToPilihan;
                $row[] = $data_soal->linkToJawaban->id; //id_kunci_jawaban
                $row[] = Session::get('id_siswa'); //id_siswa
                $row[] = $model_siswa_ujian->id; //id_ujian_siswa
                $row[] = $data_soal->id_tema_soal;
                $row[] = $model->status_lagunge;//status languange
                $row[] = $data_soal->gambar;//status languange
                $row['date']= intval(date('d', strtotime($waktu_sekarang )));
                $row['month']= intval(date('m', strtotime($waktu_sekarang )));
                $row['jam']= intval(date('H', strtotime($waktu_sekarang )));
                $row['minute']= intval(date('i', strtotime($waktu_sekarang )));

            if($id_daftar_soal !=0){
                $array[] = $row;
            }else{
                if(empty($id_jawaban_siswa)){
                    $array[] = $row;
                }
            }


        }
        $suffle_array = shuffle($array);
//            dd($array);
//        $new_array=array_rand($array, 2);
        return $array;
    }



    public function halaman_soal_ujian(){
        if(empty(Session::get('id_tema_soal'))){
            return redirect('ujian')->with('message_info','Soal belum buka');
        }
        $data_tema_ujian = tbl_soal::where('id',Session::get('id_tema_soal'))->first();
        $data = $this->data_ujian($data_tema_ujian);
        $data['data_jawaban'] = $data_tema_ujian;
        return view('Elearning.Ujian.view_dokumen', $data);
    }

    public function halaman_soal_ujian_persoal($id){
        if(empty(Session::get('id_tema_soal'))){
            return redirect('ujian')->with('message_info','Soal belum buka');
        }
        $data_tema_ujian = tbl_soal::where('id',Session::get('id_tema_soal'))->first();
        $data = $this->data_ujian($data_tema_ujian, $id);
        $data['data_jawaban'] = $data_tema_ujian;
        return view('Elearning.Ujian.view_dokumen', $data);
    }

    public function jawab_ujian(Request $req){

         $this->validate($req,[
            'id_kunci_jabawan'=>'required',
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

        return redirect('jawaban-soal')->with('message_info','Anda telah memilih jawaban '. $req->jawaban);

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
            $data_jabawan_siswa = $data->linkToKunciJabawan->where('id_kunci_jawaban',$data->id)->where('no_urut', $data->no_urut)->where('id_siswa', $req->id_siswa)->first();
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
