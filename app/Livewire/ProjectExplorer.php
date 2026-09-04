<?php

namespace App\Livewire;

use App\Models\ResearchProject;
use App\Models\OrganicUnit;
use App\Models\KnowledgeArea;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectExplorer extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUnit = '';
    public $selectedArea = '';
    public $selectedStatus = '';

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $query = ResearchProject::query()
            ->with(['coordinator', 'organicUnit', 'knowledgeArea'])
            ->whereIn('is_public', [1]); // Apenas projetos públicos

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('abstract', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedUnit) $query->where('organic_unit_id', $this->selectedUnit);
        if ($this->selectedArea) $query->where('knowledge_area_id', $this->selectedArea);
        if ($this->selectedStatus) $query->where('status', $this->selectedStatus);

        return view('livewire.project-explorer', [
            'projects' => $query->latest()->paginate(9),
            'units' => OrganicUnit::all(),
            'areas' => KnowledgeArea::all(),
        ])->layout('components.layouts.app');
    }
}