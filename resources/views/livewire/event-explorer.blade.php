<div>
    <div class="max-w-7xl mx-auto px-4 py-12 md:py-16">
        
        <!-- HEADER DA AGENDA -->
        <div class="mb-12 border-b border-gray-100 pb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <h2 class="text-4xl md:text-5xl font-black text-rovumaBlue uppercase tracking-tighter">Agenda Científica</h2>
                <p class="text-rovumaGold font-bold mt-2 italic">Conferências, Palestras e Workshops da UniRovuma</p>
            </div>
            
            <!-- ÁREA DE AÇÃO E FILTRO -->
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                
                <!-- BOTÃO DE SUBMISSÃO (O que foi acrescentado) -->
                <a href="/agenda/propor-evento" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-rovumaGold text-white px-6 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rovumaBlue transition-all shadow-lg shadow-orange-500/20 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Propor Evento
                </a>

                <!-- Filtro Rápido -->
                <div class="relative w-full sm:w-auto">
                    <select wire:model.live="unitFilter" class="w-full appearance-none rounded-2xl border-2 border-gray-100 bg-white px-5 py-3 pr-10 text-xs font-black uppercase tracking-widest text-rovumaBlue focus:border-rovumaGold focus:ring-0 cursor-pointer shadow-sm">
                        <option value="">Todas as Unidades</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->sigla }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-rovumaGold">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- LISTAGEM DE EVENTOS -->
        <div class="space-y-8">
            @forelse($events as $event)
                <div class="flex flex-col md:flex-row gap-8 bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-500 group">
                    
                    <!-- BADGE DE DATA -->
                    <div class="flex-shrink-0 w-full md:w-32 h-32 bg-rovumaBlue rounded-3xl flex flex-col items-center justify-center text-white group-hover:bg-rovumaGold transition-colors duration-500 shadow-lg">
                        <span class="text-xs font-bold uppercase opacity-80">{{ $event->start_date->translatedFormat('M') }}</span>
                        <span class="text-4xl font-black">{{ $event->start_date->format('d') }}</span>
                        <span class="text-[10px] font-bold opacity-60">{{ $event->start_date->format('H:i') }}h</span>
                    </div>

                    <!-- CONTEÚDO -->
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-3 text-[10px] font-black uppercase tracking-widest">
                            <span class="bg-blue-50 text-rovumaBlue px-3 py-1 rounded-full border border-blue-100">
                                {{ $event->organicUnit->sigla ?? 'Evento Central' }}
                            </span>
                            <span class="text-gray-300">|</span>
                            <span class="text-gray-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-rovumaGold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $event->location }}
                            </span>
                        </div>

                        <h3 class="text-2xl md:text-3xl font-black text-rovumaBlue group-hover:text-rovumaGold transition-colors uppercase tracking-tight leading-tight">
                            {{ $event->title }}
                        </h3>

                        <div class="mt-4 text-gray-600 text-sm leading-relaxed line-clamp-2 italic">
                            {!! strip_tags($event->description) !!}
                        </div>

                        <div class="mt-8 flex flex-wrap items-center gap-6">
                            <a href="/evento/{{ $event->slug }}" class="text-[11px] font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold pb-0.5 hover:text-rovumaGold transition">
                                Detalhes e Programa &rarr;
                            </a>
                            
                            @if($event->registration_url)
                                <a href="{{ $event->registration_url }}" target="_blank" class="bg-rovumaBlue text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase hover:bg-rovumaGold transition shadow-md">
                                    Inscrever-se Agora
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- IMAGEM -->
                    @if($event->featured_image)
                        <div class="hidden lg:block w-56 h-48 rounded-3xl overflow-hidden shrink-0 shadow-inner">
                            <img src="{{ asset('' . $event->featured_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-24 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                    <img src="{{ asset('images/calendary.png') }}" class="w-40 mx-auto opacity-40 mb-6">
                    <p class="text-gray-400 font-bold uppercase tracking-widest">Nenhum evento agendado para este período.</p>
                    <a href="/agenda/propor-evento" class="mt-4 inline-block text-rovumaGold font-black uppercase text-xs hover:underline">Seja o primeiro a propor um evento &rarr;</a>
                </div>
            @endforelse
        </div>
    </div>
</div>