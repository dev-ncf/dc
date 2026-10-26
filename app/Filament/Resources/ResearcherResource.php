<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResearcherResource\Pages;
use App\Models\Researcher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ResearcherResource extends Resource
{
    protected static ?string $model = Researcher::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Gestão Científica';
    protected static ?string $modelLabel = 'Investigador';
    protected static ?string $pluralModelLabel = 'Investigadores / Docentes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\FileUpload::make('photo')
                        ->label('Fotografia')
                        ->image()
                        ->avatar()
                        ->directory('researchers-photos')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('name')
                        ->label('Nome Completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('academic_title')
                        ->label('Título Académico')
                        ->placeholder('Ex: Prof. Doutor / Mestre')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('Correio Eletrónico')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('phone')
                        ->label('Contacto Telefónico')
                        ->tel()
                        ->maxLength(255),

                    // CAMPO DE RELACIONAMENTO COM AS LINHAS DE PESQUISA
                    Forms\Components\Select::make('researchLines')
                        ->label('Linhas de Pesquisa Associadas')
                        ->relationship('researchLines', 'title') // 'researchLines' é a função no Model Researcher, 'title' é a coluna da linha de pesquisa
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->columnSpanFull(),

                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('academic_title')
                    ->label('Título')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                // Opcional: Mostrar quantas linhas de pesquisa este investigador possui
                Tables\Columns\TextColumn::make('researchLines_count')
                    ->counts('researchLines')
                    ->label('Linhas de Pesquisa')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResearchers::route('/'),
            'create' => Pages\CreateResearcher::route('/create'),
            'edit' => Pages\EditResearcher::route('/{record}/edit'),
        ];
    }
}