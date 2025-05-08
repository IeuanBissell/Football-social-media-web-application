@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Notifications') }}</h5>
                    <div>
                        @if($notifications->isNotEmpty())
                            <div class="btn-group" role="group">
                                <form action="{{ route('notifications.read.all') }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        {{ __('Mark All as Read') }}
                                    </button>
                                </form>
                                <form action="{{ route('notifications.destroy.all') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete all notifications?')">
                                        {{ __('Delete All') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body">
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

                    @if($notifications->isNotEmpty())
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item list-group-item-action d-flex justify-content-between {{ $notification->read_at ? '' : 'list-group-item-light' }} py-3">
                                    <div>
                                        @if(!$notification->read_at)
                                            <span class="badge bg-primary me-2">New</span>
                                        @endif

                                        @if(isset($notification->data['message']))
                                            <p class="mb-1">{{ $notification->data['message'] }}</p>
                                        @elseif(str_contains($notification->type, 'NewPostNotification') && isset($notification->data['title']))
                                            <p class="mb-1">
                                                {{ $notification->data['author'] ?? 'Someone' }} posted {{ $notification->data['title'] ? '"' . $notification->data['title'] . '"' : 'a new post' }}
                                            </p>
                                        @else
                                            <p class="mb-1">
                                                {{ __('You have a new notification') }}
                                            </p>
                                        @endif

                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if(isset($notification->data['post_id']))
                                            <a href="{{ isset($notification->data['fixture_id']) ? url('/fixtures/' . $notification->data['fixture_id']) : url('/posts/' . $notification->data['post_id']) }}" class="btn btn-sm btn-primary me-2">
                                                {{ __('View') }}
                                            </a>
                                        @endif

                                        @if(!$notification->read_at)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="me-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    {{ __('Mark as Read') }}
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="mb-0">{{ __('You have no notifications.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
