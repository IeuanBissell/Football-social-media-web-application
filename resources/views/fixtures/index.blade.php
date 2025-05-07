@extends('layouts.app')

@section('content')
<div class="fixtures-container">
    <div class="fixtures-header">
        <h1>Upcoming Fixtures</h1>
        <p>Stay updated with the latest match schedules!</p>
    </div>

    <!-- Fixture Cards -->
    <div class="fixtures-grid">
        @foreach ($fixtures as $fixture)
            <a href="{{ route('fixtures.show', $fixture->id) }}" class="fixture-card">
                <div class="teams">
                    <span class="team home">{{ $fixture->homeTeam->name }}</span>
                    <span class="vs">VS</span>
                    <span class="team away">{{ $fixture->awayTeam->name }}</span>
                </div>
                <div class="fixture-details">
                    <div class="detail">
                        <span class="icon">📅</span>
                        <span>{{ $fixture->match_date }}</span>
                    </div>
                    <div class="detail">
                        <span class="icon">📍</span>
                        <span>{{ $fixture->location }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="pagination-container">
        {{ $fixtures->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
