<div>

    <div class="max-w-5xl mx-auto px-4 py-16">
        <!-- CABEÇALHO -->
        <div class="mb-12 text-center md:text-left">
            <h1 class="text-4xl font-black text-rovumaBlue uppercase tracking-tighter">Submeter Proposta de Investigação
            </h1>
            <p class="text-rovumaGold font-bold mt-2">Contribua para o avanço científico da Universidade Rovuma.</p>
        </div>

        <form wire:submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- COLUNA PRINCIPAL (CAMPOS) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-100 space-y-6">

                    <h2
                        class="text-xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">
                        Detalhes do Projeto</h2>

                    <!-- Título -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Título do Projeto *</label>
                        <input type="text" wire:model="title"
                            placeholder="Ex: Estudo sobre o impacto das chuvas em Nampula"
                            class="rovuma-input @error('title') rovuma-input-error @enderror">
                        @error('title')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Resumo -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Resumo Executivo *</label>
                        <textarea wire:model="abstract" rows="4" placeholder="Descreva brevemente o objetivo do projeto..."
                            class="rovuma-input"></textarea>
                        @error('abstract')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
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
                            <p class="mt-2 font-black text-sm uppercase">Anexar Proposta Técnica (PDF) *</p>
                        </div>
                        @if ($project_file)
                            <div class="mt-4 text-rovumaBlue font-bold text-xs">
                                {{ $project_file->getClientOriginalName() }}</div>
                        @endif
                    </div>
                </div>

                <!-- IDENTIFICAÇÃO (SÓ PARA DESLOGADOS) -->
                @guest
                    <div class="bg-rovumaBlue p-8 rounded-[2.5rem] shadow-xl text-white space-y-6">
                        <h2 class="text-xl font-black uppercase border-b-2 border-rovumaGold inline-block pb-1">Sua
                            Identificação</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold opacity-80 uppercase mb-2">Seu Nome Completo *</label>
                                <input type="text" wire:model="external_name" placeholder="Nome"
                                    class="rovuma-input border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs font-bold opacity-80 uppercase mb-2">Seu Email *</label>
                                <input type="email" wire:model="external_email" placeholder="email@exemplo.com"
                                    class="rovuma-input border-transparent">
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- SIDEBAR (CONFIGURAÇÕES) -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-[2.5rem] shadow-lg border border-gray-100 space-y-6">

                    <!-- Unidade Orgânica -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Faculdade / Campus
                            *</label>
                        <select wire:model="organic_unit_id" class="rovuma-input">
                            <option value="">Selecione...</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->sigla }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Área -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Área Científica *</label>
                        <select wire:model="knowledge_area_id" class="rovuma-input">
                            <option value="">Selecione...</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Objetivo da Submissão -->
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase mb-2">Objetivo do Projeto
                            *</label>
                        <select wire:model="proposed_status" class="rovuma-input border-rovumaGold">
                            <option value="">Selecione o destino...</option>
                            <option value="portfolio">Entrar na Carteira (Banco de Ideias)</option>
                            <option value="searching_funds">Procura de Financiamento</option>
                        </select>
                    </div>

                    <!-- Orçamento -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Orçamento Estimado (MZN)</label>
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
