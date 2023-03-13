@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Wali Murid</h3>

                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <img src="{{ \Storage::url($wali->foto ?? 'images/no-image.png') }}" alt="img" width="150"> --}}
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="15%">ID</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>NAMA</td>
                                    <td>: {{ $model->name }}</td>
                                </tr>
                                <tr>
                                    <td>EMAIL</td>
                                    <td>: {{ $model->email }}</td>
                                </tr>
                                <tr>
                                    <td>NO.HP</td>
                                    <td>: {{ $model->nohp }}</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL BUAT</td>
                                    <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL BUAT</td>
                                    <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </thead>
                        </table>

                        <h4 class="my-3">Tambah Data Anak</h4>
                        {!! Form::open(['route'=>'walisiswa.store', 'method'=>'POST']) !!}
                        {!! Form::hidden('wali_id', $model->id, []) !!}
                            <div class="form-group">
                                {!! Form::select('siswa_id', $siswa, null, ['class' => 'form-control select2','placeholder'=> 'Pilih Siswa']) !!}
                                <button class="btn btn-outline-primary btn-sm my-3" type="submit">Tambah</button>
                            </div>
                        {!! Form::close() !!}
                        <h4 class="my-3">Data Anak</h4>
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nisn</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model->siswa as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route'=>['walisiswa.update', $item->id],
                                                'method'=>'PUT',
                                                'onsubmit'=>'return confirm("Yakin ingin menghapus data?")'
                                            ]) !!}
                                                {{-- {!! Form::submit("Hapus", ['class'=>'btn btn-danger btn-sm']) !!} --}}
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>Hapus
                                                </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
