@extends('layouts.app')

@section('title', '- nowy produkt')

@section('content')
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Dodawanie produktu</h1>
    <div class='col-md-8 offset-md-2'>
        <div class='card'>
            <div class='card-header'>
                Nowy produkt
            </div>
            <div class='card-body'>
                <form method="post" action="{{ route('add_product') }}" class='col-md-6 offset-md-3'>
                @csrf
                    <select value="default" name='dostawca' class="custom-select">
                        <option selected>Dostawca...</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                        @endforeach
                    </select>
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">nazwa</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa produktu" name="nazwa" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <button class='btn btn-success float-right ml-2'>Dodaj</button>
                    <a href="{{ route('products') }}" class='btn btn-primary float-right'>Cofnij</a>
                </form>
            </div>
        </div>
    </div>
@endsection