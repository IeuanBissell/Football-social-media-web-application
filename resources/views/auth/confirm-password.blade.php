@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="auth-container">
        <h2 class="page-header text-center">{{ __('Confirm Password') }}</h2>

        <div class="mb-4">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="text-green">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <span class="text-error mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="btn btn-primary">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
