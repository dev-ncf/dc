<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtensionProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'coordinator_id',
        'knowledge_area_id',
        'community_partner',
        'target_beneficiaries',
        'abstract',
        'expected_impact',
        'project_file_path',
        'start_date',
        'end_date',
        'requested_budget',
        'funding_source',
        'status',
        'is_public',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'requested_budget' => 'decimal:2',
        'is_public' => 'boolean',
    ];

    // Relação com o Coordenador (geralmente tabela Users ou Researchers)
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    // Relação com a Área Científica
    public function knowledgeArea(): BelongsTo
    {
        return $this->belongsTo(KnowledgeArea::class, 'knowledge_area_id');
    }
}