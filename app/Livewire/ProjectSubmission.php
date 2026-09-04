<?php

namespace App\Livewire;

use App\Models\ResearchProject;
use App\Models\OrganicUnit;
use App\Models\KnowledgeArea;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ProjectSubmission extends Component
{
    use WithFileUploads;

    // Campos do Projeto
    public $title, $abstract, $description, $requested_budget;
    public $organic_unit_id, $knowledge_area_id, $proposed_status;
    public $project_file;

    // Campos de Identificação (Para quem não está logado)
    public $external_name, $external_email;

    protected function rules()
    {
        return [
            'title' => 'required|min:10|max:255',
            'abstract' => 'required|min:50',
            'organic_unit_id' => 'required|exists:organic_units,id',
            'knowledge_area_id' => 'required|exists:knowledge_areas,id',
            'proposed_status' => 'required|in:portfolio,searching_funds',
            'project_file' => 'required|mimes:pdf|max:10240', // Max 10MB
            'external_name' => auth()->guest() ? 'required|min:3' : 'nullable',
            'external_email' => auth()->guest() ? 'required|email' : 'nullable',
        ];
    }

    public function submit()
    {
        $this->validate();

        // Salvar o PDF da proposta técnica
        $filePath = $this->project_file->store('projects', 'public');

        ResearchProject::create([
            'title' => $this->title,
            'abstract' => $this->abstract,
            'description' => $this->description,
            'requested_budget' => $this->requested_budget ?? 0,
            'organic_unit_id' => $this->organic_unit_id,
            'knowledge_area_id' => $this->knowledge_area_id,
            'status' => 'pending_validation', // Sempre entra como pendente
            'is_public' => false, // Escondido até o admin validar
            'project_file_path' => $filePath,
            
            // Lógica de Coordenador vs Externo
            'coordinator_id' => auth()->id(), // null se for visitante
            'external_proponent_name' => auth()->check() ? auth()->user()->name : $this->external_name,
            'external_proponent_email' => auth()->check() ? auth()->user()->email : $this->external_email,
        ]);

        session()->flash('success', 'Proposta de projeto submetida com sucesso! A Direção Científica analisará os detalhes.');

        return redirect()->to('/projectos');
    }

    public function render()
    {
        return view('livewire.project-submission', [
            'units' => OrganicUnit::orderBy('name')->get(),
            'areas' => KnowledgeArea::all()
        ])->layout('components.layouts.app');
    }
}