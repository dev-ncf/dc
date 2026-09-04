<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ResearchProject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'abstract', 'description', 'status', 
        'requested_budget', 'approved_budget', 'start_date', 
        'end_date', 'project_file_path', 'coordinator_id', 
        'knowledge_area_id', 'organic_unit_id', 'funding_agency','is_public','status','external_proponent_name', 
    'external_proponent_email',
    ];
     protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',  
    ];

    public function coordinator(): BelongsTo { return $this->belongsTo(User::class, 'coordinator_id'); }
    public function knowledgeArea(): BelongsTo { return $this->belongsTo(KnowledgeArea::class); }
    public function organicUnit(): BelongsTo { return $this->belongsTo(OrganicUnit::class); }

    // Equipa do projeto (Membros além do coordenador)
    public function teamMembers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'project_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // Avaliações dos pareceristas
    public function evaluations(): MorphMany { return $this->morphMany(Evaluation::class, 'evaluable'); }
}