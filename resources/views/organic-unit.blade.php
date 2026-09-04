@extends('layouts.app')

@section('title', $unit->name . ' | UniRovuma')

@section('content')
    <!-- HERO SECTION DA UNIDADE -->
    <section class="relative h-[400px] bg-rovuma-primary flex items-center overflow-hidden">
        <img src="{{ $unit->org_chart ? asset('storage/'.$unit->org_chart) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200' }}" 
             class="absolute inset-0 w-full h-full object-cover opacity-20 blur-sm">
        <div class="absolute inset-0 bg-gradient-to-r from-rovuma-primary to-transparent"></div>
        
        <div class="relative max-w-7xl mx-auto px-6 w-full text-white">
            <div class="flex items-center gap-2 mb-4">
                <span class="bg-rovuma-secondary px-3 py-1 rounded-full text-[10px] font-black uppercase">{{ $unit->type }}</span>
                <span class="text-white/60 text-xs font-bold uppercase tracking-widest">{{ $unit->campus->name }}</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter leading-none">{{ $unit->name }}</h1>
            <p class="mt-6 text-xl text-white/80 max-w-2xl italic font-light">Comprometidos com a excelência académica e o desenvolvimento regional.</p>
        </div>
    </section>

    <!-- BARRA DE NÚMEROS DA UNIDADE (ESTATÍSTICAS) -->
    <div class="bg-white border-b border-slate-100 sticky top-24 z-40">
        <div class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-3 gap-8">
            <div class="flex items-center gap-4 justify-center border-r">
                <i data-lucide="users" class="w-8 h-8 text-rovuma-secondary"></i>
                <div>
                    <span class="block text-2xl font-black text-rovuma-primary leading-none">{{ number_format($unit->avg_students) }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Estudantes</span>
                </div>
            </div>
            <div class="flex items-center gap-4 justify-center border-r">
                <i data-lucide="graduation-cap" class="w-8 h-8 text-rovuma-secondary"></i>
                <div>
                    <span class="block text-2xl font-black text-rovuma-primary leading-none">{{ number_format($unit->avg_lecturers) }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Docentes</span>
                </div>
            </div>
            <div class="flex items-center gap-4 justify-center">
                <i data-lucide="briefcase" class="w-8 h-8 text-rovuma-secondary"></i>
                <div>
                    <span class="block text-2xl font-black text-rovuma-primary leading-none">{{ number_format($unit->avg_cta) }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Técnicos (CTA)</span>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-3 gap-16">
        
        <!-- COLUNA ESQUERDA: LIDERANÇA E ESTRATÉGIA -->
        <div class="lg:col-span-2 space-y-20">
            
            <!-- SEÇÃO SOBRE (MISSÃO/VISÃO) -->
            <section x-data="{ tab: 'missao' }">
                <div class="flex gap-8 border-b border-slate-200 mb-10">
                    <button @click="tab = 'missao'" :class="tab === 'missao' ? 'border-rovuma-secondary text-rovuma-primary' : 'border-transparent text-slate-400'" class="pb-4 border-b-4 font-black uppercase text-xs tracking-widest transition-all">Nossa Missão</button>
                    <button @click="tab = 'visao'" :class="tab === 'visao' ? 'border-rovuma-secondary text-rovuma-primary' : 'border-transparent text-slate-400'" class="pb-4 border-b-4 font-black uppercase text-xs tracking-widest transition-all">Nossa Visão</button>
                    <button @click="tab = 'valores'" :class="tab === 'valores' ? 'border-rovuma-secondary text-rovuma-primary' : 'border-transparent text-slate-400'" class="pb-4 border-b-4 font-black uppercase text-xs tracking-widest transition-all">Valores</button>
                </div>

                <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-blue-900/5 min-h-[200px] flex items-center">
                    <div x-show="tab === 'missao'" x-cloak class="text-lg leading-relaxed italic text-slate-600">
                        {!! $unit->mission ?? 'Conteúdo em actualização...' !!}
                    </div>
                    <div x-show="tab === 'visao'" x-cloak class="text-lg leading-relaxed italic text-slate-600">
                        {!! $unit->vision ?? 'Conteúdo em actualização...' !!}
                    </div>
                    <div x-show="tab === 'valores'" x-cloak class="text-lg leading-relaxed italic text-slate-600">
                        <p class="font-bold text-rovuma-primary">{{ $unit->values }}</p>
                    </div>
                </div>
            </section>

            <!-- SEÇÃO CURSOS (Se for faculdade) -->
            @if($unit->departments->count() > 0)
            <section>
                <h2 class="text-3xl font-black text-rovuma-primary uppercase tracking-tighter mb-10">Oferta Académica</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($unit->departments as $dept)
                        @foreach($dept->courses as $course)
                            <div class="bg-white p-6 rounded-3xl border border-slate-100 hover:border-rovuma-secondary transition group cursor-pointer">
                                <span class="text-[9px] font-black text-rovuma-secondary uppercase">{{ $course->level }}</span>
                                <h4 class="text-lg font-bold text-slate-800 mt-1 group-hover:text-rovuma-primary">{{ $course->name }}</h4>
                                <div class="mt-4 flex justify-between items-center text-[10px] font-bold text-slate-400">
                                    <span>{{ $course->duration }} Semestres</span>
                                    <span class="flex items-center gap-1"><i data-lucide="check-circle" class="w-3 h-3 text-emerald-500"></i> {{ $course->modality }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </section>
            @endif

            <!-- ORGANOGRAMA -->
            @if($unit->org_chart)
            <section>
                <h2 class="text-3xl font-black text-rovuma-primary uppercase tracking-tighter mb-10 text-center">Estrutura Organizacional</h2>
                <div class="bg-white p-4 rounded-[2rem] shadow-lg">
                    <img src="{{ asset('storage/'.$unit->org_chart) }}" class="w-full rounded-2xl" alt="Organograma">
                </div>
            </section>
            @endif
        </div>

        <!-- SIDEBAR: LIDERANÇA E CONTACTO -->
        <div class="space-y-12">
            <!-- CARD DO DIRECTOR -->
            <div class="bg-rovuma-primary rounded-[3rem] overflow-hidden text-white p-8 pt-12 relative shadow-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
                
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-full border-4 border-rovuma-secondary p-1 mb-6 overflow-hidden bg-white">
                        <img src="{{ $unit->leader_photo ? asset('storage/'.$unit->leader_photo) : 'https://ui-avatars.com/api/?name='.$unit->leader_name }}" class="w-full h-full object-cover rounded-full">
                    </div>
                    <h3 class="text-xl font-black leading-tight">{{ $unit->leader_name ?? 'Nome do Responsável' }}</h3>
                    <p class="text-rovuma-secondary text-xs font-bold uppercase tracking-widest mt-2">{{ $unit->leader_title ?? 'Director' }}</p>
                    <div class="w-10 h-1 bg-white/20 my-6"></div>
                    <p class="text-sm text-white/70 italic leading-relaxed">"Bem-vindo à nossa unidade orgânica. Aqui trabalhamos para a excelência no saber."</p>
                </div>
            </div>

            <!-- NEWS DA UNIDADE -->
            <div class="space-y-4">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest pl-2">Últimas da Unidade</h3>
                @forelse($news as $item)
                    <a href="#" class="block bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group">
                        <span class="text-[9px] font-bold text-rovuma-secondary">{{ $item->created_at->format('d/m/Y') }}</span>
                        <h4 class="text-sm font-bold text-slate-800 group-hover:text-rovuma-primary leading-tight mt-1">{{ $item->title }}</h4>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 italic pl-2">Nenhuma notícia recente.</p>
                @endforelse
            </div>
        </div>
    </main>

@endsection