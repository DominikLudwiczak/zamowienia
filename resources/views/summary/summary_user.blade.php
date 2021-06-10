@extends('layouts.app')

@section('title', '- podumowanie')

@section('content')
    <div class="col-md-8 mx-auto mt-4">
        <div class="card">
            <div class="card-header">Podsumowanie</div>
            <div class="card-body">
                <div class="row mx-auto">
                    <input type="text" class="form-control col-md-6" value="Czas pracy (w tym miesiącu)" readonly>
                    <input type="text" class="form-control col-md-6" value="{{ floor($job/60) }} godzin {{ $job - (floor($job/60)*60) }} minut" readonly>
                </div>
                <div class="row mx-auto mt-3">
                    <input type="text" class="form-control col-md-6" value="Wykorzystany urlop (w tym roku)" readonly>
                    <input type="text" class="form-control col-md-6" value="{{ $vacation }} dni" readonly>
                </div>
            </div>
        </div>
    </div>
@endsection