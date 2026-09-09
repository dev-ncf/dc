<?php

namespace App\Livewire;

use App\Models\InnovationProject;
use App\Models\KnowledgeArea;
use Livewire\Component;
use Livewire\WithPagination;

class InnovationExplorer extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedType = '';
    public $selectedStatus = '';

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $query = InnovationProject::query()
            ->with(['inventor', 'knowledgeArea'])
            ->where('is_public', 1);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('abstract', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedType) $query->where('innovation_type', $this->selectedType);
        if ($this->selectedStatus) $query->where('status', $this->selectedStatus);

        return view('livewire.innovation-explorer', [
            'projects' => $query->latest()->paginate(9),
            'areas' => KnowledgeArea::all(),
        ])->layout('components.layouts.app');
    }
}