 <footer class="bg-slate-900 text-white pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-white/5 pb-20">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-8">
                    <div class="leading-none border-l-4 border-rovuma-secondary pl-3">
                        <span class="block text-white font-black text-2xl tracking-tighter uppercase">Universidade</span>
                        <span class="block text-rovuma-secondary font-bold text-xl italic uppercase">Rovuma</span>
                    </div>
                </div>
                <p class="text-slate-500 text-sm max-w-md leading-relaxed italic">
                    Instituição pública moçambicana vocacionada para o ensino superior, investigação científica e extensão universitária, promovendo o desenvolvimento sustentável do país.
                </p>
                <div class="flex gap-4 mt-8">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-rovuma-secondary transition"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-rovuma-secondary transition"><i data-lucide="linkedin" class="w-4 h-4"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-rovuma-secondary transition"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                </div>
            </div>
            <div>
                <h4 class="font-black text-xs uppercase tracking-[0.2em] mb-8 text-rovuma-secondary">Explorar</h4>
                <ul class="space-y-4 text-slate-400 text-sm font-medium">
                    <li><a href="{{ route('maintenance') }}" class="hover:text-white transition">Inscrições 2026</a></li>
                    <li><a href="{{ route('maintenance') }}" class="hover:text-white transition">Cursos de Graduação</a></li>
                    <li><a href="{{ route('maintenance') }}" class="hover:text-white transition">Pós-Graduação</a></li>
                    <li><a href="{{ route('maintenance') }}" class="hover:text-white transition">Editais & Avisos</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-black text-xs uppercase tracking-[0.2em] mb-8 text-rovuma-secondary">Contactos</h4>
                <div class="space-y-4 text-slate-400 text-sm">
                    <p class="flex items-start gap-3 italic leading-relaxed"><i data-lucide="map-pin" class="w-5 h-5 text-white/20"></i> Av. FPLM, Campus de Nampula, Cidade de Nampula</p>
                    <p class="flex items-center gap-3 italic"><i data-lucide="phone" class="w-5 h-5 text-white/20"></i> (+258) 26 218 000</p>
                    <p class="flex items-center gap-3 italic underline text-white font-bold"><i data-lucide="mail" class="w-5 h-5 text-white/20"></i> secretaria@unirovuma.ac.mz</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-12 text-[10px] text-slate-600 font-bold uppercase tracking-[0.5em]">
            © {{ date('Y') }} UniRovuma | Direccao das TICs
        </div>
    </footer>