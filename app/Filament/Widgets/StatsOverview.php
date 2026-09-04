<?php
namespace App\Filament\Widgets;

use App\Models\ResearchProject;
use App\Models\Publication;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Projetos Submetidos', ResearchProject::count())
                ->description('Total de propostas recebidas')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('info'),
            Stat::make('Publicações Ativas', Publication::where('status', 'published')->count())
                ->description('Artigos e Teses no Repositório')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Investigadores', User::whereIn('user_type', ['docente', 'investigador'])->count())
                ->description('Corpo científico registado')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}