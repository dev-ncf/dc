<x-layouts.app>
    <x-slot:title>{{ $event->title }}</x-slot:title>

    <!-- HEADER DO EVENTO -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-12 md:py-20">
            <div class="flex flex-col md:flex-row gap-12 items-center">
                
                <!-- Badge de Data Gigante -->
                <div class="flex-shrink-0 w-32 h-32 md:w-40 md:h-40 bg-rovumaBlue rounded-[2.5rem] shadow-2xl flex flex-col items-center justify-center text-white border-4 border-rovumaGold">
                    <span class="text-sm md:text-base font-black uppercase opacity-80">{{ $event->start_date->translatedFormat('M') }}</span>
                    <span class="text-5xl md:text-6xl font-black">{{ $event->start_date->format('d') }}</span>
                </div>

                <div class="flex-grow text-center md:text-left">
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 mb-6">
                        <span class="bg-rovumaGold text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-[0.2em]">
                            {{ $event->organicUnit->sigla ?? 'Evento Central' }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-rovumaGold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-12 0 9 9 0 0112 0z"></path></svg>
                            {{ $event->start_date->format('H:i') }} Horas
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-black text-rovumaBlue uppercase tracking-tighter leading-tight">
                        {{ $event->title }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-12 gap-12">
            
            <!-- Descrição e Programa (8 Colunas) -->
            <div class="col-span-12 lg:col-span-8">
                @if($event->featured_image)
                    <div class="mb-12 rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white">
                        <img src="{{ asset('' . $event->featured_image) }}" class="w-full h-auto object-cover">
                    </div>
                @endif

                <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-xl shadow-blue-900/5 border border-gray-100">
                    <h3 class="text-2xl font-black text-rovumaBlue uppercase mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                        Descrição e Programa
                    </h3>
                    
                    <article class="prose prose-blue lg:prose-xl max-w-none text-gray-700 leading-relaxed italic">
                        {!! $event->description !!}
                    </article>
                </div>
            </div>

            <!-- Sidebar de Ações (4 Colunas) -->
            <aside class="col-span-12 lg:col-span-4 space-y-8">
                
                <!-- Card de Inscrição -->
                <div class="bg-rovumaBlue p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-rovumaGold rounded-full opacity-20 group-hover:scale-150 transition-transform duration-700"></div>
                    
                    <h4 class="text-xl font-black uppercase mb-6 relative z-10">Participar</h4>
                    
                    <div class="space-y-4 mb-8 relative z-10">
                        <div class="flex items-start gap-4">
                            <div class="mt-1 w-5 h-5 text-rovumaGold shrink-0">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold opacity-90">{{ $event->location }}</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1 w-5 h-5 text-rovumaGold shrink-0">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-sm font-bold opacity-90">Término: {{ $event->end_date ? $event->end_date->format('d/m/Y H:i') : 'Não definido' }}</p>
                        </div>
                    </div>

                    @if($event->registration_url)
                        <a href="{{ $event->registration_url }}" target="_blank" 
                           class="block w-full bg-white text-rovumaBlue py-4 rounded-2xl text-center font-black uppercase text-xs hover:bg-rovumaGold hover:text-white transition-all shadow-lg active:scale-95">
                            Fazer Inscrição Agora
                        </a>
                    @else
                        <div class="bg-white/10 p-4 rounded-xl text-[10px] font-bold uppercase text-center border border-white/20">
                            Entrada Livre / Sem Inscrição prévia
                        </div>
                    @endif
                </div>

                <!-- Botão de Partilha -->
                <button onclick="window.print()" class="w-full flex items-center justify-center gap-3 border-2 border-gray-200 p-4 rounded-2xl font-bold text-gray-500 hover:border-rovumaBlue hover:text-rovumaBlue transition uppercase text-xs tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-3a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Imprimir Cartaz 
                </button>

            </aside>
        </div>
    </div>
</x-layouts.app>