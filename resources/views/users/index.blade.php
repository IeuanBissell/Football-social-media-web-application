@extends('layouts.app')

@section('title', 'User List')

@section('content')
    <h1>Users</h1>

    @if ($users->count())
        <ul class="list-group">
            @foreach ($users as $user)
                <li class="list-group-item">{{ $user->name }}</li>
            @endforeach
        </ul>

        <!-- Render Pagination Links -->
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    @else
        <p>No users found.</p>
    @endif
@endsection