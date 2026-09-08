<x-layouts.app>
    <x-slot:title>Estrutura Orgânica</x-slot:title>

    <div class="max-w-7xl mx-auto px-4 py-20 space-y-32">
        
        <!-- SEÇÃO 1: CORPO DIRETIVO CENTRAL (Com fotos e hierarquia por sort_order) -->
        <section class="space-y-20">
            <div class="text-center">
                <h2 class="text-4xl font-black text-rovumaBlue uppercase tracking-tighter italic">Corpo Diretivo Central</h2>
                <div class="h-1.5 w-24 bg-rovumaGold mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="flex flex-col items-center gap-16">
                @foreach($centralLeadership as $order => $leaders)
                    
                    <div class="flex flex-wrap justify-center gap-8 md:gap-12 w-full">
                        @foreach($leaders as $leader)
                            <div class="bg-white rounded-[3rem] shadow-xl border border-gray-100 flex flex-col items-center text-center group transition-all duration-500 hover:shadow-2xl hover:-translate-y-1
                                {{ $order == 0 ? 'p-12 max-w-md border-t-8 border-rovumaGold' : 'p-8 w-full md:w-80' }}">
                                
                                <!-- FOTO DO LÍDER CENTRAL -->
                                <div class="rounded-[2.5rem] overflow-hidden mb-6 border-4 border-gray-50 shadow-inner transition-transform group-hover:scale-105
                                    {{ $order == 0 ? 'w-56 h-56' : 'w-40 h-40' }}">
                                    <img src="{{ asset(''.$leader->image_path) }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($leader->name) }}&background=003366&color=fff'">
                                </div>

                                <span class="text-rovumaGold font-black text-[10px] uppercase tracking-[0.3em]">{{ $leader->academic_level }}</span>
                                <h3 class="font-black text-rovumaBlue mt-2 uppercase tracking-tighter {{ $order == 0 ? 'text-3xl' : 'text-lg' }}">
                                    {{ $leader->name }}
                                </h3>
                                <p class="text-gray-500 font-bold text-xs mt-1 uppercase tracking-widest">{{ $leader->position }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if(!$loop->last)
                        <div class="relative w-full flex justify-center">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-100"></div>
                            </div>
                            <div class="relative bg-gray-50 px-4 rounded-full">
                                <svg class="h-6 w-6 text-rovumaGold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        

    </div>
</x-layouts.app>