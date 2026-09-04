<?php
namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        return view('livewire.navbar', [
            'navigation' => Menu::whereNull('parent_id')
                ->where('type', 'header')
                ->where('is_visible', true)
                ->with('children')
                ->orderBy('sort')
                ->get()
        ]);
    }
}