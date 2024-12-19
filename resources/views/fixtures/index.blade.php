@extends('layouts.app')

@section('title', 'Fixture List')

@section('content')
    <div class="fixture-list-container">
        <h1 class="display-4 mb-4 fw-bold text-center">Upcoming Fixtures</h1>

        @if ($fixtures->count())
            <div class="fixture-cards-wrapper">
                @foreach ($fixtures as $fixture)
                    <a href="{{ route('fixtures.show', ['id' => $fixture->id]) }}" class="card mb-3 text-decoration-none fixture-card">
                        <div class="card-body bg-dark text-white d-flex justify-content-between align-items-center">
                            <div class="text-start">
                                <strong class="d-block fs-5">
                                    {{ $fixture->homeTeam->name }}
                                    <span class="text-danger">vs</span>
                                    {{ $fixture->awayTeam->name }}
                                </strong>
                                <small class="d-block text-info">Location: {{ $fixture->location }}</small>
                                <small class="d-block text-warning">Date: {{ $fixture->match_date }}</small>
                            </div>
                            <span class="btn btn-outline-light btn-sm">
                                View Posts
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $fixtures->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-warning w-50 text-center">
                <p class="mb-0">No fixtures found. Check back later!</p>
            </div>
        @endif
    </div>
@endsection