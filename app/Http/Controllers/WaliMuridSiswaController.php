<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridSiswaController extends Controller
{
    public function index(){
        $data['models'] = Auth::user()->siswa;
        // dd($siswa);
        return view('wali.siswa.index',$data);
    }
}
