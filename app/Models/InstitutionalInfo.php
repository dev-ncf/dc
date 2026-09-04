<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionalInfo extends Model
{
    //
    protected $fillable = ['type', 'title', 'content', 'icon', 'is_active'];
}
