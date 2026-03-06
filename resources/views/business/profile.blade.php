@php
    $correo = session('usuario.correo') ?? session('usuario');
    $inicial = $correo ? strtoupper(substr($correo, 0, 1)) : '?';
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Mi Negocio</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
    
    <a href="{{ url('/') }}" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
        NexoApp
    </a>

    <div class="flex items-center gap-4">

        <span class="text-xs uppercase tracking-widest text-[#9CA3AF] hidden md:block">
            Hola, {{ $correo }}
        </span>

        <div class="h-9 w-9 rounded-full 
                    bg-gradient-to-br from-[#374151] to-black 
                    flex items-center justify-center 
                    text-white font-bold text-sm 
                    shadow-md">
            {{ $inicial }}
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
                <button onclick="switchTab('finances')" id="tab-btn-finances" class="px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Finanzas
                </button>
                <button onclick="switchTab('personnel')" id="tab-btn-personnel" class="px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Personal
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

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="group/input relative">
                                        <input type="tel" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Teléfono" />
                                        <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Teléfono</label>
                                    </div>
                                    <div class="group/input relative">
                                        <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Redes Sociales" />
                                        <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Redes Sociales (Link)</label>
                                    </div>
                                </div>

                                <div class="group/input relative">
                                    <textarea rows="4" class="peer w-full bg-transparent border border-[#374151] p-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent text-sm">Somos especialistas en cortes modernos y cuidado de la barba. Ofrecemos una experiencia premium con bebidas de cortesía y ambiente relajado.</textarea>
                                    <label class="absolute left-3 -top-2.5 bg-[#1a1a1a] px-1 text-[#9CA3AF] text-xs transition-all peer-focus:text-white">Acerca de mi negocio</label>
                                </div>

                                <div class="border-t border-[#374151] pt-2">
                                    <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF] mb-4">Dirección</h3>
                                    
                                    <!-- Street & Number -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                        <div class="group/input relative md:col-span-2">
                                            <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Calle" />
                                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Calle</label>
                                        </div>
                                        <div class="group/input relative">
                                            <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Número" />
                                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Número</label>
                                        </div>
                                    </div>

                                    <!-- Colony & Zip -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div class="group/input relative">
                                            <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Colonia" />
                                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Colonia</label>
                                        </div>
                                        <div class="group/input relative">
                                            <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Código Postal" />
                                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Código Postal</label>
                                        </div>
                                    </div>
                                    
                                    <!-- City & State -->
                                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="group/input relative">
                                            <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Ciudad" />
                                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Ciudad</label>
                                        </div>
                                         <div class="group/input relative">
                                            <input type="text" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Estado" />
                                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Estado</label>
                                        </div>
                                    </div>
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
                            @if(isset($services) && count($services) > 0)
    <span id="services-total"
          class="text-xs text-[#9CA3AF] tracking-widest">
        TOTAL: {{ count($services) }}
    </span>
@endif
                        </div>

                        <!-- Service Card Example -->
                    
                        @foreach($services as $service)


<div id="service-{{ $service['id'] }}"
    class="service-card flex bg-[#1a1a1a] border border-[#374151] p-4 gap-4 hover:border-[#F3F4F6]/50 transition-all duration-300 group">

    {{-- IMAGEN --}}
    <div class="w-24 h-24 shrink-0 bg-[#262626] rounded overflow-hidden">

    @if($service['imagen'])
        <img 
            src="{{ $service['imagen'] }}" 
            class="block w-24 h-24 object-cover"
        >
    @else
        <div class="w-24 h-24 flex items-center justify-center text-[#374151] text-xs">
            SIN IMAGEN
        </div>
    @endif

</div>

    

    {{-- CONTENIDO --}}
    <div class="flex-grow flex flex-col justify-between">
        
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-white font-bold uppercase tracking-wide text-sm">
                    {{ $service['nombre'] }}
                </h3>
                <p class="text-[#9CA3AF] text-[10px] mt-1">
                    {{ $service['descripcion'] ?? 'Sin descripción' }}
                </p>
            </div>

            <span class="text-lg font-bold text-white">
                ${{ $service['precio'] }}
            </span>
        </div>

        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <button 
                onclick='openEditModal(
                    @json($service["id"]),
                    @json($service["nombre"]),
                    @json($service["descripcion"] ?? ""),
                    @json($service["precio"]),
                    @json($service["duracion"] ?? 0),
                    @json($service["imagen"] ?? null)
                )'
                class="text-[10px] uppercase tracking-widest text-[#9CA3AF] hover:text-white">
                Editar
            </button>

            <button 
                onclick="openDeleteModal({{ $service['id'] }}, '{{ $service['nombre'] }}')"
                class="text-[10px] uppercase tracking-widest text-red-500 hover:text-red-400">
                Eliminar
            </button>
        </div>

    </div>

