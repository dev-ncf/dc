<x-layouts.app>
    <x-slot:title>Estrutura Orgânica</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 py-16">
        
        <!-- CABEÇALHO -->
        <div class="text-center mb-16">
            <span class="text-rovumaGold text-xs font-black uppercase tracking-[0.3em] bg-amber-50 px-4 py-1.5 rounded-full border border-rovumaGold/20">
                Organograma Institucional
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-rovumaBlue uppercase tracking-tight mt-3">
                Corpo Diretivo Central
            </h1>
            <p class="text-gray-500 font-medium text-sm mt-2 max-w-xl mx-auto">
                Estrutura de liderança e linhas de comando da Universidade Rovuma.
            </p>
            <div class="h-1 w-20 bg-rovumaGold mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- ÁRVORE HIERÁRQUICA / FLUXOGRAMA -->
        <div class="flex flex-col items-center w-full">
            
            @foreach($centralLeadership as $order => $leaders)
                @php
                    $isTopLevel = ($order == 0);
                    $leaderCount = count($leaders);
                @endphp

                <!-- RAMALHO / CARTÕES DO NÍVEL -->
                <div class="relative w-full flex flex-col items-center">

                    <!-- LINHAS DE ENTRADA DO NÍVEL (Apenas para níveis abaixo do Reitor no desktop) -->
                    @if(!$isTopLevel && $leaderCount > 1)
                        <div class="hidden md:flex items-center justify-center w-full max-w-5xl relative mb-8">
                            <!-- Barra Horizontal do Galho -->
                            <div class="absolute top-0 h-0.5 bg-rovumaGold/60 w-[80%] left-[10%]"></div>
                        </div>
                    @endif

                    <!-- GRELHA DE LÍDERES DO NÍVEL -->
                    <div class="flex flex-wrap justify-center gap-8 md:gap-10 w-full relative z-10">
                        @foreach($leaders as $index => $leader)
                            <div class="flex flex-col items-center relative">
                                
                                <!-- Haste vertical individual conectando a barra de topo ao cartão -->
                                @if(!$isTopLevel)
                                    <div class="hidden md:block w-0.5 h-6 bg-rovumaGold/60 -mt-6 mb-2"></div>
                                    <div class="hidden md:flex items-center justify-center text-rovumaGold -mt-3 mb-1">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- CARTÃO EXECUTIVO DO LÍDER -->
                                <div class="bg-white rounded-[2.5rem] border transition-all duration-300 flex flex-col items-center text-center group hover:-translate-y-1.5
                                    {{ $isTopLevel 
                                        ? 'p-10 w-full max-w-md shadow-2xl border-2 border-rovumaGold/60 ring-8 ring-amber-50/70 hover:shadow-rovumaGold/20' 
                                        : 'p-7 w-full sm:w-72 shadow-lg hover:shadow-xl border-gray-100' }}">

                                    <!-- FOTO COM ANEL DESTAQUE -->
                                    <div class="relative rounded-[2rem] overflow-hidden mb-5 border-4 transition-transform duration-300 group-hover:scale-105 shadow-inner
                                        {{ $isTopLevel 
                                            ? 'w-48 h-48 border-rovumaGold/40 ring-4 ring-amber-100' 
                                            : 'w-36 h-36 border-gray-100 ring-2 ring-gray-50' }}">
                                        
                                        <img src="{{ asset(''.$leader->image_path) }}" 
                                             class="w-full h-full object-cover"
                                             alt="{{ $leader->name }}"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($leader->name) }}&background=003366&color=fff&size=256'">

                                        <!-- Badge de Categoria/Ícone sobre a foto -->
                                        @if($isTopLevel)
                                            <div class="absolute bottom-2 right-2 bg-rovumaGold text-white p-1.5 rounded-xl shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- GRAU ACADÉMICO -->
                                    <span class="text-rovumaGold font-black text-[11px] uppercase tracking-[0.25em] bg-amber-50/80 px-3 py-0.5 rounded-full border border-amber-200/50">
                                        {{ $leader->academic_level ?? 'Docente' }}
                                    </span>

                                    <!-- NOME -->
                                    <h3 class="font-black text-rovumaBlue mt-2.5 uppercase tracking-tight {{ $isTopLevel ? 'text-2xl' : 'text-base' }}">
                                        {{ $leader->name }}
                                    </h3>

                                    <!-- CARGO / FUNÇÃO -->
                                    <div class="mt-2 pt-2 border-t border-gray-100 w-full">
                                        <p class="text-gray-500 font-bold text-xs uppercase tracking-wider">
                                            {{ $leader->position }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- CONECTOR VERTICAL TRONCO ENTRE NÍVEIS (SETA E LINHA FLUIDA) -->
                @if(!$loop->last)
                    <div class="flex flex-col items-center my-4 relative z-0">
                        <!-- Haste de descida -->
                        <div class="w-0.5 h-10 bg-gradient-to-b from-rovumaGold to-rovumaBlue"></div>
                        
                        <!-- Nó de ramificação central com anel pulsante -->
                        <div class="relative flex items-center justify-center">
                            <div class="w-7 h-7 rounded-full bg-white border-2 border-rovumaGold shadow-md flex items-center justify-center">
                                <svg class="w-4 h-4 text-rovumaBlue fill-current transform rotate-180" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        <!-- Haste continuação com seta inferior -->
                        <div class="w-0.5 h-10 bg-gradient-to-b from-rovumaBlue to-rovumaGold"></div>
                        <div class="text-rovumaGold -mt-2">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                @endif

            @endforeach

        </div>

    </div>
</x-layouts.app>