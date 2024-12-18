@extends('layouts.app')

@section('content')
<div class="page-container flex justify-center items-center">
    <div class="auth-container">
        <!-- Page Header -->
        <h2 class="page-header">{{ __('Register') }}</h2>
        
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="card bg-red-700 text-white">
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
                <input type="text" id="name" name="name" required autofocus class="form-input">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="text-green">{{ __('Email') }}</label>
                <input type="email" id="email" name="email" required class="form-input">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="text-green">{{ __('Password') }}</label>
                <input type="password" id="password" name="password" required class="form-input">
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="text-green">{{ __('Confirm Password') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="form-input">
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="btn w-full">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
