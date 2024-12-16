@extends('layouts.app')

@section('title', 'Fixture Details')

@section('content')
<div class="container text-center mt-5">
    <h1>{{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</h1>
    <p>{{ $fixture->location }}</p>
    <h3>Posts Related to this Fixture</h3>

        @if($fixture->posts->count())
            <ul class="list-group">
                @foreach ($fixture->posts as $post)
                    <li class="list-group-item">
                        <h5>{{ $post->user->name }}</h5>
                        <p>{{ $post->content }}</p>
                        <p>
                            <strong>{{ $post->comments->count() }} Comments</strong>
                            <a href="{{ route('posts.comments.index', $post->id) }}" class="btn btn-link">View Comments</a>
                        </p>
                    </li>
                    <br>
                @endforeach
            </ul>
        @else
            <p>No posts found for this fixture.</p>
        @endif
    <a href="{{ route('fixtures.index') }}" class="btn btn-primary">Back to Fixtures</a>
@endsection
