@extends('layouts.app')

@section('content')
<!-- Main Content Section -->
<div class="welcome-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to HalfTime</h1>
        <p>Your go-to football social hub. Connect, discuss, and celebrate the beautiful game.</p>
    </div>

    <!-- Feature Highlights -->
    <div class="feature-grid">
        <div class="feature-card">
            <i class="fas fa-futbol" aria-hidden="true"></i>
            <h2>Match Fixtures</h2>
            <p>Stay updated with upcoming matches and results</p>
        </div>

        <div class="feature-card">
            <i class="fas fa-comments" aria-hidden="true"></i>
            <h2>Fan Discussions</h2>
            <p>Share your thoughts and engage with other fans</p>
        </div>

        <div class="feature-card">
            <i class="fas fa-chart-line" aria-hidden="true"></i>
            <h2>Live Updates</h2>
            <p>Real-time match stats and commentary</p>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="cta-section">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="primary-button">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="primary-button">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="secondary-button">Register</a>
                @endif
            @endauth
        @endif
    </div>
</div>
@endsection
