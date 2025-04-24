@extends('layouts.app')

@section('content')
<div class="page-container flex justify-center items-center">
    <div class="auth-container">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="card bg-red-700 text-white mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group mb-4">
                <label for="email" class="text-green">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" required autofocus class="form-input" placeholder="Enter your email">
            </div>

            <!-- Password -->
            <div class="form-group mb-4">
                <label for="password" class="text-green">{{ __('Password') }}</label>
                <input type="password" id="password" name="password" required class="form-input" placeholder="Enter your password">
            </div>

            <!-- Remember Me -->
            <div class="form-group mb-4 flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-sm text-gray-600">{{ __('Remember Me') }}</label>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit" class="btn w-full bg-dark-green text-white hover:bg-green-700">
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
