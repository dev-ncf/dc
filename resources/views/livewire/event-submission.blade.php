<div>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-rovumaBlue uppercase tracking-tighter">Submeter Novo Evento</h1>
            <p class="text-rovumaGold font-bold mt-2">Divulgue conferências, palestras ou workshops científicos</p>
        </div>

        <form wire:submit.prevent="submit"
            class="bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-gray-100 space-y-8">
            <!-- BLOCO DE IDENTIFICAÇÃO DO PROPONENTE -->
            <div class="space-y-6 bg-gray-50 p-6 rounded-3xl border-2 border-gray-100 mb-10">
                <h2 class="text-xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">
                    Identificação do Proponente</h2>
                <p class="text-xs text-gray-500 font-medium italic">Estes dados são apenas para contacto interno da
                    Direção Científica.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Seu Nome Completo *</label>
                        <input type="text" wire:model="submitter_name" placeholder="Ex: Prof. João Manuel"
                            class="rovuma-input">
                        @error('submitter_name')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Seu Email de Contacto *</label>
                        <input type="email" wire:model="submitter_email" placeholder="email@exemplo.com"
                            class="rovuma-input">
                        @error('submitter_email')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- INFORMAÇÃO BÁSICA -->
            <div class="space-y-6">
                <h2 class="text-xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">
                    1. Informações Gerais</h2>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Título do Evento *</label>
                    <input type="text" wire:model="title"
                        placeholder="Ex: I Conferência Internacional de Biotecnologia"
                        class="rovuma-input @error('title') rovuma-input-error @enderror">
                    @error('title')
                        <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Descrição / Programa *</label>
                    <textarea wire:model="description" rows="5" placeholder="Detalhes do evento, oradores e cronograma..."
                        class="rovuma-input"></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- LOGÍSTICA -->
            <div class="space-y-6 pt-4">
                <h2 class="text-xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">
                    2. Data e Local</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Início (Data e Hora) *</label>
                        <input type="datetime-local" wire:model="start_date" class="rovuma-input">
                        @error('start_date')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Fim (Opcional)</label>
                        <input type="datetime-local" wire:model="end_date" class="rovuma-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Local ou Link Virtual *</label>
                        <input type="text" wire:model="location" placeholder="Ex: Sala 4 ou Zoom"
                            class="rovuma-input">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Faculdade Organizadora</label>
                        <select wire:model="organic_unit_id" class="rovuma-input">
                            <option value="">Evento Central (Reitoria)</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- EXTRAS -->
            <div class="space-y-6 pt-4">
                <h2 class="text-xl font-black text-rovumaBlue uppercase border-b-2 border-rovumaGold inline-block pb-1">
                    3. Mídia e Inscrição</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Cartaz do Evento (Imagem)</label>
                        <div
                            class="relative h-40 border-2 border-dashed border-gray-300 rounded-2xl flex flex-col items-center justify-center hover:border-rovumaGold transition-colors cursor-pointer bg-gray-50">
                            <input type="file" wire:model="image" class="absolute inset-0 opacity-0 cursor-pointer">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="h-full w-full object-cover rounded-2xl">
                            @else
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-xs font-bold text-gray-500 mt-2">Clique para Upload</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Link para Inscrição (Se
                            houver)</label>
                        <input type="url" wire:model="registration_url" placeholder="https://forms.gle/..."
                            class="rovuma-input">
                    </div>
                </div>
            </div>

            <!-- BOTÃO SUBMIT -->
            <div class="pt-10">
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-rovumaBlue text-white py-6 rounded-2xl font-black uppercase tracking-widest hover:bg-rovumaGold transition shadow-2xl shadow-blue-900/30 flex items-center justify-center gap-4">
                    <span wire:loading.remove>Enviar para Aprovação</span>
                    <span wire:loading>A Processar submissão...</span>
                </button>
                <p class="text-center text-[10px] text-gray-400 uppercase mt-4 font-bold tracking-widest">O seu evento
                    será revisado antes de aparecer publicamente.</p>
            </div>
        </form>
    </div>
</div>
