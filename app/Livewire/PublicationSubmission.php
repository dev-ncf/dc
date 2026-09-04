<?php

namespace App\Livewire;

use App\Models\Publication;
use App\Models\DocumentType;
use App\Models\KnowledgeArea;
use App\Models\OrganicUnit;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class PublicationSubmission extends Component
{
    use WithFileUploads;

    public $currentStep = 1;

    // Campos do Formulário
    public $title, $abstract, $author_name, $advisor_name, $publication_year;
    public $document_type_id, $knowledge_area_id, $organic_unit_id, $course_id;
    public $keywords_string, $issuing_institution = 'Universidade Rovuma';
    public $file;

    // Regras de Validação por Passo
    protected function rules()
    {
        if ($this->currentStep == 1) {
            return [
                'title' => 'required|min:10',
                'abstract' => 'required|min:50',
                'publication_year' => 'required|numeric|min:1900|max:' . (date('Y') + 1),
            ];
        }
        if ($this->currentStep == 2) {
            return [
                'author_name' => 'required',
                'document_type_id' => 'required',
                'knowledge_area_id' => 'required',
            ];
        }
        return [
            'file' => 'required|mimes:pdf|max:20480', // Max 20MB
        ];
    }

    public function nextStep()
    {
        $this->validate();
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function submit()
    {
        $this->validate();

        // Processar Keywords (String para Array)
        $keywords = array_map('trim', explode(',', $this->keywords_string));

        // Salvar Arquivo
        $path = $this->file->store('repository', 'local'); // Usando 'local' para evitar erro no InfinityFree

        Publication::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . rand(1000, 9999),
            'abstract' => $this->abstract,
            'author_name' => $this->author_name,
            'advisor_name' => $this->advisor_name,
            'publication_year' => $this->publication_year,
            'document_type_id' => $this->document_type_id,
            'knowledge_area_id' => $this->knowledge_area_id,
            'organic_unit_id' => $this->organic_unit_id,
            'course_id' => $this->course_id,
            'issuing_institution' => $this->issuing_institution,
            'keywords' => $keywords,
            'file_path' => $path,
            'user_id' => auth()->id() ?? 1, // Fallback se não houver login
            'status' => 'pending', // Sempre pendente para aprovação do bibliotecário
        ]);

        session()->flash('success', 'Trabalho submetido com sucesso! Aguarde a validação da Direção Científica.');
        return redirect()->to('/repositorio');
    }

    public function render()
    {
        return view('livewire.publication-submission', [
            'types' => DocumentType::all(),
            'areas' => KnowledgeArea::all(),
            'units' => OrganicUnit::all(),
            'courses' => Course::where('organic_unit_id', $this->organic_unit_id)->get(),
        ])->layout('components.layouts.app');
    }
}