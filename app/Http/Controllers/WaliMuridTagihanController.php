<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        // $siswa_id = Auth::user()->getAllSiswaId();
        // $data['tagihan'] = Tagihan::whereIn('siswa_id', $siswa_id)->get();
        $data['tagihan'] = Tagihan::waliSiswa()->get();

        return view('wali.tagihan.index',$data);
    }

    public function show($id){
        // $siswa_id = Auth::user()->getAllSiswaId();
        // $siswa_id = Auth::user()->siswa->pluck('id');
        // $tagihan = Tagihan::whereIn('siswa_id', $siswa_id)->findOrFail($id);
        $tagihan = Tagihan::waliSiswa()->findOrFail($id);
        $data['bankSekolah'] = BankSekolah::all();
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        return view('wali.tagihan.show', $data);
    }
}
