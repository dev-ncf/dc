<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'document_file_path',
        'version_year',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}