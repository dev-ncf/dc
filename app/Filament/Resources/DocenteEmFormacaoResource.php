<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocenteEmFormacaoResource\Pages;
use App\Filament\Resources\DocenteEmFormacaoResource\RelationManagers;
use App\Models\DocenteEmFormacao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocenteEmFormacaoResource extends Resource
{
    protected static ?string $model = DocenteEmFormacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Configuração Académica';
    protected static ?string $navigationLabel = 'Docentes em Formação';
    protected static ?string $modelLabel = 'Docente em Formação';
    protected static ?string $pluralModelLabel = 'Docentes em Formação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identificação e Carreira')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('organic_unit_id')
                            ->label('1. Unidade Orgânica')
                            ->relationship('organicUnit', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->sigla})")
                            ->searchable(['name', 'sigla'])
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('nome_completo')
                            ->label('2. Nome Completo')
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\Radio::make('sexo')
                            ->label('3. Sexo')
                            ->options(['Masculino' => 'Masculino', 'Feminino' => 'Feminino'])
                            ->inline()
                            ->required(),
                        Forms\Components\DatePicker::make('data_nascimento')
                            ->label('4. Data de Nascimento')
                            ->required(),
                        Forms\Components\Select::make('categoria')
                            ->label('5. Categoria')
                            ->options([
                                'Assistente estagiário' => 'Assistente estagiário',
                                'Assistente Universitário' => 'Assistente Universitário',
                                'Professor Auxiliar' => 'Professor Auxiliar',
                                'Professor Associado' => 'Professor Associado',
                                'Professor Catedrático' => 'Professor Catedrático',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('ano_ingresso')
                            ->label('6. Ano de Ingresso')
                            ->numeric()
                            ->minValue(1975)
                            ->maxValue(now()->year)
                            ->required(),
                        Forms\Components\Radio::make('vinculo')
                            ->label('7. Vínculo')
                            ->options(['Quadro' => 'Quadro', 'Contratado' => 'Contratado'])
                            ->inline()
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('22. E-mail')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('telefone')
                            ->label('23. Telefone')
                            ->tel()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Formação Actual')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('nivel_actual')
                            ->label('8. Nível de Formação Actual')
                            ->options([
                                'Licenciado' => 'Licenciado',
                                'Mestrado' => 'Mestrado',
                                'Doutorado' => 'Doutorado',
                                'Pós-doutorado' => 'Pós-doutorado',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('area_actual')
                            ->label('9. Área de Formação Actual')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Formação em Curso e Detalhes da Bolsa')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('nivel_em_curso')
                            ->label('10. Nível em Curso')
                            ->options([
                                'Mestrado' => 'Mestrado',
                                'Doutorado' => 'Doutorado',
                                'Pós-doutorado' => 'Pós-doutorado',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('area_em_curso')
                            ->label('11. Área em Curso')
                            ->required(),
                        Forms\Components\TextInput::make('curso')
                            ->label('12. Curso que Frequenta')
                            ->required(),
                        Forms\Components\TextInput::make('instituicao')
                            ->label('13. Instituição de Frequência')
                            ->required(),
                        Forms\Components\TextInput::make('pais')
                            ->label('14. País')
                            ->required(),
                        Forms\Components\TextInput::make('cidade')
                            ->label('15. Cidade')
                            ->required(),
                        Forms\Components\TextInput::make('ano_inicio')
                            ->label('16. Ano de Início')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('ano_previsao_fim')
                            ->label('17. Ano Previsto para Conclusão')
                            ->numeric()
                            ->required(),
                        Forms\Components\Radio::make('regime_bolsa')
                            ->label('18. Regime da Bolsa')
                            ->options([
                                'Parcial' => 'Parcial',
                                'Integral' => 'Integral',
                                'Sem bolsa' => 'Sem bolsa',
                            ])
                            ->inline()
                            ->required(),
                        Forms\Components\TextInput::make('financiador')
                            ->label('19. Financiador da Bolsa')
                            ->placeholder('Ex: Camões, Banco Mundial, Próprio'),
                        Forms\Components\TextInput::make('despacho_edital')
                            ->label('20. N.º Edital / Despacho')
                            ->required(),
                        Forms\Components\Toggle::make('possui_contrato')
                            ->label('21. Possui Contrato de Formação?')
                            ->inline(false)
                            ->default(false),
                    ]),

                Forms\Components\Section::make('Estado do Curso ')
                    ->schema([
                        Forms\Components\Placeholder::make('situacao_actual')
                            ->label('24. Situação Actual da Formação (Cálculo Automático)')
                            ->content(fn (?DocenteEmFormacao $record): string => $record ? $record->situacao_actual : 'Calculado automaticamente após salvar.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome_completo')
                    ->label('Docente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('organicUnit.name')
                    ->label('Unidade Orgânica')
                    ->description(fn (DocenteEmFormacao $record) => $record->organicUnit?->sigla)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('curso')
                    ->label('Curso / Nível')
                    ->description(fn (DocenteEmFormacao $record) => $record->nivel_em_curso),
                Tables\Columns\TextColumn::make('instituicao')
                    ->label('Instituição')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ano_previsao_fim')
                    ->label('Ano Previsto')
                    ->sortable(),
                
                // Item 24 destacado na Tabela
                Tables\Columns\TextColumn::make('situacao_actual')
                    ->label('Situação Actual')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'Atrasada') => 'danger',
                        str_contains($state, 'este ano') => 'warning',
                        default => 'success',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('nivel_em_curso')
                    ->label('Filtrar por Nível')
                    ->options([
                        'Mestrado' => 'Mestrado',
                        'Doutorado' => 'Doutorado',
                        'Pós-doutorado' => 'Pós-doutorado',
                    ]),
                Tables\Filters\SelectFilter::make('organic_unit_id')
                    ->label('Filtrar por Unidade Orgânica')
                    ->relationship('organicUnit', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListDocenteEmFormacaos::route('/'),
            'create' => Pages\CreateDocenteEmFormacao::route('/create'),
            'edit' => Pages\EditDocenteEmFormacao::route('/{record}/edit'),
        ];
    }
}
