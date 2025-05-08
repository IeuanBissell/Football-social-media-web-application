@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <!-- Welcome Section -->
    <div class="hero-section">
        <h1 id="greeting-heading">Welcome Back, {{ Auth::user()->name }}!</h1>
        <p>Your football social hub dashboard</p>
    </div>

    <!-- Dashboard Links -->
    <div class="dashboard-grid">
        <!-- View Profile Link -->
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-user-circle" aria-hidden="true"></i>
            </div>
            <h2 class="card-title">Your Activity</h2>
            <p class="card-text">View all your posts and comments</p>
            <a href="{{ route('user.show', Auth::user()->id) }}" class="primary-button">View Profile</a>
        </div>

        <!-- Edit Profile Link -->
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-edit" aria-hidden="true"></i>
            </div>
            <h2 class="card-title">Edit Profile</h2>
            <p class="card-text">Change your details or preferences</p>
            <a href="{{ route('profile.edit') }}" class="primary-button">Edit Profile</a>
        </div>

        <!-- View Fixtures Link -->
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-futbol" aria-hidden="true"></i>
            </div>
            <h2 class="card-title">View Fixtures</h2>
            <p class="card-text">Explore upcoming football matches</p>
            <a href="{{ route('fixtures.index') }}" class="primary-button">View Fixtures</a>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <h2 class="section-title">Recent Activity</h2>

    <!-- Notifications Section -->
    <div class="feature-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-bell" aria-hidden="true"></i> Notifications
                @php
                    $unreadCount = Auth::user()->unreadNotifications ? Auth::user()->unreadNotifications->count() : 0;
                @endphp

                @if($unreadCount > 0)
                    <span class="badge">{{ $unreadCount }}</span>
                @endif
            </h3>
        </div>

        <div class="notification-list">
            @if(Auth::user()->notifications->count() > 0)
                @foreach(Auth::user()->notifications as $notification)
                    <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                        <div class="notification-icon">
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
                                    <i class="fas fa-heart" style="color: #dc3545;" aria-hidden="true"></i>
                                @elseif($interactionType == 'comment')
                                    <i class="fas fa-comment" style="color: #0d6efd;" aria-hidden="true"></i>
                                @elseif($interactionType == 'share')
                                    <i class="fas fa-share-alt" style="color: var(--primary);" aria-hidden="true"></i>
                                @else
                                    <i class="fas fa-bell" style="color: #ffc107;" aria-hidden="true"></i>
                                @endif
                            @elseif($notificationType == 'newpost')
                                <i class="fas fa-file-alt" style="color: var(--primary);" aria-hidden="true"></i>
                            @else
                                <i class="fas fa-bell" style="color: #6c757d;" aria-hidden="true"></i>
                            @endif
                        </div>
                        <div class="notification-content">
                            <p>
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
                            <div class="notification-meta">
                                <small>{{ $notification->created_at->diffForHumans() }}</small>

                                <div>
                                    @if(isset($notification->data['fixture_id']))
                                        <a href="{{ route('fixtures.show', $notification->data['fixture_id']) }}" class="btn-sm primary-button">
                                            View
                                        </a>
                                    @elseif(isset($notification->data['post_id']))
                                        <a href="{{ route('fixtures.show', $notification->data['post_id']) }}" class="btn-sm primary-button">
                                            View Post
                                        </a>
                                    @endif

                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: inline-block; margin-left: 0.5rem;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-link">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="text-center mt-4">
                    <a href="{{ route('notifications.index') }}" class="secondary-button">View All Notifications</a>
                </div>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-bell-slash" style="font-size: 2rem; color: #6c757d; margin-bottom: 0.5rem;" aria-hidden="true"></i>
                    <p style="color: #6c757d;">No new notifications</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Time-based greeting
    const welcomeHeading = document.getElementById('greeting-heading');
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
    const cards = document.querySelectorAll('.dashboard-card');
    cards.forEach((card, index) => {
        // Add a slight delay to each card for a cascade effect
        setTimeout(() => {
            card.classList.add('animated');
        }, 100 * index);
    });

    // Live clock and date
    const welcomeSection = document.querySelector('.hero-section');
    if (welcomeSection) {
        const clockDiv = document.createElement('div');
        clockDiv.className = 'dashboard-clock';

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
