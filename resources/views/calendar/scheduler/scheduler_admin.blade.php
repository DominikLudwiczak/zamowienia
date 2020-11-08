@extends('layouts.app')

@section('title', '- grafik')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            Wybierz sklep
        </div>
        <div class="card-body mx-auto">
            @foreach($shops as $shop)
                <a class="btn btn-primary mb-2" href="{{route('scheduler_shop', ['id' => $shop->id])}}">{{$shop->name}}</a><br/>
            @endforeach
        </div>
    </div>
@endsection