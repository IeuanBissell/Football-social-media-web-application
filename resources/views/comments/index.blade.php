@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center text-green mb-4">Comments</h2>

        <div class="comments-list">
            @foreach ($post->comments as $comment)
                <div class="card mb-3 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-green">
                            {{ $comment->user ? $comment->user->name : 'Anonymous' }}
                        </span>
                        <small class="text-muted">
                            Posted {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <h2 class="text-center text-green mt-5">Add a Comment</h2>
        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="form-container">
            @csrf
            <div class="form-group">
                <textarea name="content" class="form-control" rows="4" placeholder="Add your comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Add Comment</button>
        </form>
        <br>
        <div class="text-center">
            <a href="{{ route('fixtures.show', $post->fixture->id) }}" class="btn btn-secondary">Back to Fixture</a>
        </div>
    </div>
@endsection
