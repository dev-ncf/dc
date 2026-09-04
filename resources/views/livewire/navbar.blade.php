<div class="sticky top-0 z-50 w-full" 
     x-data="{ scrolled: false, mobileMenu: false }" 
     x-init="window.pageYOffset > 10 ? scrolled = true : scrolled = false"
     @scroll.window="window.pageYOffset > 10 ? scrolled = true : scrolled = false">
    
    <nav :class="{ 'shadow-xl': scrolled, 'shadow-sm': !scrolled }" 
         class="bg-white border-b border-gray-100 transition-all duration-300">
        
        <!-- Topo Azul Fino (Marca UniRovuma) -->
        <div class="bg-rovumaBlue h-1.5 w-full"></div>

        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                
                <!-- 1. LOGO E IDENTIDADE -->
                <a href="/" class="flex items-center gap-3 shrink-0 group">
                    <img src="{{ asset('images/logo-rovuma.png') }}" alt="UniRovuma" class="h-12 md:h-14 w-auto transition-transform group-hover:scale-105">
                    <div class="flex flex-col border-l-2 border-gray-100 pl-3">
                        <span class="text-rovumaBlue font-black text-base md:text-lg leading-none uppercase tracking-tighter italic">UniRovuma</span>
                        <span class="text-rovumaGold font-bold text-[9px] uppercase tracking-[0.2em] mt-0.5">Direção Científica</span>
                    </div>
                </a>

                <!-- 2. MENU DESKTOP -->
                <div class="hidden lg:flex items-center space-x-1">
                    @foreach($navigation as $item)
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <a href="{{ url($item->url) }}" 
                               class="px-2 py-1 text-rovumaBlue font-semibold text-[11px] xl:text-xs uppercase hover:text-rovumaGold transition flex items-center gap-0.5 tracking-tighter {{ request()->is(ltrim($item->url, '/')) ? 'text-rovumaGold' : '' }}">
                                {{ $item->label }}
                                @if($item->children->count() > 0)
                                    <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                @endif
                            </a>

                            <!-- Dropdown Desktop -->
                            @if($item->children->count() > 0)
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-cloak
                                     class="absolute left-0 w-60 bg-rovumaBlue rounded-b-xl shadow-2xl py-2 z-50 border-t-2 border-rovumaGold mt-0">
                                    @foreach($item->children as $child)
                                        <a href="{{ url($child->url) }}" class="block px-6 py-2 text-white text-[10px] font-bold hover:bg-rovumaGold transition border-b border-white/5 last:border-0 uppercase tracking-wide">
                                            {{ $child->label }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                    
                    <!-- Botão de Ação -->
                    <a href="/admin/login" class="ml-4 bg-rovumaGold text-white px-5 py-2 rounded-full text-[10px] font-black hover:bg-rovumaBlue transition shadow-md uppercase tracking-wider shrink-0">
                        Portal do Investigador
                    </a>
                </div>

                <!-- 3. BOTÃO MOBILE (Hambúrguer) -->
                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="text-rovumaBlue p-2 focus:outline-none">
                        <svg x-show="!mobileMenu" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-show="mobileMenu" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- 4. MENU MOBILE -->
        <div x-show="mobileMenu" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             @click.away="mobileMenu = false"
             x-cloak
             class="lg:hidden bg-white border-t border-gray-100 shadow-2xl overflow-y-auto max-h-[85vh]">
            
            <div class="px-6 py-8 space-y-4">
                @foreach($navigation as $item)
                    <div x-data="{ subOpen: false }">
                        <div class="flex justify-between items-center py-2">
                            <a href="{{ url($item->url) }}" class="text-rovumaBlue font-black uppercase text-sm tracking-tight">{{ $item->label }}</a>
                            @if($item->children->count() > 0)
                                <button @click="subOpen = !subOpen" class="p-2 bg-gray-50 rounded-lg text-rovumaGold">
                                    <svg :class="{'rotate-180': subOpen}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            @endif
                        </div>

                        @if($item->children->count() > 0)
                            <div x-show="subOpen" x-collapse class="mt-2 ml-4 space-y-1 border-l-2 border-rovumaGold/30 pl-4">
                                @foreach($item->children as $child)
                                    <a href="{{ url($child->url) }}" class="block py-2 text-gray-600 text-xs font-bold uppercase tracking-tighter">
                                        {{ $child->label }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="pt-8 border-t border-gray-100">
                    <a href="/admin/login" class="block w-full text-center bg-rovumaBlue text-white py-4 rounded-xl font-black uppercase tracking-widest shadow-lg active:scale-95 transition">
                        Portal do Investigador
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>