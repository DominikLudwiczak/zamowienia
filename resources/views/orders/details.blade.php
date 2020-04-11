@extends('layouts.app')

@section('title', '- szczegóły zamówienia')

@section('content')
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>{{$supplier}} - {{$order_id}}</h1>
        <div class='input-group col-md-5 pb-3'>
            <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj">
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
            @foreach($products as $product)
                <?php $x++; ?>
                <tr>
                    <th scope="row">{{$x}}</th>
                    <td>{{$product->name}}</td>
                    <td>{{$product->ammount}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('orders') }}" class='btn btn-primary float-right'>Cofnij</a>
@endsection
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        var order_id = "{{$order_id}}";
        function fetch_search(query = '')
        {
            $.ajax({
                url:"{{route('orders_search_prod')}}",
                method:'GET',
                data:{query:query, var:order_id}, type:'details',
                dataType: 'jsonp',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                }
            });
        }
        $(document).on('input', '#search', function(){
            if($(this).val() == '')
                window.location.replace("{{route('order_details', ['order_id' => $order_id])}}");
            var query = $(this).val();
            fetch_search(query);
        });
    });
</script>
