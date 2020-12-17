@extends('layouts.app')

@section('title', '- pracownicy')

@section('content')
    <h1 style='text-decoration: underline;' class='col-md-7 pt-3 pb-3'>Edycja pracownika</h1>
    <div class='col-md-8 offset-md-2'>
        <div class='card'>
            <div class='card-header'>
                Edycja pracownika
            </div>
            <div class='card-body'>
                <form method="post" class='col-md-6 offset-md-3'>
                @csrf
                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nazwa pracownika" name="nazwa" value="{{$user->name}}" required>
                    </div>

                    <div class="input-group pt-3 pb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">E-mail</span>
                        </div>
                        <input type="email" class="form-control" placeholder="E-mail pracownika" name="email" value="{{$user->email}}" required>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="active" name="active" <?php if($user->active == 1){ echo "checked";} ?>>
                        <label class="form-check-label" for="active">Aktywny</label>
                    </div>
                    
                    <button class='btn btn-success float-right ml-2'>Dodaj</button>
                    <a href="{{ route('employees_admin') }}" class='btn btn-primary float-right'>Cofnij</a>
                </form>
            </div>
        </div>
    </div>
@endsection