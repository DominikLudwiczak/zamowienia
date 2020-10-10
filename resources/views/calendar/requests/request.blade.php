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
                <div class="row text-center">
                    @if($request->confirmed == 0)
                        <div class="col-md-6">odrzuć</div>
                        <div class="col-md-6">przyjmij</div>
                    @endif
                </div>
            </div>
            <div class="card-footer text-center">
                {{date('d-m-Y H:i:s', strtotime($request->created_at))}}
            </div>
        </div>
        <a href="{{ URL::previous() }}" class="btn btn-primary mt-3">Cofnij</a>
    </div>
@endsection