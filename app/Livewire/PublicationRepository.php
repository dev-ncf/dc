<?php

namespace App\Livewire;

use App\Models\Publication;
use App\Models\DocumentType;
use App\Models\KnowledgeArea;
use App\Models\OrganicUnit;
use Livewire\Component;
use Livewire\WithPagination;

class PublicationRepository extends Component
{
    use WithPagination;

    // Propriedades de Busca e Filtro
    public $search = '';
    public $selectedType = '';
    public $selectedArea = '';
    public $selectedUnit = '';
    public $selectedYear = '';
    public $sort = 'latest';

    // Resetar página ao mudar filtros
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'selectedType', 'selectedArea', 'selectedUnit', 'selectedYear'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Publication::query()
            ->with(['documentType', 'knowledgeArea', 'organicUnit']) // Eager loading para performance
            ->where('status', 'approved');

        // Filtro de Texto (Título, Resumo ou Autor)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('abstract', 'like', '%' . $this->search . '%')
                  ->orWhere('author_name', 'like', '%' . $this->search . '%')
                  ->orWhere('keywords', 'like', '%' . $this->search . '%');
            });
        }

        // Filtros exatos
        if ($this->selectedType) $query->where('document_type_id', $this->selectedType);
        if ($this->selectedArea) $query->where('knowledge_area_id', $this->selectedArea);
        if ($this->selectedUnit) $query->where('organic_unit_id', $this->selectedUnit);
        if ($this->selectedYear) $query->where('publication_year', $this->selectedYear);

        // Ordenação
        if ($this->sort === 'latest') $query->latest();
        if ($this->sort === 'oldest') $query->oldest();
        if ($this->sort === 'title') $query->orderBy('title', 'asc');

        return view('livewire.publication-repository', [
            'publications' => $query->paginate(10),
            'types' => DocumentType::all(),
            'areas' => KnowledgeArea::all(),
            'units' => OrganicUnit::all(),
            'years' => Publication::select('publication_year')->distinct()->orderBy('publication_year', 'desc')->pluck('publication_year')
        ])->layout('components.layouts.app');
    }
}