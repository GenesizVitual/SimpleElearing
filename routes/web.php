<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('Elearning.Dashboard.content');
});

Route::resource('siswa','Elearning\Siswa');
Route::get('export', 'Elearning\Siswa@export')->name('export');
Route::post('import-siswa', 'Elearning\Siswa@import');