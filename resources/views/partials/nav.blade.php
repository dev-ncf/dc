<!-- ESTILO ESPECÍFICO PARA O MEGA MENU (Pode ficar aqui ou no Head) -->
<style>
    [x-cloak] { display: none !important; }
    
    /* Mega Menu com Efeito de Vidro (Blur) */
    .mega-menu-container {
        position: absolute;
        top: 100%; 
        left: 50%; 
        transform: translateX(-50%); 
        width: 100vw;   
        
        /* 
           1. Background branco com 80% de opacidade 
           2. backdrop-filter aplica o blur no que está atrás 
        */
        background-color: rgba(255, 255, 255, 0.21); 
        backdrop-filter: blur(12px); 
        -webkit-backdrop-filter: blur(12px); /* Suporte para Safari */
        
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        border-bottom: 2px solid #f39c12; /* Linha de destaque na base */
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15); 
        z-index: 100;
    }

    /* Animação suave */
    .nav-link-effect {
        position: relative;
    }
    .nav-link-effect::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: #f39c12; /* rovuma-secondary */
        transition: width 0.3s ease;
    }
    .nav-link-effect:hover::after {
        width: 100%;
    }
</style>

<!-- 1. TOP BAR -->
<header class="bg-white border-b border-slate-100 py-2 px-4 relative z-[60]">
    <div class="max-w-7xl mx-auto flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
        <div class="flex gap-6 italic">
            <span class="flex items-center gap-1">
                <i data-lucide="map-pin" class="w-3 h-3 text-rovuma-secondary"></i> Nampula, Moçambique
            </span>
            <span class="hidden sm:flex items-center gap-1">
                <i data-lucide="mail" class="w-3 h-3 text-rovuma-secondary"></i> info@unirovuma.ac.mz
            </span>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('maintenance') }}" class="hover:text-rovuma-primary transition">Estudantes</a>
            <a href="{{ route('maintenance') }}" class="hover:text-rovuma-primary transition border-l border-slate-200 pl-4">Funcionários</a>
            <a href="/admin" class="bg-rovuma-primary text-white px-4 py-1 rounded-full flex items-center gap-1 ml-4 font-black hover:bg-rovuma-secondary transition-all">
                <i data-lucide="user" class="w-3 h-3"></i> SIGEUR
            </a>
        </div>
    </div>
</header>

