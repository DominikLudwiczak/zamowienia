@extends('layouts.app')

@section('title', '- wniosek')

@section('content')
    <div class="col-md-8 mx-auto mt-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col float-left">Wniosek urlopowy</div>
                    <div class="col float-right text-right">{{$user->name}}</div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                            <label for="start">Początek:</label>
                            <input class="form-control" type="date" id="start" value="{{$request->start}}" readonly/>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="end">Koniec:</label>
                        <input class="form-control" type="date" id="end" value="{{$request->end}}" readonly/>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label form="status">Status:</label>
                        <input type='text' id='status' class="form-control" value="<?php if($request->confirmed == 0){echo 'do rozpatrzenia';}elseif($request->confirmed == 1){echo 'przyjęty';}else{echo 'odrzucony';} ?>" readonly/>
                    </div>

                    <div class="row form-group col-md-6 text-center">
                        @if($request->confirmed == 0)
                            <div class="col-md-6"><label style="opacity: 0; visibility: hidden;">label</label><br/><a href="#" class="btn btn-danger">Odrzuć</a></div>
                            <div class="col-md-6"><label style="opacity: 0; visibility: hidden;">label</label><br/><a href="#" class="btn btn-success">Przyjmij</a></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                {{date('d-m-Y H:i:s', strtotime($request->created_at))}}
            </div>
        </div>
        <a href="{{ URL::previous() }}" class="btn btn-primary mt-3">Cofnij</a>
    </div>
@endsection