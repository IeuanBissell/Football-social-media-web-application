@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a Post</h1>
    <form action="{{ route('posts.store', ['fixture_id' => $fixture->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Post</button>
    </form>
</div>
@endsection
