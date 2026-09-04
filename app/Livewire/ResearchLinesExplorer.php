<?php

namespace App\Livewire;

use App\Models\OrganicUnit;
use App\Models\ResearchLine;
use Livewire\Component;

class ResearchLinesExplorer extends Component
{
    public $selectedUnitId = null;

    public function render()
    {
        return view('livewire.research-lines-explorer', [
            'units' => OrganicUnit::withCount('researchLines')->get(),
            'lines' => ResearchLine::where('is_active', true)
                ->when($this->selectedUnitId, fn($q) => $q->where('organic_unit_id', $this->selectedUnitId))
                ->get()
        ]);
    }
}