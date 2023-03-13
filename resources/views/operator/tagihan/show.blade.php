@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">DATA TAGIHAN SISWA {{ strtoupper($periode) }}</h3>

                <div class="card-body">
                    {{-- <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" width="180px"> --}}
                    <table class="table table-hover table-sm">
                        <tr>
                            <td rowspan="4" width="100">
                                <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" width="180px">
                            </td>
                        </tr>
                        <tr>
                            <td width="50">NISN</td>
                            <td> : {{ $siswa->nisn }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td> : {{ $siswa->nama }}</td>
                        </tr>
                        </tr>
                    </table>
                    <a href="{{ route('kartuspp.index',['siswa' => $siswa->id, 'tahun'=>request('tahun')]) }}" class="btn btn-primary mt-2 " target="blank"><i class="fa fa-file"></i>Kartu SPP {{ request('tahun') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header">DATA TAGIHAN {{ strtoupper($periode) }}</h5>
                <div class="card-body">
                    {{-- Data Tagihan {{$periode}} --}}
                    <table class="table table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Taihan</td>
                                <td>Jumlah Tagihan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->tagihanDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_biaya }}</td>
                                    <td>{{ formatRupiahHelper($item->jumlah_biaya) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total Pembayaran</td>
                                <td>{{ formatRupiahHelper($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <h5 class="card-header px-0">DATA PEMBAYARAN</h5>
                    <table class="table table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TANGGAL</th>
                                <th>JUMLAH</th>
                                <th>METODE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->pembayaran as $item)
                                <tr>
                                    <td width="1%">
                                        <a href="{{ route('kwitansipembayaran.show', $item->id) }}" target="blank"><i
                                                class="fa fa-print"></i></a>
                                    </td>
                                    <td>{{ $item->tanggal_bayar->translatedFormat('d/m/Y') }}</td>
                                    <td>{{ formatRupiahHelper($item->jumlah_dibayar) }}</td>
                                    <td>{{ $item->metode_pembayaran }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5 class="mt-3">Status Pembayaran : {{ strtoupper($tagihan->status) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">

                <h5 class="card-header">FORM PEMBAYARAN</h5>
                <div class="card-body">
                    {!! Form::model($model, ['route' => 'pembayaran.store', 'method' => 'POST']) !!}
                    {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}
                    <div class="form-group">
                        <label for="tanggal_bayar">Tanggal Pembayaran</label>
                        {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jumlah_dibayar">Jumlah Yang Dibayarkan</label>
                        {!! Form::text('jumlah_dibayar', null, ['class' => 'form-control rupiah']) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                    </div>
                    {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
