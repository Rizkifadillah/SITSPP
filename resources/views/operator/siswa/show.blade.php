@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h3 class="card-header">Data Siswa</h3>
    
                    <div class="card-body">
                        <div class="table-responsive">
                            <img src="{{ \Storage::url($model->foto ?? 'images/no-image.png') }}" alt="img" width="150">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <td width="35%">ID</td>
                                        <td>: {{ $model->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>NAMA</td>
                                        <td>: {{ $model->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>NISN</td>
                                        <td>: {{ $model->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <td>PROGRAM STUDI</td>
                                        <td>: {{ $model->jurusan }}</td>
                                    </tr>
                                    <tr>
                                        <td>ANGKATAN</td>
                                        <td>: {{ $model->angkatan }}</td>
                                    </tr>
                                    <tr>
                                        <td>KELAS</td>
                                        <td>: {{ $model->kelas }}</td>
                                    </tr>
                                    <tr>
                                        <td>TANGGAL BUAT</td>
                                        <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>TANGGAL BUAT</td>
                                        <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>DIBUAT OLAEH </td>
                                        <td>: {{ $model->user->name }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Tagihan</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Item Tagihan</th>
                                    <th>Jumlah Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model->biaya->children as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-end">{{ formatRupiahHelper($item->jumlah) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="2">TOTAL TAGIHAN</td>
                                <td class="text-end">{{ formatRupiahHelper($model->biaya->children->sum('jumlah')) }}</td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
