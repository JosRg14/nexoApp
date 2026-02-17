<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Registro de Cliente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased flex overflow-hidden">

    <!-- Left Side: Functional (Form) -->
    <div class="w-full lg:w-[45%] h-full flex flex-col p-8 lg:p-16 overflow-y-auto border-r border-[#374151]/30 relative scrollbar-hide">
        
        <!-- Header Nav -->
        <div class="flex justify-between items-center mb-12">
            <a href="/register" class="flex items-center text-xs tracking-widest text-[#9CA3AF] hover:text-white uppercase transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path></svg>
                Volver
            </a>
            <div class="text-xl font-bold tracking-widest uppercase text-white">
                NexoApp
            </div>
        </div>

        <!-- Form Container -->
        <div class="flex-grow flex flex-col justify-center max-w-md mx-auto w-full">
            
            <div class="space-y-8 animate-fade-in-up">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Registro</h1>
                    <p class="text-[#9CA3AF] text-sm tracking-wide">RELLENA LOS SIGUIENTES REQUISITOS</p>
                </div>

                <form class="space-y-8" onsubmit="event.preventDefault(); window.location.href='/';">
                    
                    <div class="space-y-6">
                        <div class="group/input relative">
                            <input type="email" id="email" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Email Address" />
                            <label for="email" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Email Address</label>
                        </div>
                        
                        <div class="group/input relative">
                            <input type="text" id="fullname" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Full Name" />
                            <label for="fullname" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Full Name</label>
                        </div>

                        <div class="group/input relative">
                            <input type="password" id="password" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Contraseña" />
                            <label for="password" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Contraseña</label>
                        </div>

                        <div class="group/input relative">
                            <input type="password" id="password_confirmation" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Confirmar contraseña" />
                            <label for="password_confirmation" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Confirmar contraseña</label>
                        </div>

                        <div class="group/input relative">
                            <input type="text" id="city" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Ciudad" />
                            <label for="city" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Ciudad</label>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                            Finalizar Registro
                        </button>
                    </div>

                </form>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-12 text-center">
            <p class="text-[#374151] text-xs tracking-wider">© 2026 NEXOAPP INC.</p>
        </div>

    </div>

    <!-- Right Side: Visual (Abstract Art) -->
    <div class="hidden lg:block w-[55%] h-full relative overflow-hidden bg-[#0a0a0a]">
        <!-- Abstract Dark shapes/gradients -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] to-black opacity-90 z-10"></div>
        <!-- Decorative Circle (Different Position for Variety) -->
        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-[#1c1c1c] blur-[120px] opacity-20"></div>
        
        <!-- Optional Geometric Accent -->
        <div class="absolute right-20 bottom-20 w-32 h-32 border border-[#374151] opacity-20 rotate-45"></div>

        <div class="absolute inset-0 flex items-center justify-center z-20">
            <h2 class="text-[#374151] text-9xl font-bold tracking-widest opacity-10 select-none">CLIENTE</h2>
        </div>
    </div>

</body>
</html>
