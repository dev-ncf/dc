<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResearchLineResource\Pages;
use App\Filament\Resources\ResearchLineResource\RelationManagers;
use App\Models\ResearchLine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class ResearchLineResource extends Resource
{
    protected static ?string $model = ResearchLine::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Linha de Pesquisa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Definição da Linha de Investigação')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Nome da Linha')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                    
                    Forms\Components\TextInput::make('slug')->disabled()->dehydrated()->required(),

                    Forms\Components\Select::make('organic_unit_id')
                        ->label('Faculdade Responsável')
                        ->relationship('organicUnit', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\RichEditor::make('description')
                        ->label('Descrição e Objetivos da Linha')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Ativo')
                        ->default(true)
                        ->onColor('success'),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('organicUnit.sigla')
                    ->label('Unidade')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Status'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('organic_unit_id')
                    ->label('Filtrar por Unidade')
                    ->relationship('organicUnit', 'name')
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResearchLines::route('/'),
            'create' => Pages\CreateResearchLine::route('/create'),
            'edit' => Pages\EditResearchLine::route('/{record}/edit'),
        ];
    }
}
