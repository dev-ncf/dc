<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResearchPolicyResource\Pages;
use App\Filament\Resources\ResearchPolicyResource\RelationManagers;
use App\Models\ResearchPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ResearchPolicyResource extends Resource
{
    protected static ?string $model = ResearchPolicy::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Política & Regulamento';
    protected static ?string $pluralLabel = 'Políticas de Investigação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Documento Normativo')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título do Regulamento / Política')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('category')
                            ->label('Categoria')
                            ->options([
                                'regulamento_geral' => 'Regulamento Geral de Investigação',
                                'etica' => 'Ética em Pesquisa',
                                'propriedade_intelectual' => 'Propriedade Intelectual e Patentes',
                                'financiamento' => 'Diretrizes de Financiamento',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('version_year')
                            ->label('Ano / Versão')
                            ->numeric()
                            ->default(date('Y'))
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('Breve Descrição / Âmbito')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        // Protegido contra o erro de alteração de PDF na edição
                        Forms\Components\FileUpload::make('document_file_path')
                            ->label('Documento Oficial (PDF)')
                            ->directory('policies')
                            ->acceptedFileTypes(['application/pdf'])
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrateStateUsing(fn ($state, ?ResearchPolicy $record) => $state ?? $record?->document_file_path)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Ativo / Em Vigor')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Título')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('category')->label('Categoria')->badge(),
                Tables\Columns\TextColumn::make('version_year')->label('Ano'),
                Tables\Columns\IconColumn::make('is_active')->label('Em Vigor')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResearchPolicies::route('/'),
            'create' => Pages\CreateResearchPolicy::route('/create'),
            'edit' => Pages\EditResearchPolicy::route('/{record}/edit'),
        ];
    }
}