</div>


@endforeach


                    </div>

                    <!-- Right: Add Service Form -->
                    <div class="w-full lg:w-1/2 border-l border-[#374151]/30 lg:pl-12">
    <div class="mb-8">
        <h2 class="text-3xl font-bold uppercase tracking-wide text-white">
            Agregar Servicio
        </h2>
        <p class="text-[#9CA3AF] text-xs mt-2 tracking-wide">
            COMPLETA LOS DETALLES DEL NUEVO SERVICIO
        </p>
    </div>

    <form method="POST"
      action="{{ route('business.services.store') }}"
      enctype="multipart/form-data"
      class="space-y-6">
        @csrf

        {{-- NOMBRE --}}
        <div class="group/input relative">
            <input 
                type="text" 
                name="nombre"
                value="{{ old('nombre') }}"
                maxlength="100"
                required
                class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" 
                placeholder="Nombre del servicio" />
            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                Nombre del servicio
            </label>
            @error('nombre')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="group/input relative">
            <input 
                type="text" 
                name="descripcion"
                value="{{ old('descripcion') }}"
                maxlength="255"
                class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" 
                placeholder="Descripción breve" />
            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                Descripción breve
            </label>
            @error('descripcion')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">
        Imagen del servicio
    </label>
    <input type="file"
           name="imagen"
           accept="image/*"
           class="w-full text-xs text-[#9CA3AF]">
</div>

        {{-- PRECIO --}}
        <div class="group/input relative">
            <input 
                type="number" 
                name="precio"
                value="{{ old('precio') }}"
                min="1"
                max="10000"
                step="0.01"
                required
                class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" 
                placeholder="Precio" />
            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                Precio
            </label>
            @error('precio')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- DURACIÓN --}}
        <div class="group/input relative">
            <input 
                type="number" 
                name="duracion"
                value="{{ old('duracion') }}"
                min="5"
                max="480"
                required
                class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" 
                placeholder="Duración (Minutos)" />
            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                Duración (Minutos)
            </label>
            @error('duracion')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit"
            class="w-full py-4 px-6 bg-[#1a1a1a] text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#F3F4F6] hover:text-[#1a1a1a] mt-4">
            Agregar Servicio
        </button>
    </form>
