<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
   protected $fillable = [
    'title', 'slug', 'description', 'featured_image', 
    'start_date', 'end_date', 'location', 
    'organic_unit_id', 'user_id', 'is_published', 'registration_url','submitter_name', 'submitter_email'
];

protected $casts = [
    'start_date' => 'datetime',
    'end_date' => 'datetime',
];

public function organicUnit() {
    return $this->belongsTo(OrganicUnit::class);
}
}
