<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HalfTime') }}</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts and Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="auth-layout">
            <div class="auth-brand">
                <a href="/">
                    <span class="brand-icon"><i class="fas fa-futbol"></i></span>
                    <span class="brand-name">HalfTime</span>
                </a>
            </div>

            <div class="auth-container">
                {{ $slot }}
            </div>

            <div class="auth-footer">
                <p>&copy; {{ date('Y') }} HalfTime. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
