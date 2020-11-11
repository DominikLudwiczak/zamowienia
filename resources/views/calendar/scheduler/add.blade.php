@extends('layouts.app')

@section('title', '- grafik')

@section('content')
<form method='post'>
    @csrf
        <div class="col-md-8 mx-auto mt-3">
            <div class="card">
                <div class="card-header">
                    Dodaj zmianę
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <?php 
                        $min = date('Y-m-d');
                    ?>

                    <div class="form-group">
                        <label for="date">Data:</label>
                        <input type='date' id='date' name='date' class='form-control' value="{{old('date')}}" min="{{$min}}" required/>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start">Początek:</label>
                            <input type='time' id='start' name='start' class='form-control' value="{{old('start')}}" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="end">Koniec:</label>
                            <input type='time' id='end' name='end' class='form-control' value="{{old('end')}}" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <select name='user' class="custom-select mb-2" required>
                            <option value="0" default>Użytkownik...</option>
                            @foreach($users as $user)
                                @if($user->id != old('user'))
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @else
                                    <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row col float-right">
                        <a href="{{ URL::previous() }}" class='btn btn-primary ml-auto'>Cofnij</a>
                        <button class='btn btn-success ml-2'>Dodaj</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection