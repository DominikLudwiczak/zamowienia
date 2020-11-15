@extends('layouts.app')

@section('content')
    <div class='col-md-8 mx-auto mt-4'>
        <div class="card">
            <div class="card-header">Zmiana hasła</div>

            <div class="card-body">
                <form method="post" action="{{ route('password.changing') }}" id="change">
                    @csrf
                    <div class='form-group row offset-md-2'>
                        <label for="" class="col-md-4 col-form-label text-md-right">Stare hasło</label>
                        <input class='form-control col-md-4' type='password' name='stare_haslo'/><br/>
                    </div>

                    <div class='form-group row offset-md-2'>
                        <label for="" class="col-md-4 col-form-label text-md-right">Nowe hasło</label>
                        <input class='form-control col-md-4' type='password' name='nowe_haslo'/><br/>
                    </div>

                    <div class='form-group row offset-md-2'>
                        <label for="" class="col-md-4 col-form-label text-md-right">Powtórz hasło</label>
                        <input class='form-control col-md-4' type='password' name='potw_nowe_haslo'/><br/>
                    </div>
                    
                    
                </form>
            </div>
            <div class='card-footer'>
                <button class='btn btn-success float-right' form='change'>Zmień hasło</button>
            </div>
        </div>
@endsection
