<x-layouts.app>
    <x-slot:title>Início</x-slot:title>

    <!-- Hero Section -->
    <!-- Ajustado: min-h-[500px] e padding vertical no mobile para o texto não ficar colado -->
    <section class="relative bg-rovumaBlue min-h-[500px] md:h-[600px] flex items-center overflow-hidden py-20 md:py-0">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset('images/campus.jpg') }}" class="w-full h-full object-cover">
        </div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-white text-center md:text-left">
            <!-- Ajustado: texto 3xl no mobile e 5xl/6xl no desktop -->
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black max-w-3xl leading-tight uppercase tracking-tighter">
                Impulsionando a Ciência e a Investigação no Norte de Moçambique
            </h1>
            <p class="mt-6 text-lg md:text-xl text-gray-200 max-w-xl mx-auto md:mx-0">
                Descubra projetos, publicações e editais científicos da Universidade Rovuma.
            </p>
            
            <!-- Ajustado: botões ocupam largura total no mobile e ficam lado a lado no desktop -->
            <div class="mt-10 flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                <a href="{{ route('repositorio') }}" class="bg-rovumaGold px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-rovumaBlue transition shadow-lg text-sm uppercase">
                    Ver Repositório
                </a>
                <a href="{{ route('submeter') }}" class="border-2 border-white px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-rovumaBlue transition text-white text-sm uppercase">
                    Submeter Publicação
                </a>
            </div>
        </div>
    </section>
    

    <!-- Estatísticas Rápidas -->
    <!-- Ajustado: Margem negativa menor no mobile para não sobrepor o texto do hero -->
    <section class="max-w-7xl mx-auto px-4 -mt-10 md:-mt-16 relative z-20">
        <!-- grid-cols-1 no mobile para empilhar, md:grid-cols-3 no desktop -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            <!-- Card 1 -->
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border-b-4 border-rovumaGold flex flex-col items-center md:items-start text-center md:text-left">
                <h3 class="text-rovumaBlue font-black text-4xl md:text-5xl">{{ $stats['publications'] }}</h3>
                <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Publicações Académicas</p>
            </div>
            <!-- Card 2 -->
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border-b-4 border-rovumaGold flex flex-col items-center md:items-start text-center md:text-left">
                <h3 class="text-rovumaBlue font-black text-4xl md:text-5xl">{{ $stats['projects'] }}</h3>
                <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Projetos de Investigação</p>
            </div>
            <!-- Card 3 -->
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border-b-4 border-rovumaGold flex flex-col items-center md:items-start text-center md:text-left">
                <h3 class="text-rovumaBlue font-black text-4xl md:text-5xl">{{ $stats['units'] }}</h3>
                <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Faculdades e Unidades</p>
            </div>
        </div>
    </section>
<livewire:institutional-cards />
    <!-- Últimas Notícias -->
    <section class="py-16 md:py-24 max-w-7xl mx-auto px-4">
        <!-- Título responsivo -->
        <div class="flex flex-col md:flex-row items-center gap-4 mb-12">
            <h2 class="text-2xl md:text-3xl font-black text-rovumaBlue uppercase tracking-tighter text-center md:text-left">
                Últimas Notícias Científicas
            </h2>
            <div class="hidden md:block h-1 flex-grow bg-gray-100 rounded-full"></div>
        </div>
        
        <!-- Ajustado: grid de 1 coluna no mobile, 2 em tablets e 4 em desktops grandes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($news as $post)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <!-- Imagem responsiva -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('' . $post->featured_image) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-3 left-3 bg-rovumaBlue text-white text-[9px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                            {{ $post->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <span class="text-[10px] font-black text-rovumaGold uppercase tracking-widest">{{ $post->type }}</span>
                        <h3 class="font-bold text-lg mt-2 text-rovumaBlue leading-tight line-clamp-2 h-14 group-hover:text-rovumaGold transition">
                            {{ $post->title }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-3 line-clamp-3 leading-relaxed">
                            {!! strip_tags($post->content) !!}
                        </p>
                        <div class="mt-6 pt-4 border-t border-gray-50">
                            <a href="/noticia/{{ $post->slug }}" class="flex items-center gap-2 font-black text-[10px] text-rovumaBlue uppercase tracking-widest hover:text-rovumaGold transition">
                                Ler Artigo <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Botão Ver Todas (Opcional, apenas mobile) -->
        <div class="mt-12 text-center md:hidden">
            <a href="/noticias" class="text-rovumaBlue font-bold text-sm underline">Ver todas as notícias</a>
        </div>
    </section>
</x-layouts.app>