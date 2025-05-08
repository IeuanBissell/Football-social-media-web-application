@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-5 text-center">
        <h1 class="display-4">Welcome Back, {{ Auth::user()->name }}!</h1>
    </div>

    <!-- Dashboard Links -->
    <div class="row">
        <!-- View Profile Link -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Your Profile</h5>
                    <p class="card-text">View and update your personal details</p>
                    <a href="{{ route('user.show', Auth::user()->id) }}" class="btn btn-custom">View Profile</a>
                </div>
            </div>
        </div>

        <!-- Edit Profile Link -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Edit Profile</h5>
                    <p class="card-text">Change your details or preferences</p>
                    <a href="{{ route('profile.edit', Auth::user()->id) }}" class="btn btn-custom">Edit Profile</a>
                </div>
            </div>
        </div>

        <!-- View Fixtures Link -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">View Fixtures</h5>
                    <p class="card-text">Explore upcoming football matches</p>
                    <a href="{{ route('fixtures.index') }}" class="btn btn-custom">View Fixtures</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Section -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Notifications</h5>
                    <p class="card-text">View your latest notifications</p>
                    <a href="{{ route('notifications.index') }}" class="btn btn-custom">View Notifications</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
