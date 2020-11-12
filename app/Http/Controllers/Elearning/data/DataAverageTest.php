<?php
/**
 * Created by PhpStorm.
 * User: Fandiansyah
 * Date: 29/10/2020
 * Time: 15:05
 */

namespace App\Http\Controllers\Elearning\data;

use App\Http\Controllers\Elearning\data\TahunAngkatanAktif;
use Illuminate\Support\Facades\DB;
use App\Model\MataPelajaran;
use App\Model\Soal;
use App\Model\Siswa;
use phpDocumentor\Reflection\Types\Self_;

class DataAverageTest
{
    public static $semester;

    private static $semester_data = [1,2];

    private static $data_mata_pelajaran;
    public static $data_mata_semester;

    private static function cmp_by_optionNumber($a, $b) {
        return $b["kelas"]-$a["kelas"];
    }

    public static function dataRataRata($array){

        TahunAngkatanAktif::CektanggalAktif();
        $ndata = TahunAngkatanAktif::$data;
        $array_data_mata_pelajan = [];
        #Ambil Semua mata pelajan
        $data_mata_pelajaran = MataPelajaran::all();
        foreach ($data_mata_pelajaran as $mata_pel){
            $data = self::queryAverageTest(['id_mata_pelajaran'=> ''.$mata_pel->id,'id_thn_angkatan'=> ''.$ndata->id]);
            if(!empty($data)){
                foreach ($data as $data_grafik){

                    $hitung_banyak_soal = Soal::find($data_grafik->id_tema_soal);
                    $banyak_soal = $hitung_banyak_soal->linkToDaftarSoal->count('id');
                    $column = [];
                    $column['mata_pelajaran']=$hitung_banyak_soal->linkToMataPelajaran->mata_pelajaran;
                    $column['kelas']=(int)$data_grafik->kelas;
                    $column['semester']=$data_grafik->semester;
                    $column['label']=$data_grafik->kelas.''.$data_grafik->label_kelas.' '.$data_grafik->jenis_kelas;
                    $column['y']=$data_grafik->score/$banyak_soal;
                    $array_data_mata_pelajan[$mata_pel->id][] = $column;
                }
            }
        }

        return $array_data_mata_pelajan;
    }


    public static function RedataRataRata($array){
        TahunAngkatanAktif::CektanggalAktif();
        $ndata = TahunAngkatanAktif::$data;
        $data_kelas = self::groupKelas();
        $array_data_mata_pelajan = [];
        $data_soal = self::Query(['id_thn_angkatan'=>$ndata->id]);
        foreach ($data_soal as $key=>$data){
            $soal= Soal::find($data->id_tema_soal);
            foreach (self::$semester_data as $semeter){
                $std = [];
                $std['mata_pelajaran'] = $data->id_mata_pelajaran;
                $std['kelas'] = $data->kelas;
                $std['label'] = $data->number_kelas.''.$data->label_kelas.' '.$data->jenis_kelas;
                if($data->semester==$semeter ){
                    $std['semester'] = $semeter;
                    $std['y'] = $data->score/$soal->linkToDaftarSoal->count('id');
                    $array_data_mata_pelajan[$key][$semeter] = $std;
                }else{
                    $std['semester'] = $semeter;
                    $std['y'] = 0;
                    $array_data_mata_pelajan[$key][$semeter] = $std;
                }
            }
        }

        self::$data_mata_pelajaran = $array_data_mata_pelajan;
    }

    public static function groupByMataPelajaran(){
        $data =self::$data_mata_pelajaran;
        $container = [];
        # gabungkan semua data semester
        foreach ($data as $data_semester){
            foreach ($data_semester as $data){
                $container[] = $data;
            }
        }

        # regroup by mata_pelajaran
        $result = self::groupArray($container, 'mata_pelajaran');
        return $result;
    }

