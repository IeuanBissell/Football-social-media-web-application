@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Post</h1>
    <form action="{{ route('posts.store', ['fixture_id' => $fixture->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <textarea name="content" required></textarea>
        <input type="file" name="image">
        <button type="submit">Create Post</button>
    </form>
</div>
@endsection
