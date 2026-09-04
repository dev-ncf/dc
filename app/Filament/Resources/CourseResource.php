<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Configuração Académica';
    protected static ?string $label = 'Curso';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do Curso')
                    ->required()
                    ->placeholder('Ex: Licenciatura em Informática'),
                
                Forms\Components\Select::make('organic_unit_id')
                    ->label('Faculdade / Unidade Orgânica')
                    ->relationship('organicUnit', 'name') // Certifique-se que organicUnit() está no Model Course
                    ->searchable()
                    ->preload()
                    ->required(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Curso')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('organicUnit.name')
                    ->label('Faculdade')
                    ->badge()
                    ->color('info')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('organic_unit_id')
                    ->label('Filtrar por Faculdade')
                    ->relationship('organicUnit', 'name')
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
