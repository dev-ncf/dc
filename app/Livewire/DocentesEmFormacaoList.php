<?php

namespace App\Livewire;

use App\Models\DocenteEmFormacao;
use App\Models\OrganicUnit;
use Livewire\Component;
use Livewire\WithPagination;

class DocentesEmFormacaoList extends Component
{
    use WithPagination;

    // Propriedades de busca e filtros sincronizadas na URL
    public string $search = '';
    public string $selectedUnit = '';
    public string $selectedLevel = '';

    // Reseta a paginação ao digitar ou mudar filtros
    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingSelectedUnit(): void { $this->resetPage(); }
    public function updatingSelectedLevel(): void { $this->resetPage(); }

    public function render()
    {
        $docentes = DocenteEmFormacao::query()
            ->with('organicUnit')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome_completo', 'like', "%{$this->search}%")
                      ->orWhere('curso', 'like', "%{$this->search}%")
                      ->orWhere('instituicao', 'like', "%{$this->search}%");
                });
            })
            ->when($this->selectedUnit, function ($query) {
                $query->where('organic_unit_id', $this->selectedUnit);
            })
            ->when($this->selectedLevel, function ($query) {
                $query->where('nivel_em_curso', $this->selectedLevel);
            })
            ->orderBy('nome_completo', 'asc')
            ->paginate(12);

        $unidades = OrganicUnit::orderBy('name')->get();

        return view('livewire.docentes-em-formacao-list', [
            'docentes' => $docentes,
            'unidades' => $unidades,
        ]);
    }
}