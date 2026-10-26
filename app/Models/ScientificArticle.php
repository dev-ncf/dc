<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScientificArticle extends Model
{
    protected $fillable = [
        'user_id', 
        'author_name', 
        'author_qualification', // Habilitações Literárias
        'title',                // Título do Artigo
        'journal_name',         // Nome da Revista
        'edition_and_year',     // Edição e Ano de Publicação
        'issn_doi',             // Número de ISSN/DOI
        'link',                 // Link do artigo
        'country',              // País de Publicação
        'publication_year',
        'file_path'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}