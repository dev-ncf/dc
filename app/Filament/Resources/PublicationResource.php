<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Models\Course;
use App\Models\DocumentType;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Publicação / Obra';
    protected static ?string $pluralLabel = 'Publicações e Obras';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Metadados da Publicação')
                ->tabs([

                    // ==========================================
                    // ABA 1: IDENTIFICAÇÃO BÁSICA E TIPO
                    // ==========================================
                    Forms\Components\Tabs\Tab::make('1. Identificação da Obra')
                        ->icon('heroicon-o-identification')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Título do Trabalho / Artigo / Obra')
                                ->required()
                                ->columnSpanFull()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, Set $set) => $set('slug', Str::slug($state))),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug (URL Amigável)')
                                ->disabled()
                                ->dehydrated()
                                ->required(),

                            // Tipo de Documento com live() para alternar os campos das outras abas
                            Forms\Components\Select::make('document_type_id')
                                ->label('Tipo de Documento')
                                ->relationship('documentType', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->required(),

                            Forms\Components\Select::make('knowledge_area_id')
                                ->label('Área Científica')
                                ->relationship('knowledgeArea', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Forms\Components\TextInput::make('publication_year')
                                ->label('Ano de Publicação / Defesa')
                                ->numeric()
                                ->default(now()->year)
                                ->required(),

                            Forms\Components\TextInput::make('issuing_institution')
                                ->label('Instituição de Vínculo / Origem')
                                ->default('Universidade Rovuma')
                                ->required(),
                        ])->columns(2),

                    // ==========================================
                    // ABA 2: AUTORIA E VÍNCULO ACADÉMICO
                    // ==========================================
                    Forms\Components\Tabs\Tab::make('2. Autoria e Vínculo')
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            Forms\Components\TextInput::make('author_name')
                                ->label('Nome do Autor Principal')
                                ->placeholder('Ex: Macuácua, Alberto')
                                ->required(),

                            Forms\Components\Select::make('author_degree')
                                ->label('Habilitações Literárias')
                                ->options([
                                    'Licenciatura' => 'Licenciatura',
                                    'Mestrado' => 'Mestrado',
                                    'Doutoramento' => 'Doutoramento',
                                    'Pós-Doutoramento' => 'Pós-Doutoramento',
                                    'Outro' => 'Outro',
                                ])
                                ->default('Licenciatura')
                                ->required(),

                            Forms\Components\TextInput::make('advisor_name')
                                ->label('Orientador (se aplicável para teses/monografias)'),

                            Forms\Components\Select::make('organic_unit_id')
                                ->label('Faculdade / Extensão (UniRovuma)')
                                ->relationship('organicUnit', 'name')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->nullable()
                                ->helperText('Opcional para publicações externas de docentes.'),

                            Forms\Components\Select::make('course_id')
                                ->label('Curso / Departamento')
                                ->options(fn (Get $get) => Course::where('organic_unit_id', $get('organic_unit_id'))->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->hidden(fn (Get $get) => !$get('organic_unit_id'))
                                ->nullable(),
                        ])->columns(2),

                    // ==========================================
                    // ABA 3: METADADOS ESPECÍFICOS (Tabelas 7.1, 7.2 e 7.3)
                    // ==========================================
                    Forms\Components\Tabs\Tab::make('3. Indexação e Veiculação')
                        ->icon('heroicon-o-globe-alt')
                        ->schema([
                            Forms\Components\TextInput::make('publication_country')
                                ->label('País de Publicação')
                                ->default('Moçambique')
                                ->required(),

                            Forms\Components\TextInput::make('url')
                                ->label('Link Web da Publicação')
                                ->url()
                                ->placeholder('https://doi.org/... ou https://scielo.org/...'),

                            Forms\Components\TextInput::make('doi')
                                ->label('Número DOI')
                                ->placeholder('Ex: 10.xxxx/xxxxx'),

                            // --- SEÇÃO CONDICIONAL: ARTIGO CIENTÍFICO (Tabela 7.3) ---
                            Forms\Components\Section::make('Metadados da Revista Científica (Tabela 7.3)')
                                ->icon('heroicon-o-newspaper')
                                ->visible(function (Get $get) {
                                    $type = DocumentType::find($get('document_type_id'));
                                    return $type && str_contains(strtolower($type->name), 'artigo');
                                })
                                ->schema([
                                    Forms\Components\TextInput::make('journal_name')
                                        ->label('Nome da Revista')
                                        ->required(fn (Get $get) => str_contains(strtolower(DocumentType::find($get('document_type_id'))?->name ?? ''), 'artigo')),

                                    Forms\Components\TextInput::make('volume_issue')
                                        ->label('Edição e Ano de Publicação (Volume / N.º / Páginas)')
                                        ->placeholder('Ex: Vol. 3, N.º 1, pp. 15-28 (2025)')
                                        ->required(fn (Get $get) => str_contains(strtolower(DocumentType::find($get('document_type_id'))?->name ?? ''), 'artigo')),

                                    Forms\Components\TextInput::make('issn')
                                        ->label('Número de ISSN')
                                        ->placeholder('Ex: 2410-1234'),
                                ])->columns(3),

                            // --- SEÇÃO CONDICIONAL: CAPÍTULO DE LIVRO (Tabela 7.2) ---
                            Forms\Components\Section::make('Metadados da Obra Coletiva (Tabela 7.2)')
                                ->icon('heroicon-o-bookmark')
                                ->visible(function (Get $get) {
                                    $type = DocumentType::find($get('document_type_id'));
                                    return $type && (str_contains(strtolower($type->name), 'capítulo') || str_contains(strtolower($type->name), 'capitulo'));
                                })
                                ->schema([
                                    Forms\Components\TextInput::make('book_title')
                                        ->label('Título do Livro Mãe (Onde saiu o capítulo)')
                                        ->columnSpanFull()
                                        ->required(fn (Get $get) => str_contains(strtolower(DocumentType::find($get('document_type_id'))?->name ?? ''), 'capítulo')),
                                ]),

                            // --- SEÇÃO CONDICIONAL: LIVROS E CAPÍTULOS (Tabelas 7.1 e 7.2) ---
                            Forms\Components\Section::make('Editora e ISBN (Livros e Capítulos)')
                                ->icon('heroicon-o-book-open')
                                ->visible(function (Get $get) {
                                    $type = DocumentType::find($get('document_type_id'));
                                    $name = strtolower($type?->name ?? '');
                                    return $type && (str_contains($name, 'livro') || str_contains($name, 'capítulo') || str_contains($name, 'capitulo'));
                                })
                                ->schema([
                                    Forms\Components\TextInput::make('publisher')
                                        ->label('Editora / Chancela')
                                        ->placeholder('Ex: Editora Universitária Rovuma'),

                                    Forms\Components\TextInput::make('isbn')
                                        ->label('Número de ISBN')
                                        ->placeholder('Ex: 978-989-xxx-xxx-x'),
                                ])->columns(2),
                        ])->columns(3),

                    // ==========================================
                    // ABA 4: RESUMO, FICHEIRO E ESTADO
                    // ==========================================
                    Forms\Components\Tabs\Tab::make('4. Conteúdo e Ficheiro')
                        ->icon('heroicon-o-arrow-up-tray')
                        ->schema([
                            Forms\Components\Textarea::make('abstract')
                                ->label('Resumo Académico')
                                ->rows(5)
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\TagsInput::make('keywords')
                                ->label('Palavras-chave')
                                ->placeholder('Adicionar palavra e pressionar Enter')
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('file_path')
                                ->label('Documento PDF (Máx. 20MB)')
                                ->directory('repository')
                                ->acceptedFileTypes(['application/pdf'])
                                ->maxSize(20480)
                                ->required(fn (string $operation) => $operation === 'create')
                                ->columnSpan(2),

                            Forms\Components\Select::make('status')
                                ->label('Estado da Validação')
                                ->options([
                                    'pending' => 'Pendente',
                                    'approved' => 'Aprovado',
                                    'rejected' => 'Rejeitado',
                                ])
                                ->default('pending')
                                ->required(),
                        ])->columns(3),

                ])->columnSpanFull()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->limit(35)
                    ->tooltip(fn (Publication $record): string => $record->title),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('Autor')
                    ->description(fn (Publication $record): string => $record->author_degree ?? 'Não especificado')
                    ->searchable(),

                Tables\Columns\TextColumn::make('documentType.name')
                    ->label('Tipo')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('publication_year')
                    ->label('Ano')
                    ->sortable(),

                Tables\Columns\TextColumn::make('organicUnit.sigla')
                    ->label('Unidade')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                // Mostra a revista ou livro mãe se existir
                Tables\Columns\TextColumn::make('veiculacao')
                    ->label('Veiculação')
                    ->state(function (Publication $record): string {
                        if ($record->journal_name) return "Revista: {$record->journal_name}";
                        if ($record->book_title) return "Livro: {$record->book_title}";
                        if ($record->publisher) return "Editora: {$record->publisher}";
                        return 'Institucional';
                    })
                    ->limit(25)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Aprovado',
                        'rejected' => 'Rejeitado',
                        default => 'Pendente',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submetido em')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type_id')
                    ->relationship('documentType', 'name')
                    ->label('Filtrar por Tipo de Documento'),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado de Validação')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Rejeitado',
                    ]),

                Tables\Filters\SelectFilter::make('publication_year')
                    ->label('Ano de Publicação')
                    ->options(fn () => Publication::distinct()->pluck('publication_year', 'publication_year')->toArray()),

                Tables\Filters\SelectFilter::make('organic_unit_id')
                    ->relationship('organicUnit', 'name')
                    ->label('Faculdade / Extensão'),
            ])
            ->actions([
                // Ação rápida: Aprovar
                Tables\Actions\Action::make('aprovar')
                    ->label('Aprovar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (Publication $record) => $record->update(['status' => 'approved']))
                    ->requiresConfirmation()
                    ->visible(fn (Publication $record): bool => $record->status !== 'approved'),

                // Ação rápida: Rejeitar
                Tables\Actions\Action::make('rejeitar')
                    ->label('Rejeitar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn (Publication $record) => $record->update(['status' => 'rejected']))
                    ->requiresConfirmation()
                    ->visible(fn (Publication $record): bool => $record->status !== 'rejected'),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}