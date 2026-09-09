<div>
    <div>
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4">

                <!-- HEADER -->
                <div class="mb-12 text-center md:text-left">
                    <span
                        class="bg-rovumaGold text-white px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] inline-block mb-3">Normas
                        Editoriais</span>
                    <h1 class="text-4xl md:text-5xl font-black text-rovumaBlue uppercase tracking-tighter">Políticas de
                        Publicações</h1>
                    <p class="text-rovumaGold font-bold mt-2 border-l-4 border-rovumaGold pl-4">Orientações
                        institucionais sobre direitos de autor, submissão em revistas, repositórios e difusão
                        científica.</p>
                </div>

                <!-- FILTROS -->
                <div
                    class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 mb-10 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Pesquisar por diretriz ou palavra-chave..."
                        class="rovuma-input border-gray-100 bg-gray-50">

                    <select wire:model.live="selectedCategory" class="rovuma-input border-gray-100 bg-gray-50">
                        <option value="">Todas as Categorias</option>
                        <option value="revistas_cientificas">Revistas Científicas e Indexação</option>
                        <option value="repositorio_institucional">Normas do Repositório Institucional</option>
                        <option value="teses_dissertacoes">Diretrizes para Teses e Dissertações</option>
                        <option value="incentivos_publicacao">Incentivos e Apoio à Publicação</option>
                    </select>
                </div>

                <!-- LISTAGEM DE POLÍTICAS -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($policies as $policy)
                        <div
                            class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm hover:shadow-2xl transition-all duration-500 group flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-6">
                                    <span
                                        class="bg-amber-50 text-amber-700 text-[10px] font-black px-3 py-1 rounded-lg uppercase border border-amber-100">
                                        {{ str_replace('_', ' ', $policy->category) }}
                                    </span>
                                    <span
                                        class="text-[10px] font-black px-3 py-1 rounded-full bg-gray-100 text-gray-500">
                                        Versão {{ $policy->version_year }}
                                    </span>
                                </div>

                                <h3
                                    class="text-xl font-black text-rovumaBlue leading-tight group-hover:text-rovumaGold transition-colors">
                                    {{ $policy->title }}
                                </h3>

                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    {{ $policy->description }}
                                </p>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-50">
                                <a href="{{ asset('storage/' . $policy->document_file_path) }}" target="_blank"
                                    class="w-full bg-rovumaBlue text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rovumaGold transition shadow-md flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Descarregar Documento (PDF)
                                </a>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                            <p class="text-gray-400 font-bold uppercase tracking-widest">Nenhuma diretriz de publicação
                                encontrada.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
