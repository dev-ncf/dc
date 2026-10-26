<?php

namespace App\Livewire; 

use App\Models\Course;
use App\Models\OrganicUnit;
use Livewire\Component;
use Livewire\WithPagination;

class PhdCourses extends Component // Ou DoctoralCourses
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
        $units = OrganicUnit::withCount(['courses' => function ($query) {
            $query->where('level', 'Doutoramento');
        }])->having('courses_count', '>', 0)->get();

        $activeUnit = $this->selectedUnitId ? OrganicUnit::find($this->selectedUnitId) : null;

        $courses = Course::query()
            ->where('level', 'Doutoramento') // <--- FILTRO FIXO DE DOUTORAMENTO
            ->when($this->selectedUnitId, function ($query) {
                $query->where('organic_unit_id', $this->selectedUnitId);
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->with('organicUnit')
            ->get();

        $totalDoutoramentos = Course::where('level', 'Doutoramento')->count();

        return view('livewire.phd-courses', [
            'units' => $units,
            'activeUnit' => $activeUnit,
            'courses' => $courses,
            'totalDoutoramentos' => $totalDoutoramentos
        ]);
    }
}