<?php


namespace App\Livewire;

use App\Models\Event;
use App\Models\OrganicUnit;
use Livewire\Component;
use Livewire\WithPagination;

class EventExplorer extends Component
{
    use WithPagination;

    // Filtro por Unidade Orgânica
    public $unitFilter = '';

    /**
     * Reinicia a paginação sempre que o filtro é alterado
     */
    public function updatedUnitFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Query base: Apenas eventos publicados e ordenados pela data de início (mais próximos primeiro)
        $query = Event::query()
            ->with('organicUnit') // Carrega a faculdade para evitar múltiplas consultas ao DB
            ->where('is_published', true)
            ->where('start_date', '>=', now()->subDays(1)); // Mostra eventos de hoje em diante

        // Aplica o filtro de Unidade Orgânica se selecionado
        if ($this->unitFilter) {
            $query->where('organic_unit_id', $this->unitFilter);
        }

        return view('livewire.event-explorer', [
            // Lista de eventos paginada (10 por página)
            'events' => $query->orderBy('start_date', 'asc')->paginate(10),
            
            // Lista de Unidades para o dropdown do filtro
            'units' => OrganicUnit::orderBy('name')->get(),
        ])->layout('components.layouts.app');
    }
}