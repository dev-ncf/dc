@props(['item', 'isChild' => false])

<div class="relative group/parent" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    <a href="{{ url($item->url) }}" 
       class="{{ $isChild 
            ? 'w-full px-4 py-2.5 text-white/90 hover:text-white hover:bg-rovumaGold/20 text-[11px] font-medium flex items-center justify-between border-b border-white/5 last:border-0' 
            : 'px-3 py-2 text-rovumaBlue font-semibold text-[11px] xl:text-xs uppercase hover:text-rovumaGold transition flex items-center gap-1 tracking-tight ' . (request()->is(ltrim($item->url, '/')) ? 'text-rovumaGold' : '') }}">
       
        <span>{{ $item->label }}</span>

        @if($item->children->count() > 0)
            @if($isChild)
                <!-- Seta para a direita nos sub-submenus -->
                <svg class="w-3 h-3 text-rovumaGold transition-transform duration-200" :class="{'rotate-90': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            @else
                <!-- Seta para baixo no menu principal -->
                <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            @endif
        @endif
    </a>

    <!-- Dropdown / Sub-menu com design refinado -->
    @if($item->children->count() > 0)
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             x-cloak
             class="absolute {{ $isChild ? 'left-full top-0 ml-1' : 'left-0 top-full' }} w-64 bg-rovumaBlue/95 backdrop-blur-md rounded-xl shadow-2xl py-2 z-50 border border-white/10 ring-1 ring-black/5">
            
            @foreach($item->children as $child)
                @if($child->children->count() > 0)
                    <!-- Sub-menu recursivo -->
                    <x-nav-item :item="$child" :isChild="true" />
                @else
                    <!-- Link normal do submenu -->
                    <a href="{{ url($child->url) }}" 
                       class="block px-4 py-2.5 text-white/90 hover:text-white hover:bg-rovumaGold text-[11px] font-semibold transition-all duration-150 border-b border-white/5 last:border-0 uppercase tracking-wide">
                        {{ $child->label }}
                    </a>
                @endif
            @endforeach
        </div>
    @endif
</div>