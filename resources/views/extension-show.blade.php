<x-layouts.app>
    <div class="bg-rovumaBlue py-24 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <span class="bg-rovumaGold px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6 inline-block">Projeto de Extensão Universitária</span>
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
                            Resumo e Objetivos
                        </h3>
                        <p class="text-gray-600 text-lg leading-relaxed italic">{{ $project->abstract }}</p>
                    </div>

                    @if($project->expected_impact)
                    <div>
                        <h3 class="text-2xl font-black text-rovumaBlue uppercase mb-4 flex items-center gap-3">
                            <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                            Impacto Social Esperado
                        </h3>
                        <p class="text-gray-600 leading-relaxed">{{ $project->expected_impact }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <aside class="col-span-12 lg:col-span-4 space-y-8">
                <!-- INFO COMUNITÁRIA -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50 space-y-4">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest border-b pb-4">Parceria & Envolvimento</h4>
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase block">Parceiro Comunitário</span>
                        <span class="text-sm font-bold text-rovumaBlue">{{ $project->community_partner }}</span>
                    </div>
                    @if($project->target_beneficiaries)
                    <div>
                        <span class="text-[10px] font-black text-gray-400 uppercase block">Público-Alvo</span>
                        <span class="text-sm font-bold text-rovumaBlue">{{ $project->target_beneficiaries }}</span>
                    </div>
                    @endif
                </div>

                <!-- INFO TÉCNICA -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest mb-6 border-b pb-4">Dados Técnicos</h4>
                    <ul class="space-y-4">
                        <li class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Área Temática</span>
                            <span class="text-sm font-bold text-rovumaBlue">{{ $project->knowledgeArea->name ?? 'N/A' }}</span>
                        </li>
                        @if($project->start_date && $project->end_date)
                        <li class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Período de Execução</span>
                            <span class="text-sm font-bold text-rovumaBlue">{{ $project->start_date->format('M Y') }} - {{ $project->end_date->format('M Y') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>