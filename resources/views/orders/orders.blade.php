@extends('layouts.app')

@section('title', '- zamówienia')

@section('content')
<div class='row align-items-center pt-3'>
    <h1 style='text-decoration: underline;' class='col-md-7'>Zamówienia</h1>
    <div class='input-group col-md-5'>
        <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj">
    </div>
</div>
<form action="{{ route('new_order', ['supplier_name' => session('supplier')->name ?? '']) }}" class='pt-3'>
    <button class='btn btn-success float-right'>Stwórz nowe</button>
</form>

<table class="table table-striped text-center table-hover">
    <thead class='thead-dark'>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Dostawca</th>
            <th scope="col">Składający</th>
            <th scope="col">Data</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if($_REQUEST)
                $x = $_REQUEST['page']*15-15; 
            else
                $x=0;
        ?>
        @for($i=0; $i < count($orders); $i++)
            <?php $x++; ?>
            <tr class='table-row' data-href="{{ route('order_details',['order_id' => $orders[$i]['order_id']]) }}">
                <th scope="row">{{$x}}</th>
                <td>{{$orders[$i]['supplier']}}</td>
                <td>{{$orders[$i]['user']}}</td>
                <td>{{$orders[$i]['created_at']}}</td>
            </tr>
        @endfor
    </tbody>
</table>
<div class='pagination'>{{$paginate->render()}}</div>
@endsection
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        function fetch_search(query = '')
        {
            $.ajax({
                url:"{{route('orders_search')}}",
                method:'GET',
                data:{query:query},
                dataType: 'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                    $('#pagination').hide();
                }
            });
        }
        $(document).on('input', '#search', function(){
            if($(this).val() == '')
                window.location.replace("{{route('orders')}}");
            var query = $(this).val();
            fetch_search(query);
        });
    });
</script>