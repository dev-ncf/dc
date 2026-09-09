<?php

namespace App\Livewire;

use App\Models\PublicationPolicy;
use Livewire\Component;

class PublicationPolicyExplorer extends Component
{
    public $search = '';
    public $selectedCategory = '';

    public function render()
    {
        $query = PublicationPolicy::query()->where('is_active', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedCategory) {
            $query->where('category', $this->selectedCategory);
        }

        return view('livewire.publication-policy-explorer', [
            'policies' => $query->latest()->get(),
        ])->layout('components.layouts.app');
    }
}