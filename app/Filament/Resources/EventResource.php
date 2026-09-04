<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Portal Institucional';
    protected static ?string $label = 'Evento Científico';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Section::make('Detalhes do Evento')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')->disabled()->dehydrated()->required(),

                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                    ])->columnSpan(2),

                Forms\Components\Section::make('Logística e Publicação')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Início do Evento')
                            ->required(),
                        
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('Fim do Evento'),

                        Forms\Components\TextInput::make('location')
                            ->label('Localização / Link')
                            ->placeholder('Ex: Anfiteatro Central ou Google Meet')
                            ->required(),

                        Forms\Components\Select::make('organic_unit_id')
                            ->label('Unidade Organizadora')
                            ->relationship('organicUnit', 'sigla')
                            ->placeholder('Evento Central (Reitoria)'),

                        Forms\Components\FileUpload::make('featured_image')
                            ->image()->directory('events'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(true),
                    ])->columnSpan(1),
            ])
        ]);
    }

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            // 1. Identificação Visual e Título
            Tables\Columns\ImageColumn::make('featured_image')
                ->label('Capa')
                ->circular(),

            Tables\Columns\TextColumn::make('title')
                ->label('Título do Evento')
                ->searchable()
                ->sortable()
                ->limit(35),

            // 2. Cronograma
            Tables\Columns\TextColumn::make('start_date')
                ->label('Data de Início')
                ->dateTime('d/m/Y H:i')
                ->sortable(),

            // 3. Origem e Proponente (Sintonia com submissão externa)
            Tables\Columns\TextColumn::make('organicUnit.sigla')
                ->label('Unidade')
                ->badge()
                ->color('primary')
                ->default('CENTRAL'),

            Tables\Columns\TextColumn::make('submitter_name')
                ->label('Proponente')
                ->description(fn (Event $record): string => $record->submitter_email ?? 'Utilizador Interno')
                ->color('warning')
                ->toggleable(), // Permite esconder esta coluna se necessário

            // 4. Status de Publicação
            Tables\Columns\IconColumn::make('is_published')
                ->label('Publicado')
                ->boolean()
                ->sortable(),
        ])
        ->filters([
            // Filtro por Unidade Orgânica
            Tables\Filters\SelectFilter::make('organic_unit_id')
                ->label('Filtrar por Unidade')
                ->relationship('organicUnit', 'name')
                ->searchable()
                ->preload(),

            // Filtro avançado para Aprovações
            Tables\Filters\TernaryFilter::make('is_published')
                ->label('Status de Publicação')
                ->placeholder('Todos os eventos')
                ->trueLabel('Apenas Publicados')
                ->falseLabel('Pendentes (Propostas)')
                ->queries(
                    true: fn (Builder $query) => $query->where('is_published', true),
                    false: fn (Builder $query) => $query->where('is_published', false),
                ),
        ])
        ->actions([
            // Grupo de ações para manter a interface limpa
            Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
                // Ação de Publicação Rápida
                Tables\Actions\Action::make('publish')
                    ->label('Publicar Agora')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Publicar Evento Científico')
                    ->modalDescription('Ao confirmar, este evento ficará visível imediatamente na agenda pública do portal.')
                    ->modalSubmitActionLabel('Sim, publicar')
                    ->action(fn (Event $record) => $record->update(['is_published' => true]))
                    ->visible(fn (Event $record) => !$record->is_published),
            ]),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->defaultSort('start_date', 'desc'); // Mostra os eventos mais recentes primeiro
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
