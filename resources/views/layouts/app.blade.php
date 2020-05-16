<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#328bd5">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
    @yield('head')
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" role="img" focusable="false">
                    <title>{{ config('app.name', 'Laravel') }}</title>
                    <path fill="#328bd5"
                        d="M11.25 3v30h16.5C29 33 30 32 30 30.75V5.25C30 4 29 3 27.75 3zm8.8 4.5h1.35v1.1a4.23 4.23 0 011.34.37c.3.12.59.29.88.48l-.82 1.12a4.05 4.05 0 00-.96-.49 2.72 2.72 0 00-.92-.16c-.58 0-1.02.12-1.31.36-.3.24-.44.6-.44 1.08 0 .34.08.6.25.8.17.18.38.32.63.4a9.88 9.88 0 001.29.34c.52.11.96.25 1.3.42.36.16.65.43.89.8.23.36.35.86.35 1.5v.01c0 .62-.12 1.14-.36 1.56-.25.41-.61.72-1.1.93-.3.12-.63.2-1.02.25v1.13h-1.35v-1.1a4.3 4.3 0 01-2.68-1.36l.9-1.11c.33.38.68.67 1.06.87.4.19.82.28 1.27.28.63 0 1.1-.12 1.4-.36.32-.25.47-.62.47-1.12v-.01c0-.32-.07-.57-.22-.76a1.38 1.38 0 00-.59-.41 5.34 5.34 0 00-1.12-.3 8.89 8.89 0 01-1.44-.36 2.05 2.05 0 01-.95-.75 2.6 2.6 0 01-.39-1.53v-.01c0-.65.12-1.18.35-1.6a2.2 2.2 0 011.05-.97c.26-.12.56-.2.9-.26zM15 24.75h11.25v1.5H15zm0 3h11.25v1.5H15z" />
                    <path fill="#3b4652" d="M8.25 3C7 3 6 4 6 5.25v25.5C6 32 7 33 8.25 33h1.5V3z" />
                </svg>
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cashes.index') }}">{{ __('Laporan Kas') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ __('Master') }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('cashbooks.index') }}">
                                {{ __('Buku Kas') }}
                            </a>
                            @can('admin')
                            <a class="dropdown-item" href="{{ route('cash-types.index') }}">
                                {{ __('Jenis Kas') }}
                            </a>
                            @endcan
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('profile') }}" class="dropdown-item">Edit Profil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main role="main" class="py-4 flex-shrink-0">
        @yield('content')
    </main>

    <footer class="mt-auto bg-white text-muted py-3 px-3 border-top">
        <div class="container text-sm">
            <div class="row">
                <div class="col-sm">
                    Copyright &copy; 2020 <a href="https://fb.me/fauzie.rofi">Fauzie Rofi</a>. All rights reserved.
                </div>
                <div class="col-sm text-right">Version 1.0.0</div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $.fn.datepicker.defaults.format = "yyyy-mm-dd";
    </script>
    @yield('scripts')
</body>

</html>
