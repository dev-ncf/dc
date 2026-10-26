<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // IMPORTANTE: Precisa deste import

class Course extends Model
{
    protected $fillable = ['name', 'level', 'regime', 'duration', 'description', 'organic_unit_id'];

    /**
     * Esta é a função que o Filament está a procurar.
     * O nome deve ser organicUnit (camelCase) para bater com o Resource.
     */
    public function organicUnit(): BelongsTo
    {
        return $this->belongsTo(OrganicUnit::class, 'organic_unit_id');
    }
    public function researchLines()
{
    return $this->hasMany(ResearchLine::class);
}
}