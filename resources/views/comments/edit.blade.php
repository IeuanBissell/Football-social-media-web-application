@extends('layouts.app')

@section('content')
<div class="profile-edit-container">
    <h1 class="profile-edit-title">Edit Comment</h1>

    <div class="profile-section">
        <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="content" class="text-green">Comment</label>
                <textarea class="form-input" id="content" name="content" rows="3">{{ $comment->content }}</textarea>
                @error('content')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="action-buttons">
                <button type="submit" class="primary-button">Update Comment</button>
                <a href="{{ url()->previous() }}" class="secondary-button">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
