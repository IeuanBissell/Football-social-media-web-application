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
                    <h5 class="card-title text-success">Your Activity</h5>
                    <p class="card-text">View all your posts and comments</p>
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
                        @php
                            $unreadCount = Auth::user()->unreadNotifications ? Auth::user()->unreadNotifications->count() : 0;
                        @endphp

                        @if($unreadCount > 0)
                            <span class="badge bg-danger">{{ $unreadCount }}</span>
                        @endif
                    </h5>
                    <div class="notification-list">
                        @if(isset($notifications) && count($notifications) > 0)
                            @foreach($notifications as $notification)
                                <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                                    <div class="notification-icon">
                                        @if(str_contains($notification->type, 'PostInteractionNotification'))
                                            @if(isset($notification->data['type']) && $notification->data['type'] == 'like')
                                                <i class="fas fa-heart"></i>
                                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'comment')
                                                <i class="fas fa-comment"></i>
                                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'share')
                                                <i class="fas fa-share-alt"></i>
                                            @else
                                                <i class="fas fa-bell"></i>
                                            @endif
                                        @elseif(str_contains($notification->type, 'NewPostNotification'))
                                            <i class="fas fa-file-alt"></i>
                                        @else
                                            <i class="fas fa-bell"></i>
                                        @endif
                                    </div>
                                    <div class="notification-content">
                                        <p>
                                            @if(isset($notification->data['message']))
                                                {{ $notification->data['message'] }}
                                            @elseif(str_contains($notification->type, 'NewPostNotification') && isset($notification->data['title']))
                                                {{ $notification->data['author'] ?? 'Someone' }} posted {{ $notification->data['title'] ? '"' . $notification->data['title'] . '"' : 'a new post' }}
                                            @else
                                                You have a new notification
                                            @endif
                                        </p>
                                        <div class="notification-meta">
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>

                                            @if(!$notification->read_at)
                                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-link p-0 ms-2">
                                                        <small>Mark as read</small>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
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
                                <div class="recent-post-item">
                                    <p class="recent-post-content">{{ Str::limit($post->content, 100) }}</p>
                                    <div class="recent-post-meta">
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
@endsection
