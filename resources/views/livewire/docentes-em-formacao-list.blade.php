<div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Cabeçalho -->
        <div class="mb-8 border-b border-gray-200 pb-5">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
                Docentes em Formação
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                Direcção Científica — Acompanhamento do Plano de Capacitação do Corpo Docente da Universidade Rovuma.
            </p>
        </div>

        <!-- Barra de Pesquisa e Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 bg-gray-50 p-4 rounded-xl border border-gray-200">
            <!-- Campo de Pesquisa -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Pesquisar</label>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Nome do docente, curso ou universidade..."
                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
            </div>

            <!-- Filtro: Unidade Orgânica -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Unidade Orgânica</label>
                <select wire:model.live="selectedUnit"
                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    <option value="">Todas as Unidades</option>
                    @foreach ($unidades as $unidade)
                        <option value="{{ $unidade->id }}">{{ $unidade->name }} ({{ $unidade->sigla }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro: Nível -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Nível de Formação</label>
                <select wire:model.live="selectedLevel"
                    class="w-full text-sm rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    <option value="">Todos os Níveis</option>
                    <option value="Mestrado">Mestrado</option>
                    <option value="Doutorado">Doutorado</option>
                    <option value="Pós-doutorado">Pós-doutorado</option>
                </select>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading class="w-full text-center py-4 text-blue-600 font-medium text-sm">
            A carregar dados...
        </div>

        <!-- Listagem em Grelha (Cards) -->
        <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($docentes as $docente)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between hover:shadow-md transition">
                    <div class="p-5">

                        <!-- Unidade & Categoria -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded font-medium bg-gray-100 text-gray-800">
                                {{ $docente->organicUnit?->sigla ?? 'Sem Unidade' }}
                            </span>
                            <span>{{ $docente->categoria }}</span>
                        </div>

                        <!-- Nome do Docente -->
                        <h3 class="text-base font-semibold text-gray-900 line-clamp-1 mb-1"
                            title="{{ $docente->nome_completo }}">
                            {{ $docente->nome_completo }}
                        </h3>
                        <p class="text-xs text-gray-500 mb-4">{{ $docente->organicUnit?->name }}</p>

                        <!-- Detalhes do Curso -->
                        <div class="space-y-2 text-sm border-t border-gray-100 pt-3">
                            <div>
                                <span class="text-xs text-gray-400 block">Formação em Curso</span>
                                <span class="font-medium text-gray-800">{{ $docente->nivel_em_curso }}:
                                    {{ $docente->curso }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 block">Instituição</span>
                                <span class="text-gray-700">{{ $docente->instituicao }} ({{ $docente->cidade }},
                                    {{ $docente->pais }})</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 pt-1">
                                <span>Início: <strong>{{ $docente->ano_inicio }}</strong></span>
                                <span>Previsão: <strong>{{ $docente->ano_previsao_fim }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Rodapé com Situação Actual (Item 24) -->
                    <div
                        class="px-5 py-3 border-t border-gray-100 bg-gray-50 rounded-b-xl flex items-center justify-between">
                        <span class="text-xs text-gray-500 font-medium">Situação:</span>

                        @php
                            $isAtrasado = str_contains($docente->situacao_actual, 'Atrasada');
                            $isCorrente = str_contains($docente->situacao_actual, 'este ano');
                        @endphp

                        <span
                            class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $isAtrasado ? 'bg-red-100 text-red-700' : ($isCorrente ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                            {{ $docente->situacao_actual }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Nenhum registo encontrado</h3>
                    <p class="mt-1 text-sm text-gray-500">Tente ajustar a sua pesquisa ou os filtros aplicados.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        <div class="mt-8">
            {{ $docentes->links() }}
        </div>
    </div>
</div>
