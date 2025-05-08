@extends('layouts.app')

@section('content')
<div class="container profile-container">
    <h1 class="profile-title mb-5">Your Profile</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Information -->
            <section class="mb-5">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Information') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">{{ __("Update your account's profile information.") }}</p>
                </header>

                <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-input" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        @error('name')
                            <div class="bg-red-700 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-input" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        @error('email')
                            <div class="bg-red-700 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>

                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success mt-3">
                                {{ __('Profile updated successfully.') }}
                            </div>
                        @endif
                    </div>
                </form>
            </section>

            <!-- Update Password Form -->
            <section class="mb-5">

                <div class="mt-6 space-y-6">
                    @include('profile.partials.update-password-form')
                </div>
            </section>


            <!-- Delete Account Section -->
            <section class="mb-5 gold-border">
                <div class="mt-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
