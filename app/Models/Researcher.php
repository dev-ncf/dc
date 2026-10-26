<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Researcher extends Model
{
    //
protected $fillable = ['name', 'academic_title', 'email', 'phone', 'photo'];

public function researchLines()
{
    return $this->belongsToMany(ResearchLine::class, 'research_line_researcher');
}
}
