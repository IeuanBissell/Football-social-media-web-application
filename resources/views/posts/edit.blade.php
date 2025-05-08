@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', ['fixture' => $fixture, 'post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="content" class="form-label">Post Content</label>
            <textarea class="form-control" id="content" name="content" rows="5">{{ $post->content }}</textarea>
        </div>

        @if($post->image)
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current Post Image" style="max-width: 300px;" class="img-thumbnail">
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label for="image" class="form-label">Change Image (optional)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Update Post</button>
        <a href="{{ route('fixtures.show', $fixture) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
