@extends('layouts.app')

@section('title', '- grafik')

@section('content')
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
                    @if(session('double') === 'double_user')
                        <div class='alert alert-danger'>Ten użytkownik ma już zapisaną zmianę w tym terminie!</div>
                    @elseif(session('double') === 'double_other_user')
                        <div class='alert alert-danger'>Zmiany w tym sklepie pokrywają się!</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Popraw</button>
                </div>
                </div>
            </div>
        </div>
    @endif
    <form method='post'>
    @csrf
        <div class="col-md-8 mx-auto mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                    <div class="col float-left">Edycja zmiany</div>
                    <div class="col float-right text-right">{{$shop->name}}</div>
                    </div>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <div class="form-group">
                        <label for="date">Data:</label>
                        <input type='date' id='date' name='date' class='form-control' value="{{$work->date}}" required/>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start">Początek:</label>
                            <input type='time' id='start' name='start' class='form-control' value="{{\Carbon\Carbon::parse($work->start)->format('H:i')}}" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="end">Koniec:</label>
                            <input type='time' id='end' name='end' class='form-control' value="{{\Carbon\Carbon::parse($work->end)->format('H:i')}}" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <select name='user' class="custom-select mb-2" required>
                            <option value="{{$work->user_id}}" default>{{$user->name}}</option>
                            @foreach($users as $user)
                                @if($user->id != $work->user_id)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row col float-right">
                        <a href="{{route('scheduler_view', ['id' => $work->id])}}" class='btn btn-primary ml-auto'>Cofnij</a>
                        <button class="btn btn-success ml-2" name="schedulerid" value="{{$work->id}}">Zapisz</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection