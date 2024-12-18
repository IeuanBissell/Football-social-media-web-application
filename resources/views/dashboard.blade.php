@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="text-center">
        <h2 class="mb-4 text-success">Welcome to Your Dashboard!</h2>
        <p class="lead mb-5 text-white-50">Manage your profile, check out your posts, and more!</p>

        <div class="row justify-content-center">
            <div class="card">
                <!-- Link to the current user's profile -->
                <a href="{{ route('user.show', auth()->user()->id) }}">My Profile</a>
                
                <!-- Link to the fixtures index page -->
                <a href="{{ route('fixtures.index') }}">View Fixtures</a>
            </div>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="btn btn-success btn-lg mt-4">Edit Profile</a>
    </div>
@endsection
