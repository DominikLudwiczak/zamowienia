@extends('layouts.app')

@section('title', '- święto')

@section('content')
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Edycja święta</h1>
    <div class="col-md-8 mx-auto">
        <form method="post">
        @csrf
            <div class="card">
                <div class="card-header">święto</div>
                <div class="card-body">
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa święta</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa święta" name="name" value="{{$holiday->name}}" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Data</span>
                        </div>
                        <input type="date" class="form-control" placeholder="Data" name="date" value="{{$holiday->date}}" required>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ session('url') ?? URL::previous() }}" class="btn btn-primary">Cofnij</a>
                <button type="submit" class="btn btn-success">Zapisz</button>
                <button type="button" class="btn btn-danger" data-target="#delete" data-toggle="modal">Usuń</button>
            </div>
        </form>
    </div>


    <!-- modal -->
    <form method="post" action="{{ route('delete_holiday') }}">
    @csrf
        <div class="modal fade" tabindex="-1" role="dialog" role="dialog" id="delete" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Czy na pewno chcesz usunąć to święto?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    Usunięcie tego święta spowoduje zmienę dni pracujących!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button class="btn btn-danger" name='id' value="{{$holiday->id}}" id='delete_button'>Usuń</button>
                </div>
                </div>
            </div>
        </div>
    </form>
    <!-- end modal -->
@endsection