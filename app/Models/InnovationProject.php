<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InnovationProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'inventor_id',
        'knowledge_area_id',
        'innovation_type',
        'trl_level',
        'abstract',
        'market_potential',
        'project_file_path',
        'status',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function inventor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inventor_id');
    }

    public function knowledgeArea(): BelongsTo
    {
        return $this->belongsTo(KnowledgeArea::class, 'knowledge_area_id');
    }
}