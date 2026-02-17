<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Selecciona tu Perfil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased flex flex-col">

    <!-- Navbar Minimalista -->
    <header class="w-full py-6 px-8 flex justify-between items-center border-b border-[#374151]/50">
        <a href="{{ url('/') }}" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <div class="text-sm tracking-wide text-[#9CA3AF]">
            BIENVENIDO A LA EXPERIENCIA
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col justify-center items-center px-4 py-12">
        
        <div class="max-w-7xl w-full flex flex-col items-center">
            
            <!-- Headers -->
            <div class="text-center mb-16 space-y-4">
                <h2 class="text-[#9CA3AF] tracking-[0.2em] text-sm font-medium uppercase">
                    Comienza tu viaje
                </h2>
                <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-wide text-white">
                    ¿Qué tipo de usuario eres?
                </h1>
            </div>

            <!-- Cards Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-5xl">
                
                <!-- Card: Cliente -->
                <div class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151] p-8 md:p-12 transition-all duration-300 hover:border-[#F3F4F6]/50">
                    <!-- Image Placeholder -->
                    <div class="aspect-video w-full bg-[#262626] mb-8 overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-500">
                         <!-- Aquí iría una imagen real, placeholder oscuro por ahora -->
                         <div class="w-full h-full flex items-center justify-center text-[#374151] group-hover:text-[#F3F4F6] transition-colors">
                             <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                         </div>
                    </div>
                    
                    <h3 class="text-2xl font-bold uppercase tracking-wider mb-4 text-white group-hover:text-[#F3F4F6]">
                        Cliente
                    </h3>
                    
                    <p class="text-[#9CA3AF] mb-8 leading-relaxed">
                        Encuentra los mejores negocios y servicios exclusivos en tu ciudad. Accede a promociones únicas y gestiona tus reservas.
                    </p>
                    
                    <a href="/register/client" class="mt-auto w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] text-center font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                        Empezar Ahora
                    </a>
                </div>

                <!-- Card: Negocio -->
                <div class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151] p-8 md:p-12 transition-all duration-300 hover:border-[#F3F4F6]/50">
                    <!-- Image Placeholder -->
                    <div class="aspect-video w-full bg-[#262626] mb-8 overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-500">
                         <!-- Aquí iría una imagen real, placeholder oscuro por ahora -->
                         <div class="w-full h-full flex items-center justify-center text-[#374151] group-hover:text-[#F3F4F6] transition-colors">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                         </div>
                    </div>
                    
                    <h3 class="text-2xl font-bold uppercase tracking-wider mb-4 text-white group-hover:text-[#F3F4F6]">
                        Negocio
                    </h3>
                    
                    <p class="text-[#9CA3AF] mb-8 leading-relaxed">
                        Promociona tu marca, gestiona clientes y expande tu alcance con herramientas de gestión premium.
                    </p>
                    
                    <a href="/register/business" class="mt-auto w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] text-center font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                        Empezar Ahora
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
