<x-layouts.app>
    <x-slot:title>Historial da Instituição</x-slot:title>

    <div class="max-w-4xl mx-auto px-4 py-20">
        <header class="mb-16 text-center">
            <span class="text-rovumaGold font-black uppercase tracking-widest text-xs">Desde a fundação</span>
            <h1 class="text-5xl font-black text-rovumaBlue mt-4 uppercase tracking-tighter">{{ $history->title }}</h1>
            <div class="h-1.5 w-24 bg-rovumaGold mx-auto mt-6 rounded-full"></div>
        </header>

        <div class="bg-white p-8 md:p-16 rounded-[4rem] shadow-2xl shadow-blue-900/10 border border-gray-100">
            <article class="prose prose-blue prose-xl max-w-none text-gray-700 leading-loose italic">
                {!! $history->content !!}
            </article>
        </div>
        
        <div class="mt-12 text-center">
            <a href="/" class="text-rovumaBlue font-bold hover:text-rovumaGold transition uppercase text-xs tracking-widest">&larr; Voltar para o portal</a>
        </div>
    </div>
</x-layouts.app>