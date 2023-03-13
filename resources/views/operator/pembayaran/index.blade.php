@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Pembayaran</h3>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 p-2">
                            {!! Form::open(['route'=>'pembayaran.index', 'method'=>'GET']) !!}
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        {!! Form::selectRange('tahun', '2022', date('Y')+1, request('tahun'), ['class'=> 'form-control']) !!}
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary" type="submit">
                                            Tampil
                                        </button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nisn</th>
                                    <th>Nama</th>
                                    <th>Nama Wali</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status Konfirmasi</th>
                                    <th>Tanggal Konfirmasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->siswa->nisn }}</td>
                                        <td>{{ ucwords($item->tagihan->siswa->nama) }}</td>
                                        <td>{{ ucwords($item->wali->name) }}</td>
                                        {{-- menggunakan traits --}}
                                        {{-- <td>{{ $item->formatRupiah('jumlah') }}</td> --}}
                                        {{-- menggunakan helper --}}
                                        {{-- <td>{{ formatRupiahHelper($item->jumlah_biaya, 'IDR') }}</td> --}}
                                        <td>{{ ucwords($item->metode_pembayaran) }}</td>
                                        <td>{{ $item->statusKonfirmasi }}</td>
                                        <td>{{ $item->tanggal_konfirmasi ?? 'Belum Konfirmasi' }}</td>
                                        {{-- <td>{{ $item->status }}</td> --}}
                                        
                                        <td>
                                            {!! Form::open([
                                                'route'=>['pembayaran.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin ingin menghapus data?")'
                                            ]) !!}
                                                <a 
                                                    href="{{ route('pembayaran.show',$item->id) }}" 
                                                    class="btn btn-info btn-sm">
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
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
