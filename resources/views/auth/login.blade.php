<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Iniciar Sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased flex flex-col relative overflow-hidden">

    <!-- Background Elements -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiMzNzQxNTEiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] opacity-20 z-0"></div>
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-black/50 via-transparent to-black/50 z-0 pointer-events-none"></div>

    <!-- Navbar Minimalista -->
    <header class="w-full py-6 px-8 flex justify-between items-center relative z-10">
        <div class="text-xl tracking-widest font-bold uppercase text-white">
            NexoApp
        </div>
        <a href="/" class="text-xs tracking-widest text-[#9CA3AF] hover:text-white uppercase transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al Inicio
        </a>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col justify-center items-center px-4 relative z-10">
        
        <!-- Centered Card -->
        <div class="w-full max-w-md bg-[#1a1a1a] border border-[#374151] p-8 md:p-12 shadow-2xl animate-fade-in-up">
            
            <!-- Card Header -->
            <div class="mb-10 text-center">
                <a href="/register" class="inline-flex items-center text-[10px] tracking-widest uppercase text-[#9CA3AF] hover:text-white mb-6 transition-colors font-bold">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Atrás
                </a>
                <h1 class="text-3xl font-bold uppercase tracking-wide text-white mb-2">
                    Iniciar Sesión
                </h1>
                <p class="text-[#9CA3AF] text-xs tracking-wide">
                    RELLENA LOS SIGUIENTES REQUISITOS
                </p>
            </div>

            <!-- Login Form -->
            <form class="space-y-8" onsubmit="event.preventDefault();">
                
                <div class="space-y-6">
                    <div class="group/input relative">
                        <input type="email" id="email" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Email Address" />
                        <label for="email" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Email Address</label>
                    </div>
                    
                    <div class="group/input relative">
                        <input type="password" id="password" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Contraseña" />
                        <label for="password" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Contraseña</label>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 cursor-pointer text-[#9CA3AF] hover:text-white transition-colors">
                        <input type="checkbox" class="form-checkbox h-3 w-3 bg-transparent border border-[#374151] rounded-none checked:bg-white checked:border-white focus:ring-0 text-black appearance-none transition duration-200 cursor-pointer" />
                        <span class="tracking-wide">Recordarme</span>
                    </label>
                    <a href="#" class="text-[#9CA3AF] hover:text-white underline decoration-1 underline-offset-4 tracking-wide transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <button type="submit" class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                    Iniciar Sesión
                </button>

                <div class="text-center pt-4">
                    <p class="text-[#9CA3AF] text-xs">
                        ¿Aún no tienes cuenta? 
                        <a href="/register" class="text-white font-bold tracking-widest uppercase ml-1 hover:underline decoration-1 underline-offset-4 transition-all">
                            Regístrate
                        </a>
                    </p>
                </div>

            </form>
        </div>
        
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center relative z-10">
        <p class="text-[#374151] text-[10px] tracking-widest uppercase">© 2026 NexoApp Inc.</p>
    </footer>

</body>
</html>
