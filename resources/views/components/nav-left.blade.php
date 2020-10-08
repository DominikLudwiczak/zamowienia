<nav class="navbar sidebar d-md-flex collapse sidebar-collapse navbarSupportedContent shadow" id='sidebar' style='background-color: #1D65B7; position: fixed; height: 100vh; z-index:2;'>
    <div class="mx-auto" style="height:100%;">
        <ul class="nav flex-column mx-2" style='font-size: 0.9rem;'>
            @if(Gate::allows('admin'))
                <li class="nav-item">
                    <a class="nav-link text-white" id='dashboard' href="{{ route('dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" id='orders' href="{{ route('orders') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        Zamówienia
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" id='suppliers' href="{{ route('suppliers') }}">
                        <img src="{{ asset('public/img/suppliers.svg') }}"/>
                        Dostawcy
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" id='products' href="{{ route('products') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        Produkty
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" id='vacations' href="{{ route('vacations') }}">
                        <img src="{{ asset('public/img/calendar.svg') }}"/>
                        Urlopy
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link text-white" id='products' href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Użytkownik
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" id='vacations' href="{{ route('vacations') }}">
                        <img src="{{ asset('public/img/calendar.svg') }}"/>
                        Urlopy
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>