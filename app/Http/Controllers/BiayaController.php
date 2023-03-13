<?php

namespace App\Http\Controllers;

use App\Models\Biaya as Model;
use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BiayaController extends Controller
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
            $biayas = Model::with('user')->whereNull('parent_id')->search($request->q)->paginate(10);
        }else{
            // kalau tidak ada q
            $biayas = Model::with('user')->whereNull('parent_id')->latest()->paginate(10);
        }
        
        return view('operator.biaya.index', compact('biayas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $biaya = new Model();
        if ($request->filled('parent_id')) {
            $biaya = Model::with('children')->findOrFail($request->parent_id);
        }
        $data = [
            'parentData' => $biaya,
            'model' => new Model(),
            'method' => 'POST',
            'route' => 'biaya.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA BIAYA'
        ];
        return view('operator.biaya.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBiayaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiayaRequest $request)
    {
        $requestData = $request->validated();
        // $requestData['user_id'] = Auth::user()->id;

        Model::create($requestData);
        flash('Data berhasil disimpan');
        // return redirect()->route('biaya.index');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => \App\Models\Biaya::findOrFail($id),
            'method' => 'PUT',
            'route' => ['biaya.update',$id],
            'button' => 'UBAH',
            'title' => 'FORM DATA BIAYA',
            // 'wali' => User::where('akses','wali')->pluck('name','id')

        ];
        return view('operator.biaya.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBiayaRequest  $request
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBiayaRequest $request, $id)
    {
        $requestData = $request->validated();
        $model = Model::findOrFail($id);
        
        // $requestData['user_id'] = Auth::user()->id;
        $model->fill($requestData);
        $model->save();
        flash('Data berhasil diupdate');
        return redirect()->route('biaya.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        if ($model->children->count() >= 1) {
            flash('Data tidak dapat dihapus karena masih memiliki item biaya. Hapus item biaya terlebih dahulu')->error();
            return back();
        }
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }

    public function deleteItem($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
