<div>
   
    <div class="min-h-screen bg-white">
    <!-- HERO DA PÁGINA -->
    <div class="bg-rovumaBlue py-20 text-white relative overflow-hidden">
        <div class="absolute right-0 bottom-0 opacity-10 w-96 h-96 bg-rovumaGold rounded-full -mr-20 -mb-20"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter">Oferta Académica</h1>
            <p class="text-rovumaGold font-bold text-lg mt-4 uppercase tracking-widest">Cursos e Programas por Faculdade</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-12 gap-10">
            
            <!-- BARRA LATERAL: LISTA DE UNIDADES (4 Colunas) -->
            <aside class="col-span-12 lg:col-span-4 space-y-4">
                <div class="sticky top-28">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Selecione a Faculdade</h3>
                    
                    <div class="flex flex-col gap-2">
                        <!-- Opção "Todas" -->
                        <button wire:click="$set('selectedUnitId', null)" 
                            class="flex items-center justify-between p-4 rounded-2xl transition-all duration-300 border-2 {{ is_null($selectedUnitId) ? 'border-rovumaGold bg-blue-50 text-rovumaBlue shadow-lg' : 'border-gray-100 hover:border-gray-300 text-gray-500' }}">
                            <span class="font-bold uppercase text-sm">Todas as Unidades</span>
                            <span class="bg-white px-2 py-1 rounded-md text-[10px] font-black shadow-sm">{{ \App\Models\Course::count() }}</span>
                        </button>

                        @foreach($units as $unit)
                            <button wire:click="selectUnit({{ $unit->id }})" 
                                class="group flex items-center justify-between p-4 rounded-2xl transition-all duration-300 border-2 {{ $selectedUnitId == $unit->id ? 'border-rovumaGold bg-blue-50 text-rovumaBlue shadow-lg' : 'border-gray-50 hover:border-rovumaBlue/20 text-gray-600' }}">
                                <div class="flex flex-col items-start">
                                    <span class="font-black uppercase text-sm tracking-tight">{{ $unit->sigla }}</span>
                                    <span class="text-[10px] opacity-70 font-medium truncate max-w-[200px]">{{ $unit->name }}</span>
                                </div>
                                <span class="bg-white group-hover:bg-rovumaBlue group-hover:text-white transition-colors px-2 py-1 rounded-md text-[10px] font-black shadow-sm">
                                    {{ $unit->courses_count }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- CONTEÚDO: LISTA DE CURSOS (8 Colunas) -->
            <main class="col-span-12 lg:col-span-8">
                
                <!-- Barra de Pesquisa Rápida -->
                <div class="mb-10 relative">
                    <input type="text" wire:model.live="search" 
                        placeholder="Pesquisar curso por nome... (Ex: Informática)"
                        class="w-full bg-gray-50 border-2 border-gray-100 h-16 pl-14 pr-6 rounded-2xl focus:bg-white focus:border-rovumaGold focus:ring-0 transition-all text-lg font-medium">
                    <svg class="w-6 h-6 absolute left-5 top-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Título do Contexto -->
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-rovumaBlue uppercase flex items-center gap-3">
                        <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                        {{ $activeUnit ? $activeUnit->name : 'Todos os Cursos Disponíveis' }}
                    </h2>
                    @if($activeUnit)
                        <p class="text-gray-500 text-sm mt-1 font-medium italic">Localização: {{ $activeUnit->location }}</p>
                    @endif
                </div>

                <!-- Grade de Cursos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($courses as $course)
                        <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-xl hover:border-rovumaGold transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-4">
                                    <span class="text-[9px] font-black bg-rovumaBlue text-white px-2 py-0.5 rounded uppercase tracking-widest">Graduação</span>
                                    <svg class="w-5 h-5 text-gray-200 group-hover:text-rovumaGold transition" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.822a.75.75 0 00-1.288 0l-8.322 13.17a.75.75 0 00.644 1.155h16.644a.75.75 0 00.644-1.155l-8.322-13.17z"></path></svg>
                                </div>
                                <h4 class="text-lg font-bold text-rovumaBlue leading-tight group-hover:text-rovumaBlue/80">
                                    {{ $course->name }}
                                </h4>
                                <p class="text-xs text-gray-400 mt-2 font-bold uppercase tracking-tighter">
                                    {{ $course->organicUnit->sigla }}
                                </p>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-gray-50">
                                <a href="#" class="text-[10px] font-black text-rovumaGold uppercase tracking-widest hover:underline">Ver Detalhes do Curso &rarr;</a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 font-bold">Nenhum curso encontrado para esta seleção.</p>
                        </div>
                    @endforelse
                </div>
            </main>

        </div>
    </div>
</div>
</div>
