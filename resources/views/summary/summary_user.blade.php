@extends('layouts.app')

@section('title', '- podumowanie')

@section('content')
    CZAS PRACY -> {{ floor($job/60) }} godzin i {{ $job - (floor($job/60)*60) }} minut
@endsection