<?php
namespace App\Filament\Widgets;

use App\Models\ResearchProject;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProjectsChart extends ChartWidget
{
    protected static ?string $heading = 'Fluxo de Projetos (Mensal)';
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
{
    $projectsPerMonth = ResearchProject::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->all();

    // Preenche meses vazios com zero para o gráfico não quebrar
    $data = [];
    for ($i = 1; $i <= 12; $i++) {
        $data[] = $projectsPerMonth[$i] ?? 0;
    }

    return [
        'datasets' => [
            [
                'label' => 'Projetos Submetidos',
                'data' => $data,
                'backgroundColor' => '#003366',
            ],
        ],
        'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    ];
}

    protected function getType(): string { return 'bar'; }
}