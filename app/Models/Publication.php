<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 
        'slug', 
        'abstract', 
        'keywords', 
        'user_id', 
        'author_name', 
        'advisor_name', 
        'document_type_id', 
        'knowledge_area_id', 
        'organic_unit_id', 
        'course_id', 
        'publication_year', 
        'issuing_institution', 
        'language', 
        'file_path', 
        'visibility', 
        'status', 
        'rejection_reason',
        
        // --- NOVOS CAMPOS ADICIONADOS PARA AS TABELAS 7.1, 7.2 e 7.3 ---
        'author_qualification', // Habilitações Literárias
        'publication_country',  // País de Publicação
        'book_title',           // Título do Livro (para capítulos)
        'journal_name',         // Nome da Revista (para artigos)
        'journal_edition',      // Edição/Ano da Revista (para artigos)
        'isbn_issn',            // Número de ISBN/ISSN
        'doi',                  // DOI
        'external_link',        // Link da Publicação / Artigo / Livro
    ];

    protected $casts = [
        'keywords' => 'array', 
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