@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-5 text-center">
        <h1 class="display-4 gradient-text">Welcome Back, {{ Auth::user()->name }}!</h1>
        <p class="lead text-muted">Your football social hub dashboard</p>
    </div>

    <!-- Dashboard Links -->
    <div class="row">
        <!-- View Profile Link -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg futuristic-accent">
                <div class="card-body text-center">
                    <div class="card-icon mb-3">
                        <i class="fas fa-user-circle fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title text-success">Your Profile</h5>
                    <p class="card-text">View and update your personal details</p>
                    <a href="{{ route('user.show', Auth::user()->id) }}" class="btn btn-custom">View Profile</a>
                </div>
            </div>
        </div>

        <!-- Edit Profile Link -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg futuristic-accent">
                <div class="card-body text-center">
                    <div class="card-icon mb-3">
                        <i class="fas fa-edit fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title text-success">Edit Profile</h5>
                    <p class="card-text">Change your details or preferences</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-custom">Edit Profile</a>
                </div>
            </div>
        </div>

        <!-- View Fixtures Link -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg futuristic-accent">
                <div class="card-body text-center">
                    <div class="card-icon mb-3">
                        <i class="fas fa-futbol fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title text-success">View Fixtures</h5>
                    <p class="card-text">Explore upcoming football matches</p>
                    <a href="{{ route('fixtures.index') }}" class="btn btn-custom">View Fixtures</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row mt-4">
        <div class="col-12">
            <h2 class="section-title">Recent Activity</h2>
        </div>
    </div>

    <div class="row dashboard">
        <!-- Notifications Section -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fas fa-bell me-2"></i> Notifications
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                        @endif
                    </h5>
                    <div class="notification-list">
                        @if(Auth::user()->notifications->count() > 0)
                            @foreach(Auth::user()->notifications->take(5) as $notification)
                                <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }} p-2 mb-2 border-bottom">
                                    <div class="d-flex">
                                        <div class="notification-icon me-3">
                                            @if(str_contains($notification->type, 'PostInteractionNotification'))
                                                @if(isset($notification->data['type']) && $notification->data['type'] == 'like')
                                                    <i class="fas fa-heart text-danger"></i>
                                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'comment')
                                                    <i class="fas fa-comment text-primary"></i>
                                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'share')
                                                    <i class="fas fa-share-alt text-success"></i>
                                                @else
                                                    <i class="fas fa-bell text-warning"></i>
                                                @endif
                                            @elseif(str_contains($notification->type, 'NewPostNotification'))
                                                <i class="fas fa-file-alt text-info"></i>
                                            @else
                                                <i class="fas fa-bell text-secondary"></i>
                                            @endif
                                        </div>
                                        <div class="notification-content flex-grow-1">
                                            <p class="mb-1">
                                                @if(isset($notification->data['message']))
                                                    {{ $notification->data['message'] }}
                                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'like')
                                                    <strong>{{ $notification->data['user_name'] ?? 'Someone' }}</strong> liked your post
                                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'comment')
                                                    <strong>{{ $notification->data['user_name'] ?? 'Someone' }}</strong> commented on your post
                                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'share')
                                                    <strong>{{ $notification->data['user_name'] ?? 'Someone' }}</strong> shared your post
                                                @elseif(str_contains($notification->type, 'NewPostNotification'))
                                                    New post "{{ $notification->data['title'] ?? 'Untitled' }}" was published
                                                @else
                                                    You have a new notification
                                                @endif
                                            </p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if(!$notification->read_at)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center mt-3">
                                <a href="{{ route('notifications.index') }}" class="btn btn-custom btn-sm">View All Notifications</a>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No new notifications</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Posts Section -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fas fa-comment-alt me-2"></i> Your Recent Posts
                    </h5>
                    <div class="recent-posts-list">
                        @if(isset($posts) && count($posts) > 0)
                            @foreach($posts as $post)
                                <div class="recent-post-item p-2 mb-2 border-bottom">
                                    <p class="recent-post-content mb-1">{{ Str::limit($post->content, 100) }}</p>
                                    <div class="recent-post-meta d-flex justify-content-between">
                                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                        <a href="{{ route('fixtures.show', $post->fixture_id) }}" class="recent-post-link">View Post</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center mt-3">
                                <a href="{{ route('user.show', Auth::user()->id) }}" class="btn btn-custom btn-sm">View All Posts</a>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                                <p class="text-muted">You haven't created any posts yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add these styles to your CSS */
    .notification-item.unread {
        background-color: rgba(13, 110, 253, 0.05);
        border-left: 3px solid #0d6efd;
    }

    .gradient-text {
        background: linear-gradient(45deg, #28a745, #20c997);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-custom {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(32, 201, 151, 0.3);
        color: white;
    }

    .futuristic-accent {
        border-top: 3px solid #28a745;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .futuristic-accent:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.2);
    }

    .section-title {
        position: relative;
        margin-bottom: 30px;
        padding-bottom: 10px;
        color: #28a745;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(45deg, #28a745, #20c997);
    }
</style>
@endsection
