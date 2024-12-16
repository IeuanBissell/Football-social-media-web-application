@extends('layouts.app')

@section('title', 'Fixture List')

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100 text-center">
        <h1 class="mb-4">Fixtures</h1>

        @if ($fixtures->count())
            <ul class="list-group w-50">
                @foreach ($fixtures as $fixture)
                    <li class="list-group-item bg-dark text-white">
                        <!-- Match Details -->
                        <div class="mb-2">
                            <strong class="d-block">{{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</strong>
                            <small class="text-muted">{{ $fixture->location }}</small>
                        </div>

                        <!-- Link to More Information -->
                        <a href="{{ route('fixtures.show', ['id' => $fixture->id]) }}" class="btn btn-success btn-sm">
                            View More Information
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $fixtures->links('pagination::bootstrap-5') }}
            </div>
        @else
            <p class="text-muted">No fixtures found.</p>
        @endif
    </div>
@endsection
