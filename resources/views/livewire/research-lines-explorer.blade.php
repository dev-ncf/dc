<div>
   <div class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-black text-rovumaBlue uppercase tracking-tighter">Linhas de Investigação</h2>
        <p class="text-rovumaGold font-bold mt-2">Explore as áreas de especialização científica da UniRovuma</p>
    </div>

    <div class="flex flex-wrap justify-center gap-3 mb-12">
        <button wire:click="$set('selectedUnitId', null)" 
            class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all {{ is_null($selectedUnitId) ? 'bg-rovumaGold text-white shadow-lg' : 'bg-white text-rovumaBlue border border-gray-100 hover:bg-gray-50' }}">
            Todas as Unidades
        </button>
        @foreach($units as $unit)
            <button wire:click="$set('selectedUnitId', {{ $unit->id }})" 
                class="px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all {{ $selectedUnitId == $unit->id ? 'bg-rovumaBlue text-white shadow-lg' : 'bg-white text-rovumaBlue border border-gray-100 hover:bg-gray-50' }}">
                {{ $unit->sigla }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($lines as $line)
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-2xl hover:border-rovumaGold/30 transition-all duration-500 group">
                <div class="flex justify-between items-start mb-6">
                    <span class="bg-blue-50 text-rovumaBlue text-[10px] font-black px-3 py-1 rounded-lg uppercase">
                        {{ $line->organicUnit->name }}
                    </span>
                    <svg class="w-6 h-6 text-gray-200 group-hover:text-rovumaGold transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                
                <h3 class="text-2xl font-black text-rovumaBlue leading-tight group-hover:text-rovumaGold transition uppercase tracking-tighter">
                    {{ $line->title }}
                </h3>
                
                <div class="mt-6 text-gray-600 text-sm leading-relaxed line-clamp-4 prose prose-sm">
                    {!! $line->description !!}
                </div>

                <div class="mt-8 pt-6 border-t border-gray-50">
                    <a href="#" class="inline-flex items-center gap-2 text-xs font-black text-rovumaBlue uppercase tracking-widest group-hover:gap-4 transition-all">
                        Ver projetos desta linha <span>&rarr;</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200 text-gray-400 font-bold">
                Nenhuma linha de pesquisa encontrada para esta unidade.
            </div>
        @endforelse
    </div>
</div>
</div>
