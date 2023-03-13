@extends('layouts.app_sneat_wali')
@section('js')
    <script>
        $(function(){
                $("#checkboxtoggle").click(function(){
                    if ($(this).is(":checked")) {
                        $("#pilihan_bank").fadeOut()
                        $("#form_bank_pengirim").fadeIn()
                    } else {
                        $("#pilihan_bank").fadeIn()
                        $("#form_bank_pengirim").fadeOut()
                    }
                })
            })
        $(document).ready(function() {
            @if (count($listWaliBank) >= 1) 
                        $("#form_bank_pengirim").hide()
            @else 
                        $("#form_bank_pengirim").show()
            @endif
            $("#pilih_bank").change(function(e) {
                e.preventDefault();
                var bankId = $(this).find(":selected").val();
                window.location.href = "{!! $url !!}&bank_sekolah_id=" + bankId;
            })
        })
    </script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Konfirmasi Pembayaran</h3>

                <div class="divider text">
                    <div class="divider-text "><i class="fa fa-info-circle"></i> INFORMASI REKENING PENGIRIM</div>
                </div>
                
                <div class="alert alert-info mx-4">
                    Informasi ini dibutuhkan agar operator sekolah dapat memverifikasi pembayaran yang dilakukan olek wali
                    murid melalui bank.
                </div>
                <div class="card-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'files'=>true]) !!}
                    {!! Form::hidden('tagihan_id', request('tagihan_id'),[]) !!}

                    @if (count($listWaliBank) >=1)
                        <div class="form-group" id="pilihan_bank">
                            <label for="wali_bank_id">Nama Bank Pengirim</label>
                            {!! Form::select('wali_bank_id', $listWaliBank, null, [
                                'class' => 'form-control select2',
                                'placeholder' => 'Pilih Bank Transfer',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('wali_bank_id') }}</span>
                        </div>
                        <div class="form-check mt-3" >
                            {!! Form::checkbox('pilihan_bank', 1, false, ['class'=>'form-check-input', 'id'=>'checkboxtoggle']) !!}
                            <label for="checkboxtoggle" class="form-check-label">
                                Saya punya rekening baru
                            </label>
                        </div>
                        
                    @endif
                    

                    <div id="form_bank_pengirim" class="mt-3">

                        <div class="form-group">
                            <label for="nama_bank_pengirim">Nama Bank Pengirim</label>
                            {!! Form::select('bank_id', $listBank, null, [
                                'class' => 'form-control select2',
                                'placeholder' => 'Pilih Bank Transfer',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                        </div>
                        <div class="form-group mt-2">
                            <label for="pemilik_rekening">Nama Pemilik Rekening</label>
                            {!! Form::text('pemilik_rekening', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('pemilik_rekening') }}</span>
                        </div>
                        <div class="form-group mt-2">
                            <label for="no_rekening">No. Rekening Bank Pengirim</label>
                            {!! Form::text('no_rekening', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('no_rekening') }}</span>
                        </div>
    
                        <div class="form-check mt-3">
                            {!! Form::checkbox('simpan_data_rekening', 1, true, ['class'=>'form-check-input', 'id'=>'checkboxtoggle']) !!}
                            <label for="defaultCheck3" class="form-check-label">
                                Simpan Data ini untuk pembayaran selanjutnya
                            </label>
                        </div>
                    </div>

                    <div class="divider text mt-4">
                        <div class="divider-text "><i class="fa fa-info-circle"></i> INFORMASI BANK TUJUAN</div>
                    </div>

                    <div class="form-group mt-2">
                        <label for="bank_sekolah_id">Bank Tujuan Pembayaran</label>
                        {!! Form::select('bank_sekolah_id', $listBankSekolah, request('bank_sekolah_id'), [
                            'class' => 'form-control',
                            'placeholder' => 'Pilih Bank Transfer',
                            'id' => 'pilih_bank',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('bank_sekolah_id') }}</span>
                    </div>
                    @if (request('bank_sekolah_id') != '')
                        <div class="alert alert-info my-2" role="alert">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td width="20%">Bank Tujuan</td>
                                        <td>: {{ $bankYangDipilih->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $bankYangDipilih->no_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td>
                                        <td>: {{ $bankYangDipilih->pemilik_rekening }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="divider text mt-4">
                        <div class="divider-text "><i class="fa fa-info-circle"></i> INFORMASI PEMBAYARAN</div>
                    </div>


                    <div class="form-group mt-3">
                        <label for="tanggal_bayar">Tanggal Bayar</label>
                        {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? date('Y-m-d'), ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jumlah_dibayar">Jumlah Yang Dibayarkan</label>
                        {!! Form::text('jumlah_dibayar', $tagihan->tagihanDetails->sum('jumlah_biaya'), ['class' => 'form-control rupiah']) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="bukti_bayar">Upload Bukti Pembayaran <span class="text-danger">(File harus jpg, jpeg, png. Ukuran file max.5MB)</span></label>
                        {!! Form::file('bukti_bayar', ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                    </div>
                    {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
