<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HalfTime') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Vite Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-white antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-gray-900 via-gray-800 to-black">
            <!-- Header with App Name -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-800 text-white shadow-lg rounded-lg overflow-hidden sm:rounded-lg border border-gray-600">
                <!-- Centered App Name -->
                <div class="flex justify-center items-center mb-6">
                    <a href="{{ url('/') }}" class="text-3xl font-semibold text-green-400 hover:text-green-500 transition duration-300 ease-in-out">
                        {{ config('app.name') }}
                    </a>
                </div>
                <!-- Main Content -->
                <div class="bg-gray-900 text-white p-6 rounded-lg shadow-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
