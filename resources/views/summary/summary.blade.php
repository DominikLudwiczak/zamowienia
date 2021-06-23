@extends('layouts.app')

@section('title', '- podumowanie')

@section('content')
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>Podsumowanie - {{$user->name}}</h1>
    </div>
    <div class="col-md-8 mx-auto mt-4">
        <div class="card">
            <div class="card-header">Praca</div>
            <div class="card-body">
                <div class="row">
                    <select id="job_year" class="form-control col-md-6">
                        @foreach($jobYears as $year)
                            @if($year == date('Y', strtotime($job)))
                                <option selected>{{$year}}</option>
                            @else
                                <option>{{$year}}</option>
                            @endif
                        @endforeach
                    </select>

                    @php
                        $months = ['styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień'];
                    @endphp

                    <select id="job_month" class="form-control col-md-6">
                        @foreach($months as $key => $month)
                            @if(sprintf("%02d", $key+1) == date('m', strtotime($job)))
                                <option value="{{sprintf('%02d', $key+1)}}" selected>{{$month}}</option>
                            @else
                                <option value="{{sprintf('%02d', $key+1)}}">{{$month}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-success" onclick="change('{{$user->id}}')">Zmień</button>

                <input type="text" class="form-control mt-3" value="{{floor($jobTime/60) }} godzin {{ $jobTime - (floor($jobTime/60)*60)}} minut" readonly/> 
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Urlopy</div>
            <div class="card-body">
                <div class="row">
                    <select id="vacation_year" class="form-control col-md-6">
                        @foreach($vacationYears as $year)
                            @if($year == $vacation)
                                <option selected>{{$year}}</option>
                            @else
                                <option>{{$year}}</option>
                            @endif
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-success" onclick="change('{{$user->id}}')">Zmień</button>
                </div>
                <input type="text" class="form-control mt-3" value="{{$vacationTime}} dni" readonly/>
            </div>
        </div>

        <a href="{{ route('summaries') }}" class="btn btn-primary mt-3">Cofnij</a>
    </div>

    <script>
        function change(user)
        {
            let year = document.getElementById('job_year').value;
            let month = document.getElementById('job_month').value;
            let vacation_year = document.getElementById('vacation_year').value;
            location.href = `/summary/${user}/${year}-${month}/${vacation_year}`;
        }
    </script>
@endsection