<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CooperationProject extends Model
{
    use HasFactory;

    protected $table = 'cooperation_projects';

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'is_public' => 'boolean',
    ];

    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function organicUnit(): BelongsTo
    {
        return $this->belongsTo(OrganicUnit::class, 'organic_unit_id');
    }

    public function knowledgeArea(): BelongsTo
    {
        return $this->belongsTo(KnowledgeArea::class, 'knowledge_area_id');
    }
}