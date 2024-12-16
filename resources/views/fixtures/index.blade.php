@extends('layouts.app')

@section('title', 'User List')

@section('content')
    <h1>Fixtures</h1>

    @if ($fixtures->count())
        <ul class='list-group'>
            @foreach ($fixtures as $fixture)
                <li class='list-group-item'>{{ $fixture->name }}</li>
            @endforeach
        </ul>
        <div class='mt-3'>
            {{ $fixtures->links() }}
        </div>
    @else
        <p>No fixtures found.</p>
    @endif
@endsection