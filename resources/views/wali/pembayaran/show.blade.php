@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Data Pembayaran</h3>

                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-sm">
                            
                            <thead>
                                <tr>
                                    <td colspan="2" class="bg-primary text-white fw-bold">INFORMASI TAGIHAN</td>
                                </tr>
                                <tr>
                                    <td width="18%">No.</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>ID Tagihan</td>
                                    <td>: {{ $model->tagihan_id }}</td>
                                </tr>
                                <tr>
                                    <td>Item Tagihan.</td>
                                    <td>
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nama Biaya</th>
                                                <th>Jumlah</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($model->tagihan->tagihanDetails as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_biaya }}</td>
                                                        <td>{{ formatRupiahHelper($item->jumlah_biaya) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Tagihan</td>
                                    <td>: {{ formatRupiahHelper($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                </tr>
                                <tr class="mt-2">
                                    <td colspan="2" class="bg-primary text-white fw-bold">INFORMASI SISWA</td>
                                </tr>
                                <tr>
                                    <td>Nama Siswa</td>
                                    <td>: {{ ucwords($model->tagihan->siswa->nama) }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Wali</td>
                                    <td>: {{ ucwords($model->tagihan->siswa->wali->name) }}</td>
                                </tr>

                                @if ($model->metode_pembayaran != 'manual')
                                    
                                    <tr class="mt-2">
                                        <td colspan="2" class="bg-primary text-white fw-bold">INFORMASI BANK PENGIRIM</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Pengirim</td>
                                        <td>: {{ $model->waliBank->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->waliBank->no_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pemilik Rekening</td>
                                        <td>: {{ ucwords($model->waliBank->pemilik_rekening) }}</td>
                                    </tr>
                                    <tr class="mt-2">
                                        <td colspan="2" class="bg-primary text-white fw-bold">INFORMASI BANK TUJUAN</td>
                                    </tr>                                <tr>
                                        <td>Bank Tujuan</td>
                                        <td>: {{ $model->banksekolah->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $model->banksekolah->no_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td>
                                        <td>: {{ ucwords($model->banksekolah->pemilik_rekening) }}</td>
                                    </tr>
                                @else
                                    
                                @endif
                                <tr class="mt-2">
                                    <td colspan="2" class="bg-primary text-white fw-bold">INFORMASI PEMBAYARAN</td>
                                </tr>

                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>: {{ ucwords($model->metode_pembayaran) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembayaran</td>
                                    <td>: {{ $model->tanggal_bayar->translatedFormat('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Total Tagihan</td>
                                    <td>: {{ formatRupiahHelper($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Yang Dibayar</td>
                                    <td>: {{ formatRupiahHelper($model->jumlah_dibayar) }}</td>
                                </tr>
                                <tr>
                                    <td>Bukti Pembayaran</td>
                                    <td>: 
                                        {{-- <a href="#" 
                                            onclick="popupCenter({url:'{{ \Storage::url($model->bukti_bayar) }}', 'title: Bukti Pembayaran', w: 900, h: 500})"
                                            class="btn btn-sm btn-info">
                                            Lihat Pembayaran
                                        </a>     --}}
                                        <button class="btn btn-primary btn-sm" onclick="OpenPopupCenter('{{ \Storage::url($model->bukti_bayar) }}', 'TEST!?', 800, 600);">Lihat Bukti Pembayaran</button>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Konfirmasi</td>
                                    <td>: {{ ucwords($model->statusKonfirmasi) }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: {{ ($model->tagihan->getStatusTagihanWali()) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Konfirmasi</td>
                                    <td>: {{ optional($model->tanggal_konfirmasi)->translatedFormat('d M Y H:i') }}</td>
                                </tr>
                            </thead>
                        </table>
                        @if ($model->tanggal_konfirmasi == null)
                            {!! Form::open([
                                'route'=>['wali.pembayaran.destroy', $model->id],
                                'method'=>'DELETE',
                                'onsubmit'=>'return confirm("Yakin ingin menghapus data pembayaran ini?")'
                            ]) !!}
                                {{-- {!! Form::submit("Hapus", ['class'=>'btn btn-danger btn-sm']) !!} --}}
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>Batalkan Konfirmasi Pembayaran Ini
                                </button>
                            {!! Form::close() !!}
                        @else
                            <div class="alert alert-info" role="alert">
                                    TAGIHAN INI SUDAH LUNAS
                            </div>
                        @endif
                        
                        {{-- {!! $model->links() !!} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
