<?php

namespace App\Livewire;

use App\Models\ResearchPolicy;
use Livewire\Component;

class PolicyExplorer extends Component
{
    public $search = '';
    public $selectedCategory = '';

    public function render()
    {
        $query = ResearchPolicy::query()->where('is_active', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedCategory) {
            $query->where('category', $this->selectedCategory);
        }

        return view('livewire.policy-explorer', [
            'policies' => $query->latest()->get(),
        ])->layout('components.layouts.app');
    }
}