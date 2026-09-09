<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationPolicyResource\Pages;
use App\Filament\Resources\PublicationPolicyResource\RelationManagers;
use App\Models\PublicationPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PublicationPolicyResource extends Resource
{
    protected static ?string $model = PublicationPolicy::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Política de Publicação';
    protected static ?string $pluralLabel = 'Políticas de Publicações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Diretrizes de Publicação')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título da Diretriz / Política')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('category')
                            ->label('Categoria')
                            ->options([
                                'revistas_cientificas' => 'Revistas Científicas e Indexação',
                                'repositorio_institucional' => 'Normas do Repositório Institucional',
                                'teses_dissertacoes' => 'Diretrizes para Teses e Dissertações',
                                'incentivos_publicacao' => 'Incentivos e Apoio à Publicação',
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

                        // Protegido contra o erro do PDF na edição
                        Forms\Components\FileUpload::make('document_file_path')
                            ->label('Documento Oficial (PDF)')
                            ->directory('publication-policies')
                            ->acceptedFileTypes(['application/pdf'])
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrateStateUsing(fn ($state, ?PublicationPolicy $record) => $state ?? $record?->document_file_path)
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
            'index' => Pages\ListPublicationPolicies::route('/'),
            'create' => Pages\CreatePublicationPolicy::route('/create'),
            'edit' => Pages\EditPublicationPolicy::route('/{record}/edit'),
        ];
    }
}