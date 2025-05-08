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
                                        <div class="notification-meta d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>

                                            <div class="d-flex align-items-center">
                                                @if(str_contains($notification->type, 'NewPostNotification') && isset($notification->data['post_id']))
                                                    <a href="{{ isset($notification->data['fixture_id']) ? route('fixtures.show', $notification->data['fixture_id']) : '#' }}" class="btn btn-sm btn-primary me-2">
                                                        View Post
                                                    </a>
                                                @elseif(str_contains($notification->type, 'PostInteractionNotification') && isset($notification->data['post_id']))
                                                    <a href="{{ isset($notification->data['fixture_id']) ? route('fixtures.show', $notification->data['fixture_id']) : '#' }}" class="btn btn-sm btn-primary me-2">
                                                        View
                                                    </a>
                                                @endif

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

        <!-- Recent Activity Section (Replaces Recent Posts) -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fas fa-comment-alt me-2"></i> Recent Activity
                    </h5>
                    <div class="recent-activity-list">
                        @if(isset($recentActivity) && count($recentActivity) > 0)
                            @foreach($recentActivity as $activity)
                                <div class="activity-item">
                                    <div class="d-flex align-items-start">
                                        <div class="activity-icon me-3">
                                            @if($activity['type'] == 'post')
                                                <i class="fas fa-file-alt text-success"></i>
                                            @elseif($activity['type'] == 'comment')
                                                <i class="fas fa-comment text-primary"></i>
                                            @endif
                                        </div>
                                        <div class="activity-content flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold">{{ $activity['user_name'] }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">
                                                @if($activity['type'] == 'post')
                                                    Posted in {{ $activity['fixture_name'] }}
                                                @elseif($activity['type'] == 'comment')
                                                    Commented on a post in {{ $activity['fixture_name'] }}
                                                @endif
                                            </p>
                                            <p class="activity-text">{{ Str::limit($activity['content'], 100) }}</p>
                                            <a href="{{ $activity['url'] }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center mt-3">
                                <a href="{{ route('fixtures.index') }}" class="btn btn-custom btn-sm">View All Fixtures</a>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles for Recent Activity */
.recent-activity-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.activity-item {
  background-color: white;
  border-radius: var(--border-radius-md);
  padding: 1rem;
  border-left: 3px solid var(--green-primary);
  transition: var(--transition-smooth);
  margin-bottom: 0.75rem;
}

.activity-item:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-soft);
}

.activity-icon {
  width: 34px;
  height: 34px;
  background: linear-gradient(to bottom right, var(--cream), white);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.activity-content {
  flex: 1;
}

.activity-text {
  color: var(--dark-text);
  font-size: 0.95rem;
  margin-bottom: 0.75rem;
  line-height: 1.4;
}

/* Alternate colors for post vs comment */
.activity-item:nth-child(odd) {
  border-left-color: var(--green-primary);
}

.activity-item:nth-child(even) {
  border-left-color: var(--gold);
}
</style>
@endsection
