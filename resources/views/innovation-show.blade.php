<x-layouts.app>
    <div class="bg-rovumaBlue py-24 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <span class="bg-rovumaGold px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6 inline-block">Vitrine de Inovação Tecnológica</span>
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter leading-none max-w-4xl">{{ $project->title }}</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 -mt-10 relative z-20 pb-20">
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-12 lg:col-span-8 space-y-8">
                <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl border border-gray-100 space-y-8">
                    <div>
                        <h3 class="text-2xl font-black text-rovumaBlue uppercase mb-4 flex items-center gap-3">
                            <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                            Resumo Tecnológico
                        </h3>
                        <p class="text-gray-600 text-lg leading-relaxed italic">{{ $project->abstract }}</p>
                    </div>

                    @if($project->market_potential)
                    <div>
                        <h3 class="text-2xl font-black text-rovumaBlue uppercase mb-4 flex items-center gap-3">
                            <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                            Potencial de Mercado
                        </h3>
                        <p class="text-gray-600 leading-relaxed">{{ $project->market_potential }}</p>
                    </div>
                    @endif

                    @if($project->project_file_path)
                    <div class="pt-6 border-t border-gray-100">
                        <a href="{{ asset('storage/' . $project->project_file_path) }}" target="_blank"
                            class="inline-flex items-center gap-3 bg-rovumaBlue text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rovumaGold transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Descarregar Pitch Deck / Documento Técnico (PDF)
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <aside class="col-span-12 lg:col-span-4 space-y-8">
                <!-- INFO TÉCNICA DA INOVAÇÃO -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50 space-y-6">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest border-b pb-4">Indicadores de Inovação</h4>
                    
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-gray-400 uppercase">Categoria</span>
                        <span class="text-sm font-bold text-rovumaBlue">{{ str_replace('_', ' ', $project->innovation_type) }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-gray-400 uppercase">Maturidade (TRL)</span>
                        <span class="text-sm font-bold text-rovumaBlue">{{ str_replace('_', ' ', $project->trl_level) }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-gray-400 uppercase">Área Científica</span>
                        <span class="text-sm font-bold text-rovumaBlue">{{ $project->knowledgeArea->name ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- CRIADOR / INVENTOR -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest mb-4 border-b pb-4">Inventor Principal</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-rovumaGold flex items-center justify-center text-white text-xs font-black uppercase">
                            {{ substr($project->inventor->name ?? 'I', 0, 1) }}
                        </div>
                        <span class="text-sm font-bold text-rovumaBlue">{{ $project->inventor->name ?? 'Não especificado' }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>