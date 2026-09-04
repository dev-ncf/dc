<?php

namespace App\Livewire;

use App\Models\ResearchProject;
use Livewire\Component;

class LatestProjectsList extends Component
{
    public function render()
    {
        return view('livewire.latest-projects-list', [
            // Puxa os últimos 5 projetos aprovados da UniRovuma
            'projects' => ResearchProject::latest()
                ->take(5)
                ->get()
        ]);
    }
}