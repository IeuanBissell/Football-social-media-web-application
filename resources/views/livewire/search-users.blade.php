<div class="dashboard-search futuristic-accent" x-data="{}" @click.away="$wire.closeDropdown()">
    <div class="input-group">
        <span class="input-group-text search-icon"><i class="fas fa-search"></i></span>
        <input
            type="text"
            wire:model.debounce.300ms="search"
            class="form-control"
            placeholder="Search for users..."
            aria-label="Search"
            autocomplete="off"
        >
    </div>

    @if($showDropdown)
    <div class="search-results-dropdown gold-border">
        @if(count($results) > 0)
            @foreach($results as $user)
            <a href="{{ route('user.show', $user->id) }}" class="search-result-item">
                <div class="search-result-name">{{ $user->name }}</div>
                <div class="search-result-email">{{ $user->email }}</div>
            </a>
            @endforeach
        @else
            <div class="search-no-results">No users found</div>
        @endif
    </div>
    @endif
</div>
