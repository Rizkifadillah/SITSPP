@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Siswa</h3>

                <div class="card-body">
                    <a href="{{ route('wali.siswa.create') }}" class="btn btn-primary btn-sm">Tambah Siswa</a>
                    {{-- {!! Form::open(['route'=>'siswa.index', 'method'=>'GET']) !!}
                        <div class="input-group">
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari Nama Siswa" aria-label="cari nama" aria-describedby="button-addon2">
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
                                    <th>Nama Wali</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Angkatan</th>
                                    <th>Created By</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->wali->name }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->jurusan }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            {{-- {!! Form::open([
                                                'route'=>['siswa.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin ingin menghapus data?")'
                                            ]) !!}
                                                <a href="{{ route('siswa.edit',$item->id) }}" class="btn btn-warning btn-sm">
                                                  <i class="fa fa-edit"></i>  Edit
                                                </a>
                                                <a href="{{ route('siswa.show',$item->id) }}" class="btn btn-info btn-sm mx-1">
                                                  <i class="fa fa-eye"></i>  Detail
                                                </a>
                                                {!! Form::submit("Hapus", ['class'=>'btn btn-danger btn-sm']) !!}
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>Hapus
                                                </button>
                                            {!! Form::close() !!} --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {!! $models->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
