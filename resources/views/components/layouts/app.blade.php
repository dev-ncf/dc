<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Direção Científica' }} | Universidade Rovuma</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        rovumaBlue: '#003366',
                        rovumaGold: '#f39c12',
                    }
                }
            }
        }
    </script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('images/logo-rovuma.png')}}" type="image/x-icon">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    <style>
    .rovuma-input {
        width: 100%;
        background-color: #ffffff;
        border: 2px solid #d1d5db; /* Cinza médio, bem visível */
        border-radius: 0.75rem;
        padding: 1rem;
        color: #1f2937;
        transition: all 0.2s ease-in-out;
        outline: none;
    }
    .rovuma-input:focus {
        border-color: #003366; /* Azul UniRovuma */
        box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
    }
    .rovuma-input::placeholder {
        color: #9ca3af;
        font-weight: 400;
    }
    /* Estilo para quando o campo tem erro */
    .rovuma-input-error {
        border-color: #ef4444 !important;
        background-color: #fef2f2;
    }
</style>
    
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Componente Livewire da Navbar -->
    <livewire:navbar />

    <!-- Conteúdo Dinâmico -->
    <main id="content">
        {{ $slot }}
    </main>

    <!-- Rodapé Institucional -->
    <footer class="bg-rovumaBlue text-white pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-1">
                <img src="{{ asset('images/logo-rovuma.png') }}" class="h-16 mb-4">
                <p class="text-sm text-gray-300">Dedicação, Inovação e Excelência no Ensino Superior em Moçambique.</p>
            </div>
            
            <!-- Links geridos pelo Filament (tipo footer) -->
            <div class="col-span-1">
                <h4 class="font-bold border-b border-rovumaGold pb-2 mb-4">A Direção</h4>
                <ul class="text-sm space-y-2 text-gray-300">
                    <li><a href="/pagina/historial" class="hover:text-rovumaGold">Historial</a></li>
                    <li><a href="/pagina/visao-e-missao" class="hover:text-rovumaGold">Visão e Missão</a></li>
                </ul>
            </div>
            
            <div class="col-span-1">
                <h4 class="font-bold border-b border-rovumaGold pb-2 mb-4">Contactos</h4>
                <p class="text-sm text-gray-300">Email: dc@unirovuma.ac.mz</p>
                <p class="text-sm text-gray-300">Nampula, Moçambique</p>
            </div>
        </div>
        <div class="text-center mt-10 text-xs text-gray-400 border-t border-gray-700 pt-6">
            &copy; {{ date('Y') }} Direção Científica - Universidade Rovuma. Todos os direitos reservados.
        </div>
    </footer>

    @livewireScripts
</body>
</html>