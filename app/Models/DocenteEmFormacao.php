<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DocenteEmFormacao extends Model
{
    use HasFactory;

    protected $table = 'docentes_em_formacao';
    protected $guarded = ['id'];

    protected $casts = [
        'data_nascimento' => 'date',
        'possui_contrato' => 'boolean',
    ];

    /**
     * Relação com a Unidade Orgânica
     */
    public function organicUnit(): BelongsTo
    {
        return $this->belongsTo(OrganicUnit::class, 'organic_unit_id');
    }

    /**
     * Item 24: Cálculo automático da situação da formação
     */
    protected function situacaoActual(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->ano_previsao_fim) return 'Sem previsão';
                
                $anoActual = now()->year;
                $diff = $this->ano_previsao_fim - $anoActual;

                if ($diff > 0) {
                    return "Em curso, {$diff} ano(s) para a conclusão";
                } elseif ($diff === 0) {
                    return "Em curso, conclusão prevista para este ano";
                } else {
                    $atraso = abs($diff);
                    return "Atrasada, {$atraso} ano(s) de atraso";
                }
            }
        );
    }
}