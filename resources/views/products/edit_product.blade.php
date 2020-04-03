@extends('layouts.app')

@section('title', '- nowy produkt')

@section('content')
<h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Edycja produktu</h1>
    <div class='col-md-8 offset-md-2'>
        <div class='card'>
            <div class='card-header'>
                Edycja produktu
            </div>
            <div class='card-body'>
                <form method="post" action="{{ route('edit_product_save', ['id' => $product->id]) }}" class='col-md-6 offset-md-3'>
                @csrf
                    <select name='dostawca' class="custom-select">
                        @foreach($suppliers as $supplier)
                            @if($supplier->id == $product->supplier_id)
                                <option value="{{$supplier->id}}" selected>{{$supplier->name}}</option>
                            @else
                                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa produktu" name="nazwa" value="{{$product->name}}"/>
                    </div>
                    <button class='btn btn-success float-right ml-2'>Zapisz</button>
                    <a href="{{ route('products') }}" class='btn btn-primary float-right'>Cofnij</a>
                </form>
            </div>
        </div>
    </div>
@endsection