<x-layouts.app>
    <x-slot:title>{{ $page->title }}</x-slot:title>

    <!-- HERO SECTION: Impacto Visual -->
    <div class="relative bg-rovumaBlue py-24 overflow-hidden">
        <!-- Overlay de padrão geométrico (opcional) -->
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="max-w-3xl">
                    <nav class="flex text-xs font-black text-rovumaGold mb-4 uppercase tracking-[0.2em]">
                        <a href="/" class="hover:text-white transition">Início</a>
                        <span class="mx-2 text-white/40">/</span>
                        <span>Institucional</span>
                    </nav>
                    <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">
                        {{ $page->title }}
                    </h1>
                </div>
                
                @if($page->featured_image)
                <div class="hidden md:block w-48 h-48 rounded-full border-4 border-rovumaGold overflow-hidden shadow-2xl">
                    <img src="{{ asset('' . $page->featured_image) }}" class="w-full h-full object-cover" alt="{{ $page->title }}">
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- CONTEÚDO PRINCIPAL E SIDEBAR -->
    <div class="max-w-7xl mx-auto px-4 -mt-8 relative z-20 pb-20">
        <div class="grid grid-cols-12 gap-8">
            
            <!-- Coluna do Texto (8 Colunas) -->
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl shadow-blue-900/5 border border-gray-100">
                    
                    <!-- Conteúdo do Editor Rico -->
                    <article class="prose prose-slate max-w-none 
                        prose-headings:text-rovumaBlue prose-headings:font-black prose-headings:uppercase 
                        prose-a:text-rovumaGold prose-a:font-bold hover:prose-a:text-rovumaBlue
                        prose-img:rounded-xl prose-img:shadow-lg
                        text-gray-700 leading-relaxed text-lg">
                        
                        {!! $page->content !!}

                    </article>

                    <!-- SEÇÃO DINÂMICA: Se a página for "Investigação" ou "Projectos" -->
                    @if(Str::contains(strtolower($page->slug), ['projecto', 'investigacao']))
                        <div class="mt-12 pt-12 border-t border-gray-100">
                            <h3 class="text-2xl font-black text-rovumaBlue uppercase mb-6 flex items-center gap-3">
                                <span class="w-2 h-8 bg-rovumaGold"></span>
                                Projetos de Investigação Recentes
                            </h3>
                            <livewire:latest-projects-list /> <!-- Um pequeno componente para listar projetos -->
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar (4 Colunas) -->
            <aside class="col-span-12 lg:col-span-4 space-y-8">
                
                <!-- Widget: Links Relacionados -->
                <div class="bg-rovumaBlue text-white p-8 rounded-2xl shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-rovumaGold rotate-45 translate-x-10 -translate-y-10"></div>
                    <h4 class="text-xl font-black uppercase mb-6 relative z-10">Recursos Úteis</h4>
                    <ul class="space-y-4 relative z-10">
                        <li>
                            <a href="/repositorio" class="flex items-center gap-3 group">
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-rovumaGold transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.246 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="font-bold group-hover:text-rovumaGold transition text-sm uppercase">Repositório Científico</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin" class="flex items-center gap-3 group">
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center group-hover:bg-rovumaGold transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 2 0 01.707.293l5.414 5.414a1 2 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="font-bold group-hover:text-rovumaGold transition text-sm uppercase">Submeter Artigo</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Widget: Últimas Notícias -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h4 class="text-lg font-black text-rovumaBlue uppercase mb-6 border-b-2 border-rovumaGold pb-2">Agenda Científica</h4>
                    <div class="space-y-6">
                        @foreach(\App\Models\Post::where('type', 'event')->latest()->take(3)->get() as $event)
                        <a href="/noticia/{{ $event->slug }}" class="flex gap-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg flex flex-col items-center justify-center border-b-4 border-rovumaGold group-hover:bg-rovumaBlue group-hover:text-white transition">
                                <span class="text-[10px] font-bold uppercase leading-none">{{ $event->event_start_date?->format('M') }}</span>
                                <span class="text-lg font-black leading-none">{{ $event->event_start_date?->format('d') }}</span>
                            </div>
                            <div>
                                <h5 class="text-sm font-bold text-rovumaBlue line-clamp-2 group-hover:text-rovumaGold transition">{{ $event->title }}</h5>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>