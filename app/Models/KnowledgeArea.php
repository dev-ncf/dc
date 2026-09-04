<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KnowledgeArea extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function parent(): BelongsTo { return $this->belongsTo(KnowledgeArea::class, 'parent_id'); }
    public function children(): HasMany { return $this->hasMany(KnowledgeArea::class, 'parent_id'); }
}