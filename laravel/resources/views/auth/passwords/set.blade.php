@extends('layouts.app')

@section('content')
    <div class="container">
        <div class='col-md-8 mx-auto mt-4'>
            <div class="card">
                <div class="card-header">Ustawienie hasła</div>

                <div class="card-body">
                    <form method="post" id="set">
                        @csrf
                        <div class='form-group row offset-md-2'>
                            <label for="nowe_haslo" class="col-md-4 col-form-label text-md-right">Nowe hasło</label>
                            <input class="form-control col-md-4  @error('nowe_haslo') is-invalid @enderror" type='password' id='nowe_haslo' name='nowe_haslo'/><br/>
                            @error('nowe_haslo')
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class='form-group row offset-md-2'>
                            <label for="potw_nowe_haslo" class="col-md-4 col-form-label text-md-right">Powtórz hasło</label>
                            <input class="form-control col-md-4 @error('potw_nowe_haslo') is-invalid @enderror" type='password' id='potw_nowe_haslo' name='potw_nowe_haslo'/><br/>
                            @error('potw_nowe_haslo')
                                <span class="invalid-feedback text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
            <div class='card-footer'>
                <button class='btn btn-success float-right' name="type" value="set" form='set'>Zmień hasło</button>
            </div>
        </div>
    </div>
@endsection