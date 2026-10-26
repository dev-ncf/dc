<x-layouts.app> <!-- Ou o layout principal do seu site -->
    <div class="min-h-screen bg-gray-50 pb-20">

        <!-- HEADER / HERO DO CURSO -->
        <div class="bg-rovumaBlue py-16 text-white relative overflow-hidden">
            <div class="absolute right-0 bottom-0 opacity-10 w-96 h-96 bg-rovumaGold rounded-full -mr-20 -mb-20"></div>
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span
                        class="bg-rovumaGold text-rovumaBlue text-[11px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
                        {{ $course->level }}
                    </span>
                    <span
                        class="bg-white/10 text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        {{ $course->organicUnit->name ?? 'Faculdade / Unidade' }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black uppercase tracking-tight max-w-4xl">
                    {{ $course->name }}
                </h1>
                <p class="text-rovumaGold font-bold text-sm mt-3 uppercase tracking-widest">
                    Direcção Científica — Universidade Rovuma
                </p>
            </div>
        </div>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="max-w-7xl mx-auto px-4 mt-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <!-- COLUNA DA ESQUERDA: Informações e Linhas de Pesquisa (8 Colunas) -->
                <div class="lg:col-span-8 space-y-10">

                    <!-- Sobre / Descrição Dinâmica do Banco de Dados -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-xl font-black text-rovumaBlue uppercase mb-4 flex items-center gap-3">
                            <span class="w-2 h-6 bg-rovumaGold rounded-full"></span>
                            Apresentação do Programa
                        </h3>
                      
                        <div class="text-gray-600 leading-relaxed text-base space-y-4 prose max-w-none">
                            {!! $course->description ?? '<p>Informação de apresentação em atualização.</p>' !!}
                        </div>
                    </div>

                    <!-- LINHAS DE PESQUISA E DOCENTES -->
                    <div class="space-y-6">
                        <h3 class="text-2xl font-black text-rovumaBlue uppercase flex items-center gap-3">
                            <span class="w-2 h-8 bg-rovumaGold rounded-full"></span>
                            Linhas de Pesquisa & Corpo Docente
                        </h3>

                        @forelse($course->researchLines as $line)
                            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
                                <!-- Título da Linha de Pesquisa -->
                                <div class="border-b border-gray-100 pb-4">
                                    <span class="text-[10px] font-black text-rovumaGold uppercase tracking-widest">Linha
                                        Temática</span>
                                    <h4 class="text-xl font-bold text-rovumaBlue mt-1">{{ $line->title }}</h4>
                                    @if ($line->description)
                                        <div class="text-xs text-gray-500 mt-2 prose max-w-none">
                                            {!! $line->description !!}
                                        </div>
                                    @endif
                                </div>

                                <!-- Lista de Docentes desta Linha -->
                                <div>
                                    <h5 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">
                                        Investigadores / Docentes Associados</h5>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @forelse($line->researchers as $docente)
                                            <div
                                                class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-rovumaGold/50 transition">
                                                <!-- Foto do Docente -->
                                                <div class="shrink-0">
                                                    @if ($docente->photo)
                                                        <img src="{{ asset('storage/' . $docente->photo) }}"
                                                            alt="{{ $docente->name }}"
                                                            class="w-14 h-14 rounded-full object-cover border-2 border-rovumaGold shadow-sm">
                                                    @else
                                                        <div
                                                            class="w-14 h-14 rounded-full bg-rovumaBlue text-white flex items-center justify-center font-black text-lg border-2 border-rovumaGold shadow-sm">
                                                            {{ substr($docente->name, 0, 2) }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Dados e Contactos -->
                                                <div class="overflow-hidden">
                                                    <h6 class="font-bold text-rovumaBlue text-sm truncate">
                                                        {{ $docente->name }}</h6>
                                                    <p class="text-[11px] text-rovumaGold font-semibold truncate">
                                                        {{ $docente->academic_title ?? 'Doutor / Mestre' }}</p>

                                                    <div class="mt-2 space-y-0.5">
                                                        @if ($docente->email)
                                                            <a href="mailto:{{ $docente->email }}"
                                                                class="text-[10px] text-gray-500 hover:text-rovumaBlue flex items-center gap-1 truncate">
                                                                <svg class="w-3 h-3 text-gray-400 shrink-0"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                </svg>
                                                                {{ $docente->email }}
                                                            </a>
                                                        @endif
                                                        @if ($docente->phone)
                                                            <span
                                                                class="text-[10px] text-gray-500 flex items-center gap-1">
                                                                <svg class="w-3 h-3 text-gray-400 shrink-0"
                                                                    fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                                </svg>
                                                                {{ $docente->phone }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-xs text-gray-400 italic col-span-full">Nenhum docente
                                                associado a esta linha de momento.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-12 rounded-3xl text-center border border-gray-100">
                                <p class="text-gray-400 font-bold">Linhas de pesquisa em atualização para este curso.
                                </p>
                            </div>
                        @endforelse
                    </div>

                </div>

                <!-- COLUNA DA DIREITA: Informações Dinâmicas (4 Colunas) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-28 space-y-6">
                        <h4 class="font-black text-rovumaBlue uppercase text-sm border-b border-gray-100 pb-4">Resumo do
                            Curso</h4>

                        <div class="space-y-4 text-xs">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-400 font-bold uppercase">Nível Académico:</span>
                                <span class="font-black text-rovumaBlue uppercase">{{ $course->level }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-400 font-bold uppercase">Unidade Orgânica:</span>
                                <span
                                    class="font-bold text-rovumaBlue text-right">{{ $course->organicUnit->sigla ?? 'UniRovuma' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-400 font-bold uppercase">Regime:</span>
                                <span
                                    class="font-bold text-rovumaBlue">{{ $course->regime ?? 'Laboral / Pós-Laboral' }}</span>
                            </div>
                            @if ($course->duration)
                                <div class="flex justify-between py-2 border-b border-gray-50">
                                    <span class="text-gray-400 font-bold uppercase">Duração:</span>
                                    <span class="font-bold text-rovumaBlue">{{ $course->duration }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-2">
                            <a href="javascript:history.back()"
                                class="block w-full text-center bg-rovumaBlue text-white py-3 rounded-xl font-black uppercase text-xs tracking-wider hover:bg-rovumaGold hover:text-rovumaBlue transition shadow-md">
                                &larr; Voltar à Oferta Académica
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
