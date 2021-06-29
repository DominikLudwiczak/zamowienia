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
                    <div class="col-md-5">
                        <select id="job_year" class="form-control">
                            @foreach($jobYears as $year)
                                @if($year == date('Y', strtotime($job)))
                                    <option selected>{{$year}}</option>
                                @else
                                    <option>{{$year}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                        @php
                            $months = ['styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień'];
                        @endphp
                    <div class="col-md-5">
                        <select id="job_month" class="form-control">
                            @foreach($months as $key => $month)
                                @if(sprintf("%02d", $key+1) == date('m', strtotime($job)))
                                    <option value="{{sprintf('%02d', $key+1)}}" selected>{{$month}}</option>
                                @else
                                    <option value="{{sprintf('%02d', $key+1)}}">{{$month}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <button type="button" class="btn btn-success" onclick="change('{{$user->id}}')">Zmień</button>
                    </div>
                </div>

                <input type="text" class="form-control text-center mt-3" value="{{floor($jobTime/60) }} godzin {{ $jobTime - (floor($jobTime/60)*60)}} minut" readonly/> 
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Urlopy</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <select id="vacation_year" class="form-control">
                            @foreach($vacationYears as $year)
                                @if($year == date('Y', strtotime($vacation)))
                                    <option selected>{{$year}}</option>
                                @else
                                    <option>{{$year}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @php
                        $months = ['styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień'];
                    @endphp
                    <div class="col-md-5">
                        <select id="vacation_month" class="form-control">
                            @foreach($months as $key => $month)
                                @if(sprintf("%02d", $key+1) == date('m', strtotime($vacation)))
                                    <option value="{{sprintf('%02d', $key+1)}}" selected>{{$month}}</option>
                                @else
                                    <option value="{{sprintf('%02d', $key+1)}}">{{$month}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <button type="button" class="btn btn-success" onclick="change('{{$user->id}}')">Zmień</button>
                    </div>
                </div>
                <input type="text" class="form-control text-center mt-3" value="{{$vacationTime}} dni" readonly/>
            </div>
        </div>

        @if(Gate::allows('admin'))
            <a href="{{ route('summaries') }}" class="btn btn-primary mt-3">Cofnij</a>
        @endif
    </div>

    <script>
        function change(user)
        {
            let year = document.getElementById('job_year').value;
            let month = document.getElementById('job_month').value;

            let vacation_year = document.getElementById('vacation_year').value;
            let vacation_month = document.getElementById('vacation_month').value;

            location.href = `/summary/${user}/${year}-${month}/${vacation_year}-${vacation_month}`;
        }
    </script>
@endsection