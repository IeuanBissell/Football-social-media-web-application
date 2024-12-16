@extends('layouts.app')

@section('title','Fixture information')

@section('content')
    <ul>
        <li>Home Team: {{ $fixture->home_team_id}}</li>
    </ul>
@endsection