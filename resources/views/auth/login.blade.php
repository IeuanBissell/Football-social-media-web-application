@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="auth-container">
        <!-- Page Header -->
        <h2 class="page-header text-center">{{ __('Log In') }}</h2>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
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
            <div class="form-group">
                <label for="email" class="text-green">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="form-input" placeholder="Enter your email">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="text-green">{{ __('Password') }}</label>
                <input type="password" id="password" name="password" required
                       class="form-input" placeholder="Enter your password">
            </div>

            <!-- Remember Me -->
            <div class="form-group checkbox-container">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">{{ __('Remember Me') }}</label>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="btn btn-primary w-full">
                    {{ __('Log In') }}
                </button>
            </div>

            <!-- Forgot Password -->
            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>

            <!-- Register Link -->
            <div class="mt-4 text-center">
                <span>Don't have an account?</span>
                <a href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
