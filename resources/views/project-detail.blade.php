<x-layouts.app>
    <div class="bg-rovumaBlue py-24 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <span class="bg-rovumaGold px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6 inline-block">Projeto de Investigação</span>
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter leading-none max-w-4xl">{{ $project->title }}</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 -mt-10 relative z-20 pb-20">
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl border border-gray-100 space-y-12">
                    
                    <div>
                        <h3 class="text-2xl font-black text-rovumaBlue uppercase mb-6 flex items-center gap-3">
                            <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                            Resumo do Projeto
                        </h3>
                        <p class="text-gray-600 text-lg leading-relaxed italic">{{ $project->abstract }}</p>
                    </div>

                    <div>
                        <h3 class="text-2xl font-black text-rovumaBlue uppercase mb-6 flex items-center gap-3">
                            <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                            Metodologia e Descrição
                        </h3>
                        <div class="prose prose-blue max-w-none text-gray-700">
                            {!! $project->description !!}
                        </div>
                    </div>

                </div>
            </div>

            <aside class="col-span-12 lg:col-span-4 space-y-8">
                <!-- INFO TÉCNICA -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest mb-6 border-b pb-4">Dados Técnicos</h4>
                    <ul class="space-y-4">
                        <li class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Unidade Orgânica</span>
                            <span class="text-sm font-bold text-rovumaBlue">{{ $project->organicUnit?$project->organicUnit->name:'UniRovuma' }}</span>
                        </li>
                        <li class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Área Científica</span>
                            <span class="text-sm font-bold text-rovumaBlue">{{ $project->knowledgeArea?$project->knowledgeArea->name:'Não especificada' }}</span>
                        </li>
                        <li class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Duração</span>
                            <span class="text-sm font-bold text-rovumaBlue">{{ $project->start_date->format('M Y') }} - {{ $project->end_date->format('M Y') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- EQUIPA -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-50">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest mb-6 border-b pb-4">Equipa de Investigação</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-rovumaGold flex items-center justify-center text-white text-[10px] font-black uppercase">C</div>
                            <span class="text-sm font-bold">{{ $project->coordinator->name }}</span>
                        </div>
                        @foreach($project->teamMembers as $member)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px] font-black uppercase">M</div>
                            <span class="text-sm font-medium text-gray-600">{{ $member->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>