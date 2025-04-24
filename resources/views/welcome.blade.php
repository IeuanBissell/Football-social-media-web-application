@extends('layouts.app')

@section('content')
    <!-- Main Content Section -->
    <div class="welcome-container">

        <!-- Greeting Message -->
        <div class="greeting-container mb-8">
            <h1 id="greeting-message" class="text-4xl text-cream font-bold mb-4">Welcome to HalfTime</h1>
            <p class="text-xl text-cream">Your go-to football social media hub! Explore fixtures, posts, and more!</p>
        </div>

        <!-- Buttons Container -->
        <div class="button-container mt-8">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-button btn btn-primary">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button class="nav-button btn btn-primary">
                            Log Out
                        </button>
                    </form>
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
@endsection
