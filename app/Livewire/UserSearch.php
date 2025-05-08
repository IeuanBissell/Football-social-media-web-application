<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserSearch extends Component
{
    public $search = '';

    public function render()
    {
        $users = [];

        if (strlen($this->search) > 1) {
            $users = User::where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('email', 'like', '%' . $this->search . '%')
                         ->limit(10)
                         ->get();
        }

        return view('livewire.user-search', [
            'users' => $users
        ]);
    }
}
