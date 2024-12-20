@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to the Application</h1>
    <p>Explore fixtures, posts, and more!</p>
    <a href="{{ route('fixtures.index') }}" class="btn btn-primary">View Fixtures</a>
</div>
@endsection