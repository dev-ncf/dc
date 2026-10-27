<div>

    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4">

            <!-- HEADER -->
            <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-rovumaBlue uppercase tracking-tighter">Projetos de
                        Investigação</h1>
                    <p class="text-rovumaGold font-bold mt-2 border-l-4 border-rovumaGold pl-4">Ciência ativa
                        impulsionando o desenvolvimento regional</p>
                </div>
                <a href="/projectos/submeter-proposta"
                    class="bg-rovumaBlue text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rovumaGold transition shadow-xl">
                    Submeter Nova Proposta
                </a>
            </div>

            <!-- BARRA DE FILTROS AVANÇADOS -->
            <div
                class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 mb-10 grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por título ou tema..."
                    class="rovuma-input border-gray-100 bg-gray-50 focus:bg-white col-span-1 md:col-span-1">

                <select wire:model.live="selectedUnit" class="rovuma-input border-gray-100 bg-gray-50">
                    <option value="">Todas as Faculdades</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->sigla }}</option>
                    @endforeach
                </select>

                <select wire:model.live="selectedArea" class="rovuma-input border-gray-100 bg-gray-50">
                    <option value="">Todas as Áreas</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="selectedStatus"
                    class="rovuma-input border-gray-100 bg-gray-50 font-bold text-rovumaBlue">
                    <option value="">Todos os Estados</option>
                    <option value="approved">✅ Em Execução</option>
                    <option value="completed">🏆 Concluídos</option>
                    <option value="under_review">⏳ Em Avaliação</option>
                </select>
            </div>

            <!-- LISTAGEM DE CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div
                        class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm hover:shadow-2xl transition-all duration-500 group flex flex-col">
                        <div class="flex justify-between items-start mb-6">
                            <span
                                class="bg-blue-50 text-rovumaBlue text-[10px] font-black px-3 py-1 rounded-lg uppercase border border-blue-100">
                                {{ $project->organicUnit?$project->organicUnit->sigla:'UniRovuma' }}
                            </span>

                            @php
                                $statusColors = [
                                    'approved' => 'bg-green-100 text-green-700',
                                    'completed' => 'bg-rovumaBlue text-white',
                                    'under_review' => 'bg-orange-100 text-orange-700',
                                ];
                            @endphp
                            <span
                                class="text-[9px] font-black px-3 py-1 rounded-full uppercase {{ $statusColors[$project->status] ?? 'bg-gray-100' }}">
                                {{ $project->status }}
                            </span>
                        </div>

                        <h3
                            class="text-xl font-black text-rovumaBlue leading-tight group-hover:text-rovumaGold transition-colors h-14 overflow-hidden">
                            {{ $project->title }}
                        </h3>

                        <div class="mt-6 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-rovumaBlue text-xs border-2 border-white shadow-sm">
                                {{ substr($project->coordinator->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Coordenador</span>
                                <span class="text-xs font-bold text-gray-700">{{ $project->coordinator?$project->coordinator->name:'Não especificado' }}</span>
                            </div>
                        </div>

                        <div class="mt-6 text-gray-500 text-sm line-clamp-3 italic leading-relaxed flex-grow">
                            "{{ $project->abstract }}"
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                            <div class="text-[10px] font-black text-gray-400 uppercase">
                                Orçamento: <span
                                    class="text-rovumaBlue">{{ number_format($project->requested_budget, 2) }}
                                    MT</span>
                            </div>
                            <a href="/projecto/{{ $project->id }}"
                                class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-rovumaBlue group-hover:bg-rovumaGold group-hover:text-white transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 font-bold uppercase tracking-widest">Nenhum projeto encontrado para
                            estes filtros.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>
