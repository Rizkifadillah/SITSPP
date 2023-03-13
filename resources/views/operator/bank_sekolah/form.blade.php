@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">{{ $title }}</h3>

                <div class="card-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}
                        
                        <div class="form-group mt-3">
                            <label for="nama">Nama Bank</label>
                            {!! Form::select('bank_id', $listbank,null, ['class'=>'form-control select2']) !!}
                            <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="pemilik_rekening">Pemilik Rekening</label>
                            {!! Form::text('pemilik_rekening', null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('pemilik_rekening') }}</span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="no_rekening">Nomor Rekening</label>
                            {!! Form::text('no_rekening', null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('no_rekening') }}</span>
                        </div>
                        {!! Form::submit($button, ['class'=> 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