    private static function groupArray($array, $key){
        $array_result = [];

        foreach ($array as $element){
            if(!empty(self::$semester)){
                if ($element['semester']==self::$semester){
                    $array_result[$element[$key]][] = $element;
                }
            }else{
                $array_result[$element[$key]][] = $element;
            }
        }
        self::$data_mata_semester =$array_result;
        return $array_result;
    }

    public static function groupBySemester(){
        $data = self::$data_mata_semester;
        $result =[];
        foreach ($data as $key=>$data_kelas){
            foreach ($data_kelas as $semester){
                $result[$key][$semester['semester']][] = $semester;
            }
        }
        self::$data_mata_semester = $result;
    }

    public static function Query($array){
        $data = DB::select('SELECT tbl_kunci_jawaban.id_tema_soal as id_tema_soal,if(tbl_siswa.kelas="IX",9,if(tbl_siswa.kelas="VIII",8, if(tbl_siswa.kelas="VII",7,"-"))) as number_kelas,tbl_siswa.kelas,tbl_siswa.label_kelas, tbl_siswa.jenis_kelas,sum(if(tbl_jawaban_siswa.jawaban = tbl_kunci_jawaban.jawaban, tbl_kunci_jawaban.score,0)) as score, tbl_tema_soal.semester, tbl_tema_soal.id_mata_pelajaran FROM tbl_jawaban_siswa 
                                    join tbl_kunci_jawaban on tbl_kunci_jawaban.id = tbl_jawaban_siswa.id_kunci_jawaban
                                    join tbl_siswa on tbl_siswa.id = tbl_jawaban_siswa.id_siswa
                                    JOIN tbl_tema_soal on tbl_tema_soal.id = tbl_kunci_jawaban.id_tema_soal
                                    where 
                                    tbl_tema_soal.id_thn_angkatan="'.$array['id_thn_angkatan'].'"
                                    GROUP by tbl_siswa.kelas, label_kelas, jenis_kelas, id_mata_pelajaran 
ORDER BY `number_kelas` ASC, label_kelas asc'
                           );
        return $data;
    }


    private static function groupKelas(){
        $data_group_siswa = DB::select('SELECT if(tbl_siswa.kelas="IX",9,if(tbl_siswa.kelas="VIII",8, if(tbl_siswa.kelas="VII",7,"-"))) as number_kelas,kelas, label_kelas, jenis_kelas FROM tbl_siswa GROUP BY kelas, label_kelas, jenis_kelas ORDER BY `number_kelas` ASC,label_kelas asc');
        return $data_group_siswa;
    }

    public static function dataPerbandinganRerata($array){
        // Data rata rata pelajaran
        $data = self::dataRataRata(null);
        $mata_pelajaran=[];
        foreach ($data as $key=>$data_mata_pelajaran){
            $result = array();
            foreach ($data_mata_pelajaran as $keys=>$element) {
                $result[$element['semester']][] = $element;
            }
            ksort($result);
            $mata_pelajaran[$key] = $result;
        }
      return $mata_pelajaran;
    }

