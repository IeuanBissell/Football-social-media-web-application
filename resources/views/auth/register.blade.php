@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="auth-container">
        <!-- Page Header -->
        <h2 class="page-header text-center">{{ __('Register') }}</h2>

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

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="text-green">{{ __('Name') }}</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                       class="form-input" placeholder="Enter your name">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="text-green">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="form-input" placeholder="Enter your email">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="text-green">{{ __('Password') }}</label>
                <input type="password" id="password" name="password" required
                       class="form-input" placeholder="Enter your password">
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="text-green">{{ __('Confirm Password') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="form-input" placeholder="Confirm your password">
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="btn btn-primary w-full">
                    {{ __('Register') }}
                </button>
            </div>

            <!-- Login Link -->
            <div class="mt-4 text-center">
                <span>Already have an account?</span>
                <a href="{{ route('login') }}">
                    {{ __('Log In') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