</div>

                </div>
            </section>

            <!-- TAB 3: FINANZAS -->
            <section id="tab-finances" class="hidden animate-fade-in-up">
                
                <div class="mb-8">
                    <h2 class="text-xl font-bold uppercase tracking-wide text-white mb-6">Resumen de la salud de tu negocio</h2>
                    
                    <!-- KPI Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <!-- Card 1: Ingresos Hoy -->
                        <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                            <div class="flex justify-between items-start">
                                <div class="w-10 h-10 flex items-center justify-center text-emerald-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-white flex items-center gap-1">
                                    +12% <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                </span>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-white tracking-tight mb-1">$150.00</div>
                                <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Ingresos Hoy</div>
                            </div>
                        </div>

                        <!-- Card 2: Citas Hoy -->
                        <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                            <div class="flex justify-between items-start">
                                <div class="w-10 h-10 flex items-center justify-center text-blue-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-red-500 flex items-center gap-1">
                                    -5% <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                </span>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-white tracking-tight mb-1">12</div>
                                <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Citas Hoy</div>
                            </div>
                        </div>

                        <!-- Card 3: Ingresos Mes -->
                        <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                            <div class="flex justify-between items-start">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <svg class="w-8 h-8" fill="none" stroke="#A855F7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-white flex items-center gap-1">
                                    +8% <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                </span>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-white tracking-tight mb-1">$4,250</div>
                                <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Ingresos Mes</div>
                            </div>
                        </div>



                    </div>
                </div>

                <!-- Weekly Income Chart -->
                <div class="border border-[#374151] bg-[#1a1a1a] p-6 rounded-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold uppercase tracking-wide text-white">Ingresos Semanales</h2>
                        <select class="bg-[#262626] text-white text-xs uppercase tracking-wider border border-[#374151] px-3 py-1 outline-none focus:border-white transition-colors">
                            <option>Esta Semana</option>
                            <option>Semana Pasada</option>
                        </select>
                    </div>
                    <div class="relative h-64 w-full">
                        <canvas id="weeklyIncomeChart"></canvas>
                    </div>
                </div>

                <!-- Top Services Section -->
                <div class="mt-6 border border-[#374151] bg-[#1a1a1a] p-6 rounded-sm">
                    <h2 class="text-xl font-bold uppercase tracking-wide text-white mb-6">Servicios Top</h2>
                    
                    <div class="space-y-6">


                        <!-- Service 1 -->
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-white font-bold text-sm w-32 shrink-0">Corte Clásico</span>
                        </div>

                        <!-- Service 2 -->
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-white font-bold text-sm w-32 shrink-0">Barba Premium</span>
                            <div class="flex-1 rounded-full overflow-hidden" style="height: 8px; background-color: #333333;">
                                <div class="h-full rounded-full" style="width: 45%; background-color: #ffffff;"></div>
                            </div>
                            <span class="text-[#9CA3AF] text-sm w-8 text-right">28</span>
                        </div>

                        <!-- Service 3 -->
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-white font-bold text-sm w-32 shrink-0">Corte + Barba</span>
                            <div class="flex-1 rounded-full overflow-hidden" style="height: 8px; background-color: #333333;">
                                <div class="h-full rounded-full" style="width: 25%; background-color: #ffffff;"></div>
                            </div>
                            <span class="text-[#9CA3AF] text-sm w-8 text-right">15</span>
                        </div>
                    </div>
                </div>

            </section>

            <!-- TAB 4: PERSONAL -->
            <section id="tab-personnel" class="hidden animate-fade-in-up">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold uppercase tracking-wide text-white">Equipo de Trabajo</h2>
                    <button id="btn-add-employee" class="bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors rounded-sm">
                        + Agregar Empleado
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Employee Card 1 -->
                    <div class="bg-[#262626] border border-[#374151]/50 p-6 flex items-center justify-between group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                        <div class="flex items-center gap-4">
                            <!-- Initials Avatar -->
                            <div class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-white font-bold text-lg border border-[#4B5563]">
                                J
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Juan Pérez</h3>
                                <p class="text-[#9CA3AF] text-xs">Barbero Senior</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                Activo
                            </span>
                            <div class="flex gap-2">
                                <button class="text-[#9CA3AF] hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="text-[#9CA3AF] hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Card 2 -->
                    <div class="bg-[#262626] border border-[#374151]/50 p-6 flex items-center justify-between group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                        <div class="flex items-center gap-4">
                            <!-- Initials Avatar -->
                            <div class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-white font-bold text-lg border border-[#4B5563]">
                                C
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Carlos Ruiz</h3>
                                <p class="text-[#9CA3AF] text-xs">Estilista</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">
                                Inactivo
                            </span>
                            <div class="flex gap-2">
                                <button class="text-[#9CA3AF] hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="text-[#9CA3AF] hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- Modal Agregar Empleado -->
    <div id="modal-add-employee" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="toggleModal('modal-add-employee', false)"></div>
        
        <!-- Content -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-[#1a1a1a] border border-[#374151] shadow-2xl rounded-sm p-8 animate-fade-in-up">
            <div class="flex flex-col items-center mb-6">
                <h3 class="text-xl font-bold uppercase tracking-wide text-white mb-4">Nuevo Empleado</h3>
            </div>
            
            <form class="space-y-6" onsubmit="event.preventDefault(); toggleModal('modal-add-employee', false);">
                
                <!-- Sección 1 -->
                <div>
                    <h4 class="text-[#9CA3AF] text-xs uppercase tracking-widest mb-4">Información Personal</h4>
                    
                    <!-- Nombre -->
                    <div class="group/input relative mb-4">
                        <input type="text" id="emp_name" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Nombre Completo" />
                        <label for="emp_name" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Nombre Completo</label>
                    </div>

                    <!-- Teléfono -->
                    <div class="group/input relative">
                        <input type="tel" id="emp_phone" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Teléfono" />
                        <label for="emp_phone" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Teléfono</label>
                    </div>
                </div>

                <!-- Sección 2 -->
                <div>
                    <h4 class="text-[#9CA3AF] text-xs uppercase tracking-widest mb-4 mt-6">Detalles del Cargo</h4>

                    <!-- Cargo -->
                    <div class="group/input relative mb-4">
                        <input type="text" id="emp_role_text" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Cargo (ej. Barbero)" />
                        <label for="emp_role_text" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Cargo (ej. Barbero, Recepcionista)</label>
                    </div>

                    <!-- Comisión -->
                    <div class="group/input relative mb-6">
                        <input type="number" id="emp_commission" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Comisión (%)" />
                        <label for="emp_commission" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Comisión (%)</label>
                    </div>

                    <!-- Estado Toggle -->
                    <div class="bg-[#262626] p-4 rounded-sm flex items-center justify-between border border-[#374151]/50">
                        <span class="text-white text-sm font-bold">Estado Activo</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                <!-- Botón Submit -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-white text-black py-3 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors rounded-sm shadow-lg">
                        Crear Empleado
                    </button>
                    <button type="button" onclick="toggleModal('modal-add-employee', false)" class="w-full mt-2 text-[#9CA3AF] py-2 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-edit-service" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="closeEditModal()"></div>

    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
                bg-[#1a1a1a] border border-[#374151] p-8 w-full max-w-md">

        <h3 id="editModalTitle" class="text-white font-bold mb-6 uppercase">
    Editar Servicio
</h3>

        <form method="POST"
      id="editServiceForm"
      enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <div class="space-y-5">

    <!-- 🔥 PREVIEW IMAGEN -->
    <div>
        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">
            Imagen actual
        </label>

        <img id="edit_imagen_preview"
             class="w-full h-40 object-cover rounded-lg mb-3 hidden border border-[#374151]"
             alt="Imagen del servicio">
    </div>

    <!-- 🔥 INPUT IMAGEN -->
    <div>
        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">
            Cambiar imagen
        </label>
        <input type="file"
               name="imagen"
               id="edit_imagen"
               accept="image/*"
               class="w-full text-xs text-[#9CA3AF]">
    </div>

    <div>
        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">
            Nombre del servicio
        </label>
        <input type="text"
               name="nombre"
               id="edit_nombre"
               maxlength="100"
               required
               class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
    </div>

    <div>
        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">
            Descripción
        </label>
        <input type="text"
               name="descripcion"
               id="edit_descripcion"
               maxlength="255"
               class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
    </div>

    <div>
        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">
            Precio ($)
        </label>
        <input type="number"
               name="precio"
               id="edit_precio"
               min="1"
               max="10000"
               step="0.01"
               required
               class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
    </div>

    <div>
        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">
            Duración (minutos)
        </label>
        <input type="number"
               name="duracion"
               id="edit_duracion"
               min="5"
               max="480"
               required
               class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
    </div>

</div>

<button class="mt-6 w-full bg-white text-black py-2 uppercase text-xs font-bold">
    Guardar Cambios
</button>
        </form>
    </div>
</div>

<div id="modal-delete-service" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="closeDeleteModal()"></div>

    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
                bg-[#1a1a1a] border border-[#374151] p-8 w-full max-w-md">

        <h3 class="text-red-500 font-bold mb-4 uppercase">
            Confirmar eliminación
        </h3>

        <p class="text-white text-sm mb-6">
            ¿Estás seguro que deseas eliminar 
            <span id="deleteServiceName" class="font-bold"></span>?
        </p>

        <form method="POST" id="deleteServiceForm">
            @csrf
            @method('DELETE')

            <div class="flex gap-4">
                <button type="button" 
                    onclick="closeDeleteModal()"
                    class="w-1/2 py-2 border border-[#374151] text-white text-xs uppercase">
                    Cancelar
                </button>

                <button type="submit"
                    class="w-1/2 py-2 bg-red-600 text-white text-xs uppercase font-bold hover:bg-red-700">
                    Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

<div id="global-loader" class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black/70">
    <div class="w-10 h-10 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
</div>

<div id="toast"
     class="fixed bottom-6 right-6 hidden bg-[#1a1a1a] border border-[#374151] text-white px-6 py-3 text-sm uppercase tracking-widest shadow-lg">
</div>

    <script>
        function switchTab(tab) {
            const tabs = ['info', 'services', 'finances', 'personnel'];
            
            tabs.forEach(t => {
                const section = document.getElementById(`tab-${t}`);
                const btn = document.getElementById(`tab-btn-${t}`);
                
                if (t === tab) {
                    section.classList.remove('hidden');
                    // Active Styles
                    btn.classList.add('bg-[#F3F4F6]', 'text-[#1a1a1a]');
                    btn.classList.remove('text-[#9CA3AF]', 'hover:text-white');
                    
                    // Resize chart if finances tab is opened
                    if (t === 'finances' && window.myChart) {
                        setTimeout(() => {
                           window.myChart.resize();
                        }, 100);
                    }
                } else {
                    section.classList.add('hidden');
                    // Inactive Styles
                    btn.classList.remove('bg-[#F3F4F6]', 'text-[#1a1a1a]');
                    btn.classList.add('text-[#9CA3AF]', 'hover:text-white');
                }
            });
        }

        function openEditModal(id, nombre, descripcion, precio, duracion, imagen) {

    document.getElementById('modal-edit-service').classList.remove('hidden');

    document.getElementById('editModalTitle').innerText =
        `Editando: ${nombre}`;

    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('edit_precio').value = precio;
    document.getElementById('edit_duracion').value = duracion;

    // 🔥 NUEVO: Mostrar imagen actual
    const preview = document.getElementById('edit_imagen_preview');

if (imagen) {
    preview.src = imagen;
    preview.classList.remove('hidden');
} else {
    preview.src = '';
    preview.classList.add('hidden');
}

    document.getElementById('editServiceForm').action =
        `/business/services/${id}`;
}

function openDeleteModal(id, nombre) {
    document.getElementById('modal-delete-service').classList.remove('hidden');
    document.getElementById('deleteServiceName').innerText = nombre;
    document.getElementById('deleteServiceForm').action = `/business/services/${id}`;
}

function closeDeleteModal() {
    document.getElementById('modal-delete-service').classList.add('hidden');
}

document.getElementById('deleteServiceForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const url = form.action;
    const serviceId = url.split('/').pop();
    const card = document.getElementById(`service-${serviceId}`);

    showLoader();

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams(new FormData(form))
    })
    .then(() => {
        hideLoader();

        // Animación fade out
        card.style.opacity = '0';
        card.style.transform = 'translateX(20px)';

        setTimeout(() => {
    card.remove();

    // 🔥 ACTUALIZAR CONTADOR
    const totalElement = document.getElementById('services-total');
const newTotal = document.querySelectorAll('.service-card').length;
totalElement.dataset.count = newTotal;
totalElement.innerText = "TOTAL: " + newTotal;

    showToast("Servicio eliminado correctamente");
}, 300);

        closeDeleteModal();
    });
});

    
function closeEditModal() {
    document.getElementById('modal-edit-service').classList.add('hidden');
}


        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            // Modal Logic
            const btnAddEmployee = document.getElementById('btn-add-employee');
            if (btnAddEmployee) {
                btnAddEmployee.addEventListener('click', () => toggleModal('modal-add-employee', true));
            }

            // Chart Logic
            const ctx = document.getElementById('weeklyIncomeChart').getContext('2d');
            
            // Gradient for bars
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, '#A855F7'); // Purple start
            gradient.addColorStop(1, '#3B82F6'); // Blue end

            window.myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    datasets: [{
                        label: 'Ingresos ($)',
                        data: [120, 190, 150, 250, 320, 450, 280],
                        backgroundColor: gradient,
                        borderRadius: 4,
                        hoverBackgroundColor: '#F3F4F6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#262626',
                            titleColor: '#F3F4F6',
                            bodyColor: '#9CA3AF',
                            borderColor: '#374151',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '$ ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#374151',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9CA3AF',
                                font: {
                                    family: 'sans-serif',
                                    size: 10
                                },
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9CA3AF',
                                font: {
                                    family: 'sans-serif',
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        });

        // Toggle Modal Helper
        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        function showLoader() {
    document.getElementById('global-loader').classList.remove('hidden');
}

function hideLoader() {
    document.getElementById('global-loader').classList.add('hidden');
}

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.innerText = message;
    toast.classList.remove('hidden');
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(10px)';

    setTimeout(() => {
        toast.style.transition = 'all 0.3s ease';
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 10);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 300);
    }, 3000);
}


    </script>



</body>
</html>
