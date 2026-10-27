<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- BARRA DE PROGRESSO -->
    <div class="mb-10">
        <div class="flex justify-between items-center relative">
            @foreach(['Informação', 'Vínculo e Metadados', 'Documento'] as $index => $step)
                <div class="z-10 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center border-4 font-black {{ $currentStep >= ($index + 1) ? 'bg-rovumaBlue border-rovumaGold text-white' : 'bg-white border-gray-200 text-gray-300' }}">
                        {{ $index + 1 }}
                    </div>
                    <span class="text-xs font-bold mt-2 uppercase tracking-wider {{ $currentStep >= ($index + 1) ? 'text-rovumaBlue' : 'text-gray-400' }}">
                        {{ $step }}
                    </span>
                </div>
            @endforeach
            <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 -z-0">
                <div class="h-full bg-rovumaGold transition-all duration-500" style="width: {{ ($currentStep - 1) * 50 }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] p-6 md:p-10 border border-gray-100">
        
        <!-- ========================================== -->
        <!-- PASSO 1: DADOS GERAIS DO TRABALHO          -->
        <!-- ========================================== -->
        @if($currentStep == 1)
        <div class="space-y-6 animate-fade-in">
            <h2 class="text-2xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">1. Sobre o Trabalho</h2>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Título do Trabalho / Artigo / Obra *</label>
                <input type="text" wire:model="title" placeholder="Digite o título completo da pesquisa ou publicação..." 
                       class="rovuma-input @error('title') rovuma-input-error @enderror">
                @error('title') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- TIPO DE DOCUMENTO (Agora no Passo 1 para orientar o formulário) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tipo de Documento *</label>
                    <select wire:model.live="document_type_id" class="rovuma-input border-2 border-rovumaGold @error('document_type_id') rovuma-input-error @enderror">
                        <option value="">-- Selecione o Tipo (Ex: Monografia, Artigo, Livro...) --</option>
                        @foreach($types as $type) 
                            <option value="{{ $type->id }}">{{ $type->name }}</option> 
                        @endforeach
                    </select>
                    @error('document_type_id') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- ÁREA CIENTÍFICA -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Área Científica *</label>
                    <select wire:model="knowledge_area_id" class="rovuma-input @error('knowledge_area_id') rovuma-input-error @enderror">
                        <option value="">-- Selecione a Área do Saber --</option>
                        @foreach($areas as $area) 
                            <option value="{{ $area->id }}">{{ $area->name }}</option> 
                        @endforeach
                    </select>
                    @error('knowledge_area_id') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Resumo Académico / Abstract *</label>
                <textarea wire:model="abstract" rows="5" placeholder="Copie e cole aqui o resumo do documento..." 
                          class="rovuma-input @error('abstract') rovuma-input-error @enderror"></textarea>
                @error('abstract') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ano de Publicação / Defesa *</label>
                    <input type="number" wire:model="publication_year" class="rovuma-input @error('publication_year') rovuma-input-error @enderror">
                    @error('publication_year') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Instituição de Origem / Vínculo</label>
                    <input type="text" wire:model="issuing_institution" class="rovuma-input bg-gray-50">
                </div>
            </div>
        </div>
        @endif

        <!-- ========================================== -->
        <!-- PASSO 2: AUTORIA, VÍNCULO E METADADOS      -->
        <!-- ========================================== -->
        @if($currentStep == 2)
        <div class="space-y-6 animate-fade-in">
            <div class="flex items-center justify-between border-b-2 border-rovumaGold pb-1">
                <h2 class="text-2xl font-black text-rovumaBlue uppercase">2. Vínculo e Autoria</h2>
                <span class="text-xs font-bold px-3 py-1 bg-rovumaBlue text-white rounded-full">
                    Tipo: {{ $this->selectedType?->name ?? 'Geral' }}
                </span>
            </div>

            <!-- Autores, Habilitações e Orientador -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nome do Autor *</label>
                    <input type="text" wire:model="author_name" placeholder="Ex: Macuácua, Alberto" class="rovuma-input @error('author_name') rovuma-input-error @enderror">
                    @error('author_name') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Habilitações Literárias *</label>
                    <select wire:model="author_degree" class="rovuma-input @error('author_degree') rovuma-input-error @enderror">
                        <option value="Licenciatura">Licenciatura</option>
                        <option value="Mestrado">Mestrado</option>
                        <option value="Doutoramento">Doutoramento</option>
                        <option value="Pós-Doutoramento">Pós-Doutoramento</option>
                        <option value="Outro">Outro</option>
                    </select>
                    @error('author_degree') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Orientador (se aplicável)</label>
                    <input type="text" wire:model="advisor_name" placeholder="Ex: Prof. Doutor..." class="rovuma-input">
                </div>
            </div>

            <!-- Faculdade e Curso da UniRovuma -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50/70 p-4 rounded-2xl border-2 border-blue-200">
                    <label class="block text-xs font-black text-rovumaBlue uppercase mb-2">Faculdade / Extensão (UniRovuma)</label>
                    <select wire:model.live="organic_unit_id" class="rovuma-input border-blue-300">
                        <option value="">-- Opcional para publicações externas --</option>
                        @foreach($units as $unit) 
                            <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->sigla }})</option> 
                        @endforeach
                    </select>
                </div>

                <div class="bg-orange-50/70 p-4 rounded-2xl border-2 {{ $organic_unit_id ? 'border-rovumaGold' : 'border-gray-200' }}">
                    <label class="block text-xs font-black {{ $organic_unit_id ? 'text-rovumaGold' : 'text-gray-400' }} uppercase mb-2">Curso / Departamento</label>
                    <select wire:model="course_id" class="rovuma-input {{ !$organic_unit_id ? 'bg-gray-100 cursor-not-allowed' : '' }}" {{ !$organic_unit_id ? 'disabled' : '' }}>
                        <option value="">-- {{ $organic_unit_id ? 'Selecione o Curso' : 'Escolha a faculdade' }} --</option>
                        @foreach($courses as $course) 
                            <option value="{{ $course->id }}">{{ $course->name }}</option> 
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- SE FOR ARTIGO CIENTÍFICO (Campos Exatos da Tabela 7.3)   -->
            <!-- ======================================================== -->
            @if($this->isArticle)
            <div class="bg-blue-50 border-2 border-blue-300 rounded-3xl p-6 space-y-4 animate-fade-in">
                <h3 class="text-sm font-black text-rovumaBlue uppercase tracking-wide border-b border-blue-200 pb-2">
                    Metadados da Publicação do Artigo 
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nome da Revista *</label>
                        <input type="text" wire:model="journal_name" placeholder="Ex: Revista Científica da UniRovuma" class="rovuma-input @error('journal_name') rovuma-input-error @enderror">
                        @error('journal_name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Edição e Ano de Publicação *</label>
                        <input type="text" wire:model="volume_issue" placeholder="Ex: Vol. 3, N.º 2 (2025)" class="rovuma-input @error('volume_issue') rovuma-input-error @enderror">
                        @error('volume_issue') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Número de ISSN ou DOI</label>
                        <input type="text" wire:model="issn" placeholder="Ex: 2410-1234 ou 10.xxxx" class="rovuma-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">País de Publicação *</label>
                        <input type="text" wire:model="publication_country" class="rovuma-input @error('publication_country') rovuma-input-error @enderror">
                        @error('publication_country') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Link do Artigo</label>
                        <input type="url" wire:model="url" placeholder="https://doi.org/..." class="rovuma-input">
                    </div>
                </div>
            </div>
            @endif

            <!-- ======================================================== -->
            <!-- SE FOR CAPÍTULO DE LIVRO (Campos Exatos da Tabela 7.2)   -->
            <!-- ======================================================== -->
            @if($this->isChapter)
            <div class="bg-amber-50 border-2 border-rovumaGold rounded-3xl p-6 space-y-4 animate-fade-in">
                <h3 class="text-sm font-black text-rovumaBlue uppercase tracking-wide border-b border-amber-200 pb-2">
                    Metadados do Capítulo de Livro 
                </h3>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Título do Livro (Obra Coletiva) *</label>
                    <input type="text" wire:model="book_title" placeholder="Título completo do livro onde o capítulo foi inserido..." class="rovuma-input @error('book_title') rovuma-input-error @enderror">
                    @error('book_title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Número de ISBN ou DOI</label>
                        <input type="text" wire:model="isbn" placeholder="Ex: 978-989-... ou 10.xxxx" class="rovuma-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">País de Publicação *</label>
                        <input type="text" wire:model="publication_country" class="rovuma-input @error('publication_country') rovuma-input-error @enderror">
                        @error('publication_country') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Link do Capítulo</label>
                        <input type="url" wire:model="url" placeholder="https://..." class="rovuma-input">
                    </div>
                </div>
            </div>
            @endif

            <!-- ======================================================== -->
            <!-- SE FOR LIVRO COMPLETO (Campos Exatos da Tabela 7.1)      -->
            <!-- ======================================================== -->
            @if($this->isBook)
            <div class="bg-gray-50 border-2 border-gray-300 rounded-3xl p-6 space-y-4 animate-fade-in">
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-wide border-b border-gray-200 pb-2">
                    Metadados do Livro Publicado 
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Número de ISBN ou DOI</label>
                        <input type="text" wire:model="isbn" placeholder="Ex: 978-989-xxx-xxx-x" class="rovuma-input">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">País de Publicação *</label>
                        <input type="text" wire:model="publication_country" class="rovuma-input @error('publication_country') rovuma-input-error @enderror">
                        @error('publication_country') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Link do Livro</label>
                        <input type="url" wire:model="url" placeholder="https://..." class="rovuma-input">
                    </div>
                </div>
            </div>
            @endif

        </div>
        @endif

        <!-- ========================================== -->
        <!-- PASSO 3: FICHEIRO PDF (20MB) E PALAVRAS-CHAVE -->
        <!-- ========================================== -->
        @if($currentStep == 3)
        <div class="space-y-6 animate-fade-in">
            <h2 class="text-2xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">3. Documento Final</h2>

            <div class="relative group">
                <input type="file" wire:model="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" id="file-upload">
                <div class="p-12 border-4 border-dashed border-gray-300 rounded-3xl text-center transition-all group-hover:border-rovumaGold group-hover:bg-orange-50/30">
                    <div class="bg-gray-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                        <svg class="w-10 h-10 text-gray-400 group-hover:text-rovumaGold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-black text-gray-700">Clique para selecionar o PDF do documento</p>
                    <p class="text-sm text-gray-400 mt-1">O arquivo deve ter no máximo 20MB</p>
                    
                    @if ($file)
                        <div class="mt-6 p-4 bg-rovumaBlue text-white rounded-2xl font-bold flex items-center justify-center gap-3">
                            <svg class="w-5 h-5 text-rovumaGold" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                            </svg>
                            {{ $file->getClientOriginalName() }}
                        </div>
                    @endif
                </div>
                @error('file') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Palavras-chave (separadas por vírgulas)</label>
                <input type="text" wire:model="keywords_string" placeholder="Ex: Informática, Educação, Nampula" class="rovuma-input">
            </div>
        </div>
        @endif

        <!-- BOTÕES DE NAVEGAÇÃO -->
        <div class="mt-12 flex flex-col md:flex-row gap-4 justify-between items-center">
            @if($currentStep > 1)
                <button type="button" wire:click="prevStep" class="order-2 md:order-1 px-8 py-4 text-gray-500 font-bold uppercase text-xs hover:bg-gray-100 rounded-2xl transition italic">
                    &larr; Voltar ao passo anterior
                </button>
            @else
                <div></div>
            @endif

            <div class="order-1 md:order-2 flex gap-4 w-full md:w-auto">
                @if($currentStep < 3)
                    <button type="button" wire:click="nextStep" class="w-full md:w-auto bg-rovumaBlue text-white px-12 py-5 rounded-2xl font-black uppercase text-sm hover:bg-rovumaGold hover:text-rovumaBlue transition shadow-xl shadow-blue-900/20 active:scale-95">
                        Continuar para Passo {{ $currentStep + 1 }} &rarr;
                    </button>
                @else
                    <button type="button" wire:click="submit" wire:loading.attr="disabled" class="w-full md:w-auto bg-green-600 text-white px-12 py-5 rounded-2xl font-black uppercase text-sm hover:bg-green-700 transition shadow-xl shadow-green-900/20 active:scale-95 flex items-center justify-center gap-3">
                        <span wire:loading.remove>Finalizar Submissão Agora</span>
                        <span wire:loading>Enviando documento...</span>
                    </button>
                @endif
            </div>
        </div>

    </div>
</div>