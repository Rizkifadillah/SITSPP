@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">{{ $title }}</h3>

                <div class="card-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                        @if (request()->filled('parent_id'))
                            <h5>Info {{ $parentData->nama }}</h5>
                            {!! Form::hidden('parent_id', $parentData->id, []) !!}
                            <div class="container">
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th >Parent ID</th>
                                                <th>Nama Biaya</th>
                                                <th>Jumlah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($parentData->children as $item)
                                           <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ formatRupiahHelper($item->jumlah) }}</td>
                                                <td>
                                                   <a href="{{ route('delete-biaya.item',$item->id) }}" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Anda yakin ingin meghapus item tagihan ?')">
                                                    Hapus    
                                                </a>
                                                </td>
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h5 class="mt-3">Tambah Item Tagihan</h5>
                        @endif
                        <div class="form-group mt-3">
                            <label for="nama">Nama Biaya</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'autofocus']) !!}
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="jumlah">Jumlah / Nominal</label>
                            {!! Form::text('jumlah', null, ['class'=>'form-control rupiah']) !!}
                            <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                        </div>
                        {!! Form::submit($button, ['class'=> 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
