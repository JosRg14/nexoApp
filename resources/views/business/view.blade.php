<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - The Gentlemen's Club</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
        <a href="/" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <div class="flex items-center gap-6">
            <a href="/" class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pb-24">
        
        <!-- Hero / Banner Section -->
        <div class="relative w-full h-64 md:h-80 bg-[#262626] overflow-hidden">
             <!-- Overlay pattern or decorative element -->
             <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiMzNzQxNTEiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] opacity-30"></div>
             <div class="absolute inset-0 flex items-center justify-center opacity-10">
                <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
             </div>
        </div>

        <!-- Profile Info (Overlapping Banner) -->
        <div class="max-w-7xl mx-auto px-6 relative -mt-20 mb-16 z-10">
            <div class="flex flex-col md:flex-row items-end md:items-end gap-6">
                
                <!-- Avatar -->
                <div class="h-40 w-40 rounded-full bg-[#1a1a1a] p-2 shrink-0">
                    <div class="h-full w-full rounded-full bg-[#262626] border border-[#374151] flex items-center justify-center overflow-hidden">
                         <span class="text-4xl text-[#374151]">GC</span>
                    </div>
                </div>

                <!-- Info Text -->
                <div class="flex-grow pb-4 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wide text-white mb-2">
                        The Gentlemen's Club
                    </h1>
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 text-[#9CA3AF] text-sm tracking-wide">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ciudad de México, Centro
                        </span>
                        <span class="px-2 py-0.5 border border-[#374151] text-[10px] uppercase">Barbería Premium</span>
                        <span class="text-white flex items-center gap-1">
                            ★ 4.9 (124 Reviews)
                        </span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pb-4 w-full md:w-auto">
                    <button class="w-full md:w-auto px-8 py-3 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                        Contactar
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-4 mb-10 border-b border-[#374151] pb-6 items-center">
                 <button class="px-4 py-1.5 bg-[#374151]/30 border border-[#374151] text-white text-[10px] uppercase tracking-widest transition-all">
                    Todos
                </button>
                <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                    Cortes
                </button>
                <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                    Afeitado
                </button>
                <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                    Paquetes
                </button>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in-up">
                
                <!-- Service 1 -->
                <article class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151]/50 hover:border-[#F3F4F6]/50 transition-all duration-300">
                    <div class="aspect-video bg-[#0f0f0f] relative overflow-hidden">
                        <div class="absolute inset-0 bg-transparent group-hover:bg-white/5 transition-colors duration-300"></div>
                         <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <span class="text-[#374151] text-4xl font-thin">✂️</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-white font-bold uppercase tracking-wide text-sm mb-1">Corte Ejecutivo</h3>
                        <p class="text-[#9CA3AF] text-xs leading-relaxed mb-4 line-clamp-2">
                            Corte de precisión con tijera, lavado con shampoo premium y peinado.
                        </p>
                        <div class="flex justify-between items-center border-t border-[#374151]/50 pt-3">
                            <span class="bg-[#262626] px-2 py-1 text-white text-xs font-bold tracking-wide">$350 MXN</span>
                            <a href="/service/view" class="text-[10px] uppercase tracking-widest text-[#F3F4F6] hover:underline decoration-1 underline-offset-4">Reservar</a>
                        </div>
                    </div>
                </article>

                <!-- Service 2 -->
                <article class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151]/50 hover:border-[#F3F4F6]/50 transition-all duration-300">
                    <div class="aspect-video bg-[#0f0f0f] relative overflow-hidden">
                        <div class="absolute inset-0 bg-transparent group-hover:bg-white/5 transition-colors duration-300"></div>
                         <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <span class="text-[#374151] text-4xl font-thin">🪒</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-white font-bold uppercase tracking-wide text-sm mb-1">Ritual de Barba</h3>
                        <p class="text-[#9CA3AF] text-xs leading-relaxed mb-4 line-clamp-2">
                            Afeitado tradicional con toalla caliente, aceites esenciales y masaje facial.
                        </p>
                        <div class="flex justify-between items-center border-t border-[#374151]/50 pt-3">
                            <span class="bg-[#262626] px-2 py-1 text-white text-xs font-bold tracking-wide">$250 MXN</span>
                            <button class="text-[10px] uppercase tracking-widest text-[#F3F4F6] hover:underline decoration-1 underline-offset-4">Reservar</button>
                        </div>
                    </div>
                </article>

                <!-- Service 3 -->
                <article class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151]/50 hover:border-[#F3F4F6]/50 transition-all duration-300">
                    <div class="aspect-video bg-[#0f0f0f] relative overflow-hidden">
                        <div class="absolute inset-0 bg-transparent group-hover:bg-white/5 transition-colors duration-300"></div>
                         <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <span class="text-[#374151] text-4xl font-thin">🧔‍♂️</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-white font-bold uppercase tracking-wide text-sm mb-1">Corte + Barba</h3>
                        <p class="text-[#9CA3AF] text-xs leading-relaxed mb-4 line-clamp-2">
                            El servicio completo para el caballero moderno. Incluye bebida de cortesía.
                        </p>
                        <div class="flex justify-between items-center border-t border-[#374151]/50 pt-3">
                            <span class="bg-[#262626] px-2 py-1 text-white text-xs font-bold tracking-wide">$550 MXN</span>
                            <button class="text-[10px] uppercase tracking-widest text-[#F3F4F6] hover:underline decoration-1 underline-offset-4">Reservar</button>
                        </div>
                    </div>
                </article>

                <!-- Service 4 -->
                <article class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151]/50 hover:border-[#F3F4F6]/50 transition-all duration-300">
                    <div class="aspect-video bg-[#0f0f0f] relative overflow-hidden">
                        <div class="absolute inset-0 bg-transparent group-hover:bg-white/5 transition-colors duration-300"></div>
                         <div class="absolute inset-0 flex items-center justify-center opacity-20">
                            <span class="text-[#374151] text-4xl font-thin">✨</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-white font-bold uppercase tracking-wide text-sm mb-1">Facial Express</h3>
                        <p class="text-[#9CA3AF] text-xs leading-relaxed mb-4 line-clamp-2">
                            Limpieza profunda e hidratación para revitalizar la piel cansada. 30 min.
                        </p>
                        <div class="flex justify-between items-center border-t border-[#374151]/50 pt-3">
                            <span class="bg-[#262626] px-2 py-1 text-white text-xs font-bold tracking-wide">$300 MXN</span>
                            <button class="text-[10px] uppercase tracking-widest text-[#F3F4F6] hover:underline decoration-1 underline-offset-4">Reservar</button>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="border-t border-[#374151]/30 py-8 bg-black mt-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="text-[10px] text-[#52525b] tracking-wider uppercase">
                © 2026 NexoApp Inc.
            </div>
        </div>
    </footer>

</body>
</html>
