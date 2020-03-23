@extends('layouts.app')

@section('title', '- dostawcy')

@section('content')
<table class="table table-striped text-center mt-4">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefon</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=0; ?>
        @foreach($suppliers as $supplier)
            <?php $x++; ?>
            <tr>
                <th scope="row">{{$x}}</th>
                <td>{{$supplier->nazwa}}</td>
                <td>{{$supplier->email}}</td>
                <td>{{$supplier->phone}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection