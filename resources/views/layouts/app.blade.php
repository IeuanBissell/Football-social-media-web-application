<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Football League Social Media')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/trophy.png') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-dark text-white">
    <header class="bg-black py-4">
        <div class="container text-center">
            <h1 class="mb-0 text-success">⚽ Football League Social Media</h1>
            <p class="mt-2 text-white-50">Your hub for all things football!</p>
        </div>
    </header>
    @if ($errors->any())
        <div>
            Errors:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <main class="container my-5">
        @yield('content')
    </main>
    <footer class="bg-black text-center py-3">
        <p class="text-white-50">&copy; {{ date('Y') }} Football League Social Media</p>
    </footer>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
