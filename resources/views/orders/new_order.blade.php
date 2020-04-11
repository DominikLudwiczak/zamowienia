@extends('layouts.app')

@section('title', '- nowe zamówienie')

@section('content')
    <h1 class='pt-3 col-md-12 text-md-left text-center' style='text-decoration: underline;'>Nowe zamówienie</h1>
    <div class="d-flex p-3 col-sm-12 col-md-6 mx-auto">
        <select name='supplier' class="custom-select" onchange="selectRedirect(this.value)">
            @if(isset($products))
                <option value="{{session('supplier')->name ?? ''}}" selected>{{session('supplier')->name ?? 'Dostawca...'}}</option>
            @else
                <option value="" selected>Dostawca...</option>
            @endif
            @foreach($suppliers as $supplier)
                @if(isset($products))
                    @if($supplier->name != session('supplier')->name)
                        <option value="{{$supplier->name}}">{{$supplier->name}}</option>
                    @endif
                @else
                    <option value="{{$supplier->name}}">{{$supplier->name}}</option>
                @endif
            @endforeach
        </select>
    </div>
    @if(isset($products))
        <hr/>
        <div class='row align-items-center'>
            <h3 class='col-md-7'>{{session('supplier')->name ?? ''}}</h3>
            <div class='input-group col-md-5'>
                <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj">
            </div>
        </div>
        <form method="post" action="{{ route('new_order_confirm') }}">
            @csrf
            <table class="table table-striped text-center mt-4">
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
                                <?php
                                if(session('order'))
                                {
                                    $ammount = '';
                                    for($i=0; $i < count(session('order')); $i++)
                                        if(session('order')[$i]['name'] == $product->name)
                                            $ammount = session('order')[$i]['ammount'];
                                }
                                ?>
                            <td><div class='col-sm-12 col-md-4 mx-auto'><input type='number' name="product_{{$product->id}}" oninput="set_ammount({{$product->id}})" min="1" value="{{$ammount ?? ''}}" class='form-control'/></div></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class='row col float-right'>
                <a href="{{ route('orders') }}" class='btn btn-primary ml-auto'>Cofnij</a>
                <button class='btn btn-success float-right ml-2'>Dalej</button>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                var supplier = "{{session('supplier')->id}}";
                function fetch_search(query = '')
                {
                    $.ajax({
                        url:"{{route('orders_search_prod')}}",
                        method:'GET',
                        data:{query:query, var:supplier, type:'new_order'},
                        dataType: 'jsonp',
                        success:function(data)
                        {
                            $('tbody').html(data.table_data);
                        }
                    });
                }

                $(document).on('input', '#search', function(){
                    if($(this).val() == '')
                        window.location.replace("{{route('new_order', ['supplier_name' => session('supplier')->name])}}");
                    var query = $(this).val();
                    fetch_search(query);
                });
            });

            function set_ammount(id)
            {
                var ammount = document.getElementsByName('product_'+id)[0].value;
                $.ajax({
                    url:"{{route('setAmmount')}}",
                    method:'GET',
                    data:{id:id, ammount:ammount},
                    dataType: 'jsonp',
                });
            }
        </script>
    @else
        <a href="{{ route('orders') }}" class='btn btn-primary float-right'>Cofnij</a>
    @endif
@endsection
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
