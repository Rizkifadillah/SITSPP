@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Tagihan</h3>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 p-2">
                            <a href="{{ route('tagihan.create') }}" class="btn btn-primary">Tambah Tagihan</a>
                        </div>
                        <div class="col-md-6 p-2">
                            {!! Form::open(['route'=>'tagihan.index', 'method'=>'GET']) !!}
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
                                    <th>Tanggal tagihan</th>
                                    <th>Total Tagihan</th>
                                    <th>Created By</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihans as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nisn }}</td>
                                        <td>{{ $item->siswa->nama }}</td>
                                        {{-- menggunakan traits --}}
                                        {{-- <td>{{ $item->formatRupiah('jumlah') }}</td> --}}
                                        {{-- menggunakan helper --}}
                                        {{-- <td>{{ formatRupiahHelper($item->jumlah_biaya, 'IDR') }}</td> --}}
                                        <td>{{ $item->tanggal_tagihan->translatedFormat('l d-F-Y') }}</td>
                                        <td>{{ $item->tagihanDetails->sum('jumlah_biaya') }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        
                                        <td>
                                            {!! Form::open([
                                                'route'=>['tagihan.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin ingin menghapus data?")'
                                            ]) !!}
                                                <a 
                                                    href="{{ route('tagihan.show',[
                                                        $item->id,
                                                        'siswa_id' => $item->siswa_id,
                                                        'bulan' => $item->tanggal_tagihan->format('m'),
                                                        'tahun' => $item->tanggal_tagihan->format('Y'),
                                                        ]) }}" 
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
                        {!! $tagihans->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
