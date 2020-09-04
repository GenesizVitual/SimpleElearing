<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\SiswaCheck;
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

Route::get('/', 'Elearning\Reglog@login');

Route::get('admin', 'Elearning\Reglog@admin');

Route::post('login-check', 'Elearning\Reglog@check_login');

Route::post('login-admin', 'Elearning\Reglog@login_admin');

Route::middleware([AdminCheck::class])->group(function(){

    Route::get('dashboard', function(){
        return view('Elearning.content');
    });

    Route::resource('siswa','Elearning\Siswa');
    Route::get('export', 'Elearning\Siswa@export')->name('export');
    Route::post('import-siswa', 'Elearning\Siswa@import');

    Route::resource('guru','Elearning\Guru');
    Route::post('import-guru', 'Elearning\Guru@import');

    Route::resource('soal','Elearning\Soal');
    Route::put('statu-update','Elearning\Soal@status');
    Route::post('upload-soal','Elearning\Soal@upload');
    Route::get('lihat-dokumen-soal/{id}','Elearning\Soal@view_documen');
    Route::get('hasil-ujian/{id}','Elearning\Soal@hasil_ujian');


    Route::get('kunci-jawaban/{id}','Elearning\KunciJawaban@show');
    Route::post('store-jabawan','Elearning\KunciJawaban@store');
    Route::post('form-kunci-jawaban','Elearning\KunciJawaban@create');

});



//==========Siswa=====================
Route::middleware([SiswaCheck::class])->group(function(){
    Route::get('ujian','Elearning\Ujian@index');
    Route::post('ikut-ujian','Elearning\Ujian@ikut_ujian');
    Route::put('jawab-ujian','Elearning\Ujian@jawab_ujian');
    Route::post('update-status','Elearning\Ujian@updateStatusUjian');
    Route::post('nilai-ujian','Elearning\Ujian@nilai_ujian');

});

Route::get('log-out','Elearning\Reglog@logout');

Route::get('bycript/{kode}',function($kode){
    return bcrypt($kode);
});