<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficialResource\Pages;
use App\Filament\Resources\OfficialResource\RelationManagers;
use App\Models\Official;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;

class OfficialResource extends Resource
{
    protected static ?string $model = Official::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Configuração do Portal';
    protected static ?string $label = 'Responsável / Líder';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dados do Responsável')
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Foto Oficial')
                        ->image()
                        ->avatar()
                        ->directory('officials'),
                    
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome Completo')
                            ->required(),
                        Forms\Components\Select::make('academic_level')
                            ->label('Nível Académico')
                            ->options([
                                'Prof. Doutor' => 'Prof. Doutor',
                                'Doutor' => 'Doutor',
                                'Mestre' => 'Mestre',
                                'Licenciado' => 'Licenciado',
                            ])->required(),
                        Forms\Components\TextInput::make('position')
                            ->label('Cargo / Função')
                            ->placeholder('Ex: Diretor Científico')
                            ->required(),
                        Forms\Components\Select::make('organic_unit_id')
                            ->label('Unidade Vinculada (Opcional)')
                            ->relationship('organicUnit', 'name')
                            ->placeholder('Administração Central (Reitoria)'),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Ordem de Precedência')
                            ->numeric()
                            ->default(0)
                            ->helperText('0 é o topo da lista'),
                    ]),
                    
                    Forms\Components\RichEditor::make('bio')
                        ->label('Nota Biográfica / Resumo')
                        ->columnSpanFull(),
                        
                    Forms\Components\Toggle::make('is_active')
                        ->default(true)
                        ->onColor('success'),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->circular()->label('Foto'),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('position')->label('Cargo'),
                Tables\Columns\TextColumn::make('organicUnit.sigla')
                    ->label('Unidade')
                    ->badge()
                    ->placeholder('CENTRAL'),
                Tables\Columns\TextColumn::make('sort_order')->label('Ordem')->sortable(),
            ])
            ->defaultSort('sort_order', 'asc') // Garante que a ordem 0 aparece primeiro
            ->actions([Tables\Actions\EditAction::make()])
            ->reorderable('sort_order'); // Permite arrastar para reordenar na lista!
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
            'index' => Pages\ListOfficials::route('/'),
            'create' => Pages\CreateOfficial::route('/create'),
            'edit' => Pages\EditOfficial::route('/{record}/edit'),
        ];
    }
}
