<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Registro de Negocio</title>
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
        <div class="flex-grow flex flex-col justify-center max-w-md mx-auto w-full group">
            
            <!-- Step Indicators -->
            <div class="flex items-center space-x-2 mb-10">
                <div id="step-dot-1" class="h-1 w-8 bg-white transition-all duration-300"></div>
                <div id="step-dot-2" class="h-1 w-8 bg-[#374151] transition-all duration-300"></div>
            </div>

            <form id="business-form" class="space-y-8" onsubmit="event.preventDefault();">
                
                <!-- STEP 1: Account Info -->
                <div id="step-1" class="space-y-8 animate-fade-in-up">
                    <div class="space-y-2">
                        <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Registro</h1>
                        <p class="text-[#9CA3AF] text-sm tracking-wide">RELLENA LOS SIGUIENTES REQUISITOS</p>
                    </div>

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
                            <input type="text" id="user_city" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Ciudad" />
                            <label for="user_city" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Ciudad</label>
                        </div>
                    </div>

                    <button type="button" onclick="nextStep()" class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6] mt-8">
                        Continuar
                    </button>
                </div>

                <!-- STEP 2: Business Info -->
                <div id="step-2" class="hidden space-y-8 animate-fade-in-up">
                     <div class="space-y-2">
                        <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Mi negocio</h1>
                        <p class="text-[#9CA3AF] text-sm tracking-wide">DETALLES DEL COMERCIO</p>
                    </div>

                    <div class="grid grid-cols-1 gap-8">
                         <!-- Description -->
                        <div class="group/input relative">
                            <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF] mb-2">Acerca de mi negocio</h3>
                            <textarea id="description" rows="3" class="w-full bg-transparent border border-[#374151] p-3 text-white focus:border-white focus:outline-none transition-colors text-sm" placeholder="Añade una pequeña descripción..."></textarea>
                        </div>

                         <!-- Photo Upload -->
                        <div class="group/input relative">
                             <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF] mb-2">Foto del negocio</h3>
                            <div class="border border-dashed border-[#374151] h-32 w-full flex items-center justify-center text-[#9CA3AF] hover:border-white hover:text-white transition-all cursor-pointer">
                                <span class="text-xs uppercase tracking-wide">Subir Imagen</span>
                            </div>
                        </div>

                        <!-- Business Fields -->
                        <div class="space-y-6">
                            <div class="group/input relative">
                                <input type="text" id="business_name" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Nombre del negocio" />
                                <label for="business_name" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Nombre del negocio</label>
                            </div>
                             <div class="group/input relative">
                                <input type="text" id="state" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Estado" />
                                <label for="state" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Estado</label>
                            </div>
                             <div class="group/input relative">
                                <input type="text" id="city" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Ciudad" />
                                <label for="city" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Ciudad</label>
                            </div>
                             <div class="group/input relative">
                                <input type="text" id="address" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Dirección" />
                                <label for="address" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Dirección</label>
                            </div>
                             <div class="group/input relative">
                                <input type="text" id="type" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Tipo de negocio" />
                                <label for="type" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Tipo de negocio</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                         <button type="button" onclick="prevStep()" class="w-1/3 py-4 px-6 bg-transparent text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:border-white">
                            Atrás
                        </button>
                        <button type="submit" class="flex-grow py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                            Finalizar
                        </button>
                    </div>
                </div>

            </form>
        </div>
        
        <!-- Footer -->
        <div class="mt-12 text-center">
            <p class="text-[#374151] text-xs tracking-wider">© 2026 NEXOAPP INC.</p>
        </div>

    </div>

    <!-- Right Side: Visual (Abstract Art) -->
    <div class="hidden lg:block w-[55%] h-full relative overflow-hidden bg-[#0a0a0a]">
        <!-- Abstract Dark shapes/gradients -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#1a1a1a] to-black opacity-90 z-10"></div>
        <!-- Decorative Circle -->
        <div class="absolute -right-20 -top-20 w-[600px] h-[600px] rounded-full bg-[#262626] blur-[100px] opacity-30"></div>
        <div class="absolute -left-20 -bottom-20 w-[500px] h-[500px] rounded-full bg-[#262626] blur-[80px] opacity-20"></div>
        
        <div class="absolute inset-0 flex items-center justify-center z-20">
            <h2 class="text-[#374151] text-9xl font-bold tracking-widest opacity-10 select-none">NEXO</h2>
        </div>
    </div>

    <!-- Script for Wizard Logic -->
    <script>
        function nextStep() {
            // In a real app, validate step 1 here
            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
            
            document.getElementById('step-dot-1').classList.replace('bg-white', 'bg-[#374151]');
            document.getElementById('step-dot-1').classList.add('opacity-50');
            document.getElementById('step-dot-2').classList.replace('bg-[#374151]', 'bg-white');
            
            // Scroll to top of form
            document.querySelector('.overflow-y-auto').scrollTop = 0;
        }

        function prevStep() {
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-1').classList.remove('hidden');
            
            document.getElementById('step-dot-2').classList.replace('bg-white', 'bg-[#374151]');
            document.getElementById('step-dot-1').classList.replace('bg-[#374151]', 'bg-white');
            document.getElementById('step-dot-1').classList.remove('opacity-50');
        }
    </script>
</body>
</html>
