@extends('layouts.app')

@section('title', 'Fixture Details')

@section('content')
<div class="container text-center mt-5">
    <h1>{{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</h1>
    <p>{{ $fixture->location }}</p>
    <a href="{{ route('fixtures.index') }}" class="btn btn-primary">Back to Fixtures</a>
@endsection