    private static function queryAverageTest($array){
        $id_mata_pelajaran = $array['id_mata_pelajaran'];
        $id_thn_angkatan = $array['id_thn_angkatan'];
        if(!empty(self::$semester)){
//            $query = DB::select('select * from (SELECT tbl_tema_soal.id as id_tema_soal,tbl_tema_soal.semester as semester ,if(tbl_siswa.kelas="IX",9,if(tbl_siswa.kelas="VIII",8, if(tbl_siswa.kelas="VII",7,"-"))) as kelas, tbl_siswa.jenis_kelas,tbl_siswa.label_kelas, sum(if(tbl_kunci_jawaban.jawaban = tbl_jawaban_siswa.jawaban,tbl_kunci_jawaban.score,0)) as score FROM tbl_jawaban_siswa JOIN tbl_siswa on tbl_jawaban_siswa.id_siswa = tbl_siswa.id JOIN tbl_kunci_jawaban on tbl_jawaban_siswa.id_kunci_jawaban = tbl_kunci_jawaban.id jOIN tbl_tema_soal on tbl_kunci_jawaban.id_tema_soal = tbl_tema_soal.id where tbl_tema_soal.id_mata_pelajaran="'.$id_mata_pelajaran.'" and tbl_tema_soal.id_thn_angkatan="'.$id_thn_angkatan.'" and tbl_tema_soal.semester="'.self::$semester.'" GROUP by tbl_siswa.kelas, tbl_siswa.jenis_kelas,tbl_siswa.label_kelas ORDER BY tbl_siswa.kelas DESC, tbl_siswa.jenis_kelas ASC, tbl_siswa.kelas DESC, tbl_siswa.label_kelas ASC) as d
//            ORDER BY d.`kelas` ASC, `d`.`label_kelas` ASC');

            $query = DB::select('select * from (SELECT tbl_tema_soal.id as id_tema_soal,tbl_tema_soal.semester as semester ,if(tbl_siswa.kelas="IX",9,if(tbl_siswa.kelas="VIII",8, if(tbl_siswa.kelas="VII",7,"-"))) as kelas, tbl_siswa.jenis_kelas,tbl_siswa.label_kelas, sum(if(tbl_kunci_jawaban.jawaban = tbl_jawaban_siswa.jawaban,tbl_kunci_jawaban.score,0)) as score FROM tbl_jawaban_siswa JOIN tbl_siswa on tbl_jawaban_siswa.id_siswa = tbl_siswa.id JOIN tbl_kunci_jawaban on tbl_jawaban_siswa.id_kunci_jawaban = tbl_kunci_jawaban.id jOIN tbl_tema_soal on tbl_kunci_jawaban.id_tema_soal = tbl_tema_soal.id where tbl_tema_soal.id_mata_pelajaran="'.$id_mata_pelajaran.'" and tbl_tema_soal.id_thn_angkatan="'.$id_thn_angkatan.'" and tbl_tema_soal.semester="'.self::$semester.'" GROUP by tbl_siswa.kelas, tbl_siswa.jenis_kelas,tbl_siswa.label_kelas, tbl_tema_soal.semester ORDER BY tbl_siswa.kelas DESC, tbl_siswa.jenis_kelas ASC, tbl_siswa.kelas DESC, tbl_siswa.label_kelas ASC) as d  
                ORDER BY d.`kelas` ASC, `d`.`label_kelas` ASC');
        }else{
        $query = DB::select('select * from (SELECT tbl_tema_soal.id as id_tema_soal,tbl_tema_soal.semester as semester ,if(tbl_siswa.kelas="IX",9,if(tbl_siswa.kelas="VIII",8, if(tbl_siswa.kelas="VII",7,"-"))) as kelas, tbl_siswa.jenis_kelas,tbl_siswa.label_kelas, sum(if(tbl_kunci_jawaban.jawaban = tbl_jawaban_siswa.jawaban,tbl_kunci_jawaban.score,0)) as score FROM tbl_jawaban_siswa JOIN tbl_siswa on tbl_jawaban_siswa.id_siswa = tbl_siswa.id JOIN tbl_kunci_jawaban on tbl_jawaban_siswa.id_kunci_jawaban = tbl_kunci_jawaban.id jOIN tbl_tema_soal on tbl_kunci_jawaban.id_tema_soal = tbl_tema_soal.id where tbl_tema_soal.id_mata_pelajaran="'.$id_mata_pelajaran.'" and tbl_tema_soal.id_thn_angkatan="'.$id_thn_angkatan.'" GROUP by tbl_siswa.kelas, tbl_siswa.jenis_kelas,tbl_siswa.label_kelas, tbl_tema_soal.semester ORDER BY tbl_siswa.kelas DESC, tbl_siswa.jenis_kelas ASC, tbl_siswa.kelas DESC, tbl_siswa.label_kelas ASC) as d  
                ORDER BY d.`kelas` ASC, `d`.`label_kelas` ASC');
        }
        return $query;
    }
}