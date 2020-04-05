@extends('layouts.app')

@section('title', '- nowy dostawca')

@section('content')
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Dodawanie dostawcy</h1>
    <div class='col-md-8 offset-md-2'>
        <div class='card'>
            <div class='card-header'>
                Nowy dostawca
            </div>
            <div class='card-body'>
                <form method="post" action="{{ route('add_supplier') }}" class='col-md-6 offset-md-3'>
                @csrf
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa dostawcy" name="nazwa" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">E-mail</span>
                        </div>
                        <input type="email" class="form-control" placeholder="E-mail dostawcy" name="email" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nr.tel</span>
                        </div>
                        <input type="tel" maxlength="11" id='tel' oninput="telephone(event, this.id)" class="form-control" placeholder="Numer telefonu dostawcy" name="telefon" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <button class='btn btn-success float-right ml-2'>Dodaj</button>
                    <a href="{{ route('suppliers') }}" class='btn btn-primary float-right'>Cofnij</a>
                </form>
            </div>
        </div>
    </div>
@endsection