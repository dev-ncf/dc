<div>
    <div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Título da Seção -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-rovumaBlue uppercase tracking-tighter">Identidade Estratégica</h2>
            <div class="h-1.5 w-24 bg-rovumaGold mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 mt-6 font-medium">O compromisso da Direção Científica com a excelência académica.</p>
        </div>

        <!-- Grade de Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($cards as $info)
                <div class="group bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 hover:border-rovumaGold transition-all duration-500 hover:-translate-y-2 flex flex-col items-center text-center">
                    
                    <!-- Círculo do Ícone -->
                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mb-8 group-hover:bg-rovumaBlue group-hover:rotate-12 transition-all duration-500 shadow-inner">
                        @if($info->type == 'mission')
                            <!-- Ícone Missão (Foguete) -->
                            <svg class="w-10 h-10 text-rovumaBlue group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.63 8.41m5.96 5.96a14.96 14.96 0 01-12.12 6.16m12.12-6.16a14.98 14.98 0 01-5.96-5.96m-5.84 10.76a14.98 14.98 0 01-6.16-12.12 14.98 14.98 0 0112.12 6.16"></path></svg>
                        @elseif($info->type == 'vision')
                            <!-- Ícone Visão (Olho) -->
                            <svg class="w-10 h-10 text-rovumaBlue group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c3.5 0 6.5 2.057 8.125 5m-16.25 0a17.47 17.47 0 001.375 5c1.274 4.057 5.065 7 9.542 7 3.5 0 6.5-2.057 8.125-5"></path></svg>
                        @else
                            <!-- Ícone Valores (Estrela) -->
                            <svg class="w-10 h-10 text-rovumaBlue group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        @endif
                    </div>

                    <h3 class="text-2xl font-black text-rovumaBlue uppercase tracking-tighter mb-4">{{ $info->title }}</h3>
                    
                    <!-- Conteúdo com formatação limitada para manter o design -->
                    <div class="text-gray-500 leading-relaxed text-sm font-medium line-clamp-6">
                        {!! strip_tags($info->content) !!}
                    </div>

                    <!-- Rodapé do Card -->
                    <div class="mt-auto pt-8">
                        <span class="text-[10px] font-black text-rovumaGold uppercase tracking-[0.3em] group-hover:tracking-[0.5em] transition-all">UniRovuma</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</div>
