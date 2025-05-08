<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchUsers extends Component
{
    public $search = '';
    public $results = [];
    public $showDropdown = false;

    protected $listeners = ['clickAway' => 'closeDropdown'];

    public function updatedSearch()
    {
        $this->resetPage();

        if (strlen($this->search) >= 2) {
            $this->results = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->limit(5)
                ->get();

            $this->showDropdown = count($this->results) > 0;
        } else {
            $this->results = [];
            $this->showDropdown = false;
        }
    }

    public function resetPage()
    {
        $this->reset('results');
    }

    public function closeDropdown()
    {
        $this->showDropdown = false;
    }

    public function render()
    {
        return view('livewire.search-users');
    }
}
