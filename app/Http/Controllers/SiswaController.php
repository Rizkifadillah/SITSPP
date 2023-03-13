<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Biaya;
use App\Models\Siswa as Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // serach
        if ($request->filled('q')) {
            // kalau ada q
            $siswas = Model::with('wali','user')->search($request->q)->paginate(10);
        }else{
            // kalau tidak ada q
            $siswas = Model::with('wali','user')->latest()->paginate(10);
        }
        
        return view('operator.siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama', 'id'),
            'model' => new Model(),
            'method' => 'POST',
            'route' => 'siswa.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA SISWA',
            'wali' => User::where('akses','wali')->pluck('name','id')
        ];
        return view('operator.siswa.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSiswaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiswaRequest $request)
    {
        $requestData = $request->validated();

        if($request->hasFile('foto')){
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        }
        $requestData['user_id'] = Auth::user()->id;
        Model::create($requestData);
        flash('Data berhasil disimpan');
        return redirect()->route('siswa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Model::findOrFail($id);
        return view('operator.siswa.show',[
            'model' => $model,
            'title' => 'Detail Siswa'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama', 'id'),
            'model' => \App\Models\Siswa::findOrFail($id),
            'method' => 'PUT',
            'route' => ['siswa.update',$id],
            'button' => 'UBAH',
            'title' => 'FORM DATA SISWA',
            'wali' => User::where('akses','wali')->pluck('name','id')

        ];
        return view('operator.siswa.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSiswaRequest  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiswaRequest $request, $id)
    {
        $requestData = $request->validated();
        $model = Model::findOrFail($id);
        
        if($request->hasFile('foto')){
            Storage::delete($model->foto);
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        }
        $requestData['user_id'] = Auth::user()->id;
        $model->fill($requestData);
        $model->save();
        flash('Data berhasil diupdate');
        return redirect()->route('siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
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
