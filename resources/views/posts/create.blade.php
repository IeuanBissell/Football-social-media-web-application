@extends('layouts.app')

@section('content')
<div class="profile-edit-container">
    <h1 class="profile-edit-title">Create a Post</h1>

    <div class="profile-section">
        <form action="{{ route('posts.store', ['fixture_id' => $fixture->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="form-group">
                <label for="content" class="text-green">Content</label>
                <textarea class="form-input" id="content" name="content" rows="4" required></textarea>
                @error('content')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="text-green">Upload Image (optional)</label>
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
                <button type="submit" class="primary-button">Create Post</button>
                <a href="{{ route('fixtures.show', $fixture->id) }}" class="secondary-button">Cancel</a>
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
