<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Siswa;
use App\Model\Guru;
use App\User;
use Hash;
use Session;

class Reglog extends Controller
{
    //

    public function login(){
        return view('page_login_regis.login');
    }

    public function admin(){
        return view('page_login_regis.admin');
    }

    public function guru(){
        return view('page_login_regis.guru');
    }

    #siswa
    public function check_login(Request $req){
        $this->validate($req,[
            'kode'=> 'required',
            'pass'=> 'required',
        ]);

        $model = Siswa::where('kode',$req->kode);
        if($model->count() > 0){
            $data = $model->first();

            if(Hash::check($req->pass, $data->password)){
                $req->session()->put('kode', $data->kode);
                $req->session()->put('nama', $data->nama);
                $req->session()->put('kelas', $data->kelas);
                $req->session()->put('jenis_kelas', $data->jenis_kelas);
                $req->session()->put('id_siswa', $data->id);

                return redirect('ujian')->with('message_success','Selamat Datang '.$data->nama);
            }else{
                return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
        }

    }

    public function check_guru(Request $req){
        $this->validate($req,[
            'kode'=> 'required',
            'pass'=> 'required',
        ]);

        $model = Guru::where('kode',$req->kode);
        if($model->count() > 0){
            $data = $model->first();
            if(Hash::check($req->pass, $data->password)){
                $req->session()->put('kode', $data->kode);
                $req->session()->put('nama', $data->nama);
                $req->session()->put('id_guru', $data->id);
                return redirect('soal')->with('message_success','Selamat Datang '.$data->nama);
            }else{
                return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
        }

    }

    public function login_admin(Request $req){
        $this->validate($req,[
            'email'=> 'required',
            'pass'=> 'required',
        ]);

        $model = User::where('email',$req->email);
        if($model->count()>0){
            $data = $model->first();
            if(Hash::check($req->pass, $data->password)){
                $req->session()->put('id', $data->id);
                $req->session()->put('username', $data->username);
                return redirect('guru')->with('message_success','Selamat Datang '.$data->username);
            }else{
                return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
        }


    }

    public function logout(Request $req){
        // Forget multiple keys...
        $req->session()->forget(['id', 'id_siswa', 'id_guru']);
        return redirect('/');
    }
}
