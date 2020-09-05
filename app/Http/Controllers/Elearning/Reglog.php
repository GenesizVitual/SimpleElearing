<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Siswa;
use App\User;
use Hash;

class Reglog extends Controller
{
    //

    public function login(){
        return view('page_login_regis.login');
    }

    public function admin(){
        return view('page_login_regis.admin');
    }

    public function check_login(Request $req){
        $this->validate($req,[
            'kode'=> 'required',
            'pass'=> 'required',
        ]);

        $model = Siswa::where('kode',$req->kode)->first();
        if(Hash::check($req->pass, $model->password)){
            $req->session()->put('kode', $model->kode);
            $req->session()->put('nama', $model->nama);
            $req->session()->put('kelas', $model->kelas);
            $req->session()->put('jenis_kelas', $model->jenis_kelas);
            $req->session()->put('id_siswa', $model->id);
            return redirect('ujian')->with('message_success','Selamat Datang '.$model->nama);
        }else{
            return redirect('login')->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
        }

    }

    public function login_admin(Request $req){
        $this->validate($req,[
            'email'=> 'required',
            'pass'=> 'required',
        ]);

        $model = User::where('email',$req->email)->first();
        if(Hash::check($req->pass, $model->password)){
            $req->session()->put('id', $model->id);
            $req->session()->put('username', $model->username);
            return redirect('guru')->with('message_success','Selamat Datang '.$model->username);
        }else{
            return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
        }

    }

    public function logout(Request $req){
        $req->session()->flush();
        return redirect('/');
    }
}
