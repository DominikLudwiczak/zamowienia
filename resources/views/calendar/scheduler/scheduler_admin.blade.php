@extends('layouts.app')

@section('title', '- grafik')

@section('content')
    @foreach($shops as $shop)
        {{$shop->name}}<br/>
    @endforeach
@endsection