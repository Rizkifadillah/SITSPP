@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Bank Sekolah</h3>

                <div class="card-body">
                    <a href="{{ route('banksekolah.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Bank</a>
                    {{-- {!! Form::open(['route'=>'banksekolah.index', 'method'=>'GET']) !!}
                        <div class="input-group">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari Data" aria-label="cari nama" aria-describedby="button-addon2">
                            <button type="submit" class="btn btn-outline-primary" id="button-addon2">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    {!! Form::close() !!} --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bank</th>
                                    <th>Kode Transfer</th>
                                    <th>Pemilik Rekening</th>
                                    <th>Nomor Rekening</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_bank }}</td>
                                        {{-- menggunakan traits --}}
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->pemilik_rekening }}</td>
                                        <td>{{ $item->no_rekening }}</td>
                                        {{-- menggunakan helper --}}
                                        {{-- <td>{{ formatRupiah($item->jumlah, 'IDR') }}</td> --}}
                                        <td>
                                            {!! Form::open([
                                                'route'=>['banksekolah.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin ingin menghapus data?")'
                                            ]) !!}
                                                <a href="{{ route('banksekolah.edit',$item->id) }}" class="btn btn-warning btn-sm">
                                                  <i class="fa fa-edit"></i>  Edit
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
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
