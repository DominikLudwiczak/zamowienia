@extends('layouts.app')

@section('title', '- szczegóły zamówienia')

@section('content')
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>{{$supplier}} - {{$order_id}}</h1>
        <div class='input-group col-md-5 pb-3'>
            <input class="form-control" type="search" placeholder="Szukaj" aria-label="Szukaj">
            <button class="btn btn-outline-success" type="submit">Szukaj</button>
        </div>
    </div>

    <table class="table table-striped text-center">
        <thead class='thead-dark'>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nazwa</th>
                <th scope="col">Ilość</th>
            </tr>
        </thead>
        <tbody>
            <?php $x=0; ?>
            @for($i=0; $i < count($products); $i++)
                <?php $x++; ?>
                <tr>
                    <th scope="row">{{$x}}</th>
                    <td>{{$products[$i]['name']}}</td>
                    <td>{{$products[$i]['ammount']}}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <a href="{{ route('orders') }}" class='btn btn-primary float-right'>Cofnij</a>
@endsection