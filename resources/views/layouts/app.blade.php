<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Football League Social Media')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/trophy.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Vite Integration -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dark text-white font-sans">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-black shadow-sm">
        <div class="container">
            <a class="navbar-brand text-success" href="{{ url('/') }}">⚽ Football League Social Media</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-dark text-center text-success py-5 shadow-sm">
            <div class="container">
                <h1>{{ $header }}</h1>
            </div>
        </header>
    @endisset

    <!-- Main Content -->
    <div class="container my-5">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-black text-center py-3">
        <p class="text-white-50">&copy; {{ date('Y') }} Football League Social Media. All Rights Reserved.</p>
    </footer>

    <!-- Error Handling -->
    @if ($errors->any())
        <div class="container mt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
