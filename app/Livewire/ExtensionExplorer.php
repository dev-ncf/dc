<?php

namespace App\Livewire;

use App\Models\ExtensionProject;
use App\Models\KnowledgeArea;
use Livewire\Component;
use Livewire\WithPagination;

class ExtensionExplorer extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedArea = '';
    public $selectedStatus = '';

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $query = ExtensionProject::query()
            ->with(['coordinator', 'knowledgeArea'])
            ->where('is_public', 1); // Apenas projetos públicos

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('abstract', 'like', '%' . $this->search . '%')
                  ->orWhere('community_partner', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedArea) $query->where('knowledge_area_id', $this->selectedArea);
        if ($this->selectedStatus) $query->where('status', $this->selectedStatus);

        return view('livewire.extension-explorer', [
            'projects' => $query->latest()->paginate(9),
            'areas' => KnowledgeArea::all(),
        ])->layout('components.layouts.app');
    }
}   