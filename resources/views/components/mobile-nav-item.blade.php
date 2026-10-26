@props(['item', 'depth' => 0])

@php
    // Define cores e recuos progressivos para cada nível no mobile
    $indents = ['ml-0', 'ml-3 border-l-2 border-rovumaGold/30 pl-3', 'ml-3 border-l-2 border-white/10 pl-3'];
    $currentIndent = $indents[$depth] ?? 'ml-3 border-l-2 border-white/10 pl-3';
    
    $textSizes = ['text-sm font-black', 'text-xs font-bold', 'text-[11px] font-semibold'];
    $currentTextSize = $textSizes[$depth] ?? 'text-[11px] font-normal';
@endphp

<div x-data="{ subOpen: false }" class="space-y-1">
    <div class="flex justify-between items-center py-2 px-3 rounded-lg transition-colors {{ $depth === 0 ? 'bg-gray-50/80 hover:bg-gray-100' : 'hover:bg-gray-50' }}">
        <a href="{{ url($item->url) }}" class="text-rovumaBlue uppercase tracking-tight {{ $currentTextSize }}">
            {{ $item->label }}
        </a>
        
        @if($item->children->count() > 0)
            <button @click="subOpen = !subOpen" class="p-1.5 bg-white shadow-sm border border-gray-100 rounded-md text-rovumaGold focus:outline-none transition-transform">
                <svg :class="{'rotate-180': subOpen}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
        @endif
    </div>

    @if($item->children->count() > 0)
        <div x-show="subOpen" x-collapse class="mt-1 space-y-1 {{ $currentIndent }}">
            @foreach($item->children as $child)
                @if($child->children->count() > 0)
                    <x-mobile-nav-item :item="$child" :depth="$depth + 1" />
                @else
                    <a href="{{ url($child->url) }}" class="block py-2 px-3 text-gray-600 hover:text-rovumaBlue hover:bg-gray-50 rounded-md text-xs font-bold uppercase tracking-tighter transition">
                        {{ $child->label }}
                    </a>
                @endif
            @endforeach
        </div>
    @endif
</div>