<!-- 2. NAVEGAÇÃO PRINCIPAL -->
<nav class="bg-white sticky top-0 z-50 border-b border-slate-100 shadow-sm" x-data="{ selected: null }">
    <div class="max-w-7xl mx-auto px-4 h-24 flex justify-between items-center relative">
        
        <!-- Logo UniRovuma -->
        <a href="/" class="flex items-center gap-3 flex-shrink-0 group">
            <img src="{{ asset('images/logo-rovuma.png') }}" alt="Logo UniRovuma" class="w-14">
            <div class="leading-none border-l-4 border-rovuma-primary pl-3 group-hover:border-rovuma-secondary transition-colors">
                <span class="block text-rovuma-primary font-black text-2xl tracking-tighter uppercase leading-none">Universidade</span>
                <span class="block text-rovuma-secondary font-bold text-lg italic uppercase leading-none">Rovuma</span>
            </div>
        </a>

        <!-- Links Desktop -->
        <div class="hidden lg:flex items-center h-full font-black text-slate-600 uppercase text-[11px] tracking-wider">
            
            <a href="/" class="px-5 nav-link-effect hover:text-rovuma-primary transition-all">Início</a>

            <!-- MENU 1: A UNIVERSIDADE -->
            <div class="h-full flex items-center" @mouseenter="selected = 1" @mouseleave="selected = null">
                <button :class="selected === 1 ? 'text-rovuma-primary' : ''" class="px-5 hover:text-rovuma-primary transition-all flex items-center gap-1 h-full">
                    A Universidade <i data-lucide="chevron-down" class="w-3 h-3 transition-transform" :class="selected === 1 ? 'rotate-180' : ''"></i>
                </button>
                
                <div x-show="selected === 1" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="mega-menu-container">
                    <div class="max-w-7xl mx-auto p-10 grid grid-cols-4 gap-6 text-left">
                        
                        <!-- LISTA: Instituição -->
                        <div class="bg-white/95 p-6 rounded-2xl shadow-sm border border-slate-100">
                            <h4 class="text-rovuma-secondary mb-4 border-b border-slate-50 pb-2 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">Instituição</h4>
                            <ul class="space-y-3 lowercase first-letter:uppercase font-semibold text-slate-700">
                                <li><a href="{{ route('maintenance') }}" class="hover:text-rovuma-primary flex items-center gap-2 group text-sm transition-all hover:pl-1">Missão e Visão</a></li>
                                <li><a href="{{ route('maintenance') }}" class="hover:text-rovuma-primary flex items-center gap-2 group text-sm transition-all hover:pl-1">História</a></li>
                                <li><a href="{{ route('maintenance') }}" class="hover:text-rovuma-primary flex items-center gap-2 group text-sm transition-all hover:pl-1">Calendário Académico</a></li>
                            </ul>
                        </div>

                        <!-- LISTA: Governação -->
                        <div class="bg-white/95 p-6 rounded-2xl shadow-sm border border-slate-100">
                            <h4 class="text-rovuma-secondary mb-4 border-b border-slate-50 pb-2 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">Governação</h4>
                            <ul class="space-y-3 lowercase first-letter:uppercase font-semibold text-slate-700">
                                @isset($units['Reitoria'])
                                    @foreach($units['Reitoria'] as $unit)
                                        <li><a href="{{ route('organic.unit', $unit->slug) }}" class="hover:text-rovuma-primary flex items-center gap-2 group text-sm transition-all hover:pl-1">{{ $unit->name }}</a></li>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>

                        <!-- LISTA: Apoio Técnico -->
                        <div class="bg-white/95 p-6 rounded-2xl shadow-sm border border-slate-100">
                            <h4 class="text-rovuma-secondary mb-4 border-b border-slate-50 pb-2 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">Apoio Técnico</h4>
                            <ul class="space-y-2 text-[10px] font-bold text-slate-500 uppercase">
                                @isset($units['Gabinete'])
                                    @foreach($units['Gabinete'] as $unit)
                                        <li><a href="{{ route('organic.unit', $unit->slug) }}" class="hover:text-rovuma-primary hover:pl-1 transition-all flex items-center gap-2"><div class="w-1 h-1 bg-slate-300 rounded-full"></div> {{ $unit->name }}</a></li>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>

                        <!-- ESPECIAL: CTA Qualidade -->
                        <div class="bg-rovuma-primary p-8 rounded-3xl text-center flex flex-col justify-center shadow-xl relative overflow-hidden group">
                            <i data-lucide="award" class="w-12 h-12 mx-auto text-rovuma-secondary mb-4 relative z-10"></i>
                            <h5 class="text-white font-black text-sm uppercase relative z-10 tracking-tighter">Qualidade UniRovuma</h5>
                            <p class="text-white/60 text-[9px] font-bold mt-2 uppercase relative z-10">Rigor e Inovação</p>
                            <div class="absolute inset-0 bg-rovuma-secondary opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MENU 2: ENSINO-APRENDIZAGEM -->
            <div class="h-full flex items-center" @mouseenter="selected = 2" @mouseleave="selected = null">
                <button :class="selected === 2 ? 'text-rovuma-primary' : ''" class="px-5 hover:text-rovuma-primary transition-all flex items-center gap-1 h-full font-black">
                    Ensino <i data-lucide="chevron-down" class="w-3 h-3 transition-transform" :class="selected === 2 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="selected === 2" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="mega-menu-container">
                    <div class="max-w-7xl mx-auto p-10 grid grid-cols-3 gap-8 text-left">
                        <!-- LISTA: Grid de Faculdades -->
                        <div class="col-span-2 bg-white/95 p-8 rounded-3xl shadow-sm border border-slate-100">
                            <h4 class="text-rovuma-secondary mb-6 border-b border-slate-100 pb-2 uppercase text-[10px] font-black tracking-widest text-center">Unidades Académicas (Faculdades)</h4>
                            <div class="grid grid-cols-2 gap-x-8 gap-y-2">
                                @isset($units['Faculdade'])
                                    @foreach($units['Faculdade'] as $unit)
                                        <a href="{{ route('organic.unit', $unit->slug) }}" class="flex items-center justify-between group py-2 px-3 rounded-lg hover:bg-slate-50 transition-all border-b border-slate-50">
                                            <span class="text-slate-700 group-hover:text-rovuma-primary font-bold text-[10px]">{{ $unit->name }}</span>
                                            <i data-lucide="chevron-right" class="w-3 h-3 opacity-0 group-hover:opacity-100 text-rovuma-secondary transition-all"></i>
                                        </a>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                        
                        <!-- ESPECIAL: Admissão (Mantendo seu estilo visual) -->
                            {{-- <div class="space-y-4">
                                <h4 class="text-rovuma-secondary mb-4 uppercase text-[10px] font-black tracking-widest pl-2">Admissão</h4>
                                <a href="{{ route('maintenance') }}" class="flex items-center gap-3 bg-rovuma-primary text-white p-5 rounded-2xl hover:bg-rovuma-secondary transition-all group">
                                    <i data-lucide="graduation-cap" class="w-6 h-6"></i> 
                                    <div class="flex flex-col"><span class="text-[9px] opacity-70">Cursos de</span><span class="font-black text-xs uppercase">Licenciaturas</span></div>
                                </a>
                                <a href="{{ route('maintenance') }}" class="flex items-center gap-3 bg-slate-100 text-rovuma-primary p-5 rounded-2xl hover:bg-slate-200 transition-all group">
                                    <i data-lucide="book-open" class="w-6 h-6"></i> 
                                    <div class="flex flex-col"><span class="text-[9px] opacity-60">Programas de</span><span class="font-black text-xs uppercase">Pós-Graduação</span></div>
                                </a>
                            </div> --}}
                    </div>
                </div>
            </div>

            <!-- MENU 3: PESQUISA -->
            <div class="h-full flex items-center" @mouseenter="selected = 3" @mouseleave="selected = null">
                <button :class="selected === 3 ? 'text-rovuma-primary' : ''" class="px-5 hover:text-rovuma-primary transition-all flex items-center gap-1 h-full font-black">
                    Pesquisa <i data-lucide="chevron-down" class="w-3 h-3 transition-transform" :class="selected === 3 ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="selected === 3" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="mega-menu-container">
                    <div class="max-w-7xl mx-auto p-10 grid grid-cols-4 gap-6 text-left">
                        <!-- LISTA: Científico -->
                        <div class="bg-white/95 p-6 rounded-2xl shadow-sm border border-slate-100">
                            <h4 class="text-rovuma-secondary mb-4 border-b border-slate-100 pb-2 text-[10px] font-black uppercase tracking-widest">Científico</h4>
                            <ul class="space-y-3 font-bold text-slate-700 text-[10px] uppercase">
                                <li><a href="{{ route('maintenance') }}" class="hover:text-rovuma-primary flex items-center gap-2 transition-all hover:pl-1">Comité de Ética</a></li>
                                <li><a href="{{ route('maintenance') }}" class="hover:text-rovuma-primary flex items-center gap-2 transition-all hover:pl-1">Linhas de Pesquisa</a></li>
                            </ul>
                        </div>
                        
                        <!-- LISTA: Centros -->
                        <div class="bg-white/95 p-6 rounded-2xl shadow-sm border border-slate-100">
                            <h4 class="text-rovuma-secondary mb-4 border-b border-slate-100 pb-2 text-[10px] font-black uppercase tracking-widest">Centros</h4>
                            <ul class="space-y-3 font-bold text-slate-500 text-[10px] uppercase">
                                @isset($units['Centro'])
                                    @foreach($units['Centro'] as $unit)
                                        <li><a href="{{ route('organic.unit', $unit->slug) }}" class="hover:text-rovuma-primary transition-all hover:pl-1 flex items-center gap-2"><div class="w-1 h-1 bg-rovuma-secondary rounded-full"></div> {{ $unit->name }}</a></li>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>

                        <!-- ESPECIAL: Repositório (Mantendo seu estilo visual) -->
                        <div class="col-span-2 bg-rovuma-primary p-8 rounded-3xl relative overflow-hidden text-white group shadow-2xl">
                            <div class="relative z-10">
                                <h3 class="text-2xl font-black uppercase tracking-tighter">Repositório Digital</h3>
                                <p class="text-xs text-white/60 mt-2 mb-6 max-w-xs leading-relaxed">Aceda à produção científica, teses e artigos da nossa universidade.</p>
                                <a href="{{ route('maintenance') }}" class="bg-rovuma-secondary text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-rovuma-primary transition-all">Aceder à Base de Dados</a>
                            </div>
                            <i data-lucide="database" class="absolute -right-4 -bottom-4 w-32 h-32 text-white/5"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LINKS FINAIS -->
            <a href="{{ route('maintenance') }}" class="px-5 nav-link-effect hover:text-rovuma-primary transition-all">Bibliotecas</a>
            
            <!-- BOTÃO PESQUISA -->
            <button class="ml-6 w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-rovuma-primary hover:bg-rovuma-primary hover:text-white transition-all shadow-inner">
                <i data-lucide="search" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="lg:hidden p-2 text-rovuma-primary">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>
</nav>