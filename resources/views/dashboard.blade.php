@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="text-center">
        <h2 class="mb-6 text-green-600 text-3xl font-semibold">Welcome to Your Dashboard!</h2>
        <p class="lead mb-8 text-gray-600 text-lg">Manage your profile, check out your posts, and more!</p>

        <div class="row justify-content-center">
            <div class="dashboard-container grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <!-- User Profile Card -->
                <div class="card profile-card max-w-xs mx-auto bg-white text-black rounded-lg shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <a href="{{ route('user.show', auth()->user()->id) }}" class="card-link">
                        <div class="card-content">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">My Profile</h3>
                            <p class="text-gray-500">Click here to view and edit your profile settings and information.</p>
                        </div>
                    </a>
                </div>

                <!-- Fixtures Card -->
                <div class="card fixtures-card max-w-xs mx-auto bg-white text-black rounded-lg shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <a href="{{ route('fixtures.index') }}" class="card-link">
                        <div class="card-content">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Fixtures</h3>
                            <p class="text-gray-500">Click here to see the upcoming fixtures and matches.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
