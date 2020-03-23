@extends('layouts.app')

@section('title', '- zamówienia')

@section('content')
<table class="table table-striped text-center mt-4">
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