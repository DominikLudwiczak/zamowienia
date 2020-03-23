@extends('layouts.app')

@section('title', '- produkty')

@section('content')
<table class="table table-striped text-center mt-4">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Dostawca</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=0; ?>
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
@endsection