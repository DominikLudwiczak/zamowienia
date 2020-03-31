@extends('layouts.app')

@section('title', '- produkty')

@section('content')
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-7'>Produkty</h1>
    <div class='input-group col-md-5'>
        <input class="form-control" type="search" placeholder="Szukaj" aria-label="Szukaj">
        <button class="btn btn-outline-success" type="submit">Szukaj</button>
    </div>
</div>
<form action="{{ route('new_product') }}" class='pt-3'>
    <button class='btn btn-success float-right'>Dodaj produkt</button>
</form>
<table class="table table-striped text-center mt-4">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Dostawca</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($_REQUEST)
                $x = $_REQUEST['page']*15-15; 
            else
                $x=0;
        ?>
        @for($i=0; $i < count($products); $i++)
            <?php $x++; ?>
            <tr>
                <th scope="row">{{$x}}</th>
                <td>{{$products[$i]['name']}}</td>
                <td>{{$products[$i]['supplier_id']}}</td>
            </tr>
        @endfor
    </tbody>
</table>
{{$products->render()}}
@endsection