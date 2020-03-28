@extends('layouts.app')

@section('title', '- szczegóły zamówienia')

@section('content')
    {{$order_id}}<br/>
    {{$supplier}}<br/><br/>

    @for($i=0; $i < count($products); $i++)
        {{$products[$i]['name']}}<br/>
    @endfor
@endsection