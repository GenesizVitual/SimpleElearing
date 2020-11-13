<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\SiswaCheck;
use App\Http\Middleware\CheckGuru;
use App\Http\Middleware\CheckWali;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// =============================== PPSB =========================================================
Route::get('ppsb',function(){
    return view('PPSB.login.index');
});

Route::resource('pendaftar','PPSB\Pendaftar');
Route::post('login-pendaftar','PPSB\Pendaftar@login');

Route::resource('formulir','PPSB\Formulir');
Route::post('kategori-siswa','PPSB\Formulir@kategori_siswa');

Route::resource('formulir-orang-tua','PPSB\FormulirOrangTua');

Route::resource('upload-berkas','PPSB\UploadBerkas');

//=============================== Elearning =====================================================

Route::get('/', 'Elearning\Reglog@login');

Route::get('admin', 'Elearning\Reglog@admin');

Route::get('login-guru', 'Elearning\Reglog@guru');

Route::get('login-authority', 'Elearning\Reglog@authority');

Route::get('login-wali-siswa', 'Elearning\Reglog@wali_murid');

Route::post('login-check', 'Elearning\Reglog@check_login');

Route::post('login-admin', 'Elearning\Reglog@login_admin');

Route::post('login-guru', 'Elearning\Reglog@check_guru');

Route::post('login-authority', 'Elearning\Reglog@check_authority');

Route::post('check_wali', 'Elearning\Reglog@check_wali');

Route::middleware([AdminCheck::class])->group(function(){

    Route::get('dashboard', function(){
        return view('Elearning.content');
    });

    Route::resource('authority','Elearning\Authority');
    Route::resource('siswa','Elearning\Siswa');
    Route::resource('wali-siswa','Elearning\WaliSiswa');
    Route::get('export', 'Elearning\Siswa@export')->name('export');
    Route::post('import-siswa', 'Elearning\Siswa@import');

    Route::resource('guru','Elearning\Guru');
    Route::post('import-guru', 'Elearning\Guru@import');

//    Route::resource('soal','Elearning\Soal');
//    Route::put('statu-update','Elearning\Soal@status');
//    Route::post('upload-soal','Elearning\Soal@upload');
//    Route::get('lihat-dokumen-soal/{id}','Elearning\Soal@view_documen');
//    Route::get('hasil-ujian/{id}','Elearning\Soal@hasil_ujian');
//    Route::get('monitor-ujian/{id}','Elearning\Soal@halaman_monitoring_ujian');
//    Route::post('data-monitor-ujian','Elearning\Soal@data_hasil_ujian_api');
//    Route::get('monitoring-hasil-ujian-aktif','Elearning\Soal@halaman_monitoring_semua_ujian');
//    Route::post('monitoring-hasil-ujian-aktif-api','Elearning\Soal@data_semua_hasil_ujian');
//    Route::get('cetak-hasil-ujian/{id}','Elearning\Soal@cetak_hasil_ujian');


//    Route::get('kunci-jawaban/{id}','Elearning\KunciJawaban@show');
//    Route::post('store-jabawan','Elearning\KunciJawaban@store');
//    Route::post('form-kunci-jawaban','Elearning\KunciJawaban@create');

    Route::resource('soal','Elearning\Soal');

    Route::resource('daftar-soal','Elearning\DaftarSoal');

    Route::resource('tahun-angkatan','Elearning\ThnAngkatan');

    Route::resource('mata-pelajaran','Elearning\MataPelajaran');

    Route::put('statu-update','Elearning\Soal@status');
    Route::post('upload-soal','Elearning\Soal@upload');
    Route::get('lihat-dokumen-soal/{id}','Elearning\DaftarSoal@view_documen');
    Route::get('hasil-ujian/{id}','Elearning\Soal@hasil_ujian');
    Route::get('hasil-ujian/{id}/grup-kelas','Elearning\Soal@hasil_ujian_by_kelas');
    Route::get('hasil-ujian/{id}/grup-kelas/cetak','Elearning\Soal@cetak_hasil_ujian_by_kelas');
    Route::get('detail-jawaban/{id_ujian_siswa}','Elearning\Soal@halaman_detail_ujian');
    Route::get('cetak-detail-hasil-ujian/{id_ujian_siswa}','Elearning\Soal@cetak_detail_ujian');
    Route::get('monitor-ujian/{id}','Elearning\Soal@halaman_monitoring_ujian');
    Route::post('data-monitor-ujian','Elearning\Soal@data_hasil_ujian_api');
    Route::get('monitoring-hasil-ujian-aktif','Elearning\Soal@halaman_monitoring_semua_ujian');
    Route::post('monitoring-hasil-ujian-aktif-api','Elearning\Soal@data_semua_hasil_ujian');
    Route::get('cetak-hasil-ujian/{id}','Elearning\Soal@cetak_hasil_ujian');

    Route::get('laporan-guru','Elearning\Soal@laporan');
    Route::post('grafik-hasil-ujian','Elearning\Soal@grafik');
    Route::get('grafik-perbandingan-hasil-ujian','Elearning\Soal@grafik_perbandingan_hasil_ujian');
    Route::get('grafik-perkembangan-nilai-rerata-kelas','Elearning\Soal@perkembangan_nilai_rerata_kelas');
    Route::get('nilai-terata-kelas-semester','Elearning\Soal@nilai_terata_kelas_semester');

    Route::get('kunci-jawaban/{id}','Elearning\KunciJawaban@show');
    Route::post('store-jabawan','Elearning\KunciJawaban@store');
    Route::post('form-kunci-jawaban','Elearning\KunciJawaban@create');

});

////==========guru=====================
//Route::middleware([CheckGuru::class])->group(function(){
//
//
//});

//==========Siswa=====================
Route::middleware([SiswaCheck::class])->group(function(){
    Route::get('ujian','Elearning\Ujian@index');
    Route::post('ikut-ujian','Elearning\Ujian@ikut_ujian');
    Route::get('jawaban-soal','Elearning\Ujian@halaman_soal_ujian');
    Route::get('jawaban-soal/{id}','Elearning\Ujian@halaman_soal_ujian_persoal');
    Route::get('ujian-dimulai','Elearning\Ujian@ikut_ujian');
    Route::put('jawab-ujian','Elearning\Ujian@jawab_ujian');
    Route::post('update-status','Elearning\Ujian@updateStatusUjian');
    Route::post('nilai-ujian','Elearning\Ujian@nilai_ujian');
    Route::get('laporan-ujian','Elearning\Siswa@laporan_ujian');
    Route::get('cetak-hasil-ujian-siswa','Elearning\Siswa@cetak_ujian');
});

Route::middleware([CheckWali::class])->group(function(){
    Route::get('wali-murid','Elearning\Siswa@lihat_siswa');
    Route::get('cetak-laporan-siswa','Elearning\Siswa@wali_cetak_ujian');
});

Route::get('log-out','Elearning\Reglog@logout');

Route::get('bycript/{kode}',function($kode){
    return bcrypt($kode);
});