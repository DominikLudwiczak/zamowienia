@extends('layouts.app')

@section('title', '- urlopy')

@section('content')
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class="col-md-7">Urlopy</h1>
        <div class='input-group col-md-5' style="justify-content: flex-end;">
            <a href="{{ route('vacation_add') }}" class='btn btn-success mb-2'>Dodaj</a>
        </div>
    </div>
    <div class="calendar mx-auto">
        <div class="calendar-header">
            <button class="calendar-header__arrow mr-4" onclick="previous({{$month}}-1, {{$year}})"><i class="fa fa-chevron-left"></i></button> 
            {{$miesiace[$month-1]}} {{$year}} 
            <button class="calendar-header__arrow ml-4" onclick="next({{$month}}+1, {{$year}})"><i class="fa fa-chevron-right"></i></button>
        </div>

        <div class="calendar-days d-none d-md-flex d-lg-flex">
            <span class="calendar-days">Poniedziałek</span>
            <span class="calendar-days">Wtorek</span>
            <span class="calendar-days">Środa</span>
            <span class="calendar-days">Czwartek</span>
            <span class="calendar-days">Piątek</span>
            <span class="calendar-days">Sobota</span>
            <span class="calendar-days">Niedziela</span>
        </div>
        <div class="calendar-days d-md-none">
            <span class="calendar-days">Pn</span>
            <span class="calendar-days">Wt</span>
            <span class="calendar-days">Śr</span>
            <span class="calendar-days">Czw</span>
            <span class="calendar-days">Pt</span>
            <span class="calendar-days">Sob</span>
            <span class="calendar-days">Nd</span>
        </div>
        <div class="calendar-week">
            @for($i=0; $i < ceil((cal_days_in_month(CAL_GREGORIAN, $month, $year) + date('N', strtotime($year."-".$month."-1")))/7)*7; $i++)
                @if($i % 7 == 0 && $i > 0)
                    </div>
                    <div class="calendar-week">
                @endif
                <?php $z = str_pad($i-(date('N', strtotime($year."-".$month."-1"))-1)+1, 2, 0, STR_PAD_LEFT);?>

                @if(date("N", strtotime($year."-".$month."-".$z)) == 7)
                    <div class='calendar-day calendar-day__sunday'>
                @else
                    <div class='calendar-day'>
                @endif
                    
                    @if($z > 0 && $z <= cal_days_in_month(CAL_GREGORIAN, $month, $year))
                        <span class="calendar-day__num">{{$z}}</span>
                        
                        @foreach($vacations->where('start', '<=', $year."-".$month."-$z")->where('end', '>=', $year."-".$month."-$z")->where('confirmed', '>=', 0) as $vacation)
                            @if(Gate::allows('admin'))
                                @if($vacation->confirmed == 0)
                                    <a href="{{ route('request', ['id' => $vacation->id]) }}" class="calendar-event" id="e_{{$vacation->id}}" onmouseover="hoverEvent(this.id)" onmouseout="hoverEvent(this.id)">
                                        <span class="d-none d-sm-flex">{{ $users->where('id', $vacation->user_id)->first()->name }}</span>
                                        <i class="fa fa-times d-flex d-sm-none"></i>
                                    </a>
                                @else
                                    <a href="{{ route('request', ['id' => $vacation->id]) }}" class="calendar-event calendar-event__conf" id="e_{{$vacation->id}}" onmouseover="hoverEvent(this.id)" onmouseout="hoverEvent(this.id)">
                                        <span class="d-none d-sm-flex">{{ $users->where('id', $vacation->user_id)->first()->name }}</span>
                                        <i class="fa fa-times d-flex d-sm-none"></i>
                                    </a>
                                @endif
                            @else
                                @if($vacation->user_id == $curr_usr)
                                    @if($vacation->confirmed == 0)
                                        <a href="{{ route('request', ['id' => $vacation->id]) }}" class="calendar-event" id="e_{{$vacation->id}}" onmouseover="hoverEvent(this.id)" onmouseout="hoverEvent(this.id)">
                                            <span class="d-none d-sm-flex">{{ $users->where('id', $vacation->user_id)->first()->name }}</span>
                                            <i class="fa fa-times d-flex d-sm-none"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('request', ['id' => $vacation->id]) }}" class="calendar-event calendar-event__conf" id="e_{{$vacation->id}}" onmouseover="hoverEvent(this.id)" onmouseout="hoverEvent(this.id)">
                                            <span class="d-none d-sm-flex">{{ $users->where('id', $vacation->user_id)->first()->name }}</span>
                                            <i class="fa fa-times d-flex d-sm-none"></i>
                                        </a>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
            @endfor
        </div>
    </div>
@endsection