<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Guru;
use App\Model\Siswa;
use App\Model\Soal as tbl_soal;
use App\Model\FileSoal;
use App\Model\KunciJawaban;
use App\Model\SiswaUjian;
use App\Model\ThnAnggaran;
use App\Model\MataPelajaran;
use App\Http\Controllers\Elearning\data\DataAverageTest;
use App\Http\Controllers\Elearning\data\PerkembanganNilaiRerataKelas;
use Session;

class Soal extends Controller
{
    //

    public function index()
    {
        $group_kelas = Siswa::all()->groupBy('kelas');
        $group_jenis_kelas = Siswa::all()->groupBy('jenis_kelas');
        if(!empty(Session::get('id_guru'))){
            $soal=tbl_soal::all()->where('id_guru', Session::get('id_guru'))->sortByDesc('created_at');
            $guru = Guru::all()->where('id',Session::get('id_guru'));
        }else{
            $soal=tbl_soal::all()->sortByDesc('created_at');;
            $guru = Guru::all();
        }
        $data=[
            'guru'=> $guru,
            'group_jenis_kelas'=> $group_jenis_kelas,
            'group_kelas'=> $group_kelas,
            'thn_angkatan'=>ThnAnggaran::all()->where('status','1'),
            'mata_pelajaran'=>MataPelajaran::all(),
            'data'=>$soal
        ];
        return view('Elearning.Soal.content', $data);
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
            'status_lagunge'=>'required',
            'status_waktu'=>'required',
            'id_thn_angkatan'=>'required',
            'semester'=>'required',
            'id_mata_pelajaran'=>'required',
        ]);

        $jam=0;
        $menit=0;
        if(!empty($req->jam)){
            $jam = $req->jam;
        }

        if(!empty($req->menit)){
            $menit = $req->menit;
        }

        $time = $jam.':'.$menit.':00';
        $nreq = $req->except(['_token','_method']);
        $uniqid = $this->unique_code(5);
        $nreq['token'] = $uniqid;
        $nreq['time'] = $time;
        $model =new tbl_soal($nreq);
        if($model->save()){
            return redirect()->back()->with('message_success','Anda telah membuat tema soal dengan nama :'.$model->judul_soal);
        }else{
            return redirect()->back()->with('message_error','Gagal, membuat tema soal baru');
        }
    }

    public function edit($id){
        $model = tbl_soal::where('id_guru', Session::get('id_guru'))->findOrFail($id);
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
            'status_lagunge'=>'required',
            'status_waktu'=>'required',
            'id_thn_angkatan'=>'required',
            'semester'=>'required',
            'id_mata_pelajaran'=>'required',
        ]);

        $jam=0;
        $menit=0;
        if(!empty($req->jam)){
            $jam = $req->jam;
        }

        if(!empty($req->menit)){
            $menit = $req->menit;
        }

        $model =tbl_soal::where('id_guru', Session::get('id_guru'))->findOrFail($id);
        $model->id_guru = $req->id_guru;
        $model->judul_soal = $req->judul_soal;
        $model->jenis_kelas = $req->jenis_kelas;
        $model->kelas = $req->kelas;
        $model->status_lagunge = $req->status_lagunge;
        $model->status_waktu = $req->status_waktu;
        $model->id_thn_angkatan = $req->id_thn_angkatan;
        $model->semester = $req->semester;
        $model->id_mata_pelajaran = $req->id_mata_pelajaran;

        if($req->status_waktu==0){
            $time = $jam.':'.$menit.':00';
            $model->time =$time;
        }else{
            $model->time = '00:00';
        }
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
        $model =tbl_soal::where('id_guru', Session::get('id_guru'))->findOrFail($req->id);

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

        $model =tbl_soal::where('id_guru', Session::get('id_guru'))->findOrFail($req->id);
        if($model->delete()){
            return response()->json(array('status'=>'success','message'=>'Anda telah menghapus soal dengan nama :'.$model->judul_soal));
        }else{
            return response()->json(array('status'=>'error','message'=>'Gagal, menghapus data'));
        }
    }

    //================================== Batas Soal ====================================================================
    function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public function hasil_ujian($id)
    {
        $data = $this->data_hasil_ujian($id);
        return view('Elearning.report.hasil_ujian',$data);
    }

    public function hasil_ujian_by_kelas($id)
    {
        $data = $this->data_hasil_ujian($id);
        $data['data_ujian']=$this->group_by("label", $data['data_ujian']);
        ksort($data['data_ujian']);
//        dd($data);
        return view('Elearning.report.hasil_ujian_by_kelas',$data);
    }

    public function cetak_hasil_ujian_by_kelas($id)
    {
        $data = $this->data_hasil_ujian($id);
        $data['data_ujian']=$this->group_by("label", $data['data_ujian']);
        ksort($data['data_ujian']);
//        dd($data);
        return view('Elearning.report.cetak_hasil_ujian_by_kelas',$data);
    }

    public function halaman_monitoring_ujian($id)
    {
        $data =[
            'id_tema_soal'=> $id
        ];
        return view('Elearning.report.monitoring_hasil_ujian', $data);
    }

    public function halaman_monitoring_semua_ujian()
    {
        return view('Elearning.report.monitoring_semua_hasil_ujian');
    }

    public function data_hasil_ujian_api(Request $req)
    {
        $this->validate($req,[
            'id_tema_soal'=>'required',
            '_token'=> 'required'
        ]);
        $id = $req->id_tema_soal;
        $data = $this->data_hasil_ujian($id);
        return response()->json($data);
    }


    public function data_semua_hasil_ujian(Request $request){
        $this->validate($request,[
            '_token'=> 'required'
        ]);

        $array=array();
        $model = tbl_soal::all()->where('status',1);
        foreach ($model as $data){
            $array[] = $this->data_hasil_ujian($data->id)['data_ujian'];
        }
        return response()->json(array('data_ujian'=>$array));
    }

    public function compareByScore($a, $b) {
        return $b["jawaban_score"]-$a["jawaban_score"];
    }

    public function data_hasil_ujian($id){
        if(!empty(Session::get('id_guru'))){
            $model =tbl_soal::where('id_guru', Session::get('id_guru'))->findOrFail($id);
        }else{
            $model =tbl_soal::findOrFail($id);
        }

        $data = $this->kolom_nilai_ujian($model);
        $data['id_soal']= $id;

        return $data;
    }

    public function cetak_hasil_ujian($id)
    {
        $model =tbl_soal::where('id_guru', Session::get('id_guru'))->findOrFail($id);
        $data = $this->kolom_nilai_ujian($model);
        $data['id_soal'] = $id;
        return view('Elearning.report.cetak_hasil_ujian', $data);
    }

    private function kolom_nilai_ujian($model, $kelas=null, $label=null){
        $no=1;
        $row = array();
        if(!empty($data=$model->linkToSiswaUjian)) {
            foreach ($data as $data_siswa){
                $colum = array();
                $colum['no'] = $no++;
                $colum['tgl_ujian'] = date('d-m-Y H:i:s', strtotime($model->linkOneToSiswaUjian->waktu_mulai));

                $colum['nama'] = $data_siswa->linkToSiswa->nama;
                $colum['kode'] = $data_siswa->linkToSiswa->kode;
                $colum['kelas'] = $data_siswa->linkToSiswa->kelas;
                $colum['label'] = $data_siswa->linkToSiswa->label_kelas;
                $colum['jenis_kelas'] = $data_siswa->linkToSiswa->jenis_kelas;
                $hasil =$this->nilai_ujian($data_siswa->linkToSiswa->id, $data_siswa->id_tema_soal);
                $colum['hasil'] = $hasil;
                $colum['jawaban_benar'] = $hasil['jawaban_benar'];
                $colum['jawaban_salah'] = $hasil['jawaban_salah'];
                $colum['jawaban_score'] = $hasil['jawaban_score'];
                $colum['id_ujian_siswa'] = $data_siswa->id;
                $row[] = $colum;
            }
        }
        if(!empty($row)){
            usort($row, array("App\Http\Controllers\Elearning\Soal", "compareByScore"));
        }
        $data =[
            'data_ujian'=> $row,
            'soal'=> $model,
            'data_soal' =>$model
        ];
        return $data;
    }

    public function halaman_detail_ujian($id_siswa_ujian){
        $model = $this->data_detail_ujian($id_siswa_ujian);
        return view('Elearning.report.detail_hasil_ujian', $model);
    }

    public function cetak_detail_ujian($id_siswa_ujian){
        $model = $this->data_detail_ujian($id_siswa_ujian);
        return view('Elearning.report.cetak_detail_hasil_ujian', $model);
    }

    public function data_detail_ujian($id_siswa_ujian)
    {
        $model = SiswaUjian::findOrFail($id_siswa_ujian);
        $cek_tema_soal = $model->linkToTemaSoal;
        $data_siswa = $model->linkToSiswa;
        $row=[];
        if($cek_tema_soal->id_guru == Session::get('id_guru')){
            #cek jawaban siswa
            $model_ujian_siswa = $model->linkToJawabanSiswa->sortBy('no_urut');
            $no_urut = 1;
            $total_skor = 0;

            foreach ($model_ujian_siswa as $data_jabawan){
                $column = [];
                $column['no'] = $no_urut++;
                $column['kode_soal'] = $data_jabawan->no_urut;
                $column['kunci_jawaban'] = $data_jabawan->linkToKunciJawaban->jawaban;
                $column['skor'] = $data_jabawan->linkToKunciJawaban->score;
                $skor = 0;
                if($data_jabawan->linkToKunciJawaban->jawaban == $data_jabawan->jawaban){
                    $skor = $data_jabawan->linkToKunciJawaban->score;
                }
                $column['jawaban_siswa'] = $data_jabawan->jawaban;
                $column['sub_skor'] = $skor;
                $total_skor += $skor;
                $row[] = $column;
            }
            return ['siswa'=>$data_siswa,'tema_soal'=>$cek_tema_soal,'data_jawaban'=>$row,'total_skor'=>$total_skor, 'id_soal_ujian'=>$id_siswa_ujian];
        }else{
            return "you don't have authorized in this pages";
        }
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


    private function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    private function group_by($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
        return $result;
    }

    public function laporan(){
        return view('Elearning.Guru.laporan.master');
    }

    public function grafik(Request $req)
    {
        $this->validate($req,[
            'semester'=> 'required'
        ]);
        DataAverageTest::$semester = $req->semester;
        DataAverageTest::RedataRataRata(null);
        $data = DataAverageTest::groupByMataPelajaran();
        $mata_pelajaran = MataPelajaran::all();
        return view('Elearning.Guru.laporan.grafik', ['data'=> $data,'pelajaran'=>$mata_pelajaran]);
    }



    public function grafik_perbandingan_hasil_ujian()
    {
        DataAverageTest::RedataRataRata(null);
        DataAverageTest::groupByMataPelajaran(null);
        DataAverageTest::groupBySemester();
        $data = DataAverageTest::$data_mata_semester;
        $mata_pelajaran = MataPelajaran::all();
        return view('Elearning.Guru.laporan.perbandingan_mata_pelajaran', ['data'=> $data,'pelajaran'=>$mata_pelajaran]);
    }

    public function perkembangan_nilai_rerata_kelas(){
        PerkembanganNilaiRerataKelas::data_Average();
        $data = PerkembanganNilaiRerataKelas::pecah_data_rerata_permata_pelajaran();
        return view('Elearning.Guru.laporan.perbandingan_mata_pelajaran_kelas', ['data'=> $data]);
    }

    public function nilai_terata_kelas_semester(){
        PerkembanganNilaiRerataKelas::data_Average();
        PerkembanganNilaiRerataKelas::pecah_data_rerata_permata_pelajaran();
        PerkembanganNilaiRerataKelas::regroupData();
        $data=PerkembanganNilaiRerataKelas::regroupData();
//        dd($data);
        return view('Elearning.Guru.laporan.nilai_terata_kelas', ['data'=> $data]);
    }

}
