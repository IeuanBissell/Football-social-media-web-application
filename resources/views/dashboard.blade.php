@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="text-center">
        <h2 class="mb-4 text-success">Welcome to Your Dashboard!</h2>
        <p class="lead mb-5 text-white-50">Manage your profile, check out your posts, and more!</p>

        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card bg-secondary text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Your Posts</h5>
                        <p class="card-text">View, edit, or delete your posts.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-secondary text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Settings</h5>
                        <p class="card-text">Manage your account settings and preferences.</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="btn btn-success btn-lg mt-4">Edit Profile</a>
    </div>
@endsection
