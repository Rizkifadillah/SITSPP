@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Wali</h3>

                <div class="card-body">
                    <a href="{{ route('wali.create') }}" class="btn btn-primary btn-sm">Tambah Wali</a>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No.HP</th>
                                    <th>Email</th>
                                    <th>Akses</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->nohp }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->akses }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route'=>['user.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin ingin menghapus data?")'
                                            ]) !!}
                                                <a href="{{ route('wali.edit',$item->id) }}" class="btn btn-warning btn-sm">
                                                  <i class="fa fa-edit"></i>  Edit
                                                </a>
                                                <a href="{{ route('wali.show',$item->id) }}" class="btn btn-info btn-sm">
                                                  <i class="fa fa-eye"></i>  Detail
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
                        {!! $users->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
