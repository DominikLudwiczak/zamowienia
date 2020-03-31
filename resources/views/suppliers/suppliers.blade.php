@extends('layouts.app')

@section('title', '- dostawcy')

@section('content')
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-7'>Dostawcy</h1>
    <div class='input-group col-md-5'>
        <input class="form-control" type="search" placeholder="Szukaj" aria-label="Szukaj">
        <button class="btn btn-outline-success" type="submit">Szukaj</button>
    </div>
</div>
<form action="{{ route('new_supplier') }}" class='pt-3'>
    <button class='btn btn-success float-right'>Dodaj dostawcę</button>
</form>
<table class="table table-striped table-responsive-sm text-center mt-4">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefon</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($_REQUEST)
                $x = $_REQUEST['page']*15-15; 
            else
                $x=0;
        ?>
        @foreach($suppliers as $supplier)
            <?php $x++; ?>
            <tr>
                <th scope="row">{{$x}}</th>
                <td>{{$supplier->name}}</td>
                <td>{{$supplier->email}}</td>
                <td>{{$supplier->phone}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{$suppliers->render()}}
@endsection