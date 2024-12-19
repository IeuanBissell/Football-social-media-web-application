@extends('layouts.app')

@section('title', 'HalfTime')

@section('content')
    <div class="welcome-container text-center">
        <h2 class="welcome-heading">Connect. Compete. Celebrate.</h2>
        <p class="welcome-subheading">Stay updated on your favorite teams, interact with fans, and celebrate the beautiful game!</p>
        
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card welcome-card">
                    <div class="card-body">
                        <h5 class="card-title">Latest Fixtures</h5>
                        <p class="card-text">Catch up on all the latest fixtures from around the world.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card welcome-card">
                    <div class="card-body">
                        <h5 class="card-title">Stats galore</h5>
                        <p class="card-text">Get in-depth insights about your favorite teams.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card welcome-card">
                    <div class="card-body">
                        <h5 class="card-title">Fan Zone</h5>
                        <p class="card-text">Join the community and share your passion for football.</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('register') }}" class="btn btn-success btn-lg mt-4">Join Now</a>
    </div>
@endsection
