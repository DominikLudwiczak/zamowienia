@extends('layouts.app')

@section('title', '- zamówienia')

@section('content')
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-7'>Zamówienia</h1>
    <div class='input-group col-md-5'>
        <input class="form-control" type="search" placeholder="Szukaj" aria-label="Szukaj">
        <button class="btn btn-outline-success" type="submit">Szukaj</button>
    </div>
</div>
<form action="{{ route('new_order') }}" class='pt-3'>
    <button class='btn btn-success float-right'>Stwórz nowe</button>
</form>

<table class="table table-striped table-responsive-sm text-center">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Dostawca</th>
            <th scope="col">Składający</th>
            <th scope="col">Data</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=0; ?>
        @for($i=0; $i < count($orders); $i++)
            <?php $x++; ?>
            <tr>
                <th scope="row">{{$x}}</th>
                <td>{{$orders[$i]['supplier_id']}}</td>
                <td>{{$orders[$i]['user_id']}}</td>
                <td>{{$orders[$i]['created_at']}}</td>
            </tr>
        @endfor
    </tbody>
</table>
@endsection