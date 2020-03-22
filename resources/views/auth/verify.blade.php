@extends('layouts.app')

@section('title', '- aktywacja')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Zweryfikuj swój adres E-mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Nowy link aktywacyjny został wysłany na twój adres E-mail.') }}
                        </div>
                    @endif

                    {{ __('Zanim pójdziesz dalej, sprawdź skrzynkę E-mail i potwierdx link aktywacyjny.') }}
                    {{ __('Jeśli nie dostałeś wiadomości E-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('kliknij tutaj, aby wysłać go ponownie') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
