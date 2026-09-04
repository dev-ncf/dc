<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- BARRA DE PROGRESSO (Simplificada) -->
    <div class="mb-10">
        <div class="flex justify-between items-center relative">
            @foreach(['Informação', 'Vínculo', 'Finalização'] as $index => $step)
                <div class="z-10 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center border-4 font-black {{ $currentStep >= ($index + 1) ? 'bg-rovumaBlue border-rovumaGold text-white' : 'bg-white border-gray-200 text-gray-300' }}">
                        {{ $index + 1 }}
                    </div>
                </div>
            @endforeach
            <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 -z-0">
                <div class="h-full bg-rovumaGold transition-all duration-500" style="width: {{ ($currentStep - 1) * 50 }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] p-6 md:p-10 border border-gray-100">
        
        <!-- PASSO 1: INFORMAÇÃO BÁSICA -->
        @if($currentStep == 1)
        <div class="space-y-6 animate-fade-in">
            <h2 class="text-2xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">1. Sobre o Trabalho</h2>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Título do Trabalho *</label>
                <input type="text" wire:model="title" placeholder="Digite o título completo da sua pesquisa..." 
                       class="rovuma-input @error('title') rovuma-input-error @enderror">
                @error('title') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Resumo Académico *</label>
                <textarea wire:model="abstract" rows="5" placeholder="Copie e cole aqui o resumo/abstract do seu documento..." 
                          class="rovuma-input @error('abstract') rovuma-input-error @enderror"></textarea>
                @error('abstract') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ano de Publicação *</label>
                    <input type="number" wire:model="publication_year" placeholder="Ex: 2024" class="rovuma-input">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Instituição</label>
                    <input type="text" wire:model="issuing_institution" placeholder="Universidade Rovuma" class="rovuma-input bg-gray-50">
                </div>
            </div>
        </div>
        @endif

        <!-- PASSO 2: CLASSIFICAÇÃO -->
        @if($currentStep == 2)
        <div class="space-y-6 animate-fade-in">
            <h2 class="text-2xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">2. Vínculo e Autoria</h2>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nome do Autor Principal *</label>
                <input type="text" wire:model="author_name" placeholder="Escreva o nome como deve aparecer na citação..." class="rovuma-input">
                @error('author_name') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-4 rounded-2xl border-2 border-blue-200">
                    <label class="block text-xs font-black text-rovumaBlue uppercase mb-2">Selecione a Faculdade *</label>
                    <select wire:model.live="organic_unit_id" class="rovuma-input border-blue-300">
                        <option value="">-- Escolha uma Unidade --</option>
                        @foreach($units as $unit) <option value="{{ $unit->id }}">{{ $unit->name }}</option> @endforeach
                    </select>
                </div>
                <div class="bg-orange-50 p-4 rounded-2xl border-2 {{ $organic_unit_id ? 'border-rovumaGold' : 'border-gray-200' }}">
                    <label class="block text-xs font-black {{ $organic_unit_id ? 'text-rovumaGold' : 'text-gray-400' }} uppercase mb-2">Selecione o Curso *</label>
                    <select wire:model="course_id" class="rovuma-input {{ !$organic_unit_id ? 'bg-gray-100' : '' }}" {{ !$organic_unit_id ? 'disabled' : '' }}>
                        <option value="">-- Primeiro escolha a faculdade --</option>
                        @foreach($courses as $course) <option value="{{ $course->id }}">{{ $course->name }}</option> @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tipo de Documento *</label>
                    <select wire:model="document_type_id" class="rovuma-input">
                        <option value="">-- Selecione o tipo (Ex: Monografia) --</option>
                        @foreach($types as $type) <option value="{{ $type->id }}">{{ $type->name }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Área Científica *</label>
                    <select wire:model="knowledge_area_id" class="rovuma-input">
                        <option value="">-- Selecione a área de estudo --</option>
                        @foreach($areas as $area) <option value="{{ $area->id }}">{{ $area->name }}</option> @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif

        <!-- PASSO 3: UPLOAD -->
        @if($currentStep == 3)
        <div class="space-y-6 animate-fade-in">
            <h2 class="text-2xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">3. Documento Final</h2>

            <div class="relative group">
                <input type="file" wire:model="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" id="file-upload">
                <div class="p-12 border-4 border-dashed border-gray-300 rounded-3xl text-center transition-all group-hover:border-rovumaGold group-hover:bg-orange-50/30">
                    <div class="bg-gray-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                        <svg class="w-10 h-10 text-gray-400 group-hover:text-rovumaGold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <p class="text-lg font-black text-gray-700">Clique para selecionar o PDF</p>
                    <p class="text-sm text-gray-400 mt-1">O arquivo deve ter no máximo 20MB</p>
                    
                    @if ($file)
                        <div class="mt-6 p-4 bg-rovumaBlue text-white rounded-2xl font-bold flex items-center justify-center gap-3">
                            <svg class="w-5 h-5 text-rovumaGold" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                            {{ $file->getClientOriginalName() }}
                        </div>
                    @endif
                </div>
                @error('file') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Palavras-chave</label>
                <input type="text" wire:model="keywords_string" placeholder="Informatica, Educação, Nampula (use vírgulas)" class="rovuma-input">
            </div>
        </div>
        @endif

        <!-- BOTÕES -->
        <div class="mt-12 flex flex-col md:flex-row gap-4 justify-between">
            @if($currentStep > 1)
                <button wire:click="prevStep" class="order-2 md:order-1 px-8 py-4 text-gray-500 font-bold uppercase text-xs hover:bg-gray-100 rounded-2xl transition italic">
                    &larr; Voltar ao passo anterior
                </button>
            @else
                <div></div>
            @endif

            <div class="order-1 md:order-2 flex gap-4">
                @if($currentStep < 3)
                    <button wire:click="nextStep" class="w-full md:w-auto bg-rovumaBlue text-white px-12 py-5 rounded-2xl font-black uppercase text-sm hover:bg-rovumaGold transition shadow-xl shadow-blue-900/20 active:scale-95">
                        Continuar para Passo {{ $currentStep + 1 }} &rarr;
                    </button>
                @else
                    <button wire:click="submit" wire:loading.attr="disabled" class="w-full md:w-auto bg-green-600 text-white px-12 py-5 rounded-2xl font-black uppercase text-sm hover:bg-green-700 transition shadow-xl shadow-green-900/20 active:scale-95 flex items-center justify-center gap-3">
                        <span wire:loading.remove>Finalizar Submissão Agora</span>
                        <span wire:loading>Enviando ficheiro...</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>