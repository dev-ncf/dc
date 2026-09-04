<?php


namespace App\Livewire;

use App\Models\OrganicUnit;
use App\Models\Course;
use Livewire\Component;

class CourseCatalog extends Component
{
    public $selectedUnitId = null;
    public $search = '';

    public function selectUnit($id)
    {
        $this->selectedUnitId = $id;
    }

    public function render()
    {
        $units = OrganicUnit::withCount('courses')->get();

        $courses = Course::query()
            ->when($this->selectedUnitId, fn($q) => $q->where('organic_unit_id', $this->selectedUnitId))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('name')
            ->get();

        return view('livewire.course-catalog', [
            'units' => $units,
            'courses' => $courses,
            'activeUnit' => $this->selectedUnitId ? OrganicUnit::find($this->selectedUnitId) : null,
        ])->layout('components.layouts.app');
    }
}
