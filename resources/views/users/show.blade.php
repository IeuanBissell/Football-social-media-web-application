@extends('layouts.app')

@section('content')
<div class="profile-container">
    <h1 class="profile-title">{{ $user->name }}'s Profile</h1>

    {{-- Posts Section --}}
    <div class="posts-section">
        <h2 class="section-title">Posts</h2>
        @if($user->posts->isNotEmpty())
            <div class="cards-wrapper">
                @foreach($user->posts as $post)
                    <div class="card post-card">
                        <div class="card-header">
                            <strong>{{ $post->user->name ?? 'Unknown User' }}</strong>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $post->content }}</p>
                            <small class="text-muted">Posted on {{ $post->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-content-message">{{ $user->name }} has not created any posts yet.</p>
        @endif
    </div>

    {{-- Comments Section --}}
    <div class="comments-section">
        <h2 class="section-title">Comments</h2>
        @if($user->comments->isNotEmpty())
            <div class="cards-wrapper">
                @foreach($user->comments as $comment)
                    <div class="card comment-card">
                        <div class="card-header">
                            <strong>{{ $comment->user->name ?? 'Unknown User' }}</strong>
                            <small class="text-muted">on Post: "{{ $comment->post->content ?? 'Unknown Post' }}"</small>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $comment->content }}</p>
                            <small class="text-muted">Commented on {{ $comment->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-content-message">{{ $user->name }} has not made any comments yet.</p>
        @endif
    </div>
</div>
@endsection
