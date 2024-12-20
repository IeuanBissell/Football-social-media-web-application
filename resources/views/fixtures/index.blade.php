@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="fixtures-header text-center mb-5">
        <h1 class="text-black display-4 fw-bold">Upcoming Fixtures</h1>
        <p class="text-muted lead">Stay updated with the latest match schedules!</p>
    </div>

    <!-- Fixture List -->
    <div class="fixtures-list">
        <ul class="list-group list-group-flush">
            @foreach ($fixtures as $fixture)
                <li class="list-group-item fixture-card shadow-lg mb-3 p-4 rounded">
                    <a href="{{ route('fixtures.show', $fixture->id) }}" class="text-decoration-none text-dark">
                        <h5 class="fw-bold text-success">
                            {{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}
                        </h5>
                    </a>
                    <p class="text-muted small">Match Date: {{ $fixture->match_date }}</p>
                    <span class="badge bg-success">{{ $fixture->location }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
