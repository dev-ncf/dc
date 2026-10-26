<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookChapter extends Model
{
    protected $fillable = [
        'user_id', 
        'author_name', 
        'author_qualification', // Habilitações Literárias
        'chapter_title',        // Título do Capítulo Livro
        'book_title',           // Título do Livro
        'isbn_doi', 
        'link', 
        'country', 
        'publication_year',
        'file_path'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}