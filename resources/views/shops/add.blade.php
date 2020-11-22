@extends('layouts.app')

@section('title', '- sklepy')

@section('content')
<h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Dodawanie sklepu</h1>
    <div class='col-md-8 offset-md-2'>
        <div class='card'>
            <div class='card-header'>
                Nowy sklep
            </div>
            <div class='card-body'>
                <form method="post" class='col-md-6 offset-md-3'>
                @csrf
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa sklepu" name="name" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Miejscowość</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Miejscowość" name="city" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Ulica</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ulica" name="street" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Numer</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Numer" name="number" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Kod pocztowy</span>
                        </div>
                        <input type="text" class="form-control" placeholder="00-000" pattern="[0-9]{2}-[0-9]{3}" name="postal" required>
                    </div>
                    <button class='btn btn-success float-right ml-2'>Dodaj</button>
                    <a href="{{ route('shops') }}" class='btn btn-primary float-right'>Cofnij</a>
                </form>
            </div>
        </div>
    </div>
@endsection