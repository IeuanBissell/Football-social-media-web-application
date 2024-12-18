<!-- resources/views/user/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-success">{{ $user->name }}'s Profile</h1>

    <!-- User's Posts -->
    <h3 class="mt-4">Posts</h3>
    <ul class="list-group list-group-flush">
        @foreach ($user->posts as $post)
            <li class="list-group-item bg-dark text-white p-4 mb-3 rounded shadow-sm">
                <h5 class="fw-bold text-success">{{ $post->user->name }}</h5>
                <p class="mb-2">{{ $post->content }}</p>
                <p class="post-date mb-3">Posted {{ $post->created_at->diffForHumans() }}</p>

                <!-- Show Comments for this Post -->
                <button class="btn btn-outline-warning btn-sm show-comments-btn" data-post-id="{{ $post->id }}">
                    {{ $post->comments->count() }} Comments
                </button>

                <!-- Comments Section -->
                <div class="comments-list" id="commentsList-{{ $post->id }}">
                    @foreach ($post->comments as $comment)
                        <div class="comment-card bg-dark text-white p-2 my-2 rounded">
                            <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                            <p class="text-muted">Commented {{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
