<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Authority as tbl_authority;

class Authority extends Controller
{
    //
    private $authority = [
        "Kepala Sekolah",
        "Staf",
    ];

    public function index(){
        $data = [
            'authority'=> $this->authority,
            'data'=> tbl_authority::all()
        ];
        return view('Elearning.authority.content', $data);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'username'=> 'required|unique:tbl_authority,username',
            'password'=> 'required',
            'authority'=> 'required',
        ]);


        $model = new tbl_authority();
        $model->username = $req->username;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        $model->authority = $req->authority;

        if($model->save()){
            return redirect()->back()->with('message_success','Authority telah ditambahkan');
        }else{
            return redirect()->back()->with('message_error','Gagal, menambahkan authority baru');
        }
    }

    public function edit($id){
        $data =tbl_authority::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $req,$id)
    {
        $this->validate($req, [
            'username' => 'required|unique:tbl_authority,username',
            'password' => 'required',
            'authority' => 'required',
        ]);


        $model = tbl_authority::find($id);
        $model->username = $req->username;
        $model->password = bcrypt($req->password);
        $model->see_password = $req->password;
        $model->authority = $req->authority;

        if ($model->save()) {
            return redirect()->back()->with('message_success', 'Authority telah diubah');
        } else {
            return redirect()->back()->with('message_error', 'Gagal, mengubah data authority');
        }
    }

    public function destroy(Request $req, $id){
        $model = tbl_authority::find($id);
        if ($model->delete()) {
            return redirect()->back()->with('message_success', 'Authority telah dihapus');
        } else {
            return redirect()->back()->with('message_error', 'Gagal, menghapus data authority');
        }
    }

}
