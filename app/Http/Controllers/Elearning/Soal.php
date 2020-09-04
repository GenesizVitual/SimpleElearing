<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Guru;
use App\Model\Siswa;
use App\Model\Soal as tbl_soal;
use App\Model\FileSoal;
use App\Model\KunciJawaban;

class Soal extends Controller
{
    //
    public function index()
    {
        $group_kelas = Siswa::all()->groupBy('kelas');
        $group_jenis_kelas = Siswa::all()->groupBy('jenis_kelas');
        $data=[
            'guru'=> Guru::all(),
            'group_jenis_kelas'=> $group_jenis_kelas,
            'group_kelas'=> $group_kelas,
            'data'=> tbl_soal::all()
        ];
        return view('ELearning.Soal.content', $data);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            '_token'=>'required',
            '_method'=>'required',
            'id_guru'=>'required',
            'judul_soal'=>'required',
            'jenis_kelas'=>'required',
            'kelas'=>'required',
        ]);


        $nreq = $req->except(['_token','_method']);
        $uniqid = $this->unique_code(5);
        $nreq['token'] = $uniqid;
        $model =new tbl_soal($nreq);
        if($model->save()){
            return redirect()->back()->with('message_success','Anda telah membuat tema soal dengan nama :'.$model->judul_soal);
        }else{
            return redirect()->back()->with('message_error','Gagal, membuat tema soal baru');
        }
    }

    public function edit($id){
        $model = tbl_soal::findOrFail($id);
        return response()->json($model);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
            '_token'=>'required',
            '_method'=>'required',
            'id_guru'=>'required',
            'judul_soal'=>'required',
            'jenis_kelas'=>'required',
            'kelas'=>'required',
            'time'=>'required',
        ]);


        $model =tbl_soal::findOrFail($id);
        $model->id_guru = $req->id_guru;
        $model->judul_soal = $req->judul_soal;
        $model->jenis_kelas = $req->jenis_kelas;
        $model->kelas = $req->kelas;
        $model->time = $req->time;
        if($model->save()){
            return redirect()->back()->with('message_success','Anda telah mengubah item tema soal dengan nama :'.$model->judul_soal);
        }else{
            return redirect()->back()->with('message_error','Gagal, mengubah tema soal baru');
        }
    }

    public function status(Request $req)
    {
        $this->validate($req,[
            '_token'=>'required',
            '_method'=>'required',
            'id'=>'required',
        ]);
        $model =tbl_soal::findOrFail($req->id);
        if($model->status == 1){
            $model->status = '0';
        }else{
            $model->status = '1';
        }
        if($model->save()){
            return response()->json(array('status'=>'success','message'=>'Anda telah mengubah status :'.$model->judul_soal));
        }else{
            return response()->json(array('status'=>'error','message'=>'Gagal, menghapus data'));
        }

    }

    public function destroy(Request $req, $id){
        $this->validate($req,[
            '_token'=>'required',
            '_method'=>'required',
            'id'=>'required',
        ]);

        $model =tbl_soal::findOrFail($req->id);
        if($model->delete()){
            return response()->json(array('status'=>'success','message'=>'Anda telah menghapus soal dengan nama :'.$model->judul_soal));
        }else{
            return response()->json(array('status'=>'error','message'=>'Gagal, menghapus data'));
        }
    }

    function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }


    public function hasil_ujian($id)
    {
        $model =tbl_soal::findOrFail($id);
        $row = array();
        $no =1;

        if(!empty($data=$model->linkToSiswaUjian)) {
            foreach ($data as $data_siswa){
                $colum = array();
                $colum['no'] = $no++;
                $colum['nama'] = $data_siswa->linkToSiswa->nama;
                $colum['kode'] = $data_siswa->linkToSiswa->kode;
                $colum['kelas'] = $data_siswa->linkToSiswa->kelas;
                $colum['jenis_kelas'] = $data_siswa->linkToSiswa->jenis_kelas;
                $colum['hasil'] = $this->nilai_ujian($data_siswa->linkToSiswa->id, $data_siswa->id_tema_soal);
                $row[] = $colum;
            }
        }

        $data =[
            'data_ujian'=> $row,
            'soal'=> $model
        ];

        return view('Elearning.report.hasil_ujian', $data);
    }

    public function upload(Request $req){
        $this->validate($req,[
            'id_tema_soal'=>'required',
            'file'=>'required'
        ]);
        $file = str_replace('view','preview',$req->file);

        $nmodel = FileSoal::updateOrCreate(
            ['id_tema_soal'=>$req->id_tema_soal],['nama_file'=>$file]
        );

        if($nmodel){
            return redirect()->back()->with('message_success', 'File Soal Berhasil Upload');
        }

    }

    public function view_documen($id){
        $model = tbl_soal::findOrFail($id);
        $url_file = public_path('file/').$model->linkToFileSoal->nama_file;
        return view('Elearning.Soal.view_dokumen', array('data'=> $model,'url'=>$url_file));
    }

    public function nilai_ujian($id_siswa,$id_tema_soal){

        $model = KunciJawaban::all()->where('id_tema_soal',$id_tema_soal)->sortBy('no_urut');
        $row = array();
        $jawaban_benar=0;
        $jawaban_score=0;
        $jawaban_salah=0;
        foreach ($model as $data){
            $data_jabawan_siswa = $data->linkToKunciJabawan->where('id_siswa', $id_siswa)->first();
            if($data_jabawan_siswa->jawaban == $data->jawaban){
                $jawaban_score +=  $data->score;
                $jawaban_benar +=  1;
            }else{
                $jawaban_salah += 1;
            }
        }

        $data = [
            'jawaban_benar'=> $jawaban_benar,
            'jawaban_salah'=> $jawaban_salah,
            'jawaban_score'=> ($jawaban_score*$jawaban_benar)/$model->count(),
        ];

        return $data;
    }
}
