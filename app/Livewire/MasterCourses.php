<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\OrganicUnit;
use Livewire\Component;
use Livewire\WithPagination;

class MasterCourses extends Component
{
    use WithPagination;

    public $selectedUnitId = null;
    public $search = '';

    public function selectUnit($unitId)
    {
        $this->selectedUnitId = $unitId;
        $this->resetPage();
    }

    public function render()
    {
        // Conta apenas as unidades que possuem cursos de Mestrado
        $units = OrganicUnit::withCount(['courses' => function ($query) {
            $query->where('level', 'Mestrado');
        }])->having('courses_count', '>', 0)->get();

        $activeUnit = $this->selectedUnitId ? OrganicUnit::find($this->selectedUnitId) : null;

        $courses = Course::query()
            ->where('level', 'Mestrado') // <--- FILTRO FIXO DE MESTRADO
            ->when($this->selectedUnitId, function ($query) {
                $query->where('organic_unit_id', $this->selectedUnitId);
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->with('organicUnit')
            ->get();

        $totalMestrados = Course::where('level', 'Mestrado')->count();

        return view('livewire.master-courses', [
            'units' => $units,
            'activeUnit' => $activeUnit,
            'courses' => $courses,
            'totalMestrados' => $totalMestrados
        ]);
    }
}