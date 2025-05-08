@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="auth-container">
        <h2 class="page-header text-center">{{ __('Reset Password') }}</h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="text-green">{{ __('Email') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                @error('email')
                    <span class="text-error mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="text-green">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <span class="text-error mt-2">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="text-green">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                @error('password_confirmation')
                    <span class="text-error mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
