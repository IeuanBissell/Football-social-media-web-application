@extends('layouts.app')

@section('content')
<div class="fixtures-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Fixture Details Section -->
    <div class="fixtures-header">
        <h1>{{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</h1>
        <div class="fixture-meta">
            <p><span class="icon" aria-hidden="true">📍</span> {{ $fixture->location }}</p>
            <p><span class="icon" aria-hidden="true">📅</span> {{ $fixture->match_date }}</p>
        </div>
    </div>

    <!-- Post Creation Form Section -->
    <div class="content-card mb-4">
        <div class="content-card-header">
            <h2 class="edit-section-title">Create a Post</h2>
        </div>
        <div class="content-card-body">
            <form action="{{ route('posts.store', $fixture) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="form-group">
                    <textarea name="content" class="form-input" rows="3" placeholder="Write your post..." required></textarea>
                </div>
                <div class="form-group">
                    <label for="image" class="text-green">Upload Image (optional)</label>
                    <input type="file" name="image" id="image" class="form-input" accept="image/*" onchange="previewImage(this)">
                    <div id="image-preview" class="mt-2" style="display: none;">
                        <img src="" id="preview-img" class="post-image">
                        <button type="button" class="secondary-button" onclick="removeImage()">Remove Image</button>
                    </div>
                </div>
                <button type="submit" class="primary-button">Post</button>
            </form>
        </div>
    </div>

    <!-- Posts Section -->
    <h2 class="profile-section-title">Posts</h2>
    <div id="posts-list">
        @if($posts->count())
            <div class="cards-wrapper">
                @foreach($posts as $post)
                    <div class="content-card">
                        <!-- Post Content -->
                        <div class="content-card-header">
                            <a href="{{ route('user.show', $post->user->id) }}" class="card-author">
                                {{ $post->user->name }}
                            </a>
                            <span class="text-muted">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="content-card-body">
                            <div class="post-content">{{ $post->content }}</div>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="post-image">
                            @endif

                            <!-- Post Actions -->
                            <div class="action-buttons mt-2">
                                <!-- Edit Button - Only for author -->
                                @if(Auth::check() && Auth::id() == $post->user_id)
                                    <a href="{{ route('posts.edit', ['fixture' => $fixture->id, 'post' => $post->id]) }}" class="secondary-button btn-sm">Edit</a>
                                @endif

                                <!-- Delete Button - For author and admins -->
                                @if(Auth::check() && (Auth::id() == $post->user_id || Auth::user()->hasRole('admin')))
                                    <form action="{{ route('posts.destroy', ['fixture' => $fixture->id, 'post' => $post->id]) }}" method="POST" style="display: inline-block; margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="danger-button btn-sm">Delete</button>
                                    </form>
                                @endif
                            </div>

                            <!-- Comments Section -->
                            <div class="comments-section mt-4">
                                <h3 class="edit-section-title">Comments</h3>
                                @foreach($post->comments as $comment)
                                    <div class="comment-item">
                                        <div class="comment-header">
                                            <a href="{{ route('user.show', $comment->user->id) }}" class="comment-author">
                                                {{ $comment->user->name }}
                                            </a>
                                            <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="comment-content">{{ $comment->content }}</div>

                                        <!-- Comment Actions -->
                                        <div class="action-buttons mt-2">
                                            <!-- Edit Button - Only for author -->
                                            @if(Auth::check() && Auth::id() == $comment->user_id)
                                                <a href="{{ route('comments.edit', $comment->id) }}" class="secondary-button btn-sm">Edit</a>
                                            @endif

                                            <!-- Delete Button - For author and admins -->
                                            @if(Auth::check() && (Auth::id() == $comment->user_id || Auth::user()->hasRole('admin')))
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline-block; margin: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="danger-button btn-sm">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Add Comment Form -->
                            @auth
                            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form mt-3">
                                @csrf
                                <div class="form-group">
                                    <textarea name="content" class="form-input" rows="2" placeholder="Add a comment..." required></textarea>
                                </div>
                                <button type="submit" class="primary-button btn-sm">Comment</button>
                            </form>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-content-message">
                <i class="fas fa-file-alt" aria-hidden="true"></i>
                <p>No posts yet for this fixture. Be the first to post!</p>
            </div>
        @endif
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
