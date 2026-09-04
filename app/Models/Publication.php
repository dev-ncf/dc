<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importante!

class Publication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'abstract', 'keywords', 'user_id', 'author_name', 
        'advisor_name', 'document_type_id', 'knowledge_area_id', 
        'organic_unit_id', 'course_id', 'publication_year', 
        'language', 'file_path', 'visibility', 'status', 'rejection_reason'
    ];

    // RELAÇÕES (O Filament usa estes nomes exatos)
      protected $casts = [
        'keywords' => 'array', // Transforma automaticamente o array em JSON para o banco de dados
    ];

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function organicUnit(): BelongsTo
    {
        return $this->belongsTo(OrganicUnit::class);
    }

    public function knowledgeArea(): BelongsTo
    {
        return $this->belongsTo(KnowledgeArea::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}