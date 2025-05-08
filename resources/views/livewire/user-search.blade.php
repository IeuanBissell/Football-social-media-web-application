<div>
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input
            wire:model.debounce.500ms="search"
            type="text"
            class="form-control"
            placeholder="Search users..."
            aria-label="Search users"
        >
    </div>

    @if (strlen($search) > 1)
        <div class="list-group position-absolute" style="z-index: 1000; width: 100%;">
            @forelse ($users as $user)
                <a href="{{ route('user.show', $user->id) }}" class="list-group-item list-group-item-action">
                    <div class="fw-bold">{{ $user->name }}</div>
                    <small class="text-muted">{{ $user->email }}</small>
                </a>
            @empty
                <div class="list-group-item">No users found</div>
            @endforelse
        </div>
    @endif
</div>
