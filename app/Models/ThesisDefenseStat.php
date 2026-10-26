<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThesisDefenseStat extends Model
{
    protected $table = 'thesis_defenses_stats';
    protected $fillable = [
        'organic_unit_id',      // Faculdade
        'course_id',            // Curso
        'dissertations_count',  // Número de Dissertações
        'theses_count',         // Número de Teses
        'reference_year'        // Ano de referência (ex: 2025)
    ];

    public function organicUnit(): BelongsTo
    {
        return $this->belongsTo(OrganicUnit::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}