<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Siswa;
use App\Model\Guru;
use App\Model\Authority as tbl_authority;
use App\User;
use App\Model\WaliSiswa;
use Hash;
use Session;

class Reglog extends Controller
{
    //

    public function login(Request $req){
        $req->session()->forget(['id', 'id_siswa', 'id_guru','level','id_wali_murid']);
        return view('page_login_regis.login');
    }

    public function admin(Request $req){
        $req->session()->forget(['id', 'id_siswa', 'id_guru','level','id_wali_murid']);
        return view('page_login_regis.admin');
    }

    public function guru(Request $req){
        $req->session()->forget(['id', 'id_siswa', 'id_guru','level','id_wali_murid']);
        return view('page_login_regis.guru');
    }

    public function authority(Request $req){
        $req->session()->forget(['id', 'id_siswa', 'id_guru','level','id_wali_murid']);
        return view('page_login_regis.authority');
    }

    public function wali_murid(Request $req){
        $req->session()->forget(['id', 'id_siswa', 'id_guru','level','id_wali_murid']);
        return view('page_login_regis.wali_murid');
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
                return redirect()->back()->with('message_error','Maaf, Kode Siswa atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Kode Siswa atau password anda salah. silahkah coba lagi');
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
                return redirect()->back()->with('message_error','Maaf, Kode Guru atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Kode Guru atau password anda salah. silahkah coba lagi');
        }
    }

    public function login_admin(Request $req){
        $this->validate($req,[
            'email'=> 'required',
            'pass'=> 'required',
        ]);

        $model = User::where('email',$req->email)->where('level','1');
        if($model->count()>0){
            $data = $model->first();
            if(Hash::check($req->pass, $data->password)){
                $req->session()->put('id', $data->id);
                $req->session()->put('username', $data->username);
                $req->session()->put('level', 100);
                return redirect('guru')->with('message_success','Selamat Datang '.$data->username);
            }else{
                return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
        }
    }

    public function check_authority(Request $req){
        $this->validate($req,[
            'username'=> 'required',
            'pass'=> 'required',
        ]);

        $model = tbl_authority::where('username',$req->username);
        if($model->count()>0){
            $data = $model->first();
            if(Hash::check($req->pass, $data->password)){
                $req->session()->put('id', $data->id);
                $req->session()->put('username', $data->username);
                $req->session()->put('level', $data->authority);
                return redirect('guru')->with('message_success','Selamat Datang '.$data->username);
            }else{
                return redirect()->back()->with('message_error','Maaf, Nama Pengguna atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Nama Pengguna atau password anda salah. silahkah coba lagi');
        }
    }

    public function check_wali(Request $req){
        $this->validate($req,[
            'username'=> 'required',
            'pass'=> 'required',
        ]);

        $data_siswa = Siswa::where('kode',$req->username)->first();
        $model = WaliSiswa::where('id_siswa',$data_siswa->id)->where('password',$req->pass);
        if($model->count()>0){
            $data = $model->first();
            $req->session()->put('id_wali_murid', $data->id_siswa);
            $req->session()->put('username', $data->nama_pengguna);
            $req->session()->put('level', 99);
            return redirect('wali-murid')->with('message_success','Selamat Datang '.$data->nama_pengguna);
        }else{
            return redirect()->back()->with('message_error','Maaf, Nama Pengguna atau password anda salah. silahkah coba lagi');
        }
    }

    public function logout(Request $req){
        // Forget multiple keys...
        $req->session()->forget(['id', 'id_siswa', 'id_guru','level','id_wali_murid']);
        return redirect('/');
    }
}
