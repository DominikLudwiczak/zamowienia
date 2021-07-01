@extends('layouts.app')

@section('title', '- święta')

@section('content')
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-10'>Święta w {{$year}} roku</h1>
    <select class="form-control col" onchange="yearChange(this.value)">
        @foreach($years as $row)
            @if($row == $year)
                <option value='{{$row}}' selected>{{$row}}</option>
            @else
                <option value='{{$row}}'>{{$row}}</option>
            @endif
        @endforeach
    </select>
</div>

<form action="{{ route('new_holiday') }}" class='pt-3'>
    <button class='btn btn-success float-right'>Dodaj święto</button>
</form>

<table class="table table-striped table-responsive-sm text-center table-hover">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Data</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(isset($_REQUEST['page']))
                $x = $_REQUEST['page']*15-15; 
            else
                $x=0;
        ?>
        @foreach($holidays as $holiday)
            <?php $x++; ?>
            <tr class='table-row' data-href="{{ route('holiday',['id' => $holiday->id]) }}" style="cursor: pointer;">
                <th scope="row">{{$x}}</th>
                <td>{{$holiday->name}}</td>
                <td>{{$holiday->date}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class='pagination'>{{$holidays->render()}}</div>
@endsection
<script>
    function yearChange(year)
    {
        location.replace(`/holidays/all/${year}`)
    }
</script>