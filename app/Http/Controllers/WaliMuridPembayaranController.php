<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use App\Models\WaliBank;
use App\Notifications\PembayaranNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class WaliMuridPembayaranController extends Controller
{

    public function index()
    {
        $pembayaran = Pembayaran::where('wali_id', auth()->user()->id)
            ->where('tanggal_konfirmasi','<>', null)
            ->latest()
            ->orderBy('tanggal_konfirmasi', 'desc')
            ->paginate(50);
        ;
        $data['models'] = $pembayaran;
        return view('wali.pembayaran.index', $data);
    }

    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        // dd($pembayaran);
        return view('operator.pembayaran.show',[
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id]
        ]);
    }

    public function create(Request $request)
    {
        // $data['tagihan'] = Tagihan::where('id', $request->tagihan_id)->first();
        // $data['tagihan'] = Tagihan::whereIn('siswa_id',Auth::user()->siswa->pluck('id'))->where('id', $request->tagihan_id)->first();
        // $data['tagihan'] = Tagihan::whereIn('siswa_id',Auth::user()->getAllSiswaId())->where('id', $request->tagihan_id)->first();
        $data['tagihan'] = Tagihan::waliSiswa()->findOrFail($request->tagihan_id);
        // $data['bankSekolah'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBankSekolah'] = BankSekolah::pluck('nama_bank', 'id');
        $data['listBank'] = Bank::pluck('nama_bank', 'id');
        $data['listWaliBank'] = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');
        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }
        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id' => $request->tagihan_id
        ]);

        return view('wali.pembayaran.form', $data);
    }

    public function store(Request $request)
    {

        // validasi jika tidah memilih bank pengirim atau bank baru
        if ($request->wali_bank_id =='' && $request->no_rekening == '') {
            flash('Silahkan pilih bank pengirim')->error();
            return back();
        }
        // $pilihanBank = $request->pilihan_bank;
        // if ($pilihanBank == null) {
        //     // wali memilih dari select
        // } else {
        //     // wali membuat rekening baru
        // }

        // if ($request->filled('pilihan_bank')) {
        if ($request->no_rekening && $request->pemilik_rekening) {
            // walib membuat rekening bank baru
            $bankId = $request->bank_id;
            $namaRekeningPengirim = $request->nama_rekening_pengirim;
            $nomorRekeningPengirim = $request->nomor_rekening_pengirim;
            $bank = Bank::findOrFail($bankId);
            if ($request->filled('simpan_data_rekening')) {
                $requestDataBank = $request->validate([
                    'pemilik_rekening' => 'required',
                    'no_rekening' => 'required',
                ]);
                // menyimpan berkali-kali
                // $waliBank = new WaliBank();
                // $waliBank->pemilik_rekening = $requestDataBank('nama_rekening_pengirim');
                // $waliBank->no_rekening = $requestDataBank('nomor_rekening_pengirim');
                // $waliBank->wali_id = Auth::user()->id;
                // $waliBank->kode = $bank->sandi_bank;
                // $waliBank->nama_bank = $bank->nama_bank;
                // $waliBank->save();

                // menyimpan hanya 1 data saja tidak bisa data ganda
                $waliBank = WaliBank::firstOrCreate(
                    // [
                    //     'no_rekening' => $requestDataBank['no_rekening'],
                    //     'pemilik_rekening' => $requestDataBank['pemilik_rekening'],
                    // ],
                    $requestDataBank,
                    [
                        'pemilik_rekening' => $requestDataBank['pemilik_rekening'],
                        'wali_id' => Auth::user()->id,
                        'kode' => $bank->sandi_bank,
                        'nama_bank' => $bank->nama_bank
                    ]
                );
                // dd($waliBank);
            }
        } else {
            $waliBankId = $request->wali_bank_id;
            $waliBank = WaliBank::findOrFail($waliBankId);
        }
        // dd($waliBank);

        $jumlahDibayar = str_replace('.','',$request->jumlah_dibayar);
        $validasiPembayaran = Pembayaran::where('jumlah_dibayar', $jumlahDibayar)
                ->where('tagihan_id',$request->tagihan_id)
                // ->where('status_konfirmasi', 'belum')
                ->first();

        if ($validasiPembayaran != null) {
            flash('Data pembayaran ini sudah ada dan akan segera dikonfirmasi oleh admin sekolah')->error();
            return back();
        }
        $request->validate([
            'tanggal_bayar' => 'required',
            'jumlah_dibayar' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $buktiBayar = $request->file('bukti_bayar')->store('public');
        $dataPembayaran = [
            'bank_sekolah_id' => $request->bank_sekolah_id,
            'wali_bank_id' => $waliBank->id,
            'tagihan_id' => $request->tagihan_id,
            'wali_id' => auth()->user()->id,
            'tanggal_bayar' => $request->tanggal_bayar,
            // 'status_konfirmasi' => 'belum',
            'jumlah_dibayar' => $jumlahDibayar,
            'bukti_bayar' => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id' => 0
        ];
        // dd($dataPembayaran);
        DB::beginTransaction();
        try {
            //code...
            $pembayaran = Pembayaran::create($dataPembayaran);
            // dd($pembayaran);
            $userOperator = User::where('akses', 'operator')->get();
            Notification::send($userOperator, new PembayaranNotification($pembayaran));
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            flash('Gagal menyimpan data pembayaran,' . $th->getMessage())->error();
            return back();
        }
        flash('Pembayaran berhasil disimpan dan akan segera dikonfirmasi oleh operator')->success();
        return redirect()->route('wali.pembayaran.show', $pembayaran->id);
    }

    public function destroy($id){
        $pembayaran = Pembayaran::findOrFail($id);
        if ($pembayaran->tanggal_konfirmasi != null) {
            flash("Data pembayaran ini sudah dikonfirmasi, tidak bisa dihapus")->error();
            return back();
        }
        \Storage::delete($pembayaran->bukti_bayar);
        $pembayaran->delete();
        flash("Data Pembayaran berhasil dihapus")->success();
        return redirect()->route('wali.pembayaran.index');

    }
}
