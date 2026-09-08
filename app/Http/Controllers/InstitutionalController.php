<?php

namespace App\Http\Controllers;

use App\Models\{InstitutionalInfo,OrganicUnit,Official};
use Illuminate\Http\Request;

class InstitutionalController extends Controller
{
    public function identity()
    {
        // Puxamos Visão, Missão e Valores
        $infos = InstitutionalInfo::where('is_active', true)
            ->whereIn('type', ['vision', 'mission', 'values'])
            ->get()
            ->keyBy('type'); // Organiza o array pelas chaves 'vision', 'mission', etc.

        return view('institutional.identity', compact('infos'));
    }

    public function history()
    {
        // Puxamos apenas o Historial
        $history = InstitutionalInfo::where('type', 'history')
            ->where('is_active', true)
            ->firstOrFail();

        return view('institutional.history', compact('history'));
    }
public function structure()
{
    // Agrupamos os oficiais que não pertencem a uma faculdade pelo valor do sort_order
    $centralLeadership = \App\Models\Official::whereNull('organic_unit_id')
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get()
        ->groupBy('sort_order'); // O valor do sort_order define a linha

    $units = \App\Models\OrganicUnit::with(['officials' => function($q) {
        $q->where('is_active', true)->orderBy('sort_order');
    }])->get();

    return view('institutional.structure', compact('centralLeadership', 'units'));
}   
}