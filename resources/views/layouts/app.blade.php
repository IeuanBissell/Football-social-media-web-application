<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'HalfTime')</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Custom CSS -->
        <link href="{{ asset('css/halftime-light-theme.css') }}" rel="stylesheet">

        <!-- Livewire Styles -->
        @livewireStyles

        <!-- Vite Integration -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <!-- Header Navigation -->
        <header class="site-header">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <!-- Logo -->
                        <a class="navbar-brand gradient-text" href="{{ url('/') }}">
                            <i class="fas fa-futbol"></i> HalfTime
                        </a>

                        <!-- Mobile Toggle Button -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Navigation Links -->
                        <div class="collapse navbar-collapse" id="navbarContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('fixtures*') ? 'active' : '' }}" href="{{ route('fixtures.index') }}">Fixtures</a>
                                </li>
                                @auth
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ url('/dashboard') }}">Dashboard</a>
                                </li>
                                @endauth
                            </ul>

                            <!-- Search Field (Simple Non-Livewire Version) -->
                            @auth
                            <div class="d-flex mx-3" style="width: 250px; position: relative;">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" placeholder="Search users..." aria-label="Search users" id="userSearchInput">
                                </div>
                                <div class="position-absolute w-100" style="top: 100%; z-index: 1000; display: none;" id="searchResults"></div>
                            </div>
                            @endauth

                            <div class="d-flex align-items-center">
                                @auth
                                <!-- User Dropdown -->
                                <div class="dropdown user-dropdown">
                                    <button class="btn dropdown-toggle user-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="me-2">{{ Auth::user()->name }}</span>
                                        <i class="fas fa-user-circle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('user.show', Auth::id()) }}">Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @else
                                <!-- Login/Register Links -->
                                <a href="{{ route('login') }}" class="btn btn-custom me-2">Login</a>
                                @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                                @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <div class="page-container py-4">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="container text-center">
                <p>&copy; {{ date('Y') }} HalfTime. All rights reserved.</p>
            </div>
        </footer>

        <!-- Alpine.js (for Livewire interactions) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Livewire Scripts -->
        @livewireScripts

        <!-- Additional Scripts -->
        @yield('scripts')

        <!-- User Search JavaScript -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('userSearchInput');
            const searchResults = document.getElementById('searchResults');

            if (searchInput) {
                let debounceTimer;

                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    // Clear previous timer
                    clearTimeout(debounceTimer);

                    // Hide results if query is empty
                    if (query.length < 2) {
                        searchResults.style.display = 'none';
                        return;
                    }

                    // Set a new timer
                    debounceTimer = setTimeout(function() {
                        // Fetch results
                        fetch(`/api/users/search?q=${query}`)
                            .then(response => response.json())
                            .then(data => {
                                // Clear previous results
                                searchResults.innerHTML = '';

                                if (data.length === 0) {
                                    // No results found
                                    searchResults.innerHTML = '<div class="list-group-item">No users found</div>';
                                } else {
                                    // Create results list
                                    const resultsList = document.createElement('div');
                                    resultsList.className = 'list-group';

                                    data.forEach(user => {
                                        const item = document.createElement('a');
                                        item.href = `/users/${user.id}`;
                                        item.className = 'list-group-item list-group-item-action';
                                        item.innerHTML = `
                                            <div class="fw-bold">${user.name}</div>
                                            <small class="text-muted">${user.email}</small>
                                        `;
                                        resultsList.appendChild(item);
                                    });

                                    searchResults.appendChild(resultsList);
                                }

                                // Show results
                                searchResults.style.display = 'block';
                            })
                            .catch(error => {
                                console.error('Error fetching search results:', error);
                            });
                    }, 300); // 300ms debounce
                });

                // Hide results when clicking outside
                document.addEventListener('click', function(event) {
                    if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                        searchResults.style.display = 'none';
                    }
                });
            }
        });
        </script>
    </body>
</html>
