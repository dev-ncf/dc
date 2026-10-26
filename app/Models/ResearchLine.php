<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchLine extends Model
{
    //
    protected $fillable = ['title', 'description', 'slug', 'organic_unit_id','knowledge_area_id','course_id','is_active'];
    public function organicUnit()
    {
        return $this->belongsTo(OrganicUnit::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function researchers()
    {
        return $this->belongsToMany(Researcher::class, 'research_line_researcher');
    }
}
