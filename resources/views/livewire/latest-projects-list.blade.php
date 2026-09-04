<div>
    <div class="space-y-4">
    @forelse($projects as $project)
        <div class="flex items-center justify-between p-5 bg-gray-50 rounded-2xl border border-transparent hover:border-rovumaGold hover:bg-white hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rovumaBlue rounded-full flex items-center justify-center text-white shrink-0 group-hover:bg-rovumaGold transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-rovumaBlue group-hover:text-rovumaGold transition uppercase text-sm tracking-tight">
                        {{ $project->title }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-1 font-medium">
                        Coordenação: {{ $project->coordinator->name }} | {{ $project->knowledgeArea->name }}
                    </p>
                </div>
            </div>
            
            <div class="text-right hidden md:block">
                <span class="text-[10px] font-black bg-green-100 text-green-700 px-3 py-1 rounded-full uppercase">Ativo</span>
            </div>
        </div>
    @empty
        <div class="p-8 text-center border-2 border-dashed border-gray-200 rounded-2xl">
            <p class="text-gray-400 text-sm italic">Nenhum projeto em exibição no momento.</p>
        </div>
    @endforelse
</div>
</div>
