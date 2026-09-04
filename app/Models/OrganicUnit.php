<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganicUnit extends Model
{
    protected $fillable = ['name', 'sigla', 'type', 'location', 'slug'];

    public function users(): HasMany { return $this->hasMany(User::class); }
    public function posts(): HasMany { return $this->hasMany(Post::class); }
    public function publications(): HasMany { return $this->hasMany(Publication::class); }
    public function projects(): HasMany { return $this->hasMany(ResearchProject::class); }
    public function courses(): HasMany { return $this->hasMany(Course::class); }
    public function researchLines(): HasMany { return $this->hasMany(ResearchLine::class); }
}