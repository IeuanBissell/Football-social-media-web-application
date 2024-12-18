@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="text-center">
        <h2 class="mb-4 text-success">Welcome to Your Dashboard!</h2>
        <p class="lead mb-5 text-white-50">Manage your profile, check out your posts, and more!</p>

        <div class="row justify-content-center">
            <div class="dashboard-container">
                <!-- User Profile Card -->
                <div class="card profile-card">
                    <a href="{{ route('user.show', auth()->user()->id) }}" class="card-link">
                        <div class="card-content">
                            <h3>My Profile</h3>
                            <p>Click here to view and edit your profile settings and information.</p>
                        </div>
                    </a>
                </div>
            
                <!-- Fixtures Card -->
                <div class="card fixtures-card">
                    <a href="{{ route('fixtures.index') }}" class="card-link">
                        <div class="card-content">
                            <h3>Fixtures</h3>
                            <p>Click here to see the upcoming fixtures and matches.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection