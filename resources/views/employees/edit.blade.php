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

                    <!-- @if($user->email_verified_at == null)
                        <hr/>
                            <div class="text-center">
                                <p class="text-danger">Ten użytkownik nie ma potwierdzonego adresu email! Czy wysłać jeszcze raz email z linkiem 
                                do aktywacji konta?</p>
                                <button class='btn btn-primary' form="" data-target="#danger" data-toggle="modal">Wyślij</button>
                            </div>
                        <hr/>
                    @endif -->
                    
                    <button class='btn btn-success float-right ml-2'>Zapisz</button>
                    <a href="{{ route('employees_admin') }}" class='btn btn-primary float-right'>Cofnij</a>
                </form>
            </div>
        </div>
    </div>

    <!-- modal danger -->
        <!-- <form method="post" action="{{ route('employee_resend', ['id' => $user->id]) }}">
        @csrf
            <div class="modal fade" tabindex="-1" role="dialog" role="dialog" id="danger" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UWAGA!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        Ta wiadomość email wyśle się tylko wtedy, gdy czas na aktywację konta upłynął!
                    </div>
                    <div class="modal-footer">
                        <button href="#" class='btn btn-success'>Wyślij</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
                    </div>
                    </div>
                </div>
            </div>
        </form> -->
    <!-- end modal -->
@endsection