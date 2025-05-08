@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="auth-container">
        <h2 class="page-header text-center">{{ __('Forgot Password') }}</h2>

        <div class="mb-4">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="text-green">{{ __('Email') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus />
                @error('email')
                    <span class="text-error mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}">
                    {{ __('Back to Login') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
