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
        <!-- Notifications Section - Full Width -->
        <div class="col-md-12 mb-4">
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
                        @if(Auth::user()->notifications->count() > 0)
                            @foreach(Auth::user()->notifications as $notification)
                                <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                                    <div class="notification-icon">
                                        <!-- Debug: Display notification type -->
                                        @php
                                            $type = class_basename($notification->type);
                                            $notificationType = '';

                                            if (str_contains($notification->type, 'PostInteraction')) {
                                                $notificationType = 'interaction';
                                                $interactionType = $notification->data['type'] ?? 'unknown';
                                            } elseif (str_contains($notification->type, 'NewPost')) {
                                                $notificationType = 'newpost';
                                            } else {
                                                $notificationType = 'general';
                                            }
                                        @endphp

                                        @if($notificationType == 'interaction')
                                            @if($interactionType == 'like')
                                                <i class="fas fa-heart text-danger"></i>
                                            @elseif($interactionType == 'comment')
                                                <i class="fas fa-comment text-primary"></i>
                                            @elseif($interactionType == 'share')
                                                <i class="fas fa-share-alt text-success"></i>
                                            @else
                                                <i class="fas fa-bell text-warning"></i>
                                            @endif
                                        @elseif($notificationType == 'newpost')
                                            <i class="fas fa-file-alt text-success"></i>
                                        @else
                                            <i class="fas fa-bell text-secondary"></i>
                                        @endif
                                    </div>
                                    <div class="notification-content">
                                        <p>
                                            <!-- Debug: Display notification data -->
                                            @if(isset($notification->data['message']))
                                                {{ $notification->data['message'] }}
                                            @elseif($notificationType == 'newpost')
                                                {{ $notification->data['author'] ?? 'Someone' }} posted {{ isset($notification->data['title']) && !empty($notification->data['title']) ? '"' . $notification->data['title'] . '"' : 'a new post' }}
                                            @elseif($notificationType == 'interaction')
                                                @if($interactionType == 'like')
                                                    {{ $notification->data['user_name'] ?? 'Someone' }} liked your post
                                                @elseif($interactionType == 'comment')
                                                    {{ $notification->data['user_name'] ?? 'Someone' }} commented on your post
                                                @elseif($interactionType == 'share')
                                                    {{ $notification->data['user_name'] ?? 'Someone' }} shared your post
                                                @else
                                                    {{ $notification->data['user_name'] ?? 'Someone' }} interacted with your post
                                                @endif
                                            @else
                                                You have a new notification
                                            @endif
                                        </p>
                                        <div class="notification-meta d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>

                                            <div class="d-flex align-items-center">
                                                @if(isset($notification->data['fixture_id']))
                                                    <a href="{{ route('fixtures.show', $notification->data['fixture_id']) }}" class="btn btn-sm btn-primary me-2">
                                                        View
                                                    </a>
                                                @elseif(isset($notification->data['post_id']))
                                                    <a href="{{ route('fixtures.show', $notification->data['post_id']) }}" class="btn btn-sm btn-primary me-2">
                                                        View Post
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
    </div>
</div>
@endsection
@section('scripts')
<style>
/* Dashboard Card Animations */
.card {
    transition: transform 0.3s, box-shadow 0.3s;
    opacity: 0;
    transform: translateY(20px);
}

.card-animated {
    opacity: 1;
    transform: translateY(0);
}

.card-hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}

/* Dashboard Clock */
.dashboard-clock {
    font-size: 1rem;
    color: #6c757d;
    margin-top: 0.5rem;
    text-align: center;
}

/* Optional: Make notification items look nicer with animations */
.notification-item {
    transition: background-color 0.3s;
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}

.notification-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time-based greeting
    const welcomeHeading = document.querySelector('.welcome-section h1');
    if (welcomeHeading) {
        const currentHour = new Date().getHours();
        let greeting;

        if (currentHour < 12) {
            greeting = 'Good Morning';
        } else if (currentHour < 18) {
            greeting = 'Good Afternoon';
        } else {
            greeting = 'Good Evening';
        }

        // Get the username from the existing heading
        const usernameText = welcomeHeading.textContent;
        const username = usernameText.split(',')[1]?.trim().replace('!', '') || '';

        // Update the heading with the time-based greeting
        welcomeHeading.textContent = `${greeting}, ${username}!`;
    }

    // Card animations
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        // Add a slight delay to each card for a cascade effect
        setTimeout(() => {
            card.classList.add('card-animated');
        }, 100 * index);

        // Add hover effects
        card.addEventListener('mouseenter', function() {
            this.classList.add('card-hover');
        });

        card.addEventListener('mouseleave', function() {
            this.classList.remove('card-hover');
        });
    });

    // Live clock and date
    const welcomeSection = document.querySelector('.welcome-section');
    if (welcomeSection) {
        const clockDiv = document.createElement('div');
        clockDiv.className = 'dashboard-clock mt-2';

        function updateClock() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            clockDiv.textContent = now.toLocaleDateString('en-US', options);
        }

        updateClock();
        setInterval(updateClock, 1000);
        welcomeSection.appendChild(clockDiv);
    }
});
</script>
@endsection
