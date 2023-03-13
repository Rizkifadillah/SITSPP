@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Biaya</h3>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('biaya.create') }}" class="btn btn-primary btn-sm">Tambah Biaya</a>
                        </div>
                        <div class="col-md-6">
                            {!! Form::open(['route'=>'biaya.index', 'method'=>'GET']) !!}
                                <div class="input-group">
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari Data" aria-label="cari nama" aria-describedby="button-addon2">
                                    <button type="submit" class="btn btn-outline-primary" id="button-addon2">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Biaya</th>
                                    <th>Total Tagihan</th>
                                    <th>Created By</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($biayas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        {{-- menggunakan traits --}}
                                        <td>{{ formatRupiahHelper($item->total_tagihan) }}</td>
                                        {{-- menggunakan helper --}}
                                        {{-- <td>{{ formatRupiah($item->jumlah, 'IDR') }}</td> --}}
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route'=>['biaya.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin ingin menghapus data?")'
                                            ]) !!}
                                                <a href="{{ route('biaya.edit',$item->id) }}" class="btn btn-warning btn-sm">
                                                  <i class="fa fa-edit"></i>  Edit
                                                </a>
                                                <a href="{{ route('biaya.create',['parent_id'=>$item->id]) }}" class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i>  Items
                                                </a>
                                                {{-- {!! Form::submit("Hapus", ['class'=>'btn btn-danger btn-sm']) !!} --}}
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>Hapus
                                                </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $biayas->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
