<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [
        'label',
        'url',
        'parent_id',
        'sort',
        'is_external',
        'type',
    ];
    public function parent() { return $this->belongsTo(Menu::class, 'parent_id'); }
    public function children() { return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort'); }
}
