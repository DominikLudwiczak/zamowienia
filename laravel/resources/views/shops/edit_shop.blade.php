@extends('layouts.app')

@section('title', "- $shop->name")

@section('content')
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Edycja sklepu</h1>
    <div class="col-md-8 mx-auto offset-md-2">
        <div class="card">
            <div class="card-header">
                Edycja sklepu
            </div>

            <div class="card-body">
                <form method='post' class='col-md-6 mx-auto'>
                @csrf
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa sklepu" name="name" value="{{$shop->name}}" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Miejscowość</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Miejscowość" name="city" value="{{$shop->city}}" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Ulica</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ulica" name="street" value="{{$shop->street}}" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Numer</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Numer" name="number" value="{{$shop->number}}" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Kod pocztowy</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Kod pocztowy" name="postal" pattern="[0-9]{2}-[0-9]{3}" value="{{substr($shop->postal, 0, 2).'-'.substr($shop->postal, 2)}}" required>
                    </div>
                    <div class="row float-right">
                        <a class='btn btn-primary' href="{{route('shops')}}">Cofnij</a>
                        <button type='submit' class='btn btn-success ml-2'>Zapisz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection