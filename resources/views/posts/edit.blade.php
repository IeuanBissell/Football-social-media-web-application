@extends('layouts.app')

@section('content')
<div class="profile-edit-container">
    <h1 class="profile-edit-title">Edit Post</h1>

    <div class="profile-section">
        <form action="{{ route('posts.update', ['fixture' => $fixture, 'post' => $post->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="content" class="text-green">Post Content</label>
                <textarea class="form-input" id="content" name="content" rows="5">{{ $post->content }}</textarea>
                @error('content')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            @if($post->image)
                <div class="form-group">
                    <label class="text-green">Current Image</label>
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Current Post Image" class="post-image">
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="image" class="text-green">Change Image (optional)</label>
                <input type="file" class="form-input" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                @error('image')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                <div id="image-preview" class="mt-2" style="display: none;">
                    <img src="" id="preview-img" class="post-image">
                    <button type="button" class="secondary-button" onclick="removeImage()">Remove Image</button>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="primary-button">Update Post</button>
                <a href="{{ route('fixtures.show', $fixture) }}" class="secondary-button">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        var preview = document.getElementById('preview-img');
        var previewContainer = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        document.getElementById('image').value = '';
        document.getElementById('image-preview').style.display = 'none';
        document.getElementById('preview-img').src = '';
    }
</script>
@endsection
