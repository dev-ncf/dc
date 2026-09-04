<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    protected $fillable = [
        'evaluable_id', 'evaluable_type', 'reviewer_id', 
        'comment', 'score', 'decision'
    ];

    // Permite obter o objeto avaliado (Publicação ou Projeto)
    public function evaluable(): MorphTo { return $this->morphTo(); }

    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewer_id'); }
}