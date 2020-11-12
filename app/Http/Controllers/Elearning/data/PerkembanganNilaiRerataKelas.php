<?php
/**
 * Created by PhpStorm.
 * User: Fandiansyah
 * Date: 04/11/2020
 * Time: 20:01
 */

namespace App\Http\Controllers\Elearning\data;
use App\Http\Controllers\Elearning\data\DataAverageTest;
use Illuminate\Support\Facades\DB;

class PerkembanganNilaiRerataKelas
{
    public static $data;
    private static $data_average;
    public static function data_Average(){
        DataAverageTest::RedataRataRata(null);
        DataAverageTest::groupByMataPelajaran(null);
        DataAverageTest::groupBySemester();
        self::$data_average= DataAverageTest::$data_mata_semester;
        self::pecah_data_rerata_permata_pelajaran();
    }

    private static function cmp_by_optionNumber($a, $b) {
        return round($b["y"],2)-round($a["y"],2);
    }

    public static function pecah_data_rerata_permata_pelajaran(){
        $row = [];
        #Bongkar data
        foreach (self::$data_average as $mata_pelajaran){
            foreach ($mata_pelajaran as $keys=> $data_semester){
                foreach ($data_semester as $key=> $item){
                    $row[$keys][$key][] = $item;
                }
            }
        }

        $result = [];
        foreach ($row as $key => $semester){
            $reData = [];
            foreach ($semester as $kelas){
                $mata_pelajarna = count($kelas);
                $nilai = 0;
                foreach ($kelas as $data_item){
                    $reData=$data_item;
                    $nilai+=$data_item['y'];
                }
                $reData['y'] = $nilai/$mata_pelajarna;
                $result[$key][]= $reData;
            }
        }

        self::$data = $result;
        return $result;
    }

    public static function regroupData(){
        $data = self::$data;
        $container = [];
        foreach ($data as $semster){
            $container[] = self::groupBy($semster);
        }
        return $container;
    }

    private static function groupBy($array){
        $result = [];
        foreach ($array as $data){
            $result[$data['kelas']][]=$data;
        }

        return $result;
    }

}