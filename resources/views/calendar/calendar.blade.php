@extends('layouts.app')

@section('title', '- Urlopy')

@section('content')
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>Kalendarz</h1>
        <div class='input-group col-md-5'>
            <a href="{{ route('vacation_add') }}" class='btn btn-success'>Dodaj</a>
        </div>
    </div>
    <div class="calendar mx-auto">
        <div class="calendar-header">
            <button onclick="previous({{$month}}-1, {{$year}})">Wstecz</button> 
            {{$miesiace[$month-1]}} {{$year}} 
            <button onclick="next({{$month}}+1, {{$year}})">Dalej</button>
        </div>

        <div class="calendar-days">
            <span class="calendar-days">Poniedziałek</span>
            <span class="calendar-days">Wtorek</span>
            <span class="calendar-days">Środa</span>
            <span class="calendar-days">Czwartek</span>
            <span class="calendar-days">Piątek</span>
            <span class="calendar-days">Sobota</span>
            <span class="calendar-days">Niedziela</span>
        </div>
        <div class="calendar-week">
        <!-- cal_days_in_month(CAL_GREGORIAN, $month, $year) + date('N', strtotime($year."-".$month."-1"))-1 -->
            @for($i=0; $i < 35; $i++)
                @if($i % 7 == 0 && $i > 0)
                    </div>
                    <div class="calendar-week">
                @endif

                <div class='calendar-day'>
                    <?php $z = str_pad($i-(date('N', strtotime($year."-".$month."-1"))-1)+1, 2, 0, STR_PAD_LEFT);?>
                    
                    @if($z > 0 && $z <= cal_days_in_month(CAL_GREGORIAN, $month, $year))
                        <h3>{{$z}}</h3>
                        @foreach($vacations->where('start', '<=', $year."-".$month."-$z")->where('end', '>=', $year."-".$month."-$z")->where('confirmed', '>=', 0) as $vacation)
                            {{ $users->where('id', $vacation->user_id)->first()->name }}
                        @endforeach
                    @endif
                </div>
            @endfor
        </div>
    </div>
@endsection