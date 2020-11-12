<?php

namespace App\Http\Controllers\PPSB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;

class Pendaftar extends Controller
{
    //
    public function index(){
        return view('PPSB.Pendaftar.content');
    }

    public function store(Request $req){
        $this->validate($req,[
            'username'=> 'required',
            'email'=> 'required|unique:users,email',
            'password'=> 'required',
            'repassword'=> 'required',
        ]);

        if($req->password != $req->repassword ){
            return redirect()->back()->with('message_error','Password yang ada masukan berbeda');
        }

        $model = new User();
        $model->username = $req->username;
        $model->name = $req->username;
        $model->email = $req->email;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        if($model->save()){
            return redirect('ppsb')->with('message_success', 'Account anda telah dibuat silahkah login');
        }
        return redirect('ppsb')->with('message_error', 'Maaf, Accoun gagal dibuat');
    }

    public function login(Request $req){
        $this->validate($req,[
            'email'=> 'required',
            'password'=> 'required',
        ]);

        $model = User::where('email',$req->email);
        if($model->count() > 0){
            $data = $model->first();
            if(Hash::check($req->password, $data->password)){
                $req->session()->put('id_pendaftar', $data->id);
                return redirect('pendaftar')->with('message_success','Selamat Datang '.$data->username);
            }else{
                return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
            }
        }else{
            return redirect()->back()->with('message_error','Maaf, Email atau password anda salah. silahkah coba lagi');
        }
    }
}
