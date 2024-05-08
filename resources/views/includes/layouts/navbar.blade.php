{{-- NAVABAR --}}
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center me-3" href="{{ url('/') }}">
            <div class="logo_laravel d-flex align-items-center justify-content-center">
                <img src="{{ Vite::asset('resources/img/logo.png') }}" alt="" class="img-fluid me-1" id="nav-logo">
                <span id="link-logo">boolbnb</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">


                {{-- SOLO UTENTI AUTENTICATI --}}
                @auth
                <li class="nav-item mx-2">
                    {{-- PANNELLO DI CONTROLLO --}}
                    <a class="nav-link "
                        href="http://localhost:5173/">{{ __('Home') }}</a>
                </li>
                    <li class="nav-item mx-2">
                        {{-- PANNELLO DI CONTROLLO --}}
                        <a class="nav-link @if (Route::is('welcome') || Route::is('admin.statistic*')) active @endif"
                            href="{{ route('welcome') }}">{{ __('Pannello di Controllo') }}</a>
                    </li>
                    <li class="nav-item mx-2">
                        {{-- APPARTAMENTI --}}
                        <a class="nav-link @if (Route::is('admin.apartments*')) active @endif"
                            href="{{ route('admin.apartments.index') }}">{{ __('Appartamenti') }}</a>
                    </li>
                @endauth


            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->


                {{-- UTENTI NON AUTENTICATI --}}
                @guest
                    {{-- ACCEDI --}}
                    <li class="nav-item">
                        <a class="btn bg-hover text-white" href="{{ route('welcome') }}">{{ __('Accedi') }}</a>
                    </li>
                    {{-- CONTROLLO DELLA ROTTA REGISTRATI --}}
                    @if (Route::has('register'))
                        <li class="nav-item ms-1">
                            <a class="btn c-main btn-sec" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item mx-2">
                        {{-- APPARTAMENTI --}}
                        <a class="nav-link @if (Route::is('admin.messages*')) active @endif"
                            href="{{ route('admin.messages.index') }}"><i class="fa-regular fa-bell"></i></a>
                    </li>
                    {{-- DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa-regular fa-circle-user"></i>
                            {{-- NOME UTENTE --}}
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            {{-- PROFILO --}}
                            <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profilo') }}</a>
                            {{-- ESCI --}}
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                {{ __('Esci') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest


            </ul>
        </div>
    </div>
</nav>
