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

        @if($fixture->posts->count())
            <ul class="list-group list-group-flush">
                @foreach ($fixture->posts as $post)
                    <li class="list-group-item bg-dark text-white p-4 mb-3 rounded shadow-sm post-item">
                        <h5 class="fw-bold text-success">{{ $post->user->name }}</h5>
                        <p class="mb-2">{{ $post->content }}</p>
                        <p class="post-date mb-3">Posted {{ $post->created_at->diffForHumans() }}</p>
                        <p class="mb-0">
                            <!-- View Comments Button -->
                            <button class="btn btn-outline-warning btn-sm show-comments-btn" data-post-id="{{ $post->id }}">
                                {{ $post->comments->count() }} Comments
                            </button>
                        </p>
                        
                        <!-- Comments Overlay - Initially Hidden -->
                        <div class="comments-overlay d-none mt-4" id="commentsOverlay-{{ $post->id }}">
                            <div class="overlay-content">
                                <h5 class="text-success">Comments for {{ $post->user->name }}'s Post</h5>
                                
                                <!-- Display the Post content as well -->
                                <div class="post-content mb-4">
                                    <div class="post-header">
                                        <span class="fw-bold">{{ $post->user->name }}</span>
                                        <small class="text-muted">Posted {{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p>{{ $post->content }}</p>
                                </div>
                                
                                <div class="comments-list" id="commentsList-{{ $post->id }}"></div>

                                <!-- Add Comment Form -->
                                <div class="mt-4">
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

<!-- Inline JavaScript for Comments Overlay -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Event listener for each "View Comments" button
        document.querySelectorAll('.show-comments-btn').forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.getAttribute('data-post-id');
                fetchComments(postId);
            });
        });

        // Function to fetch comments
        function fetchComments(postId) {
            const commentsOverlay = document.getElementById('commentsOverlay-' + postId);
            const commentsList = document.getElementById('commentsList-' + postId);

            // Show the comments overlay
            commentsOverlay.classList.remove('d-none');
            commentsList.innerHTML = 'Loading comments...';

            // Fetch comments from the server
            fetch(`/posts/${postId}/comments`)
                .then(response => response.json())
                .then(data => {
                    commentsList.innerHTML = ''; // Clear loading message

                    // Loop through the comments and add them to the list
                    data.comments.forEach(comment => {
                        commentsList.innerHTML += `
                            <div class="card mb-2 bg-secondary shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-success">
                                        ${comment.user_name || 'Anonymous'}
                                    </span>
                                    <small class="text-muted">
                                        Posted ${comment.created_at}
                                    </small>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">${comment.content}</p>
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error fetching comments:', error);
                    commentsList.innerHTML = '<p class="text-danger">Failed to load comments. Please try again.</p>';
                });
        }

        // Event listener for "Close" button to hide the overlay
        document.querySelectorAll('.close-comments-btn').forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.getAttribute('data-post-id');
                const commentsOverlay = document.getElementById('commentsOverlay-' + postId);
                commentsOverlay.classList.add('d-none'); // Hide the overlay
            });
        });

        // Close the overlay when clicking outside of the content area
        document.querySelectorAll('.comments-overlay').forEach(overlay => {
            overlay.addEventListener('click', (event) => {
                if (event.target === overlay) { // If the click was on the background
                    overlay.classList.add('d-none');
                }
            });
        });

        // Event listener for "Add Comment" button
        document.querySelectorAll('.btn[id^="addCommentBtn"]').forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.getAttribute('data-post-id');
                const commentText = document.getElementById('commentText-' + postId).value;
                addComment(postId, commentText);
            });
        });

        // Function to add a comment
        function addComment(postId, content) {
            if (!content.trim()) {
                alert('Comment cannot be empty');
                return;
            }

            // Send AJAX request to add the comment
            fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ content })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Comment added:', data);
                // After adding, refetch and display the updated comments
                fetchComments(postId);
            })
            .catch(error => {
                console.error('Error adding comment:', error);
            });
        }
    });
</script>

@endsection