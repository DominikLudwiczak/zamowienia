@extends('layouts.app')

@section('title', '- grafik')

@section('content')
    <div class="col-md-8 mx-auto mt-3">
        <div class="card">
            <div class="card-header">
                Szczegóły zmiany
            </div>
            <div class="card-body col-md-8 mx-auto">
                <div class="form-group">
                    <label for="date">Data:</label>
                    <input type='date' id='date' class='form-control' value="{{$work->date}}" readonly/>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="start">Początek:</label>
                        <input type='time' id='start' class='form-control' value="{{$work->start}}" readonly/>
                    </div>
                    <div class="col-md-6">
                        <label for="end">Koniec:</label>
                        <input type='time' id='end' class='form-control' value="{{$work->end}}" readonly/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="user">Pracownik:</label>
                        <input type="text" class='form-control' id="user" value="{{$user->name}}" readonly/>
                    </div>
                    <div class="col-md-6">
                        <label for="shop">Sklep:</label>
                        <input type="text" class='form-control' id="shop" value="{{$shop->name}}" readonly/>
                    </div>
                </div>
                
                <div class="row col float-right">
                    @if(Gate::allows('admin'))
                        <a href="{{ route('scheduler_shop', ['id' => $shop->id]) }}" class='btn btn-primary ml-auto'>Cofnij</a>
                        <a href="{{ route('scheduler_edit', ['id' => $work->id]) }}" class='btn btn-success ml-2'>Edytuj</a>
                        <button class='btn btn-danger ml-2' data-target="#delete" data-toggle="modal" value="{{$work->id}}" onclick="modal_delete(this.value)">Usuń</button>
                    @else
                        <a href="{{ route('scheduler_user', ['id' => $shop->id]) }}" class='btn btn-primary ml-auto'>Cofnij</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- modal delete -->
    <form method="post" action="{{route('scheduler_delete')}}">
    @csrf
    <div class="modal fade" tabindex="-1" role="dialog" role="dialog" id="delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Czy na pewno chcesz usunąć tą zmianę?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button class="btn btn-danger" name='id' id='delete_button'>Usuń</button>
            </div>
            </div>
        </div>
    </div>
</form>
    <!-- end modal -->
@endsection