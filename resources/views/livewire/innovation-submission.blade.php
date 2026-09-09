<div>
   <div>
    <div class="max-w-5xl mx-auto px-4 py-16">
        <div class="mb-12 text-center md:text-left">
            <span class="bg-rovumaGold text-white px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.3em] inline-block mb-3">Empreendedorismo & Patentes</span>
            <h1 class="text-4xl font-black text-rovumaBlue uppercase tracking-tighter">Submeter Inovação ou Startup</h1>
            <p class="text-rovumaGold font-bold mt-2">Transforme a sua investigação científica num produto ou solução comercializável.</p>
        </div>

        <form wire:submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-100 space-y-6">
                    <h2 class="text-xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">Detalhes do Protótipo / Ideia</h2>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Título da Inovação / Produto *</label>
                        <input type="text" wire:model="title" placeholder="Ex: Biopesticida à base de plantas nativas" class="rovuma-input">
                        @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Categoria *</label>
                            <select wire:model="innovation_type" class="rovuma-input">
                                <option value="">Selecione...</option>
                                <option value="prototipo_tecnologico">Protótipo Tecnológico / Hardware</option>
                                <option value="produto_alimentar">Agroalimentar / Bioproduto</option>
                                <option value="software">Software / Aplicativo Digital</option>
                                <option value="patente">Registo de Patente</option>
                            </select>
                            @error('innovation_type') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Maturidade Tecnológica (TRL) *</label>
                            <select wire:model="trl_level" class="rovuma-input">
                                <option value="trl_1_3">TRL 1-3: Conceito / Pesquisa Básica</option>
                                <option value="trl_4_6">TRL 4-6: Protótipo / Teste Laboratorial</option>
                                <option value="trl_7_9">TRL 7-9: Pronto para Mercado</option>
                            </select>
                            @error('trl_level') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Resumo Técnico da Inovação *</label>
                        <textarea wire:model="abstract" rows="4" placeholder="Explique como a tecnologia funciona..." class="rovuma-input"></textarea>
                        @error('abstract') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Potencial de Mercado e Aplicabilidade *</label>
                        <textarea wire:model="market_potential" rows="3" placeholder="Qual o problema de mercado que resolve e quem são os clientes?" class="rovuma-input"></textarea>
                        @error('market_potential') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Upload PDF / Pitch Deck -->
                    <div class="p-8 border-4 border-dashed border-gray-100 rounded-3xl text-center hover:border-rovumaGold transition group relative">
                        <input type="file" wire:model="project_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-gray-400 group-hover:text-rovumaGold">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="mt-2 font-black text-sm uppercase">Anexar Pitch Deck / Documento Técnico (PDF) *</p>
                        </div>
                        @if ($project_file)
                            <div class="mt-4 text-rovumaBlue font-bold text-xs">{{ $project_file->getClientOriginalName() }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-[2.5rem] shadow-lg border border-gray-100 space-y-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Área Científica *</label>
                        <select wire:model="knowledge_area_id" class="rovuma-input">
                            <option value="">Selecione...</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                        @error('knowledge_area_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-rovumaBlue text-white py-6 rounded-2xl font-black uppercase tracking-widest hover:bg-rovumaGold transition shadow-xl flex items-center justify-center gap-3">
                        <span wire:loading.remove>Submeter Inovação</span>
                        <span wire:loading>A Enviar...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
