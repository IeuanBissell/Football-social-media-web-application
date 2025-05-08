@extends('layouts.app')

@section('content')
<div class="profile-container">
    <div class="hero-section">
        <h1 class="profile-title">{{ $user->name }}'s Profile</h1>
        <p>Welcome to your personal profile page!</p>
    </div>

    {{-- Posts Section --}}
    <h2 class="section-title">Posts</h2>
    @if($user->posts->isNotEmpty())
        <div class="cards-wrapper">
            @foreach($user->posts as $post)
                <div class="content-card">
                    <div class="content-card-header">
                        <strong>{{ $post->user->name ?? 'Unknown User' }}</strong>
                        <span class="text-muted">{{ $post->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="content-card-body">
                        <div class="post-content">{{ $post->content }}</div>
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="post-image">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-content-message">
            <i class="fas fa-file-alt" aria-hidden="true"></i>
            <p>{{ $user->name }} has not created any posts yet.</p>
        </div>
    @endif

    {{-- Comments Section --}}
    <h2 class="section-title">Comments</h2>
    @if($user->comments->isNotEmpty())
        <div class="cards-wrapper">
            @foreach($user->comments as $comment)
                <div class="content-card">
                    <div class="content-card-header">
                        <strong>{{ $comment->user->name ?? 'Unknown User' }}</strong>
                        <span class="text-muted">{{ $comment->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="content-card-body">
                        <div class="comment-content">{{ $comment->content }}</div>
                    </div>
                    <div class="content-card-footer">
                        On post: "{{ Str::limit($comment->post->content ?? 'Unknown Post', 50) }}"
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-content-message">
            <i class="fas fa-comment-slash" aria-hidden="true"></i>
            <p>{{ $user->name }} has not made any comments yet.</p>
        </div>
    @endif
</div>
@endsection
