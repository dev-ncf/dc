<div>
    <div>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            
            <!-- HEADER -->
            <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="bg-rovumaGold text-white px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] inline-block mb-3">Tecnologia & Patentes</span>
                    <h1 class="text-4xl md:text-5xl font-black text-rovumaBlue uppercase tracking-tighter">Inovação e Empreendedorismo</h1>
                    <p class="text-rovumaGold font-bold mt-2 border-l-4 border-rovumaGold pl-4">Soluções científicas transformadas em produtos de mercado</p>
                </div>
                <a href="/inovacao/submeter-proposta" class="bg-rovumaBlue text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rovumaGold transition shadow-xl text-center">
                    Submeter Inovação / Startup
                </a>
            </div>

            <!-- FILTROS -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 mb-10 grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar protótipos, patentes..." class="rovuma-input border-gray-100 bg-gray-50">

                <select wire:model.live="selectedType" class="rovuma-input border-gray-100 bg-gray-50">
                    <option value="">Todas as Categorias</option>
                    <option value="prototipo_tecnologico">Protótipo Tecnológico</option>
                    <option value="produto_alimentar">Agroalimentar / Bioproduto</option>
                    <option value="software">Software / App</option>
                    <option value="patente">Patente / Propriedade Intelectual</option>
                </select>

                <select wire:model.live="selectedStatus" class="rovuma-input border-gray-100 bg-gray-50 font-bold text-rovumaBlue">
                    <option value="">Todos os Estados</option>
                    <option value="incubating">Em Incubação</option>
                    <option value="market_ready">Pronto para o Mercado</option>
                    <option value="patented">Patenteado</option>
                </select>
            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm hover:shadow-2xl transition-all duration-500 group flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <span class="bg-purple-50 text-purple-700 text-[10px] font-black px-3 py-1 rounded-lg uppercase border border-purple-100">
                                    {{ str_replace('_', ' ', $project->innovation_type) }}
                                </span>
                                <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase bg-blue-50 text-rovumaBlue">
                                    {{ str_replace('_', ' ', $project->status) }}
                                </span>
                            </div>

                            <h3 class="text-xl font-black text-rovumaBlue leading-tight group-hover:text-rovumaGold transition-colors h-14 overflow-hidden">
                                {{ $project->title }}
                            </h3>

                            <div class="mt-6 text-gray-500 text-sm line-clamp-3 italic leading-relaxed">
                                "{{ $project->abstract }}"
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Inventor / Criador</span>
                                <span class="text-xs font-bold text-gray-700">{{ $project->inventor->name ?? 'N/A' }}</span>
                            </div>
                            <a href="/inovacao/{{ $project->id }}" class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-rovumaBlue group-hover:bg-rovumaGold group-hover:text-white transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 font-bold uppercase tracking-widest">Nenhuma inovação encontrada.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>
</div>
