@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notifications</h1>
    <ul class="list-group">
        @foreach ($notifications as $notification)
            <li class="list-group-item">
                {{ $notification->data['message'] }}
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
            </li>
        @endforeach
    </ul>
    <form action="{{ route('notifications.read') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary mt-3">Mark All as Read</button>
    </form>
</div>
@endsection
