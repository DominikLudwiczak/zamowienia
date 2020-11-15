@extends('layouts.app')

@section('content')
    <div class='col-md-8 mx-auto mt-4'>
        <div class="card">
            <div class="card-header">Zmiana hasła</div>

            <div class="card-body">
                <form method="post" action="{{ route('password.changing') }}" id="change">
                    @csrf
                    <div class='form-group row offset-md-2'>
                        <label for="stare_haslo" class="col-md-4 col-form-label text-md-right">Stare hasło</label>
                        <input class="form-control col-md-4 @error('stare_haslo') is-invalid @enderror" type='password' id='stare_haslo' name='stare_haslo'/><br/>
                        @error('stare_haslo')
                            <span class="invalid-feedback text-center" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    

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
                <button class='btn btn-success float-right' form='change'>Zmień hasło</button>
            </div>
        </div>
@endsection
