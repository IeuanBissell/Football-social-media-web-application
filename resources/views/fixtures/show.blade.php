@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Fixture Details Section -->
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h1 class="display-4 text-dark">{{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</h1>
            <p><strong class="text-dark">Location:</strong> {{ $fixture->location }}</p>
            <p><strong class="text-dark">Date:</strong> {{ $fixture->match_date }}</p>
        </div>
    </div>

    <!-- Post Creation Form Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h3 class="text-success">Create a Post</h3>
            <form action="{{ route('posts.store', $fixture->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="Write your post..." required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="image" class="text-muted">Upload Image (optional)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-custom">Post</button>
            </form>
        </div>
    </div>

    <!-- Posts Section -->
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-dark">Posts</h3>
            @if($fixture->posts->count())
                <div class="list-group">
                    @foreach($fixture->posts as $post)
                        <div class="list-group-item mb-4 bg-light border-0 shadow-sm">
                            <!-- Post Content -->
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold text-success">
                                    <a href="{{ route('user.show', $post->user->id) }}" class="text-decoration-none text-dark">
                                        {{ $post->user->name }}
                                    </a>
                                </h5>
                                <span class="badge bg-secondary text-light">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            <p>{{ $post->content }}</p>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid my-3 rounded">
                            @endif

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
                                <div class="list-group">
                                    @foreach($post->comments as $comment)
                                        <div class="list-group-item bg-light">
                                            <p class="mb-1">
                                                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                                            </p>
                                            <p class="text-muted small">Commented {{ $comment->created_at->diffForHumans() }}</p>

                                            <!-- Edit and Delete Options for the Comment -->
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
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Add Comment Form -->
                            @auth
                            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="form-group">
                                    <textarea name="content" class="form-control" rows="2" placeholder="Add a comment..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-custom mt-2">Comment</button>
                            </form>
                            @endauth
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">No posts yet for this fixture. Be the first to post!</p>
            @endif
        </div>
    </div>
</div>
@endsection