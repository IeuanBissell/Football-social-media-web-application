@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Welcome Section -->
    <div class="welcome-section card shadow-lg p-4 rounded">
        <h1 class="text-center text-black fw-bold display-4">Welcome to HalfTime</h1>
        <p class="text-center text-muted lead mb-4">Your go-to football social media hub! Explore fixtures, posts, and more!</p>
        <div class="text-center">
            <a href="{{ route('fixtures.index') }}" class="btn btn-lg btn-custom">View Fixtures</a>
        </div>
    </div>
</div>
@endsection
