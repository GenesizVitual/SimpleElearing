<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Excel;
use App\Model\Siswa as tbl_siswa;
use App\Model\SiswaUjian as siswa_ujian;
use App\Model\Soal as tbl_soal;
use App\Model\KunciJawaban;
use Illuminate\Support\Facades\DB;
use Session;


class Siswa extends Controller
{
    //

    public function index(){
        $data = tbl_siswa::all();
        $data_yg_sama = DB::select('select * from(SELECT COUNT(kode) as count_code, kode FROM tbl_siswa WHERE kode GROUP by kode  
) as d where d.count_code> 1');
        $array = [
            'data'=> $data,
            'data_yg_sama'=>$data_yg_sama
        ];
        return view('Elearning.Siswa.content', $array);
    }

    public function edit($id){
        $model = tbl_siswa::select('kode','nama','kelas','jenis_kelas','label_kelas','angkatan')->findOrFail($id);
        return response()->json($model);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'angkatan'=> 'required',
            'kode'=> 'required|unique:tbl_siswa,kode',
            'password'=> 'required',
            'nama'=> 'required',
            'kelas'=> 'required',
            'jenis_kelas'=> 'required',
            'label_kelas'=> 'required',
        ]);

        $model =new tbl_siswa();
        $model->angkatan = $req->angkatan;
        $model->kode = $req->kode;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        $model->nama = $req->nama;
        $model->kelas = $req->kelas;
        $model->label_kelas = $req->label_kelas;
        $model->jenis_kelas = $req->jenis_kelas;
        if($model->save()){
            return redirect()->back()->with('message_success','Anda telah menambah data siswa :'.$model->nama);
        }else{
            return redirect()->back()->with('message_error','gagal, menambah data siswa');
        }
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
           'label_kelas'=> 'required',
        ]);

        $model = tbl_siswa::findOrFail($id);
        $model->angkatan = $req->angkatan;
        $model->kode = $req->kode;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        $model->nama = $req->nama;
        $model->kelas = $req->kelas;
        $model->label_kelas = $req->label_kelas;
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
            return redirect()->back()->with('message_success',' Anda telah menghapus data siswa :'.$model->nama);
        }else{
            return redirect()->back()->with('message_error',' gagal, menghapus data siswa');
        }
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function lihat_siswa(){
        $data = $this->hasil_ujian(Session::get('id_wali_murid'));
        $murid = tbl_siswa::findOrfail(Session::get('id_wali_murid'));
        return view('Elearning.report.hasil_ujian_siswa',['data_ujian'=> $data,'data_siswa'=>$murid]);
    }

    public function wali_cetak_ujian(){
        $data = $this->hasil_ujian(Session::get('id_wali_murid'));
        $murid = tbl_siswa::findOrfail(Session::get('id_wali_murid'));
        return view('Elearning.report.cetak_hasil_ujian_siswa',['data_ujian'=> $data,'data_siswa'=>$murid]);
    }


    public function laporan_ujian(){
        $data = $this->hasil_ujian(Session::get('id_siswa'));
        return view('Elearning.report.hasil_ujian_siswa',['data_ujian'=> $data]);
    }

    public function cetak_ujian(){
        $data = $this->hasil_ujian(Session::get('id_siswa'));
        return view('Elearning.report.cetak_hasil_ujian_siswa',['data_ujian'=> $data]);
    }

    public function hasil_ujian($id_siswa){
        $data_siswa_ujian = siswa_ujian::all()->where('id_siswa', $id_siswa);
        $row = [];
        foreach ($data_siswa_ujian as $data_tema_soal){
            $row[] = $this->data_hasil_ujian($data_tema_soal->id_tema_soal);
        }
        return $row;
    }

    public function data_hasil_ujian($id){
        if(!empty(Session::get('id_guru'))){
            $model =tbl_soal::where('id_guru', Session::get('id_guru'))->findOrFail($id);
        }else{
            $model =tbl_soal::findOrFail($id);
        }
        $row = array();
        $no =1;

        if(!empty(Session::get('id_siswa'))){
            $data=$model->linkToSiswaUjian->where('id_siswa', Session::get('id_siswa'))->sortBy('waktu_mulai') ;
        }else{
            $data=$model->linkToSiswaUjian->sortBy('waktu_mulai') ;
        }

        if(!empty($data)) {
            foreach ($data as $data_siswa){
                $colum = array();
                $colum['no'] = $no++;
                $colum['mata_pejaharan'] = $model->judul_soal;
                $colum['nama'] = $data_siswa->linkToSiswa->nama;
                $colum['kode'] = $data_siswa->linkToSiswa->kode;
                $colum['tgl_ujian'] = date('d-m-Y H:i:s', strtotime($model->linkOneToSiswaUjian->waktu_mulai));
                $colum['kelas'] = $data_siswa->linkToSiswa->kelas;
                $colum['jenis_kelas'] = $data_siswa->linkToSiswa->jenis_kelas;
                $hasil = $this->nilai_ujian($data_siswa->linkToSiswa->id, $data_siswa->id_tema_soal);
                $colum['jawaban_benar'] = $hasil['jawaban_benar'];
                $colum['jawaban_salah'] = $hasil['jawaban_salah'];
                $colum['jawaban_score'] = $hasil['jawaban_score'];
                $colum['id_ujian_siswa'] = $data_siswa->id;
                $row[] = $colum;
            }
        }

        return $row;
    }

    public function nilai_ujian($id_siswa,$id_tema_soal){
        $model = KunciJawaban::all()->where('id_tema_soal',$id_tema_soal)->sortBy('no_urut');
        $row = array();
        $jawaban_benar_score=0;
        $jawaban_benar=0;
        $jawaban_score=0;
        $jawaban_salah=0;

        $total_score = 0;

        foreach ($model as $data){
            if(!empty($data->linkToKunciJabawan)){
                $data_jabawan_siswa = $data->linkToKunciJabawan->where('id_kunci_jawaban',$data->id)->where('no_urut', $data->no_urut)->where('id_siswa', $id_siswa)->first();
                if(!empty($data_jabawan_siswa)){
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
            }
        }

        $data = [
            'jawaban_benar'=> $jawaban_benar,
            'jawaban_salah'=> $jawaban_salah,
            'jawaban_score'=> abs($jawaban_benar_score),
        ];


        return $data;
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
            return redirect()->back()->with('message_success',' Import data siswa telah selesai');
        }


        return redirect()->back()->with('message_error',' Gagal,mengimport data siswa');
    }
}
