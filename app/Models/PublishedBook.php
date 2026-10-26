<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublishedBook extends Model
{
    protected $fillable = [
        'user_id', 
        'author_name', 
        'author_qualification', // Habilitações Literárias
        'title', 
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