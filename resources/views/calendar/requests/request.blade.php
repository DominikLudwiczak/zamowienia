@extends('layouts.app')

@section('title', '- wniosek')

@section('content')
    <div class="col-md-8 mx-auto mt-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col float-left">Wniosek urlopowy</div>
                    <div class="col float-right text-right">{{$users->where('id', $request->user_id)->first()->name}}</div>
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

                    <div class="form-group col-md-6">
                        <label form="status">Wysłany przez:</label>
                        <input type='text' id='status' class="form-control" value="{{$users->where('id', $request->who_added)->first()->name}}" readonly/>
                    </div>
                </div>
                @if($request->confirmed == 0)
                    <form method='post' class='row col-md-12 text-center'>
                        @csrf
                        <input type='hidden' name='url' value="{{URL::previous()}}"/>
                        <div class="col-md-6"><label style="opacity: 0; visibility: hidden;">label</label><br/><button type='submit' name="status" value="denny" class="btn btn-danger">Odrzuć</button></div>
                        <div class="col-md-6"><label style="opacity: 0; visibility: hidden;">label</label><br/><button type='submit' name="status" value="allow" class="btn btn-success">Przyjmij</button></div>
                    </form>
                @else
                    <div class="row">
                        <div class="form-group col-md-6">
                            @if($request->confirmed == -1)
                                <label form="status">Odrzucony przez:</label>
                            @else
                                <label form="status">Przyjęty przez:</label>
                            @endif
                            <input type='text' id='status' class="form-control" value="{{$users->where('id', $request->who_conf)->first()->name}}" readonly/>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="last_update">Ostatnia aktualizacja:</label>
                            <input type="text" id='last_update' class="form-control" value="{{date('d-m-Y H:i:s', strtotime($request->updated_at))}}" readonly/>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer text-center">
                {{date('d-m-Y H:i:s', strtotime($request->created_at))}}
            </div>
        </div>
            <a href="{{ URL::previous() }}" class="btn btn-primary mt-3">Cofnij</a>
    </div>
@endsection