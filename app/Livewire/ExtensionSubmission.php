<?php

namespace App\Livewire;

use App\Models\ExtensionProject;
use App\Models\KnowledgeArea;
use Livewire\Component;
use Livewire\WithFileUploads;

class ExtensionSubmission extends Component
{
    use WithFileUploads;

    public $title, $community_partner, $target_beneficiaries, $abstract, $expected_impact, $requested_budget;
    public $knowledge_area_id, $start_date, $end_date;
    public $project_file;
    public $external_name, $external_email;

    protected function rules()
    {
        return [
            'title' => 'required|min:10|max:255',
            'community_partner' => 'required|min:3',
            'target_beneficiaries' => 'nullable|string',
            'abstract' => 'required|min:50',
            'expected_impact' => 'nullable|string',
            'knowledge_area_id' => 'required|exists:knowledge_areas,id',
            'project_file' => 'required|mimes:pdf|max:10240',
            'external_name' => auth()->guest() ? 'required|min:3' : 'nullable',
            'external_email' => auth()->guest() ? 'required|email' : 'nullable',
        ];
    }

    public function submit()
    {
        $this->validate();

        $filePath = $this->project_file->store('extension-projects', 'public');

        ExtensionProject::create([
            'title' => $this->title,
            'community_partner' => $this->community_partner,
            'target_beneficiaries' => $this->target_beneficiaries,
            'abstract' => $this->abstract,
            'expected_impact' => $this->expected_impact,
            'requested_budget' => $this->requested_budget ?? 0,
            'knowledge_area_id' => $this->knowledge_area_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => 'pending', 
            'is_public' => false, 
            'project_file_path' => $filePath,
            'coordinator_id' => auth()->id(),
        ]);

        session()->flash('success', 'Proposta de extensão submetida com sucesso!');
        return redirect()->to('/extensao');
    }

    public function render()
    {
        return view('livewire.extension-submission', [
            'areas' => KnowledgeArea::all()
        ])->layout('components.layouts.app');
    }
}