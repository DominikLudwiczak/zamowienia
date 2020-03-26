@extends('layouts.app')

@section('title', '- nowe zamówienie')

@section('content')
    <h1 class='pt-3 col-md-12 text-md-left text-center' style='text-decoration: underline;'>Nowe zamówienie</h1>
    <form method='post' action="{{ route('new_order_choosen') }}" id='new_order_choosen'>
    @csrf
        <div class="d-flex p-3 col-sm-12 col-md-6 mx-auto">
            <select name='supplier' class="custom-select" onchange="test()">
                <option value="{{session('supplier')->id ?? ''}}" selected>{{session('supplier')->name ?? 'Dostawca...'}}</option>
                @foreach($suppliers as $supplier)
                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                @endforeach
            </select>
        </div>
    </form>
    @if(isset($products))
        <hr/>
        <div class='row align-items-center'>
            <h3 class='col-md-7'>{{session('supplier')->name ?? ''}}</h3>
            <div class='input-group col-md-5'>
                <input class="form-control" type="search" placeholder="Szukaj" aria-label="Szukaj">
                <button class="btn btn-outline-success" type="submit">Szukaj</button>
            </div>
        </div>
        <form method="post" action="{{ route('new_order_confirm') }}">
            @csrf
            <table class="table table-striped text-center mt-4">
                <thead class='thead-dark'>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Ilość</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $x=0; ?>
                    @foreach($products as $product)
                        <?php $x++; ?>
                        <tr>
                            <th scope="row">{{$x}}</th>
                            <td>{{$product->name}}</td>
                                <?php
                                if(session('order'))
                                {
                                    $ammount = '';
                                    for($i=0; $i < count(session('order')); $i++)
                                        if(session('order')[$i]['name'] == $product->name)
                                            $ammount = session('order')[$i]['ammount'];
                                }
                                ?>
                            <td><div class='col-sm-12 col-md-4 mx-auto'><input type='number' name="product_{{$product->id}}" value="{{$ammount ?? ''}}"class='form-control'/></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class='row col float-right'>
                <a href="{{ route('orders') }}" class='btn btn-primary ml-auto'>Cofnij</a>
                <button class='btn btn-success float-right ml-2'>Dalej</button>
            </div>
        </form>
    @else
        <a href="{{ route('orders') }}" class='btn btn-primary float-right'>Cofnij</a>
    @endif
@endsection