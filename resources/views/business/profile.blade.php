<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Mi Negocio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
        <div class="text-xl tracking-widest font-bold uppercase text-white">
            NexoApp
        </div>
        <div class="flex items-center gap-6">
            <span class="text-xs uppercase tracking-widest text-[#9CA3AF]">Hola, Urban Fade</span>
            <div class="h-8 w-8 rounded-full bg-[#374151] overflow-hidden border border-[#374151]">
                <!-- Avatar placeholder -->
                <svg class="h-full w-full text-[#9CA3AF]" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-12">
        
        <!-- Header Section -->
        <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6">
            <div>
                <h1 class="text-4xl font-bold uppercase tracking-wide text-white mb-2">Mi Negocio</h1>
                <p class="text-[#9CA3AF] text-sm tracking-wide">GESTIONA TU PERFIL Y SERVICIOS</p>
            </div>
            
            <!-- Tabs Navigation -->
            <div class="flex space-x-1 bg-[#0f0f0f] p-1 border border-[#374151]/50 rounded-sm">
                <button onclick="switchTab('info')" id="tab-btn-info" class="px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#1a1a1a] bg-[#F3F4F6]">
                    Información
                </button>
                <button onclick="switchTab('services')" id="tab-btn-services" class="px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Servicios
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="relative min-h-[600px]">
            
            <!-- TAB 1: INFORMACIÓN -->
            <section id="tab-info" class="animate-fade-in-up">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    <!-- Left: Form -->
                    <div class="space-y-8">
                        <form class="space-y-8" onsubmit="event.preventDefault();">
                            <div class="space-y-6">
                                <div class="group/input relative">
                                    <input type="text" value="Urban Fade Studio" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Nombre del Negocio" />
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Nombre del Negocio</label>
                                </div>
                                
                                <div class="group/input relative">
                                    <input type="text" value="Barbería & Spa" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Tipo de Negocio" />
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Tipo de Negocio</label>
                                </div>

                                <div class="group/input relative">
                                    <textarea rows="4" class="peer w-full bg-transparent border border-[#374151] p-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent text-sm">Somos especialistas en cortes modernos y cuidado de la barba. Ofrecemos una experiencia premium con bebidas de cortesía y ambiente relajado.</textarea>
                                    <label class="absolute left-3 -top-2.5 bg-[#1a1a1a] px-1 text-[#9CA3AF] text-xs transition-all peer-focus:text-white">Acerca de mi negocio</label>
                                </div>
                            </div>

                            <!-- Branding Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Profile Photo -->
                                <div class="space-y-2">
                                    <span class="text-[#9CA3AF] text-xs uppercase tracking-wider">Foto de Perfil</span>
                                    <div class="h-32 w-full bg-[#262626] border border-dashed border-[#374151] flex flex-col items-center justify-center text-[#374151] hover:text-white hover:border-white transition-all cursor-pointer group">
                                        <div class="w-12 h-12 rounded-full border border-[#374151] flex items-center justify-center mb-2 group-hover:border-white transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <span class="text-[10px] uppercase tracking-widest">Subir Logo</span>
                                    </div>
                                </div>

                                <!-- Banner -->
                                <div class="space-y-2">
                                    <span class="text-[#9CA3AF] text-xs uppercase tracking-wider">Banner</span>
                                    <div class="h-32 w-full bg-[#262626] border border-dashed border-[#374151] flex flex-col items-center justify-center text-[#374151] hover:text-white hover:border-white transition-all cursor-pointer">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-[10px] uppercase tracking-widest">Subir Portada</span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF]">Fotos de mi negocio</h3>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="aspect-square bg-[#262626] border border-[#374151] flex items-center justify-center cursor-pointer hover:border-white transition-colors">
                                        <span class="text-2xl text-[#374151]">+</span>
                                    </div>
                                    <div class="aspect-square bg-[#262626] border border-[#374151]"></div>
                                    <div class="aspect-square bg-[#262626] border border-[#374151]"></div>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <button class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-black hover:text-white hover:border-[#F3F4F6]">
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Profile Visual -->
                    <div class="flex flex-col items-center justify-center border border-[#374151]/30 bg-[#0f0f0f] p-12 relative overflow-hidden">
                         <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiMzNzQxNTEiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] opacity-20"></div>
                        
                        <div class="relative z-10 text-center">
                            <div class="w-32 h-32 rounded-full bg-[#262626] border-2 border-[#374151] mx-auto mb-6 flex items-center justify-center overflow-hidden group cursor-pointer hover:border-white transition-colors">
                                <svg class="w-16 h-16 text-[#374151] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-white uppercase tracking-wide">Urban Fade Studio</h2>
                            <p class="text-[#9CA3AF] text-sm mt-1">Barbería & Spa</p>
                            <div class="mt-6 flex justify-center gap-2">
                                <span class="px-3 py-1 bg-[#374151]/30 border border-[#374151] text-[10px] uppercase text-[#9CA3AF] tracking-widest">Ver Perfil Público</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TAB 2: SERVICIOS -->
            <section id="tab-services" class="hidden animate-fade-in-up">
                <div class="flex flex-col lg:flex-row gap-12">
                    
                    <!-- Left: Services List -->
                    <div class="w-full lg:w-1/2 space-y-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold uppercase tracking-wide text-white">Mis Servicios</h2>
                            <span class="text-xs text-[#9CA3AF] tracking-widest">TOTAL: 2</span>
                        </div>

                        <!-- Service Card Example -->
                        <div class="flex bg-[#1a1a1a] border border-[#374151] p-4 gap-4 hover:border-[#F3F4F6]/50 transition-colors group cursor-pointer">
                            <div class="w-24 h-24 bg-[#262626] shrink-0"></div>
                            <div class="flex-grow flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-white font-bold uppercase tracking-wide text-sm">Corte Clásico</h3>
                                        <p class="text-[#9CA3AF] text-[10px] mt-1">Incluye lavado y peinado.</p>
                                    </div>
                                    <span class="text-lg font-bold text-white">$25.00</span>
                                </div>
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-[10px] uppercase tracking-widest text-[#9CA3AF] hover:text-white">Editar</button>
                                    <button class="text-[10px] uppercase tracking-widest text-red-500 hover:text-red-400">Eliminar</button>
                                </div>
                            </div>
                        </div>

                        <div class="flex bg-[#1a1a1a] border border-[#374151] p-4 gap-4 hover:border-[#F3F4F6]/50 transition-colors group cursor-pointer">
                            <div class="w-24 h-24 bg-[#262626] shrink-0"></div>
                            <div class="flex-grow flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-white font-bold uppercase tracking-wide text-sm">Afeitado Navaja</h3>
                                        <p class="text-[#9CA3AF] text-[10px] mt-1">Toalla caliente y aceites esenciales.</p>
                                    </div>
                                    <span class="text-lg font-bold text-white">$15.00</span>
                                </div>
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-[10px] uppercase tracking-widest text-[#9CA3AF] hover:text-white">Editar</button>
                                    <button class="text-[10px] uppercase tracking-widest text-red-500 hover:text-red-400">Eliminar</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right: Add Service Form -->
                    <div class="w-full lg:w-1/2 border-l border-[#374151]/30 lg:pl-12">
                         <div class="mb-8">
                            <h2 class="text-3xl font-bold uppercase tracking-wide text-white">Agregar Servicio</h2>
                            <p class="text-[#9CA3AF] text-xs mt-2 tracking-wide">COMPLETA LOS DETALLES DEL NUEVO SERVICIO</p>
                        </div>
                        
                        <form class="space-y-6" onsubmit="event.preventDefault();">
                             <div class="group/input relative">
                                <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Nombre del servicio" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Nombre del servicio</label>
                            </div>

                            <div class="group/input relative">
                                <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Descripción breve" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Descripción breve</label>
                            </div>

                            <div class="group/input relative">
                                <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Precio" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Precio</label>
                            </div>

                            <div class="space-y-2">
                                <span class="text-[#9CA3AF] text-xs">Imagen del servicio (opcional)</span>
                                <div class="h-32 w-full bg-[#262626] border border-dashed border-[#374151] flex items-center justify-center text-[#374151] hover:text-white hover:border-white transition-all cursor-pointer">
                                    <span class="text-xs uppercase tracking-widest">Subir Foto</span>
                                </div>
                            </div>

                             <button class="w-full py-4 px-6 bg-[#1a1a1a] text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#F3F4F6] hover:text-[#1a1a1a] mt-4">
                                Agregar Servicio
                            </button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </main>

    <script>
        function switchTab(tab) {
            const tabs = ['info', 'services'];
            
            tabs.forEach(t => {
                const section = document.getElementById(`tab-${t}`);
                const btn = document.getElementById(`tab-btn-${t}`);
                
                if (t === tab) {
                    section.classList.remove('hidden');
                    // Active Styles
                    btn.classList.add('bg-[#F3F4F6]', 'text-[#1a1a1a]');
                    btn.classList.remove('text-[#9CA3AF]', 'hover:text-white');
                } else {
                    section.classList.add('hidden');
                    // Inactive Styles
                    btn.classList.remove('bg-[#F3F4F6]', 'text-[#1a1a1a]');
                    btn.classList.add('text-[#9CA3AF]', 'hover:text-white');
                }
            });
        }
    </script>
</body>
</html>
