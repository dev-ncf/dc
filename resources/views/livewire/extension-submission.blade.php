<div>
    <div>
        <div class="max-w-5xl mx-auto px-4 py-16">
            <div class="mb-12 text-center md:text-left">
                <h1 class="text-4xl font-black text-rovumaBlue uppercase tracking-tighter">Submeter Projeto de Extensão
                </h1>
                <p class="text-rovumaGold font-bold mt-2">Promova impacto e transformação direta nas comunidades.</p>
            </div>

            <form wire:submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-100 space-y-6">
                        <h2
                            class="text-xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">
                            Informações do Projeto</h2>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Título do Projeto *</label>
                            <input type="text" wire:model="title"
                                placeholder="Ex: Capacitação digital para jovens agricultores" class="rovuma-input">
                            @error('title')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Parceiro Comunitário *</label>
                                <input type="text" wire:model="community_partner"
                                    placeholder="Ex: Associação Comunitária X" class="rovuma-input">
                                @error('community_partner')
                                    <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Público-Alvo</label>
                                <input type="text" wire:model="target_beneficiaries"
                                    placeholder="Ex: 40 Mulheres empreendedoras" class="rovuma-input">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Resumo / Objetivos *</label>
                            <textarea wire:model="abstract" rows="4" placeholder="Descreva o propósito da extensão..." class="rovuma-input"></textarea>
                            @error('abstract')
                                <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Impacto Social Esperado</label>
                            <textarea wire:model="expected_impact" rows="3" placeholder="Que mudanças pretende gerar na comunidade?"
                                class="rovuma-input"></textarea>
                        </div>

                        <!-- Upload PDF -->
                        <div
                            class="p-8 border-4 border-dashed border-gray-100 rounded-3xl text-center hover:border-rovumaGold transition group relative">
                            <input type="file" wire:model="project_file"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="text-gray-400 group-hover:text-rovumaGold">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <p class="mt-2 font-black text-sm uppercase">Anexar Proposta de Extensão (PDF) *</p>
                            </div>
                            @if ($project_file)
                                <div class="mt-4 text-rovumaBlue font-bold text-xs">
                                    {{ $project_file->getClientOriginalName() }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- SIDEBAR -->
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-[2.5rem] shadow-lg border border-gray-100 space-y-6">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Área Temática *</label>
                            <select wire:model="knowledge_area_id" class="rovuma-input">
                                <option value="">Selecione...</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Início</label>
                                <input type="date" wire:model="start_date" class="rovuma-input text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Fim</label>
                                <input type="date" wire:model="end_date" class="rovuma-input text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Orçamento (MZN)</label>
                            <input type="number" wire:model="requested_budget" placeholder="0.00" class="rovuma-input">
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-rovumaBlue text-white py-6 rounded-2xl font-black uppercase tracking-widest hover:bg-rovumaGold transition shadow-xl flex items-center justify-center gap-3">
                            <span wire:loading.remove>Submeter Proposta</span>
                            <span wire:loading>A Enviar...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
