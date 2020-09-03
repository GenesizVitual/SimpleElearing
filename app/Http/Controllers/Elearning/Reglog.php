<?php

namespace App\Http\Controllers\Elearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Reglog extends Controller
{
    //

    public function login(){
        return view('page_login_regis.login');
    }
}
