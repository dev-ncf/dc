<div>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- HEADER DO REPOSITÓRIO -->
            <div
                class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-gray-200 pb-8">
                <div>
                    <h1 class="text-5xl font-black text-rovumaBlue tracking-tighter uppercase leading-none">Repositório
                    </h1>
                    <p class="text-rovumaGold font-bold text-lg mt-2 italic">Arquivo Digital de Produção Científica e
                        Académica</p>
                </div>

                <!-- Barra de Busca Global -->
                <div class="relative w-full md:w-96 group">
                    <input type="text" wire:model.live.debounce.400ms="search"
                        placeholder="Pesquisar por título, autor ou tema..."
                        class="w-full bg-white border-2 border-gray-100 h-14 pl-12 pr-4 rounded-2xl shadow-sm focus:border-rovumaGold focus:ring-0 transition-all group-hover:shadow-md">
                    <svg class="w-6 h-6 absolute left-4 top-4 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-8">

                <!-- SIDEBAR DE FILTROS (3 Colunas) -->
                <aside class="col-span-12 lg:col-span-3 space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-xl shadow-blue-900/5 border border-gray-100">
                        <h2
                            class="font-black text-rovumaBlue uppercase text-sm tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4 text-rovumaGold" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z">
                                </path>
                            </svg>
                            Refinar Pesquisa
                        </h2>

                        <!-- Filtro: Tipo -->
                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Tipo de
                                Recurso</label>
                            <select wire:model.live="selectedType"
                                class="w-full border-gray-100 rounded-xl text-sm focus:border-rovumaGold focus:ring-0 font-medium">
                                <option value="">Todos os tipos</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro: Faculdade/Campus -->
                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Faculdade /
                                Campus</label>
                            <select wire:model.live="selectedUnit"
                                class="w-full border-gray-100 rounded-xl text-sm focus:border-rovumaGold focus:ring-0 font-medium">
                                <option value="">Todas as Unidades</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filtro: Ano -->
                        <div class="mb-6">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Ano de
                                Publicação</label>
                            <select wire:model.live="selectedYear"
                                class="w-full border-gray-100 rounded-xl text-sm focus:border-rovumaGold focus:ring-0 font-medium">
                                <option value="">Qualquer ano</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button wire:click="$set('search', '')"
                            class="w-full py-3 text-xs font-bold text-gray-400 hover:text-rovumaBlue transition uppercase tracking-widest">
                            Limpar todos os filtros
                        </button>
                    </div>
                </aside>

                <!-- LISTAGEM DE RESULTADOS (9 Colunas) -->
                <main class="col-span-12 lg:col-span-9 space-y-6">

                    <!-- Info de Resultados e Sort -->
                    <div class="flex justify-between items-center px-2">
                        <p class="text-sm text-gray-500 font-medium">
                            Mostrando <span class="text-rovumaBlue font-bold">{{ $publications->total() }}</span>
                            documentos encontrados
                        </p>
                        <select wire:model.live="sort"
                            class="border-none bg-transparent text-xs font-black text-rovumaBlue uppercase tracking-widest focus:ring-0 cursor-pointer">
                            <option value="latest">Mais Recentes</option>
                            <option value="oldest">Mais Antigos</option>
                            <option value="title">Título A-Z</option>
                        </select>
                    </div>

                    <!-- Lista de Cards -->
                    @forelse($publications as $pub)
                        <div
                            class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-rovumaGold/30 transition-all duration-300 group relative overflow-hidden">
                            <!-- Badge Lateral de Tipo -->
                            <div
                                class="absolute top-0 right-0 px-6 py-1 bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-bl-2xl group-hover:bg-rovumaGold group-hover:text-white transition-colors">
                                {{ $pub->documentType->name }}
                            </div>

                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Ícone do Documento -->
                                <div
                                    class="hidden md:flex w-20 h-24 bg-blue-50 rounded-2xl items-center justify-center shrink-0 group-hover:bg-rovumaBlue transition-colors duration-500">
                                    <svg class="w-10 h-10 text-rovumaBlue group-hover:text-white transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 2 0 01.707.293l5.414 5.414a1 2 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>

                                <div class="flex-grow">
                                    <h2
                                        class="text-xl md:text-2xl font-black text-rovumaBlue leading-tight group-hover:text-rovumaGold transition-colors cursor-pointer">
                                        {{ $pub->title }}
                                    </h2>

                                    <div
                                        class="flex flex-wrap items-center gap-y-2 gap-x-4 mt-3 text-sm font-bold uppercase tracking-tight text-gray-400">
                                        <span class="text-rovumaBlue">Autor: {{ $pub->author_name }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span>Ano: {{ $pub->publication_year }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-rovumaGold">{{ $pub->organicUnit->name ?? 'Externo' }}</span>
                                    </div>

                                    <p class="text-gray-600 mt-4 line-clamp-2 text-sm leading-relaxed italic">
                                        "{{ $pub->abstract }}"
                                    </p>

                                    <!-- Keywords Badges -->
                                    <div class="flex flex-wrap gap-2 mt-5">
                                        @foreach ($pub->keywords as $keyword)
                                            <span
                                                class="bg-gray-50 text-gray-500 text-[9px] font-black px-2 py-1 rounded-md uppercase border border-gray-100">{{ $keyword }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Botão de Download / Detalhes -->
                            <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                                <a href="{{ route('publication.show', $pub->slug) }}"
                                    class="text-xs font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold pb-0.5 hover:text-rovumaGold transition">Ver
                                    DETALHES</a>

                                @if ($pub->visibility === 'public')
                                    <a href="{{ asset('' . $pub->file_path) }}" target="_blank"
                                        class="flex items-center gap-2 bg-rovumaBlue text-white px-6 py-3 rounded-xl text-xs font-black hover:bg-rovumaGold hover:-translate-y-1 transition shadow-lg shadow-blue-900/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                            </path>
                                        </svg>
                                        ACEDER AO DOCUMENTO (PDF)
                                    </a>
                                @else
                                    <span class="flex items-center gap-2 text-gray-400 text-xs font-black uppercase">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Acesso Restrito
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div
                            class="text-center py-20 bg-white rounded-3xl shadow-inner border-2 border-dashed border-gray-100">
                            <img src="{{ asset('images/search_17302933.png') }}" alt="Nenhum resultado encontrado"
                                class="w-48 mx-auto opacity-50 mb-6">
                            <p class="text-gray-400 font-bold text-lg">Nenhuma publicação corresponde à sua busca.</p>
                            <button wire:click="$set('search', '')"
                                class="mt-4 text-rovumaGold font-black uppercase text-xs hover:underline">Limpar
                                Filtros</button>
                        </div>
                    @endforelse

                    <!-- Paginação Personalizada -->
                    <div class="mt-12">
                        {{ $publications->links() }}
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
