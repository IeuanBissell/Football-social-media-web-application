@extends('layouts.app')

@section('content')
    <!-- Main Content Section -->
    <div class="split-screen-container">

        <!-- Left Side: Greeting Message -->
        <div class="left-container">
            <div class="greeting-container">
                <h1 id="greeting-message">Welcome to HalfTime</h1>
                <p>Your go-to football social media hub! Explore fixtures, posts, and more!</p>
            </div>
        </div>

        <!-- Right Side: Buttons -->
        <div class="right-container">
            <div class="button-container">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-button btn btn-primary">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-button btn btn-primary">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-button btn btn-primary">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
@endsection
