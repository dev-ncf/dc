<?php

namespace App\Livewire;

use App\Models\InstitutionalInfo;
use Livewire\Component;

class InstitutionalCards extends Component
{
    public function render()
    {
        return view('livewire.institutional-cards', [
            // Buscamos Missão, Visão e Valores por ordem específica
            'cards' => InstitutionalInfo::where('is_active', true)
                ->whereIn('type', ['vision', 'mission', 'values'])
                ->get()
                ->sortBy(function($item) {
                    return array_search($item->type, ['mission', 'vision', 'values']);
                })
        ]);
    }
}
