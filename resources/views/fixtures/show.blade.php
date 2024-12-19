@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100 d-flex flex-row p-0">
    <!-- Left Column: Fixture Details -->
    <div class="fixture-details col-md-4 d-flex flex-column align-items-start justify-content-center p-4 bg-dark text-white rounded-end shadow">
        <h1 class="display-6 fw-bold text-success mb-3">
            {{ $fixture->homeTeam->name }} <span class="text-danger">vs</span> {{ $fixture->awayTeam->name }}
        </h1>
        <p class="fs-5 mb-3">Location: {{ $fixture->location }}</p>
        <p class="fs-5 mb-4">Date: {{ $fixture->match_date }}</p>
        <a href="{{ route('fixtures.index') }}" class="btn btn-success btn-lg shadow">Back to Fixtures</a>
    </div>

    <!-- Right Column: Posts Section -->
    <div class="posts-section col-md-8 p-5 bg-secondary text-light rounded-start">
        <h3 class="mb-4 text-uppercase fw-bold text-light">Posts</h3>

        <!-- Create Post Form -->
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="fixture_id" value="{{ $fixture->id }}">
            <div class="form-group">
                <textarea name="content" placeholder="Write a post..." class="form-control" required rows="4"></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="image">Upload Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create Post</button>
        </form>

        <!-- Display Posts -->
        @if($fixture->posts->count())
            <ul class="list-group list-group-flush mt-4">
                @foreach ($fixture->posts as $post)
                    <li class="list-group-item bg-dark text-white p-4 mb-3 rounded shadow-sm post-item">
                        <h5 class="fw-bold text-success">
                            <a href="{{ route('user.show', $post->user->id) }}" class="text-success text-decoration-none">
                                {{ $post->user->name }}
                            </a>
                        </h5>
                        <p class="mb-2">{{ $post->content }}</p>
                        @if($post->image)
                            <img src="{{ asset('storage/images/' . $post->image) }}" alt="Post Image" class="img-fluid my-3" style="max-width: 100%; height: auto;">
                        @endif
                        <p class="post-date mb-3">Posted {{ $post->created_at->diffForHumans() }}</p>

                        <!-- Edit and Delete Buttons -->
                        @if($post->user_id == auth()->id())
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @elseif(auth()->user()->is_admin)
                            <!-- Admin can edit or delete any post -->
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif

                        <!-- View Comments Button -->
                        <button class="btn btn-outline-warning btn-sm show-comments-btn" data-post-id="{{ $post->id }}">
                            {{ $post->comments->count() }} Comments
                        </button>

                        <!-- Comments Overlay - Initially Hidden -->
                        <div class="comments-overlay d-none" id="commentsOverlay-{{ $post->id }}">
                            <div class="overlay-content">
                                
                                <!-- Display the Post content as well -->
                                <div class="post-content mb-4">
                                    <div class="post-header">
                                        <span class="fw-bold">{{ $post->user->name }}</span>
                                        <small class="text-muted">Posted {{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p>{{ $post->content }}</p>
                                </div>
                                
                                <!-- List of Comments -->
                                <div class="comments-list" id="commentsList-{{ $post->id }}">
                                    <!-- Comments will be fetched and populated here via JavaScript -->
                                </div>

                                 <!-- Add Comment Form in Overlay -->
                                 <div class="add-comment-section">
                                    <textarea id="commentText-{{ $post->id }}" class="form-control" rows="2" placeholder="Add your comment..." required></textarea>
                                    <button class="btn btn-primary mt-2" id="addCommentBtn-{{ $post->id }}" data-post-id="{{ $post->id }}">Add Comment</button>
                                </div>

                                <!-- Close Button for the Overlay -->
                                <button class="btn btn-secondary mt-3 close-comments-btn" data-post-id="{{ $post->id }}">Close</button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-warning">
                No posts found for this fixture.
            </div>
        @endif
    </div>
</div>

<!-- Include CSRF token in the meta tag for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Inline JavaScript for Comments Overlay -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Show comments when the "View Comments" button is clicked
        document.querySelectorAll('.show-comments-btn').forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                const overlay = document.getElementById('commentsOverlay-' + postId);
                const commentsList = document.getElementById('commentsList-' + postId);

                // Show the comments overlay
                overlay.classList.remove('d-none');

                // Fetch and display comments
                fetch(`/posts/${postId}/comments`)
                    .then(response => response.json())
                    .then(data => {
                        commentsList.innerHTML = ''; // Clear any previous loading message
                        data.comments.forEach(comment => {
                            commentsList.innerHTML += `
                                <div class="card mb-2 bg-dark text-light shadow-sm comment-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-success">${comment.user_name}</span>
                                        <small class="text-muted">Posted ${comment.created_at}</small>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">${comment.content}</p>
                                    </div>
                                </div>
                            `;
                        });
                    });
            });
        });

        // Close the comments overlay when the close button is clicked
        document.querySelectorAll('.close-comments-btn').forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                const overlay = document.getElementById('commentsOverlay-' + postId);
                overlay.classList.add('d-none');
            });
        });

        // Close the overlay when clicking outside of the content area (on the overlay background)
        document.querySelectorAll('.comments-overlay').forEach(overlay => {
            overlay.addEventListener('click', function (event) {
                if (event.target === overlay) { // If the click was on the background area
                    overlay.classList.add('d-none');
                }
            });
        });

        // Add comment functionality
        document.querySelectorAll('.btn[id^="addCommentBtn"]').forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                const commentText = document.getElementById('commentText-' + postId).value;

                if (!commentText.trim()) {
                    alert('Comment cannot be empty');
                    return;
                }

                fetch(`/posts/${postId}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ content: commentText }),
                })
                .then(response => response.json())
                .then(data => {
                    const commentsList = document.getElementById('commentsList-' + postId);
                    commentsList.innerHTML += `
                        <div class="card mb-2 bg-dark text-light shadow-sm comment-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">${data.user_name}</span>
                                <small class="text-muted">Posted just now</small>
                            </div>
                            <div class="card-body">
                                <p class="card-text">${data.content}</p>
                            </div>
                        </div>
                    `;

                    // Clear the textarea and update comment count
                    document.getElementById('commentText-' + postId).value = '';
                    const commentCountButton = document.querySelector(`.show-comments-btn[data-post-id="${postId}"]`);
                    commentCountButton.textContent = `${data.comment_count} Comments`;
                });
            });
        });
    });
</script>

@endsection