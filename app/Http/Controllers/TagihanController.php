<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Biaya;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TagihanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // serach
        if ($request->filled('bulan') && $request->filled('tahun')) {
            // kalau ada q
            $tagihans = Model::latest()
                ->whereMonth('tanggal_tagihan', $request->bulan)
                ->whereYear('tanggal_tagihan', $request->tahun)
                ->paginate(10);
        }else{
            // kalau tidak ada q
            $tagihans = Model::latest()->paginate(10);
        }
        
        return view('operator.tagihan.index', compact('tagihans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswa = Siswa::all();
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => 'tagihan.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA TAGIHAN',
            'angkatan' => $siswa->pluck('angkatan','angkatan'),
            'kelas' => $siswa->pluck('kelas','kelas'),
            // kalau memakai select2
            // 'biaya' => Biaya::get()->pluck('nama_biaya_full','id'),
            // kalau memakai checkbox
            'biaya' => Biaya::get()
        ];
        return view('operator.tagihan.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        // 1.lakukan validasi
        $requestData = $request->validated();

        // 2.ambil data biaya yang ditagihkan
        $biayaIdArray = $requestData['biaya_id'];

        // 3.ambil data siswa yang ditagih berdasarkan kelas atau berdasarkan angkatan
        $siswa = Siswa::query();
        if ($requestData['kelas'] != '') {
            $siswa->where('kelas', $requestData['kelas']);
        }
        if ($requestData['angkatan'] != '') {
            $siswa->where('angkatan', $requestData['angkatan']);
        }
        $siswa = $siswa->get();

        // 4.lakukan perulangan berdasarkan data siswa
        foreach($siswa as $itemSiswa){
            $biaya = Biaya::whereIn('id', $biayaIdArray)->get();
            unset($requestData['biaya_id']);
            $requestData['siswa_id'] = $itemSiswa->id;
            $requestData['status'] ='baru';
            $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
            $bulanTagihan = $tanggalTagihan->format('m');
            $tahunTagihan = $tanggalTagihan->format('Y');
            $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                ->whereMonth('tanggal_tagihan', $bulanTagihan)
                ->whereYear('tanggal_tagihan', $tahunTagihan)
                ->first();
            if ($cekTagihan == null) {
                // simpan data
                $tagihan = Model::create($requestData);
                foreach($biaya as $itemBiaya){
                    $detail = TagihanDetail::create([
                        // dd($tagihan->id),
                        'tagihan_id' => $tagihan->id,
                        'nama_biaya' => $itemBiaya->nama,
                        'jumlah_biaya' => $itemBiaya->jumlah,
                    ]);
                }
            }
            // $itemSiswa = $item;
            // print_r($itemSiswa);
            // echo'<br>';
            // echo'<hr>';
            // $biaya = Biaya::whereIn('id', $biayaIdArray)->get();
            // print_r($biaya);
            // echo'<br>';
            // echo'<hr>';
            // 5.didalam perulangan, simpan tagihan berdasarkan biaya dan siswa
            // foreach($biaya as $itemBiaya){
            //     $dataTagihan = [
            //         'siswa_id' => $itemSiswa->id,
            //         'angkatan' => $requestData['angkatan'],
            //         'kelas' => $requestData['kelas'],
            //         'tanggal_tagihan' => $requestData['tanggal_tagihan'],
            //         'tanggal_jatuh_tempo' => $requestData['tanggal_jatuh_tempo'],
            //         'nama_biaya' => $itemBiaya->nama,
            //         'jumlah_biaya' => $itemBiaya->jumlah,
            //         'keterangan' => $requestData['keterangan'],
            //         'status' => 'baru' 
            //     ];
                // print_r($dataTagihan);
                // echo'<br>';
                // $tanggalJatuhTempo = Carbon::parse($requestData['tanggal_jatuh_tempo']);
                // $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
                // $bulanTagihan = $tanggalTagihan->format('m');
                // $tahunTagihan = $tanggalTagihan->format('Y');
                // $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                //     ->where('nama_biaya', $itemBiaya->nama)
                //     ->whereMonth('tanggal_tagihan', $bulanTagihan)
                //     ->whereYear('tanggal_tagihan', $tahunTagihan)
                //     ->first();
                // if ($cekTagihan == null) {
                    // simpan data
                //     Model::create($dataTagihan);
                // }
            // }
        }
        flash('Data tagihan berhasil disimpan')->success();
        return back();
        // 6.simpan notifikasi database untuk tagihan
        // 7.kirim pesan whatsapp
        // 8.redirect back() dengan pesan sukses
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $viewShow = 'tagihan.show';
        $tagihan = Model::with('pembayaran')->findOrFail($id);
        // dd($tagihan);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['periode'] = Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('F Y');
        $data['model'] = new Pembayaran();
        // dd($data['tagihan']);
        return view('operator.'. $viewShow, $data);
        // return view(`operator.tagihan.show`, compact($data['tagihan']));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagihanRequest  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagihanRequest $request, Model $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $tagihan)
    {
        //
    }
}
