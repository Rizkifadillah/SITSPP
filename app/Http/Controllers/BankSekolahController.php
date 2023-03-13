<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah as Model;
use App\Http\Requests\StoreBankSekolahRequest;
use App\Http\Requests\UpdateBankSekolahRequest;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // serach
        // if ($request->filled('q')) {
            // kalau ada q
            // $models = Model::with('user')->search($request->q)->paginate(10);
        // }else{
            // kalau tidak ada q
            $models = Model::latest()->paginate(10);
        // }
        
        return view('operator.bank_sekolah.index', compact('models'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => 'banksekolah.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA BIAYA',
            'listbank' => Bank::pluck('nama_bank','id')
        ];
        return view('operator.bank_sekolah.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBankSekolahRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankSekolahRequest $request)
    {
        $requestData = $request->validated();
        $bank = Bank::find($request['bank_id']);
        unset($requestData['bank_id']);
        $requestData['kode'] = $bank->sandi_bank;
        $requestData['nama_bank'] = $bank->nama_bank;
        // dd($requestData);
        Model::create($requestData);
        flash('Data berhasil disimpan');
        return redirect()->route('banksekolah.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankSekolah  $bankSekolah
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('operator.bank_sekolah.show',[
            'model' => Model::findOrFail($id),
            'title' => 'Detail Bank'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankSekolah  $bankSekolah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => \App\Models\BankSekolah::findOrFail($id),
            'method' => 'PUT',
            'route' => ['banksekolah.update',$id],
            'button' => 'UBAH',
            'title' => 'FORM DATA BANK SEKOLAH',
            // 'listbank' => [Bank::]
            // 'wali' => User::where('akses','wali')->pluck('name','id')

        ];
        return view('operator.bank_sekolah.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankSekolahRequest  $request
     * @param  \App\Models\BankSekolah  $bankSekolah
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankSekolahRequest $request, $id)
    {
        $requestData = $request->validated();
        $model = Model::findOrFail($id);
        
        // $requestData['user_id'] = Auth::user()->id;
        $model->fill($requestData);
        $model->save();
        flash('Data berhasil diupdate');
        return redirect()->route('banksekolah.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankSekolah  $bankSekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
