@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Fixture Details -->
        <div class="col-md-12">
            <h1 class="display-5">{{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</h1>
            <p><strong>Location:</strong> {{ $fixture->location }}</p>
            <p><strong>Date:</strong> {{ $fixture->match_date }}</p>
        </div>
    </div>

    <!-- Post Creation Form -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Create a Post</h3>
            <form action="{{ route('posts.store', $fixture->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="Write your post..." required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="image">Upload Image (optional)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>
    </div>

    <!-- Posts Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Posts</h3>
            @if($fixture->posts->count())
                <ul class="list-group">
                    @foreach($fixture->posts as $post)
                        <li class="list-group-item mb-4 bg-light">
                            <!-- Post Content -->
                            <div>
                                <h5 class="fw-bold text-success">
                                    <a href="{{ route('user.show', $post->user->id) }}" class="text-decoration-none">
                                        {{ $post->user->name }}
                                    </a>
                                </h5>
                                <p>{{ $post->content }}</p>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid my-3">
                                @endif
                                <p class="text-muted small">Posted {{ $post->created_at->diffForHumans() }}</p>
                            </div>

                            <!-- Edit and Delete Options for the Post -->
                            @can('edit', $post)
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endcan

                            @can('delete', $post)
                            <form action="{{ route('posts.destroy', ['fixture_id' => $post->fixture_id, 'post' => $post->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @endcan

                            <!-- Comments Section -->
                            <div class="mt-4">
                                <h6>Comments</h6>
                                <ul class="list-group">
                                    @foreach($post->comments as $comment)
                                        <li class="list-group-item">
                                            <p class="mb-1">
                                                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                                            </p>
                                            <p class="text-muted small">Commented {{ $comment->created_at->diffForHumans() }}</p>

                                            <!-- Edit and Delete Options for the Comments -->
                                            @can('edit', $comment)
                                                <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            @endcan

                                            @can('delete', $comment)
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            @endcan
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Add Comment Form -->
                            @auth
                            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="form-group">
                                    <textarea name="content" class="form-control" rows="2" placeholder="Add a comment..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary mt-2">Comment</button>
                            </form>
                            @endauth
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No posts yet for this fixture. Be the first to post!</p>
            @endif
        </div>
    </div>
</div>
@endsection