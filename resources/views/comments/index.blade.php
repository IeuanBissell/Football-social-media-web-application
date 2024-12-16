@extends('layouts.app')

@section('content')

    <h1>Comments for Post: {{ $post->content }}</h1>
    @if ($comments->count())
        <ul class="list-group">
            @foreach ($comments as $comment)
                <li class="list-group-item">
                    @if ($comment->user)
                        <strong>{{ $comment->user->name }}</strong>
                    @else
                        <strong>Anonymous</strong>
                    @endif
                    <p>{{ $comment->content }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p>No comments yet.</p>
    @endif

    <h2>Add a Comment</h2>
    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf
        <textarea name="content" class="form-control" rows="2" placeholder="Add your comment..." required></textarea>
        <button type="submit" class="btn btn-primary mt-3">Add Comment</button>
    </form>
    <br>
    <a href="{{ route('fixtures.show', $post->fixture->id) }}" class="btn btn-secondary">Back to Fixture</a>
@endsection