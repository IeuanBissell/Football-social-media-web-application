@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="auth-container">
        <h2 class="page-header text-center">{{ __('Verify Your Email Address') }}</h2>

        @if (session('resent'))
            <div class="alert alert-success mb-4" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="mb-4">
            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}
        </div>

        <form class="text-center" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Request another link') }}
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('home') }}">
                {{ __('Back to Home') }}
            </a>
        </div>
    </div>
</div>
@endsection
