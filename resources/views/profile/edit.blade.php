@extends('layouts.app')

@section('content')
<div class="profile-edit-container">
    <h1 class="profile-edit-title">Your Profile</h1>

    <div class="profile-section">
        <div class="section-header">
            <h2 class="edit-section-title">{{ __('Profile Information') }}</h2>
            <p class="section-description">{{ __("Update your account's profile information.") }}</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name" class="text-green">{{ __('Name') }}</label>
                <input type="text" class="form-input" id="name" name="name" value="{{ Auth::user()->name }}" required>
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="text-green">{{ __('Email') }}</label>
                <input type="email" class="form-input" id="email" name="email" value="{{ Auth::user()->email }}" required>
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="primary-button">{{ __('Update Profile') }}</button>

                @if (session('status') === 'profile-updated')
                    <div class="success-message mt-3">
                        {{ __('Profile updated successfully.') }}
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Update Password Form -->
    <div class="profile-section">
        <div class="section-header">
            <h2 class="section-title">{{ __('Update Password') }}</h2>
            <p class="section-description">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="current_password" class="text-green">{{ __('Current Password') }}</label>
                <input type="password" class="form-input" id="current_password" name="current_password" autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="text-green">{{ __('New Password') }}</label>
                <input type="password" class="form-input" id="password" name="password" autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="text-green">{{ __('Confirm Password') }}</label>
                <input type="password" class="form-input" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="primary-button">{{ __('Update Password') }}</button>

                @if (session('status') === 'password-updated')
                    <div class="success-message mt-3">
                        {{ __('Password updated successfully.') }}
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Delete Account Section -->
    <div class="profile-section danger-section">
        <div class="section-header">
            <h2 class="section-title">{{ __('Delete Account') }}</h2>
            <p class="section-description">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
        </div>

        <button type="button" class="danger-button" onclick="document.getElementById('deleteModal').style.display='flex'">
            {{ __('Delete Account') }}
        </button>

        <!-- Delete Account Modal -->
        <div id="deleteModal" class="modal-overlay" style="display: none;">
            <div class="modal-container">
                <div class="modal-header">
                    <h3 class="section-title">{{ __('Are you sure you want to delete your account?') }}</h3>
                    <p class="section-description">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="form-group">
                        <label for="password" class="text-green">{{ __('Password') }}</label>
                        <input type="password" class="form-input" id="password" name="password" placeholder="{{ __('Password') }}">
                        @error('password', 'userDeletion')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="secondary-button" onclick="document.getElementById('deleteModal').style.display='none'">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="danger-button">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Close modal when clicking outside of it
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('deleteModal');
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Show modal if there are errors in the deletion form
        @if($errors->userDeletion->isNotEmpty())
            document.getElementById('deleteModal').style.display = 'flex';
        @endif
    });
</script>
@endsection
