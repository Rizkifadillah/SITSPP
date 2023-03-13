<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // where tidak sama dengan wali
        $users = Model::where('akses', 'wali')->latest()->paginate(10);
        return view('operator.wali.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new \App\Models\User(),
            'method' => 'POST',
            'route' => 'wali.store',
            'button' => 'SIMPAN'
        ];
        return view('operator.wali.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'nohp' => 'required|unique:users,nohp',
            'password' => 'required'
        ]);
        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['email_verified_at'] = now();
        $requestData['nohp_verified_at'] = now();
        $requestData['akses'] = 'wali';
        Model::create($requestData);
        flash('Data berhasil disimpan');
        return redirect()->route('wali.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $siswa = \App\Models\Siswa::whereNotIn('wali_id', [$id])->pluck('nama','id');
        // dd($siswa);

        // $wali = Model::wali()->where('id',$id)->firstOrFail();
        return view('operator.wali.show',[
            // 'siswa' => \App\Models\Siswa::pluck('nama','id'),
            // 'siswa' => DB::table('siswas')->whereNotIn('wali_id',[$id])->pluck('nama','id'),
            // 'siswa' => \App\Models\Siswa::whereNotIn('wali_id',[$id])->pluck('nama','id'),
            'siswa' => \App\Models\Siswa::where('wali_id', null)->pluck('nama','id'),
            'model' => Model::with('siswa')->wali()->where('id',$id)->firstOrFail(),
            'title' => "Detail Data Wali Murid"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => \App\Models\User::findOrFail($id),
            'method' => 'PUT',
            'route' => ['wali.update',$id],
            'button' => 'UBAH'
        ];
        return view('operator.wali.form',$data);    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'nohp' => 'required|unique:users,nohp,'.$id,
            'akses' => 'nullable',
            'password' => 'nullable',
            'email_verified_at' => 'nullable',
            'nohp_verified_at' => 'nullable'
        ]);
        $model = Model::findOrFail($id);
        if ($requestData['password']  == "") {
            unset($requestData['password']);
        }else{
            $requestData['password'] = bcrypt($requestData['password']);
        }
        $model->fill($requestData);
        $model->save();
        // $requestData['email_verified_at'] = now();
        // $requestData['nohp_verified_at'] = now();
        // Model::create($requestData);
        flash('Data berhasil diupdate');
        return redirect()->route('wali.index');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::where('akses', 'wali')->findOrFail($id);
        if($model->id == 1 || $id == Auth::user()->id){
            flash('Data tidak bisa dihapus')->error();
            return back();
        }
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
