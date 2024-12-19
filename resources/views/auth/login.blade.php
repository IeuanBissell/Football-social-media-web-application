@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="login-container">
            <h2 class="text-3xl font-bold text-center mb-6 text-green-600">{{ __('Login') }}</h2>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" required autofocus placeholder="Enter your email"
                        class="w-full px-4 py-3 mt-2 bg-gray-100 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none transition duration-300">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password"
                        class="w-full px-4 py-3 mt-2 bg-gray-100 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none transition duration-300">
                </div>

                <!-- Remember Me -->
                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-sm text-gray-600">{{ __('Remember Me') }}</label>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-green-500 transition duration-300">
                        {{ __('Log In') }}
                    </button>
                </div>

                <!-- Forgot Password -->
                <div class="mt-4 text-center">
                    <a href="{{ route('password.request') }}" class="text-green-600 hover:text-green-700 text-sm">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
