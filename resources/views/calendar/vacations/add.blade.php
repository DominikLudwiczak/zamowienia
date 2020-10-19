@extends('layouts.app')

@section('title', '- urlopy')

@section('content')
    <form method='post'>
    @csrf
        <div class="col-md-8 mx-auto mt-3">
            <div class="card">
                <div class="card-header">
                    Wniosek o urlop
                </div>
                <div class="card-body mx-auto">
                    @if(Gate::allows('admin'))
                        <select name='user' class="custom-select mb-2">
                            <option value="0" default>Użytkownik...</option>
                            @foreach($users as $user)
                                @if($user->id != old('user'))
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @else
                                    <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif

                    <?php 
                        $min = date('Y-m-d', strtotime('+1 day'));
                        $max = date('Y-m-d', strtotime('+1 month 1 day'));
                    ?>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start">Początek:</label>
                            <input type='date' id='start' name='start' class='form-control' value="{{old('start')}}" min="{{$min}}" max="{{$max ?? ''}}"/>
                        </div>
                        <div class="col-md-6">
                            <label for="end">Koniec:</label>
                            <input type='date' id='end' name='end' class='form-control' value="{{old('end')}}" min="{{$min}}" max="{{$max ?? ''}}"/>
                        </div>
                    </div>
                    
                    <div class="row col float-right">
                        <a href="{{ route('vacations') }}" class='btn btn-primary ml-auto'>Cofnij</a>
                        <button class='btn btn-success ml-2'>Wyślij</button>
                    </div>
                </div>
            </div>
        </div>
        @if(session('double'))
            <div class="modal" tabindex="-1" role="dialog" id='alert'>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alert!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if(session('double') === 'vacation')
                            <div class='alert alert-danger'>Istnieje urlop w tym terminie, popraw swój wniosek!</div>
                        @elseif(session('double') === 'proposal')
                            <div class='alert alert-primary'>Istnieje wniosek o urlop, który się pokrywa z twoim, czy pomimo tego wysłać wniosek?</div>
                        @elseif(session('double') === 'double')
                            <div class='alert alert-danger'>Masz już złożony wniosek o urlop w tym terminie, popraw swój wniosek!</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Popraw</button>
                        @if(session('double') === 'proposal')
                            <button class='btn btn-success' name='double' value='true'>Wyślij</button>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        @endif
    </form>
@endsection