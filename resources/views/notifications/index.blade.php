@extends('layouts.app')

@section('content')
<div class="profile-container">
    <h1 class="profile-section-title">{{ __('Notifications') }}</h1>

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

    <div class="content-card">
        @if($notifications->isNotEmpty())
            <div class="content-card-header d-flex justify-content-between align-items-center">
                <div class="edit-section-title">Manage Notifications</div>
                <div class="action-buttons">
                    <form action="{{ route('notifications.read.all') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="secondary-button btn-sm">
                            {{ __('Mark All as Read') }}
                        </button>
                    </form>
                    <form action="{{ route('notifications.destroy.all') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="danger-button btn-sm"
                            onclick="return confirm('Are you sure you want to delete all notifications?')">
                            {{ __('Delete All') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="content-card-body">
                <div class="notification-list">
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->read_at ? 'read' : 'unread' }}">
                            <div class="notification-content">
                                @if(!$notification->read_at)
                                    <span class="badge">New</span>
                                @endif

                                <p>
                                    @if(isset($notification->data['message']))
                                        {{ $notification->data['message'] }}
                                    @elseif(str_contains($notification->type, 'NewPostNotification') && isset($notification->data['title']))
                                        {{ $notification->data['author'] ?? 'Someone' }} posted {{ $notification->data['title'] ? '"' . $notification->data['title'] . '"' : 'a new post' }}
                                    @else
                                        {{ __('You have a new notification') }}
                                    @endif
                                </p>
                                <div class="notification-meta">
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>

                                    <div class="action-buttons">
                                        @if(isset($notification->data['post_id']))
                                            <a href="{{ isset($notification->data['fixture_id']) ? url('/fixtures/' . $notification->data['fixture_id']) : url('/posts/' . $notification->data['post_id']) }}" class="primary-button btn-sm">
                                                {{ __('View') }}
                                            </a>
                                        @endif

                                        @if(!$notification->read_at)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="secondary-button btn-sm">
                                                    {{ __('Mark as Read') }}
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="danger-button btn-sm">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-container">
                    {{ $notifications->links() }}
                </div>
            </div>
        @else
            <div class="no-content-message">
                <i class="fas fa-bell-slash" aria-hidden="true"></i>
                <p>{{ __('You have no notifications.') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
