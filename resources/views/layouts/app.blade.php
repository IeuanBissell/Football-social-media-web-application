<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'HalfTime')</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Bootstrap CSS - Direct link to ensure it works -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('css/halftime-light-theme.css') }}" rel="stylesheet">

        <!-- Livewire Styles -->
        @livewireStyles

        <!-- Vite Integration -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <!-- Header Navigation -->
        <header class="site-header bg-white shadow-sm">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <!-- Logo -->
                        <a class="navbar-brand text-success fw-bold" href="{{ url('/') }}">
                            <i class="fas fa-futbol me-2"></i> HalfTime
                        </a>

                        <!-- Mobile Toggle Button -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Navigation Links -->
                        <div class="collapse navbar-collapse" id="navbarContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('fixtures*') ? 'active' : '' }}" href="{{ route('fixtures.index') }}">
                                        <i class="fas fa-calendar-alt me-1"></i> Fixtures
                                    </a>
                                </li>
                                @auth
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                    </a>
                                </li>
                                @endauth
                            </ul>

                            <!-- Search Field -->
                            @auth
                            <form class="d-flex mx-3 position-relative">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 bg-light" placeholder="Search users..." id="userSearchInput">
                                </div>
                                <div class="position-absolute w-100 top-100 start-0 mt-1 d-none" id="searchResults" style="z-index: 1000;">
                                    <!-- Search results will appear here -->
                                </div>
                            </form>
                            @endauth

                            <div class="d-flex align-items-center">
                                @auth
                                <!-- Simple non-bootstrap Dropdown that will definitely work -->
                                <div class="dropdown">
                                    <a href="#" class="text-decoration-none text-dark d-flex align-items-center" onclick="toggleDropdown(event)">
                                        <span class="me-2">{{ Auth::user()->name }}</span>
                                        <i class="fas fa-user-circle fs-4 text-success"></i>
                                    </a>
                                    <div id="userDropdownMenu" class="position-absolute bg-white shadow rounded mt-2 end-0 py-2" style="min-width: 200px; right: 0; display: none; z-index: 1000;">
                                        <a href="{{ route('user.show', Auth::id()) }}" class="dropdown-item py-2 px-4 d-block">
                                            <i class="fas fa-user me-2"></i> Profile
                                        </a>
                                        <a href="{{ route('profile.edit') }}" class="dropdown-item py-2 px-4 d-block">
                                            <i class="fas fa-cog me-2"></i> Edit Profile
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 px-4 text-start w-100 bg-transparent border-0">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @else
                                <!-- Login/Register Links -->
                                <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Login</a>
                                @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-success">Register</a>
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
            <div class="container">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-light py-4 mt-5 border-top">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} HalfTime. All rights reserved.</p>
            </div>
        </footer>

        <!-- Bootstrap JS - Direct link to ensure it works -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

        <!-- Livewire Scripts -->
        @livewireScripts

        <!-- Additional Scripts -->
        @yield('scripts')

        <!-- Custom JS for Dropdown -->
        <script>
            // Simple toggle function for the dropdown
            function toggleDropdown(event) {
                event.preventDefault();
                const menu = document.getElementById('userDropdownMenu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            }

            // Close dropdown when clicking elsewhere
            document.addEventListener('click', function(event) {
                const dropdown = document.querySelector('.dropdown');
                const menu = document.getElementById('userDropdownMenu');

                if (dropdown && menu && !dropdown.contains(event.target)) {
                    menu.style.display = 'none';
                }
            });

            // User Search JavaScript
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
                            searchResults.classList.add('d-none');
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
                                        searchResults.innerHTML = '<div class="list-group-item p-3">No users found</div>';
                                    } else {
                                        // Create results list
                                        const resultsList = document.createElement('div');
                                        resultsList.className = 'list-group shadow';

                                        data.forEach(user => {
                                            const item = document.createElement('a');
                                            item.href = `/users/${user.id}`;
                                            item.className = 'list-group-item list-group-item-action p-3';
                                            item.innerHTML = `
                                                <div class="fw-bold">${user.name}</div>
                                                <small class="text-muted">${user.email}</small>
                                            `;
                                            resultsList.appendChild(item);
                                        });

                                        searchResults.appendChild(resultsList);
                                    }

                                    // Show results
                                    searchResults.classList.remove('d-none');
                                })
                                .catch(error => {
                                    console.error('Error fetching search results:', error);
                                });
                        }, 300); // 300ms debounce
                    });

                    // Hide results when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                            searchResults.classList.add('d-none');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
