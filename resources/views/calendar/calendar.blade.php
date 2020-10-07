@extends('layouts.app')

@section('title', '- Grafik')

@section('content')
    <div class="col-md-12">
        <button onclick="previous({{$month}}-1, {{$year}})">Wstecz</button> {{$miesiace[$month-1]}} {{$year}} <button onclick="next({{$month}}+1, {{$year}})">Dalej</button>
        <div class="row">
            <div class="col-md-1">
                Poniedziałek
            </div>
            <div class="col-md-1">
                Wtorek
            </div>
            <div class="col-md-1">
                Środa
            </div>
            <div class="col-md-1">
                Czwartek
            </div>
            <div class="col-md-1">
                Piątek
            </div>
            <div class="col-md-1">
                Sobota
            </div>
            <div class="col-md-1">
                Niedziela
            </div>
        </div>
        <div class="row">
            @for($i=0; $i < cal_days_in_month(CAL_GREGORIAN, $month, $year) + date('N', strtotime($year."-".$month."-1"))-1; $i++)
                @if($i % 7 == 0 && $i > 0)
                    </div>
                    <div class="row">
                @endif

                <div class='col-md-1'>
                    @if($i >= date('N', strtotime($year."-".$month."-1"))-1)
                        <?php $z = str_pad($i-(date('N', strtotime($year."-".$month."-1"))-1)+1, 2, 0, STR_PAD_LEFT);?>
                        <h3>{{$z}}</h3>
                        @foreach($vacations->where('start', '<=', $year."-".$month."-$z")->where('end', '>=', $year."-".$month."-$z") as $vacation)
                            {{$vacation->start}} | {{$vacation->end}}<br/>
                        @endforeach
                    @endif
                </div>
            @endfor
        </div>
    </div>
@endsection