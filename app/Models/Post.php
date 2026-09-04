<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'content', 'featured_image', 'type', 
        'event_start_date', 'event_end_date', 'location', 
        'attachment_path', 'user_id', 'organic_unit_id', 
        'is_published', 'published_at'
    ];

    protected $casts = [
        'event_start_date' => 'datetime',
        'event_end_date' => 'datetime',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function author(): BelongsTo { return $this->belongsTo(User::class, 'user_id'); }
    public function organicUnit(): BelongsTo { return $this->belongsTo(OrganicUnit::class); }
}