<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Image;
use Storage;
use Session;
use App\Model\DaftarSoal as tbl_soal;
use App\Model\Soal as tbl_tema_soal;
use App\Model\Soal;
use App\Model\Pilihan;
use App\Model\KunciJawaban;

class DaftarSoal extends Controller
{
    //
    public $option = ['a','b','c','d'];
    public function show($id_tema_soal)
    {
        $data_tema_soal=tbl_tema_soal::where('id_guru', Session::get('id_guru'))->findOrFail($id_tema_soal);

        $data_soal = tbl_soal::where('id_tema_soal',$id_tema_soal)
            ->where('id_guru', Session::get('id_guru'));
        $data_backup = tbl_soal::where('id_tema_soal',$id_tema_soal)
            ->where('id_guru', Session::get('id_guru'));
        $last_no_urut = 0;
        if(!empty($data_no_urut=$data_backup->orderBy('no_urut','desc')->first())){
            $last_no_urut = $data_no_urut->no_urut;
        }
//        $last_no_urut = $data_backup->orderBy('no_urut','desc')->first();
        $pangginate = $data_soal->orderBy('no_urut','asc')->paginate(20);
        $data= [
            'data_soal'=>$pangginate,
            'pilihan'=> $this->option,
            'id_tema_soal'=>$id_tema_soal,
            'no_urut'=> $last_no_urut+1,
            'data_tema_soal'=>$data_tema_soal
        ];

        return view('Elearning.DaftarSoal.content', $data);
    }

    public function store(Request $req)
    {

        $this->validate($req,[
            'no_urut'=>'required',
            'id_tema_soal'=>'required',
            'soal'=>'required',
            'label'=>'required',
            'pilihan'=>'required',
            'jawaban'=>'required',
            'skor'=>'required',
            'waktu_kerja'=>'required',
            'status_lagunge'=>'required',

        ]);


        if($req->status_lagunge==0){
            $soal = $this->b64toUrl($req->soal);
        }else{
            $soal = $req->soal;
        }

        $model = tbl_soal::updateOrCreate(
            ['id_guru'=>Session::get('id_guru'),'id_tema_soal'=>$req->id_tema_soal,'no_urut'=> $req->no_urut],
            ['soal'=>$soal,'waktu_kerja'=> $req->waktu_kerja]
        );

        if($model){

            if(!empty($gambar=$req->gambar)){
                $imagename = time().'--'.uniqid(). '.' . $gambar->getClientOriginalExtension();

                $model_gambar = tbl_soal::findOrFail($model->id);
                if(!empty($model_gambar->gambar))
                {
                    $file_path =public_path('gambar_bhs_arab').'/' . $model->gambar;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
                $model->gambar = $imagename;
                $gambar->move(public_path('gambar_bhs_arab/'), $imagename);
                $model->save();
            }else{
                $model_gambar = tbl_soal::findOrFail($model->id);
                if(!empty($model_gambar->gambar))
                {
                    $file_path =public_path('gambar_bhs_arab').'/' . $model->gambar;
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                }
                $model->gambar = '';
                $model->save();
            }

            foreach ($req->pilihan as $key => $text){

                $model_pilihan_soal = Pilihan::updateOrCreate(
                    ['id_daftar_soal'=> $model->id,'label'=>$req->label[$key]],
                    ['text'=>$text]
                );
                if($model_pilihan_soal){

                    if(!empty($gambar2=$req->pilihan_gambar[$key])){
                        $imagename2 = time().'--'.uniqid().'.' . $gambar2->getClientOriginalExtension();

                        $model_gambar_pilihan = Pilihan::findOrFail($model_pilihan_soal->id);
                        if(!empty($model_gambar_pilihan->gambar))
                        {
                            $file_path =public_path('gambar_bhs_arab').'/pilihan/' . $model_gambar_pilihan->gambar;
                            if (file_exists($file_path)) {
                                @unlink($file_path);
                            }
                        }
                        $model_gambar_pilihan->gambar = $imagename2;
                        if(!empty($imagename2)){
                            $gambar2->move(public_path('gambar_bhs_arab/pilihan/'), $imagename2);
                        }
                        $model_gambar_pilihan->save();
                    }else{
                        $model_gambar_pilihan = Pilihan::findOrFail($model_pilihan_soal->id);
                        if(!empty($model_gambar_pilihan->gambar))
                        {
                            $file_path =public_path('gambar_bhs_arab').'/pilihan/' . $model_gambar_pilihan->gambar;
                            if (file_exists($file_path)) {
                                @unlink($file_path);
                            }
                        }
                        $model_gambar_pilihan->gambar = '';
                        $model_gambar_pilihan->save();
                    }

                }
            }

        }

        $model_kunci_jawaban =KunciJawaban::updateOrCreate(
            ['id_tema_soal'=>$req->id_tema_soal, 'id_daftar_soal'=>$model->id, 'no_urut'=>$req->no_urut],
            ['jawaban'=> $req->jawaban,'score'=> $req->skor]
        );

        return redirect()->back()->with('message_info','Soal No.'. $req->no_urut.' telah disimpan');
    }

    public function destroy(Request $req, $id){
        try{
            $model = tbl_soal::findOrFail($id);
            if($model->delete()){
                return redirect()->back()->with('message_info','Soal No.'. $req->no_urut.' telah dihapus');
            }else{
                return redirect()->back()->with('message_info','Maaf, Soal tidak dapat hapus');
            }
        }catch (Throwable $e){
            return false;
        }
    }

    public function view_documen($id){
        $model = Soal::findOrFail($id);
        return view('Elearning.Soal.view_dokumen', array('data'=> $model));
    }


    function b64toUrl ( $data )
    {
        // Create blank dom object
        $dom = new \DOMDocument();

        // Load data in the dom object
        $dom->loadHTML($data);

        // Searching for the img tag
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {

            //Getting the value of src attribuite of img
            $raw = $image->getAttribute('src');

            /* If src tag has value data:image
             * than it is upload from device in
             * base64 format
             */
            if (preg_match('/data:image/', $raw)) {
                $name = uniqid();

                preg_match('/data:image\/(?<mime>.*?)\;/', $raw, $groups);
                $mimetype = $groups['mime'];
                $filepath = 'public/images/' . $name . '.' . $mimetype;

                // Convert base64 data to the image again
                $img = Image::make($raw)
                    ->encode($mimetype, 100);

                // Store the image in disk
                Storage::put($filepath, $img);

                // Remove old src attribute value
                $image->removeAttribute('src');

                // Set new src attribute value as a url that gives image in response.
                $url=asset('storage/images/'.$name .'.'. $mimetype);
                $image->setAttribute('src',$url);
            }
        }

        // Return the dom html
        return $dom->saveHTML();
    }
}
