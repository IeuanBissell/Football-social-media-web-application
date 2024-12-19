@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Notifications</h1>
    <ul class="list-group">
        @foreach ($notifications as $notification)
            <form action="/notifications/read" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Mark All as Read</button>
            </form>
            <li class="list-group-item">
                {{ $notification->data['message'] }}
                <a href="{{ url('/posts/' . ($notification->data['post_id'] ?? '')) }}">View</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
