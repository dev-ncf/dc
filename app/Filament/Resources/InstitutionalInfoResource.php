<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstitutionalInfoResource\Pages;
use App\Filament\Resources\InstitutionalInfoResource\RelationManagers;
use App\Models\InstitutionalInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InstitutionalInfoResource extends Resource
{
    protected static ?string $model = InstitutionalInfo::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Configuração do Portal';
    protected static ?string $label = 'Identidade Institucional';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Conteúdo Estratégico')
                ->description('Defina a Missão, Visão ou Valores da Direção Científica.')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->label('Tipo de Informação')
                        ->options([
                            'mission' => 'Missão',
                            'vision' => 'Visão',
                            'values' => 'Valores',
                            'history' => 'Historial Breve',
                        ])
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('title')
                        ->label('Título Exibido')
                        ->required()
                        ->placeholder('Ex: Nossa Missão'),

                    Forms\Components\RichEditor::make('content')
                        ->label('Descrição Detalhada')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Select::make('icon')
                        ->label('Ícone Visual')
                        ->options([
                            'heroicon-o-eye' => 'Olho (Visão)',
                            'heroicon-o-rocket-launch' => 'Foguete (Missão)',
                            'heroicon-o-star' => 'Estrela (Valores)',
                            'heroicon-o-clock' => 'Relógio (História)',
                        ])
                        ->default('heroicon-o-star'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Visível no Site')
                        ->default(true)
                        ->onColor('success'),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'mission' => 'Missão',
                        'vision' => 'Visão',
                        'values' => 'Valores',
                        'history' => 'História',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('title')->label('Título'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Ativo'),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstitutionalInfos::route('/'),
            'create' => Pages\CreateInstitutionalInfo::route('/create'),
            'edit' => Pages\EditInstitutionalInfo::route('/{record}/edit'),
        ];
    }
}