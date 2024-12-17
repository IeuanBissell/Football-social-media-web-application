@extends('layouts.app')

@section('title', 'Welcome to Football League Social Media')

@section('content')
    <div class="text-center">
        <h2 class="mb-4 text-success">Connect. Compete. Celebrate.</h2>
        <p class="lead mb-5 text-white-50">Stay updated on your favorite teams, interact with fans, and celebrate the beautiful game!</p>
        
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card bg-secondary text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Latest Matches</h5>
                        <p class="card-text">Catch up on all the latest matches and scores in real time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-secondary text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Team Highlights</h5>
                        <p class="card-text">Get in-depth insights and news about your favorite teams.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-secondary text-white shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Fan Zone</h5>
                        <p class="card-text">Join the community and share your passion for football.</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('register') }}" class="btn btn-success btn-lg mt-4">Join Now</a>
    </div>
@endsection
