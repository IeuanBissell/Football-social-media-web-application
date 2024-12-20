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
        
        <!-- Create Post Form -->
        <form id="createPostForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="fixture_id" value="{{ $fixture->id }}">
            <div class="form-group">
                <textarea name="content" id="postContent" placeholder="Write a post..." class="form-control" required rows="4"></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="image">Upload Image (optional)</label>
                <input type="file" name="image" accept="image/*" class="form-control" id="postImage">
            </div>
            <button type="submit" id="createPostBtn" class="btn btn-primary mt-3">Create Post</button>
        </form>
    </div>

    <!-- Right Column: Posts Section -->
    <div class="posts-section col-md-8 p-5 bg-secondary text-light rounded-start">
        <h3 class="mb-4 text-uppercase fw-bold text-light">Posts</h3>

        @if($fixture->posts->count())
            <ul class="list-group list-group-flush">
                @foreach ($fixture->posts as $post)
                    <li class="list-group-item bg-dark text-white p-4 mb-3 rounded shadow-sm post-item">
                        <!-- Make the username clickable and link to the user's profile page -->
                        <h5 class="fw-bold text-success">
                            <a href="{{ route('user.show', $post->user->id) }}" class="text-success text-decoration-none">
                                {{ $post->user->name }}
                            </a>
                        </h5>
                        <p class="mb-2">{{ $post->content }}</p>
                        <p class="post-date mb-3">Posted {{ $post->created_at->diffForHumans() }}</p>

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
        const fixtureId = '{{ $fixture->id }}';
        const createPostForm = document.getElementById('createPostForm');
        const createPostBtn = document.getElementById('createPostBtn');

        // Handle Post Creation via AJAX
        createPostForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(createPostForm);

            // Disable the button to prevent multiple submissions
            createPostBtn.disabled = true;
            createPostBtn.innerText = 'Submitting...';

            // Send the POST request to the route using the named route
            fetch("{{ route('posts.store', ['id' => $fixture->id]) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // If successful, insert the new post into the list
                    const newPostHtml = `
                        <li class="list-group-item bg-dark text-white p-4 mb-3 rounded shadow-sm post-item" id="post-${data.post.id}">
                            <h5 class="fw-bold text-success">${data.user_name}</h5>
                            <p class="mb-2">${data.post.content}</p>
                            ${data.image_url ? `<img src="${data.image_url}" alt="Post Image" class="img-fluid my-3" style="max-width: 100%; height: auto;">` : ''}
                            <p class="post-date mb-3">Posted just now</p>
                        </li>
                    `;
                    document.getElementById('postsList').insertAdjacentHTML('afterbegin', newPostHtml);

                    // Clear the form fields
                    document.getElementById('postContent').value = '';
                    document.getElementById('postImage').value = '';

                    // Restore the button state
                    createPostBtn.disabled = false;
                    createPostBtn.innerText = 'Create Post';
                } else {
                    // Handle error response
                    alert('Error creating post: ' + (data.message || 'Unknown error'));
                    createPostBtn.disabled = false;
                    createPostBtn.innerText = 'Create Post';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the post.');
                createPostBtn.disabled = false;
                createPostBtn.innerText = 'Create Post';
            });
        });

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
                    data.comments.forEach(comment => {
                        commentsList.innerHTML += `
                            <div class="card mb-2 bg-dark text-light shadow-sm comment-card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-success">${comment.user_name || 'Anonymous'}</span>
                                    <small class="text-muted">Posted ${comment.created_at}</small>
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

        // Function to add a comment and update comment count
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
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ content })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Comment added:', data);

                // Dynamically append the new comment to the overlay without reloading
                const commentsList = document.getElementById('commentsList-' + postId);
                commentsList.innerHTML += `
                    <div class="card mb-2 bg-dark text-light shadow-sm comment-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-success">${data.user_name || 'Anonymous'}</span>
                            <small class="text-muted">Posted just now</small>
                        </div>
                        <div class="card-body">
                            <p class="card-text">${data.content}</p>
                        </div>
                    </div>
                `;

                // Clear the comment input field
                document.getElementById('commentText-' + postId).value = '';

                // Update the comment count on the button dynamically
                const commentCountButton = document.querySelector(`.show-comments-btn[data-post-id="${postId}"]`);
                commentCountButton.textContent = `${data.comment_count} Comments`;
            })
            .catch(error => {
                console.error('Error adding comment:', error);
            });
        }
    });
</script>
@endsection
