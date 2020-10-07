<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>zamówienia @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('/public/js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='/public/js/script.js' type='text/javascript'></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/public/css/app.css') }}" rel="stylesheet">
</head>
<body onload="active()">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" onclick="change_sidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Zaloguj się') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <hr id='linia' style='display:none;'/>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wyloguj się') }}
                                    </a>

                                    <a class='dropdown-item' href="{{ route('password.change') }}">Zmień hasło</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @auth
            <div class='container-fluid'>
                <div class="row">
                    <x-nav-left/>
                    <div class='col-md-9 mx-auto'>
                        @include('includes.messages')
                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            <main class='py-4'>
                @include('includes.messages')
                @yield('content')
            </main>
        @endauth
    </div>
    
    <script>
        function active()
        {
            var route = "{{Route::getCurrentRoute()->getName()}}";
            if(route.includes('order'))
                route = 'orders';
            else if(route.includes('supplier'))
                route = 'suppliers';
            else if(route.includes('product'))
                route = 'products';
            else if(route.includes('calenda'))
                route = 'calendar';
            else
                route = 'dashboard';

            var item = document.getElementById(route);
            if(item)
                item.style.textDecoration = "underline";
        }

        $(document).ready(function(){
            $('.toast').toast('show');
        });
    </script>
</body>
</html>