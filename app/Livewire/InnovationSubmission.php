<?php

namespace App\Livewire;

use App\Models\InnovationProject;
use App\Models\KnowledgeArea;
use Livewire\Component;
use Livewire\WithFileUploads;

class InnovationSubmission extends Component
{
    use WithFileUploads;

    public $title, $innovation_type, $trl_level = 'trl_1_3';
    public $abstract, $market_potential, $knowledge_area_id;
    public $project_file;
    public $external_name, $external_email;

    protected function rules()
    {
        return [
            'title' => 'required|min:10|max:255',
            'innovation_type' => 'required',
            'trl_level' => 'required',
            'knowledge_area_id' => 'required|exists:knowledge_areas,id',
            'abstract' => 'required|min:50',
            'market_potential' => 'required|min:30',
            'project_file' => 'required|mimes:pdf|max:15360', // Max 15MB para Pitch Decks
            'external_name' => auth()->guest() ? 'required|min:3' : 'nullable',
            'external_email' => auth()->guest() ? 'required|email' : 'nullable',
        ];
    }

    public function submit()
    {
        $this->validate();

        $filePath = $this->project_file->store('innovation-projects', 'public');

        InnovationProject::create([
            'title' => $this->title,
            'innovation_type' => $this->innovation_type,
            'trl_level' => $this->trl_level,
            'knowledge_area_id' => $this->knowledge_area_id,
            'abstract' => $this->abstract,
            'market_potential' => $this->market_potential,
            'status' => 'pending', // Entra pendente para validação da Direção de Inovação
            'is_public' => false,
            'project_file_path' => $filePath,
            'inventor_id' => auth()->id(), // null se for visitante externo (ajustar se tua migration permitir nulos, ou associar a um user genérico)
        ]);

        session()->flash('success', 'Proposta de inovação submetida com sucesso! A nossa incubadora analisará o seu projeto.');
        return redirect()->to('/inovacao');
    }

    public function render()
    {
        return view('livewire.innovation-submission', [
            'areas' => KnowledgeArea::all()
        ])->layout('components.layouts.app');
    }
}