<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Official extends Model
{
    protected $fillable = [
        'name', 'academic_level', 'position', 'image_path', 
        'bio', 'organic_unit_id', 'sort_order', 'is_active'
    ];

    public function organicUnit(): BelongsTo
    {
        return $this->belongsTo(OrganicUnit::class);
    }
}