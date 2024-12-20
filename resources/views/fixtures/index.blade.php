@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Fixtures</h1>
    <ul class="list-group">
        @foreach ($fixtures as $fixture)
            <li class="list-group-item">
                <a href="{{ route('fixtures.show', $fixture->id) }}">
                    {{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}
                </a>
                <span class="badge bg-secondary">{{ $fixture->match_date }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
