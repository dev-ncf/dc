<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'featured_image'
    ];
    /**
 * Retorna o URL completo da página para o frontend
 */
public function getPublicUrl()
{
    return url("/pagina/{$this->slug}");
}
}
