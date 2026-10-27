<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CooperationAgreement extends Model
{
    use HasFactory;

    protected $table = 'cooperation_agreements';

    protected $guarded = ['id'];

    protected $casts = [
        'signature_date' => 'date',
        'expiration_date' => 'date',
        'auto_renew' => 'boolean',
        'is_public' => 'boolean',
        'areas_of_cooperation' => 'array',
    ];

    public function organicUnit(): BelongsTo
    {
        return $this->belongsTo(OrganicUnit::class, 'organic_unit_id');
    }

    public function focalPoint(): BelongsTo
    {
        return $this->belongsTo(User::class, 'focal_point_id');
    }

    // Acessório para verificar se o acordo está expirado na data de hoje
    public function getIsExpiredAttribute(): bool
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }
}