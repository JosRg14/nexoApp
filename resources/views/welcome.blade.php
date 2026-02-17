<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Bienvenido</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    <!-- Top Banner -->
    <div class="bg-black py-2 text-center">
        <p class="text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF]">Bienvenido a NexoApp</p>
    </div>

    <!-- Navbar -->
    <header class="w-full border-b border-[#374151]/50 sticky top-0 bg-[#1a1a1a]/95 backdrop-blur-sm z-50">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col md:flex-row justify-between items-center gap-6">
            
            <!-- Logo & Search Group -->
            <div class="flex items-center w-full md:w-auto gap-8">
                <div class="text-2xl font-bold tracking-widest uppercase text-white shrink-0">
                    NEXOAPP
                </div>

                <!-- Minimal Search Bar -->
                <div class="relative hidden md:block w-full max-w-md group">
                    <input type="text" 
                        class="w-64 focus:w-80 transition-all duration-500 bg-transparent border-b border-[#374151] py-2 pl-2 pr-8 text-sm text-white focus:border-white focus:outline-none placeholder-transparent" 
                        placeholder="Buscar..." 
                    />
                    <label class="absolute left-2 top-2 text-[#9CA3AF] text-xs pointer-events-none uppercase tracking-wider transition-all group-focus-within:-top-3 group-focus-within:text-[10px] group-focus-within:text-white">
                        Buscar Servicios...
                    </label>
                    <svg class="w-4 h-4 absolute right-0 top-2.5 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Navigation Actions -->
            <nav class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                <a href="/dashboard" class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">Dashboard</a>
                <a href="/business/profile" class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">Tu Negocio</a>
                <a href="/login" class="px-5 py-2.5 bg-[#F3F4F6] text-[#1a1a1a] text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white hover:border hover:border-[#F3F4F6] transition-all duration-300">
                    Iniciar Sesión
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 py-20 md:py-32">
            <div class="max-w-3xl space-y-8 animate-fade-in-up">
                <h1 class="text-5xl md:text-7xl font-bold uppercase tracking-wide text-white leading-tight">
                    Bienvenido a <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-[#374151]">Nexo App!</span>
                </h1>
                
                <p class="text-[#9CA3AF] text-lg leading-relaxed max-w-2xl border-l border-[#374151] pl-6">
                    Conectamos necesidades con soluciones. Descubre una red exclusiva de servicios y negocios curados para ofrecerte la mejor experiencia en tu ciudad. Calidad, rapidez y estilo en un solo lugar.
                </p>

                <div class="pt-4">
                    <a href="/register" class="inline-block py-4 px-10 bg-[#1a1a1a] border border-[#F3F4F6] text-[#F3F4F6] text-sm font-bold uppercase tracking-[0.2em] hover:bg-[#F3F4F6] hover:text-[#1a1a1a] transition-all duration-300">
                        Empezar Ahora
                    </a>
                </div>
            </div>
        </section>

        <!-- Filters & Grid -->
        <section class="max-w-7xl mx-auto px-6 pb-24">
            
            <!-- Filter Bar -->
            <div class="flex flex-wrap gap-4 mb-12 border-b border-[#374151] pb-6 items-center justify-between">
                <div class="flex gap-4">
                     <!-- Filter Pill -->
                    <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                        Ordenar
                    </button>
                    <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                        Categoría
                    </button>
                    <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                        Precio
                    </button>
                </div>
                <div class="text-[#374151] text-xs uppercase tracking-widest">
                    Mostrando Resultados
                </div>
            </div>

            <!-- Trends Title -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold uppercase tracking-widest text-white flex items-center gap-4">
                    Tendencias
                    <span class="h-px w-20 bg-[#374151]"></span>
                </h2>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Barbershops Data -->
                @php
                    $barbershops = [
                        [
                            'name' => 'The Gentlemen\'s Club',
                            'desc' => 'Corte clásico y afeitado tradicional con toalla caliente. Una experiencia de lujo atemporal.',
                            'tag' => '4.9 ★'
                        ],
                        [
                            'name' => 'Urban Fade Studio',
                            'desc' => 'Especialistas en degradados, diseños urbanos y las últimas tendencias en estilismo masculino.',
                            'tag' => 'NEW'
                        ],
                        [
                            'name' => 'Razor & Blade',
                            'desc' => 'Barbería ejecutiva de alto nivel. Servicio exclusivo bajo reserva para el hombre moderno.',
                            'tag' => '5.0 ★'
                        ],
                        [
                            'name' => 'Legacy Barbershop',
                            'desc' => 'Heredando la tradición del buen corte. Ambiente clásico, música jazz y whiskey de cortesía.',
                            'tag' => 'TOP'
                        ]
                    ];
                @endphp

                @foreach ($barbershops as $index => $shop)
                <article onclick="window.location.href='{{ $index === 0 ? '/business/view' : '#' }}'" class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151]/50 hover:border-[#F3F4F6]/50 transition-all duration-500 cursor-pointer">
                    <!-- Image Area -->
                    <div class="aspect-[4/5] bg-[#0f0f0f] relative overflow-hidden">
                        <div class="absolute inset-0 bg-transparent group-hover:bg-white/5 transition-colors duration-300"></div>
                        <!-- Abstract Barber Icon/Placeholder -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <!-- Simple scissors/razor abstract representation or just geometric -->
                            <svg class="w-16 h-16 text-[#374151]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-white font-bold uppercase tracking-wide text-sm group-hover:text-[#9CA3AF] transition-colors">
                                {{ $shop['name'] }}
                            </h3>
                            <span class="text-[10px] text-[#F3F4F6] bg-[#374151]/50 px-2 py-1 tracking-widest">{{ $shop['tag'] }}</span>
                        </div>
                        <p class="text-[#9CA3AF] text-xs leading-relaxed border-l border-[#374151] pl-3 py-1">
                            {{ $shop['desc'] }}
                        </p>
                    </div>
                    
                    <!-- Hover Action -->
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-[#F3F4F6] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                </article>
                @endforeach
            </div>

        </section>

    </main>

    <!-- Simple Footer -->
    <footer class="border-t border-[#374151]/30 py-12 bg-black">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="text-sm font-bold tracking-widest uppercase text-[#374151]">
                NexoAPP
            </div>
            <div class="text-[10px] text-[#52525b] tracking-wider">
                © 2026 DARK LUXURY UI
            </div>
        </div>
    </footer>

</body>
</html>
