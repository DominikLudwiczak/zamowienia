@extends('layouts.app')

@section('title', '- podumowanie')

@section('content')
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>Podsumowania</h1>
        <div class='input-group col-md-5'>
            <input class="form-control" type="search" placeholder="Szukaj" id='search' aria-label="Szukaj" autofocus>
        </div>
    </div>
    <table class="table table-responsive-sm table-striped table-hover text-center mx-auto mt-3">
        <thead class="thead-dark">
            <tr>
                <th scope="row">Nazwa</th>
                <th scope="row">Czas pracy (w tym miesiącu)</th>
                <th scope="row">Wykorzystany urlop (w tym roku)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class='table-row' data-href="{{ route('summary',['id' => $user[3]]) }}" style="cursor: pointer;">
                    <td>{{$user[0]}}</td>
                    <td>{{floor($user[1]/60) }} godzin {{ $user[1] - (floor($user[1]/60)*60)}} minut</td>
                    <td>{{$user[2]}} dni</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function(){
            function fetch_search(query = '')
            {
                $.ajax({
                    url:"{{route('summaries_search')}}",
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
                if($(this).val() == '')
                    window.location.replace("{{route('summaries')}}");
                var query = $(this).val();
                fetch_search(query);
            });
        });
    </script>
@endsection