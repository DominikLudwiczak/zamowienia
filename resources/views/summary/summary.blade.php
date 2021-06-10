@extends('layouts.app')

@section('title', '- podumowanie')

@section('content')
    <div class='row align-items-center pt-3'>
        <h1 style='text-decoration: underline;' class='col-md-7'>Podsumowanie - {{$user->name}}</h1>
    </div>
    <div class="col-md-8 mx-auto mt-4">
        <div class="card">
            <div class="card-header">Podsumowanie</div>
            <div class="card-body">
                
            </div>
        </div>

        <a href="{{ route('summaries') }}" class="btn btn-primary mt-3">Cofnij</a>
    </div>
@endsection