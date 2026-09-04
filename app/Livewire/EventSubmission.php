<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\OrganicUnit;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Filament\Notifications\Notification; // Para avisar o Admin

class EventSubmission extends Component
{
    use WithFileUploads;

    // Campos do Evento
    public $title, $description, $start_date, $end_date, $location, $organic_unit_id, $registration_url, $image;
    
    // Campos do Proponente (Público)
    public $submitter_name, $submitter_email;

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'description' => 'required|min:20',
        'start_date' => 'required|after:now',
        'location' => 'required',
        'submitter_name' => 'required|min:3',
        'submitter_email' => 'required|email',
        'image' => 'nullable|image|max:2048',
    ];

    public function submit()
    {
        $this->validate();

        $imagePath = $this->image ? $this->image->store('events', 'public') : null;

        $event = Event::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . rand(100, 999),
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'organic_unit_id' => $this->organic_unit_id,
            'registration_url' => $this->registration_url,
            'featured_image' => $imagePath,
            'submitter_name' => $this->submitter_name,
            'submitter_email' => $this->submitter_email,
            'user_id' => null, // Não há utilizador logado
            'is_published' => false,
        ]);

        // NOTIFICAÇÃO PARA O ADMIN (Aparece no sino do Filament)
        Notification::make()
            ->title('Nova proposta de evento recebida')
            ->body("O evento \"{$this->title}\" foi submetido por {$this->submitter_name}.")
            ->warning()
            ->sendToDatabase(\App\Models\User::where('user_type', 'admin')->get());

        session()->flash('success', 'A sua proposta foi enviada com sucesso! A Direção Científica irá analisar e publicar em breve.');
        
        return redirect()->to('/agenda');
    }

    public function render()
    {
        return view('livewire.event-submission', [
            'units' => OrganicUnit::orderBy('name')->get()
        ])->layout('components.layouts.app');
    }
}