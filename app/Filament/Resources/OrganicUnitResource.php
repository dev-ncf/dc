<?php
namespace App\Filament\Resources;

use App\Filament\Resources\OrganicUnitResource\Pages;
use App\Models\OrganicUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class OrganicUnitResource extends Resource
{
    protected static ?string $model = OrganicUnit::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Administração';
    protected static ?string $label = 'Unidade Orgânica';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identificação da Unidade')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        
                        Forms\Components\TextInput::make('sigla')
                            ->required()
                            ->maxLength(20),
                            
                        Forms\Components\Select::make('type')
                            ->options([
                                'reitoria' => 'Reitoria',
                                'faculdade' => 'Faculdade',
                                'extensao' => 'Extensão',
                                'campus' => 'Campus',
                            ])->required(),

                        Forms\Components\TextInput::make('location')->required(),
                        
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->unique(OrganicUnit::class, 'slug', ignoreRecord: true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('sigla')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('type')->label('Tipo'),
                Tables\Columns\TextColumn::make('location')->label('Localização'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'reitoria' => 'Reitoria',
                        'faculdade' => 'Faculdade',
                        'extensao' => 'Extensão',
                        'campus' => 'Campus',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganicUnits::route('/'),
            'create' => Pages\CreateOrganicUnit::route('/create'),
            'edit' => Pages\EditOrganicUnit::route('/{record}/edit'),
        ];
    }
}