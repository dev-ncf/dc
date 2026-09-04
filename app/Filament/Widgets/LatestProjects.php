<?php
namespace App\Filament\Widgets;

use App\Models\ResearchProject;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestProjects extends BaseWidget
{
    protected static ?int $sort = 3; // Ordem no dashboard
    protected int | string | array $columnSpan = 'full'; // Ocupa a largura total

    public function table(Table $table): Table
    {
        return $table
            ->query(ResearchProject::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Título do Projeto')->limit(50),
                Tables\Columns\TextColumn::make('coordinator.name')->label('Coordenador'),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn($state) => match($state){
                    'submitted' => 'warning',
                    'approved' => 'success',
                    default => 'gray'
                }),
                Tables\Columns\TextColumn::make('created_at')->label('Data de Submissão')->date(),
            ]);
    }
}
