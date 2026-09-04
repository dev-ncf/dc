<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeAreaResource\Pages;
use App\Filament\Resources\KnowledgeAreaResource\RelationManagers;
use App\Models\KnowledgeArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KnowledgeAreaResource extends Resource
{
    protected static ?string $model = KnowledgeArea::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Administração';
    protected static ?string $label = 'Área de Conhecimento';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make('name')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('parent_id')
                    ->label('Área Superior (Opcional)')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->placeholder('Selecione se for uma sub-área'),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('parent.name')->label('Área Pai')->default('Principal'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y'),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKnowledgeAreas::route('/'),
            'create' => Pages\CreateKnowledgeArea::route('/create'),
            'edit' => Pages\EditKnowledgeArea::route('/{record}/edit'),
        ];
    }
}