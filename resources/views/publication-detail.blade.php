<x-layouts.app>
    <x-slot:title>{{ $publication->title }}</x-slot:title>

    <!-- HEADER / HERO DA PUBLICAÇÃO -->
    <section class="bg-white border-b border-gray-100 py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                <div class="max-w-4xl">
                    <!-- Tipo de Documento Badge -->
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-rovumaGold/10 text-rovumaGold uppercase tracking-widest mb-6">
                        {{ $publication->documentType->name }}
                    </span>
                    
                    <h1 class="text-3xl md:text-5xl font-black text-rovumaBlue leading-tight tracking-tighter uppercase">
                        {{ $publication->title }}
                    </h1>

                    <div class="mt-8 flex flex-wrap items-center gap-6 text-sm font-bold text-gray-400 uppercase tracking-tight">
                        <div class="flex items-center gap-2">
                            <span class="text-rovumaBlue">Autor:</span>
                            <span class="text-gray-600">{{ $publication->author_name }}</span>
                        </div>
                        @if($publication->advisor_name)
                        <div class="flex items-center gap-2 border-l border-gray-200 pl-6">
                            <span class="text-rovumaBlue">Orientador:</span>
                            <span class="text-gray-600">{{ $publication->advisor_name }}</span>
                        </div>
                        @endif
                        <div class="flex items-center gap-2 border-l border-gray-200 pl-6">
                            <span class="text-rovumaBlue">Ano:</span>
                            <span class="text-gray-600">{{ $publication->publication_year }}</span>
                        </div>
                    </div>
                </div>

                <!-- Botão de Download Principal -->
                <div class="shrink-0 w-full md:w-auto">
                    @if($publication->visibility === 'public')
                    <a href="{{ asset('' . $publication->file_path) }}" target="_blank" 
                       class="flex items-center justify-center gap-3 bg-rovumaBlue text-white px-8 py-5 rounded-2xl font-black text-sm hover:bg-rovumaGold hover:-translate-y-1 transition shadow-2xl shadow-blue-900/30 w-full md:w-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        DOWNLOAD PDF COMPLETO
                    </a>
                    @else
                    <div class="bg-gray-100 text-gray-400 px-8 py-5 rounded-2xl font-black text-xs text-center border-2 border-dashed border-gray-200 uppercase">
                        🔒 Acesso Restrito ao Arquivo
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- CONTEÚDO TÉCNICO -->
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-12 gap-12">
            
            <!-- Coluna Principal (8 Colunas) -->
            <div class="col-span-12 lg:col-span-8 space-y-12">
                
                <!-- Resumo / Abstract -->
                <div>
                    <h3 class="text-xl font-black text-rovumaBlue uppercase mb-6 flex items-center gap-3">
                        <span class="w-2 h-6 bg-rovumaGold rounded-full"></span>
                        Resumo / Abstract
                    </h3>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed italic border-l-4 border-gray-50 pl-8">
                        {{ $publication->abstract }}
                    </div>
                </div>

                <!-- Tabela de Metadados (O Coração da Página) -->
                <div>
                    <h3 class="text-xl font-black text-rovumaBlue uppercase mb-6 flex items-center gap-3">
                        <span class="w-2 h-6 bg-rovumaGold rounded-full"></span>
                        Informação Técnica (Metadados)
                    </h3>
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                        <table class="w-full">
                            <tbody class="divide-y divide-gray-50">
                                <tr class="group">
                                    <td class="px-6 py-4 font-black text-rovumaBlue bg-gray-50/50 w-48 uppercase text-[10px] tracking-widest">Instituição</td>
                                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $publication->issuing_institution }}</td>
                                </tr>
                                <tr class="group">
                                    <td class="px-6 py-4 font-black text-rovumaBlue bg-gray-50/50 uppercase text-[10px] tracking-widest">Unidade Orgânica</td>
                                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $publication->organicUnit->name ?? 'Não aplicável' }}</td>
                                </tr>
                                <tr class="group">
                                    <td class="px-6 py-4 font-black text-rovumaBlue bg-gray-50/50 uppercase text-[10px] tracking-widest">Curso / Programa</td>
                                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $publication->course->name ?? 'Geral' }}</td>
                                </tr>
                                <tr class="group">
                                    <td class="px-6 py-4 font-black text-rovumaBlue bg-gray-50/50 uppercase text-[10px] tracking-widest">Área Científica</td>
                                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $publication->knowledgeArea->name }}</td>
                                </tr>
                                <tr class="group">
                                    <td class="px-6 py-4 font-black text-rovumaBlue bg-gray-50/50 uppercase text-[10px] tracking-widest">Palavras-chave</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($publication->keywords as $kw)
                                                <span class="bg-blue-50 text-rovumaBlue px-2 py-1 rounded text-xs font-bold">{{ $kw }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr class="group">
                                    <td class="px-6 py-4 font-black text-rovumaBlue bg-gray-50/50 uppercase text-[10px] tracking-widest">Idioma</td>
                                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $publication->language }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Citação Automática (Fundamental para Academia) -->
                <div class="bg-rovumaBlue rounded-3xl p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                    <h3 class="text-lg font-black uppercase mb-4 tracking-wider">Como citar este trabalho (Normas APA)</h3>
                    <div class="bg-white/10 p-6 rounded-xl border border-white/10 font-mono text-sm leading-relaxed">
                        {{ $publication->author_name }} ({{ $publication->publication_year }}). 
                        <span class="italic">{{ $publication->title }}</span>. 
                        {{ $publication->issuing_institution }}. 
                        Disponível em: {{ url()->current() }}
                    </div>
                </div>

            </div>

            <!-- Sidebar Lateral (4 Colunas) -->
            <aside class="col-span-12 lg:col-span-4 space-y-8">
                
                <!-- Estatísticas Simples -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest mb-6">Métricas do Documento</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-2xl">
                            <span class="block text-2xl font-black text-rovumaBlue">0</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase">Visualizações</span>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-2xl">
                            <span class="block text-2xl font-black text-rovumaBlue">0</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase">Downloads</span>
                        </div>
                    </div>
                </div>

                <!-- Documentos Relacionados -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="font-black text-rovumaBlue uppercase text-xs tracking-widest mb-6">Trabalhos Relacionados</h4>
                    <div class="space-y-6">
                        @php
                            $related = \App\Models\Publication::where('knowledge_area_id', $publication->knowledge_area_id)
                                ->where('id', '!=', $publication->id)
                                ->take(3)->get();
                        @endphp
                        
                        @forelse($related as $rel)
                        <a href="/repositorio/{{ $rel->slug }}" class="group block">
                            <h5 class="text-sm font-bold text-rovumaBlue group-hover:text-rovumaGold transition line-clamp-2 uppercase">{{ $rel->title }}</h5>
                            <span class="text-[10px] font-bold text-gray-400">{{ $rel->publication_year }} | {{ $rel->author_name }}</span>
                        </a>
                        @empty
                        <p class="text-xs text-gray-400 italic">Sem recomendações para esta área.</p>
                        @endforelse
                    </div>
                </div>

            </aside>
        </div>
    </section>
</x-layouts.app>