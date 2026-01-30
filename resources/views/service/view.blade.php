<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Corte Ejecutivo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
        <a href="/" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <div class="flex items-center gap-6">
            <a href="/business/view" class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al Negocio
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-6 md:p-12">
        
        <div class="max-w-6xl w-full bg-[#1a1a1a] md:border border-[#374151]/50 p-0 md:p-12 animate-fade-in-up">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
                
                <!-- Left Column: Service Info -->
                <div class="space-y-8">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wide text-white mb-4">
                            Corte Ejecutivo
                        </h1>
                        <p class="text-[#9CA3AF] text-sm leading-relaxed border-l border-[#374151] pl-4">
                            Experimenta el máximo nivel de detalle. Nuestro Corte Ejecutivo no es solo un cambio de look, es un ritual. Incluye asesoría de imagen personalizada, lavado con productos premium, corte de precisión con tijera y finalizado con peinado profesional.
                        </p>
                    </div>

                    <div class="w-full aspect-video bg-[#0f0f0f] relative overflow-hidden border border-[#374151]/30">
                        <div class="absolute inset-0 flex items-center justify-center opacity-20">
                             <svg class="w-32 h-32 text-[#374151]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M刀8 刀c0-1 1-2 3-2h6c2 0 3 1 3 2v8c0 1-1 2-3 2H11c-2 0-3-1-3-2V8z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                         <!-- Placeholder Image Overlay -->
                         <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] via-transparent to-transparent opacity-80"></div>
                         <div class="absolute bottom-4 left-4">
                            <span class="text-white text-xs font-bold tracking-widest uppercase bg-[#374151]/50 px-3 py-1 backdrop-blur-sm">Duración: 45 Min</span>
                         </div>
                    </div>
                </div>

                <!-- Right Column: Reviews & Action -->
                <div class="flex flex-col h-full">
                    
                    <div class="flex-grow">
                        <h2 class="text-2xl font-bold uppercase tracking-wide text-white mb-8 flex items-center justify-between">
                            Reseñas
                            <span class="text-xs text-[#9CA3AF] font-normal tracking-wide">4.9/5.0 (24 OPINIONES)</span>
                        </h2>

                        <!-- Reviews List -->
                        <div class="space-y-6 max-h-[400px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-[#374151] scrollbar-track-transparent">
                            <!-- Review 1 -->
                            <div class="border-b border-[#374151]/30 pb-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[#F3F4F6] text-[10px] bg-[#374151] px-1.5 py-0.5 font-bold">5.0 ★</span>
                                    <span class="text-[#9CA3AF] text-xs font-bold uppercase tracking-wider">Carlos M.</span>
                                </div>
                                <p class="text-[#9CA3AF] text-xs leading-relaxed italic">
                                    "Excelente servicio. El barbero fue muy atento a los detalles y el ambiente es increíble. Definitivamente volveré."
                                </p>
                            </div>

                            <!-- Review 2 -->
                            <div class="border-b border-[#374151]/30 pb-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[#F3F4F6] text-[10px] bg-[#374151] px-1.5 py-0.5 font-bold">5.0 ★</span>
                                    <span class="text-[#9CA3AF] text-xs font-bold uppercase tracking-wider">Javier R.</span>
                                </div>
                                <p class="text-[#9CA3AF] text-xs leading-relaxed italic">
                                    "La mejor experiencia de barbería que he tenido. El corte quedó perfecto."
                                </p>
                            </div>

                             <!-- Review 3 -->
                            <div class="border-b border-[#374151]/30 pb-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[#F3F4F6] text-[10px] bg-[#374151] px-1.5 py-0.5 font-bold">4.8 ★</span>
                                    <span class="text-[#9CA3AF] text-xs font-bold uppercase tracking-wider">Luis G.</span>
                                </div>
                                <p class="text-[#9CA3AF] text-xs leading-relaxed italic">
                                    "Muy buen servicio, aunque tuve que esperar unos minutos extra. El resultado valió la pena."
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Area -->
                    <div class="mt-8 border-t border-[#374151] pt-8">
                        <div class="flex justify-between items-end mb-6">
                            <div class="text-[#9CA3AF] text-xs uppercase tracking-widest">
                                Precio Total
                            </div>
                            <div class="text-3xl font-bold text-white tracking-tight">
                                $350 <span class="text-sm font-normal text-[#9CA3AF]">MXN</span>
                            </div>
                        </div>
                        <button class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-[0.2em] uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                            Reservar Cita
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Simple Footer -->
    <footer class="border-t border-[#374151]/30 py-8 bg-black">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="text-[10px] text-[#52525b] tracking-wider uppercase">
                © 2026 NexoApp Inc.
            </div>
        </div>
    </footer>

</body>
</html>
