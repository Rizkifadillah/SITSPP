@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- <div class="card">
                <h3 class="card-header">DATA TAGIHAN SISWA {{ strtoupper($siswa->nama) }}</h3>

                <div class="card-body">
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
            </div> --}}
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">TAGIHAN SPP {{ strtoupper($siswa->nama) }}</h5>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 col-sm-12">
                                <table class="table table-hover table-sm table-borderless">
                                    <tr>
                                        <td rowspan="8" width="100" class="align-top">
                                            <img src="{{ \Storage::url($siswa->foto) }}" alt="{{ $siswa->nama }}" width="100px">
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
                                    <tr>
                                        <td>Jurusan</td>
                                        <td> : {{ $siswa->jurusan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td> : {{ $siswa->kelas }}</td>
                                    </tr>
                                    <tr>
                                        <td>Angkatan</td>
                                        <td> : {{ $siswa->angkatan }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <table class="table table-hover table-sm table-borderless">
                                   
                                    <tr>
                                        <td>No. Tagihan</td>
                                        <td> : #USHJ{{ $tagihan->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jurusan</td>
                                        <td> : {{ $tagihan->tanggal_tagihan->translatedFormat('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td> : {{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Pembayaran</td>
                                        <td> : {{ $tagihan->getStatusTagihanWali() }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="" target="blank"><i class="fa fa-file-pdf"></i> Cetak Invoice Tagihan</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                    </div>
                    {{-- Data Tagihan {{$periode}} --}}
                    <table class="table table-hover table-sm table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <td width="1%">No</td>
                                <td>Nama Taihan</td>
                                <td class="text-end">Jumlah Tagihan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->tagihanDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_biaya }}</td>
                                    <td class="text-end">{{ formatRupiahHelper($item->jumlah_biaya) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center fw-bold">Total Pembayaran</td>
                                <td class="text-end fw-bold">{{ formatRupiahHelper($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="alert alert-secondary mt-4" role="alert">
                        Pembayaran Bisa dilakukan dengan cara langsung ke Operator sekolah atau di transfer melalui bank milik sekolah berikut:
                        <br>
                        <u><i>Jangan melakukan transfer selain ke Rekening yang terdaftar dibawah ini.</i></u>
                        <br>
                        Silahkan lihat tata cara melakukan pembayaran melalui <a href="">ATM</a> atau <a href="">Internet Banking</a>
                        <br>
                        Setelah melakukan pembayaran, silahkan upload bukti pembayaran melalui tompol konfirmasi yang ada dibawah ini:
                    </div>
                    <ul>
                        <li><a href="">Lihat Cara Pembayaran Melalui ATM</a></li>
                        <li><a href="">Lihat Cara Pembayaran Melalui Internet Banking</a></li>
                    </ul>
                    <div class="row">
                        @foreach ($bankSekolah as $itemBank)
                            <div class="col-md-6 text-info">
                                <div class="alert alert-info">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td width="40%">Bank Tujuan</td>
                                                <td>: {{ $itemBank->nama_bank }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>: {{ $itemBank->no_rekening }}</td>
                                            </tr>
                                            <tr>
                                                <td>Atas Nama</td>
                                                <td>: {{ $itemBank->pemilik_rekening }}</td>
                                            </tr>
    
                                        </tbody>
                                    </table>
                                    <a href="{{ route('wali.pembayaran.create',[
                                        'tagihan_id' => $tagihan->id,
                                        'bank_sekolah_id' => $itemBank->id
                                    ]) }}" class="btn btn-info btn-sm mt-3">Konfirmasi Pembayaran</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-7"> --}}
            {{-- <div class="card">

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
            </div> --}}
        {{-- </div> --}}
    </div>
@endsection
