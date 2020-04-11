@extends('layouts.app')

@section('title', '- potwierdzenie zamówienia')

@section('content')
    @if(count(session('order')) > 0)
        <div class='row align-items-center pt-3 pb-3'>
            <h1 style='text-decoration: underline;' class='col-md-7 text-center text-md-left'>Potwierdzenie zamówienia</h1>
            <div class='input-group col-md-5'>
                <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj">
            </div>
        </div>
        <h3 class='text-center text-md-left'>{{session('supplier')->name}}</h3>
        <table class="table table-striped text-center">
            <thead class='thead-dark'>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Ilość</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <form method='post' action="{{ route('new_order_send') }}" id ='send'>
        @csrf
            <div class="row col float-right pb-3"> 
                <textarea class='form-control col-md-6 ml-auto' rows='3' name='msg' style="resize:none;" placeholder='Dodatkowe uwagi dla dostawcy'>@if(session('msg')) {{session('msg')}} @endif</textarea>
            </div>
        </form>
        <div class='row col float-right'>
            <button class='btn btn-primary ml-auto' name='supplier' value="{{session('supplier')->name}}" onclick="selectRedirect(this.value)">Cofnij</button>
            <button class='btn btn-success ml-2' form='send'>Wyślij</button>
        </div>
    @endif
@endsection
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        fetch_search();
        function fetch_search(query = '')
        {
            $.ajax({
                url:"{{route('confirm_search')}}",
                method:'GET',
                data:{query:query},
                dataType: 'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                }
            });
        }
        $(document).on('input', '#search', function(){
            var query = $(this).val();
            fetch_search(query);
        });
    });
</script>
