<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResearchLineResource\Pages;
use App\Models\ResearchLine;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ResearchLineResource extends Resource
{
    protected static ?string $model = ResearchLine::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Linha de Pesquisa';
    protected static ?string $pluralLabel = 'Linhas de Pesquisa';

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
                    
                    Forms\Components\TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required(),

                    // 1. Faculdade / Unidade Orgânica
                    Forms\Components\Select::make('organic_unit_id')
                        ->label('Faculdade Responsável')
                        ->relationship('organicUnit', 'name')
                        ->searchable()
                        ->preload()
                        ->live() // Necessário para atualizar o campo de cursos dinamicamente se desejar
                        ->afterStateUpdated(fn (callable $set) => $set('course_id', null)) // Limpa o curso ao mudar de faculdade
                        ->required(),

                    // 2. Curso Associado (Novo)
                    Forms\Components\Select::make('course_id')
                        ->label('Curso Específico')
                        ->options(function (callable $get) {
                            $organicUnitId = $get('organic_unit_id');
                            if (!$organicUnitId) {
                                return Course::pluck('name', 'id'); // Mostra todos se nenhuma faculdade estiver selecionada
                            }
                            return Course::where('organic_unit_id', $organicUnitId)->pluck('name', 'id'); // Filtra por faculdade
                        })
                        ->searchable()
                        ->preload()
                        ->nullable() // Pode ser opcional caso a linha seja geral da faculdade
                        ->helperText('Selecione o curso a que esta linha pertence (opcional).'),

                    Forms\Components\Textarea::make('description')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Linha de Pesquisa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('course.name')
                    ->label('Curso')
                    ->badge()
                    ->color('success')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('organicUnit.sigla')
                    ->label('Faculdade')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('organic_unit_id')
                    ->label('Filtrar por Unidade')
                    ->relationship('organicUnit', 'name'),

                Tables\Filters\SelectFilter::make('course_id')
                    ->label('Filtrar por Curso')
                    ->relationship('course', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
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