@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <!-- Main Content -->
    <main class="flex-grow">
        
        <!-- Hero Section -->
        @if(session('rol') === 'cliente' && session()->has('usuario'))
            <!-- Hero para Cliente Autenticado -->
            <section class="max-w-7xl mx-auto px-6 py-20 md:py-32">
                <div class="max-w-3xl space-y-8 animate-fade-in-up">
                    <h1 class="text-5xl md:text-7xl font-bold uppercase tracking-wide text-white leading-tight">
                        Hola, <br/>
                        <span class="text-[#25B5DA]">{{ session('usuario')['nombre_completo'] ?? session('usuario')['nombre'] ?? 'Usuario' }}!</span>
                    </h1>
                    
                    <p class="text-[#9CA3AF] text-lg leading-relaxed max-w-2xl border-l border-[#25B5DA]/50 pl-6">
                        Explora los mejores negocios cerca de ti. Encuentra servicios exclusivos, reserva en segundos y disfruta de la mejor calidad.
                    </p>
                    
                    <div class="pt-4">
                        <a href="/mis-citas" class="inline-block py-4 px-10 bg-[#25B5DA] text-[#1a1a1a] text-sm font-bold uppercase tracking-[0.2em] hover:bg-[#25B5DA] hover:shadow-lg hover:shadow-[#25B5DA]/20 transition-all duration-300 transform hover:-translate-y-1 rounded-sm">
                            Ver Mis Citas
                        </a>
                    </div>
                </div>
            </section>
        @else
            <!-- Hero Público -->
            <section class="max-w-7xl mx-auto px-6 py-20 md:py-32">
                <div class="max-w-3xl space-y-8 animate-fade-in-up">
                    <h1 class="text-5xl md:text-7xl font-bold uppercase tracking-wide text-white leading-tight">
                        Bienvenido a <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0]">Nexo App!</span>
                    </h1>
                    
                    <p class="text-[#9CA3AF] text-lg leading-relaxed max-w-2xl border-l border-[#374151] pl-6">
                        Conectamos necesidades con soluciones. Descubre una red exclusiva de servicios y negocios curados para ofrecerte la mejor experiencia en tu ciudad. Calidad, rapidez y estilo en un solo lugar.
                    </p>
                    
                    @if(!session()->has('rol'))
                    <div class="pt-4">
                        <a href="/register" class="inline-block py-4 px-10 bg-[#1a1a1a] border border-[#25B5DA] text-[#25B5DA] text-sm font-bold uppercase tracking-[0.2em] hover:bg-[#25B5DA] hover:text-[#1a1a1a] hover:shadow-[0_0_20px_rgba(234,179,8,0.3)] transition-all duration-300 rounded-sm">
                            Empezar Ahora
                        </a>
                    </div>
                    @endif
                </div>
            </section>
            
            @if(!session()->has('rol'))
            <!-- Section Cómo funciona -->
            <section class="max-w-7xl mx-auto px-6 pb-20 animate-fade-in-up" style="animation-delay: 100ms;">
                <h2 class="text-3xl font-bold uppercase tracking-wide text-white text-center mb-12">¿Cómo funciona?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center group bg-[#1a1a1a] border border-[#374151] p-8 rounded-xl hover:border-[#25B5DA]/50 transition-all duration-300">
                        <div class="w-16 h-16 mx-auto bg-[#25B5DA]/10 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#25B5DA]/20 group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-search text-2xl text-[#25B5DA]"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-3 tracking-wide">1. Explora</h3>
                        <p class="text-[#9CA3AF] text-sm leading-relaxed">Descubre negocios exclusivos en tu área y explora sus servicios, horarios y valoraciones reales.</p>
                    </div>
                    <div class="text-center group bg-[#1a1a1a] border border-[#374151] p-8 rounded-xl hover:border-[#25B5DA]/50 transition-all duration-300">
                        <div class="w-16 h-16 mx-auto bg-[#25B5DA]/10 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#25B5DA]/20 group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-calendar-alt text-2xl text-[#25B5DA]"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-3 tracking-wide">2. Agenda</h3>
                        <p class="text-[#9CA3AF] text-sm leading-relaxed">Reserva en segundos eligiendo el servicio, el profesional de tu preferencia y el horario ideal.</p>
                    </div>
                    <div class="text-center group bg-[#1a1a1a] border border-[#374151] p-8 rounded-xl hover:border-[#25B5DA]/50 transition-all duration-300">
                        <div class="w-16 h-16 mx-auto bg-[#25B5DA]/10 rounded-full flex items-center justify-center mb-6 group-hover:bg-[#25B5DA]/20 group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-star text-2xl text-[#25B5DA]"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-3 tracking-wide">3. Disfruta</h3>
                        <p class="text-[#9CA3AF] text-sm leading-relaxed">Recibe un servicio excelente en el lugar, califica tu experiencia y compártela a la comunidad.</p>
                    </div>
                </div>
            </section>
            @endif
        @endif

        <!-- Filters & Grid -->
        <section class="max-w-7xl mx-auto px-6 pb-24">
            
        <!-- Filter Bar Simplificado con formulario GET -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-12 border-b border-[#374151] pb-6 animate-fade-in-up" style="animation-delay: 200ms;">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-[#9CA3AF] text-[10px] uppercase tracking-widest mr-2">Filtrar por:</span>
                
                <a href="{{ route('home') }}?categoria=todos" 
                class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider transition-all {{ empty($categoria) || $categoria === 'todos' ? 'bg-[#25B5DA] text-black font-bold' : 'bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-[#25B5DA]' }}">
                    Todos
                </a>
                
                <a href="{{ route('home') }}?categoria=barberia" 
                class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider transition-all {{ $categoria === 'barberia' ? 'bg-[#25B5DA] text-black font-bold' : 'bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-[#25B5DA]' }}">
                    Barbería
                </a>
                
                <a href="{{ route('home') }}?categoria=salon" 
                class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider transition-all {{ $categoria === 'salon' ? 'bg-[#25B5DA] text-black font-bold' : 'bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-[#25B5DA]' }}">
                    Salón
                </a>
                
                <a href="{{ route('home') }}?categoria=peluqueria" 
                class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider transition-all {{ $categoria === 'peluqueria' ? 'bg-[#25B5DA] text-black font-bold' : 'bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-[#25B5DA]' }}">
                    Peluquería
                </a>
                
                <a href="{{ route('home') }}?categoria=spa" 
                class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider transition-all {{ $categoria === 'spa' ? 'bg-[#25B5DA] text-black font-bold' : 'bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-[#25B5DA]' }}">
                    Spa
                </a>
                
                <a href="{{ route('home') }}?categoria=otros" 
                class="px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider transition-all {{ $categoria === 'otros' ? 'bg-[#25B5DA] text-black font-bold' : 'bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-[#25B5DA]' }}">
                    Otros
                </a>
            </div>
            
            <div class="text-[#9CA3AF] text-xs uppercase tracking-widest">
                Mostrando <span class="text-white">{{ count($negocios) }}</span> resultados
            </div>
        </div>
        
        <!-- Trends Title -->
        <div class="mb-10 animate-fade-in-up" style="animation-delay: 300ms;">
            <h2 class="text-2xl font-bold uppercase tracking-widest text-white flex items-center gap-4">
                Destacados
                <span class="h-px w-full max-w-[100px] bg-gradient-to-r from-[#25B5DA]/50 to-transparent"></span>
            </h2>
        </div>

            <!-- Grid de Negocios desde API -->
            @if(count($negocios) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($negocios as $index => $negocio)
                
                <article class="group relative bg-[#262626] rounded-xl overflow-hidden border border-[#374151] hover:border-[#25B5DA]/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-[#25B5DA]/10 cursor-pointer animate-fade-in-up block"
                         onclick="window.location.href='/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}'"
                         style="animation-delay: {{ 300 + ($index * 100) }}ms;">
                    
                    <!-- Imagen con overlay -->
                    <div class="relative aspect-[4/5] overflow-hidden">
                        @php
                            \Log::info('Vista home - Negocio (Limpio):', [
                                'id' => $negocio['id_negocio'] ?? $negocio['id'] ?? null,
                                'nombre' => $negocio['nombre'] ?? null,
                                'foto_perfil_url' => $negocio['foto_perfil'] ?? null
                            ]);
                        @endphp
                        @if(!empty($negocio['foto_perfil']))
                            <img src="{{ $negocio['foto_perfil'] }}" 
                                 alt="{{ $negocio['nombre'] }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center group-hover:scale-110 transition-transform duration-700">
                                <svg class="w-16 h-16 text-[#374151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] via-[#1a1a1a]/40 to-transparent opacity-90 group-hover:opacity-80 transition-opacity duration-300"></div>
                        
                        <!-- Badge calificación -->
                        <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-full border border-white/10 shadow-lg">
                            <span class="text-[#25B5DA] text-xs font-bold flex items-center gap-1">
                                @if(isset($negocio['calificacion']) && $negocio['calificacion'] > 0)
                                    <i class="fas fa-star text-[10px]"></i>
                                    {{ number_format($negocio['calificacion'], 1) }}
                                @else
                                    <i class="fas fa-star text-[10px]"></i>
                                    Sin reseñas
                                @endif
                            </span>
                        </div>
                        
                        <!-- Badge tipo de negocio -->
                        <div class="absolute bottom-4 left-4 bg-[#25B5DA]/20 backdrop-blur-sm px-3 py-1.5 rounded-full border border-[#25B5DA]/30">
                            <span class="text-[#25B5DA] text-[10px] font-bold uppercase tracking-wider">
                                {{ ucfirst($negocio['tipo_negocio'] ?? 'Servicios') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Contenido -->
                    <div class="p-5">
                        <h3 class="text-white font-bold text-base uppercase tracking-wide group-hover:text-[#25B5DA] transition-colors line-clamp-1">
                            {{ $negocio['nombre'] }}
                        </h3>
                        
                        <p class="text-[#9CA3AF] text-xs mt-2 line-clamp-2 leading-relaxed h-8">
                            {{ $negocio['acerca_de'] ?? 'Descubre los mejores servicios en ' . $negocio['nombre'] }}
                        </p>
                        
                       <!-- Ubicación -->
                        @php
                            $ciudad = 'Ubicación no especificada';
                            
                            if (isset($negocio['direccion']) && is_array($negocio['direccion'])) {
                                $ciudad = $negocio['direccion']['ciudad'] ?? 'Ubicación no especificada';
                            } elseif (isset($negocio['ciudad'])) {
                                $ciudad = $negocio['ciudad'];
                            }
                        @endphp

                        <div class="flex items-center gap-1.5 mt-4 text-[10px] text-[#9CA3AF] uppercase tracking-wider bg-[#1a1a1a] rounded px-2 py-1.5 w-max">
                            <svg class="w-3.5 h-3.5 text-[#25B5DA]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="truncate max-w-[150px]">
                                {{ $ciudad }}
                            </span>
                        </div>
                    
                    <!-- Barra inferior animada -->
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                </article>

                @endforeach
            </div>

            <!-- Contador de resultados al final -->
            <div class="text-center mt-12 text-[#9CA3AF] text-xs uppercase tracking-widest animate-fade-in-up" style="animation-delay: 500ms;">
                Mostrando <span class="text-white">{{ count($negocios) }}</span> negocios registrados
            </div>

            @else
            <!-- Mensaje cuando no hay negocios -->
            <div class="text-center py-20 animate-fade-in-up">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#262626] border border-[#374151] text-[#25B5DA] mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="text-white text-xl uppercase tracking-wide font-bold mb-2">No hay negocios aquí</div>
                <p class="text-[#9CA3AF] text-sm">Aún no hemos registrado negocios en nuestra plataforma.</p>
                @if(!session()->has('rol'))
                <a href="/register" class="inline-block mt-8 py-3 px-8 bg-[#25B5DA] text-[#1a1a1a] font-bold text-xs uppercase tracking-[0.2em] rounded-sm hover:bg-[#25B5DA] transition-colors shadow-lg shadow-[#25B5DA]/20">
                    Registrar el Primer Negocio
                </a>
                @endif
            </div>
            @endif

        </section>

        <!-- Stats & Company Footer -->
        <div class="bg-[#0f0f0f] border-t border-[#374151] py-16">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-5 gap-12 items-center">
                <!-- Información de la Empresa -->
                <div class="md:col-span-2 space-y-5 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3">
                        <div class="w-12 h-12 rounded bg-[#25B5DA] flex items-center justify-center shadow-lg shadow-[#25B5DA]/20">
                            <span class="text-black font-extrabold text-2xl">N</span>
                        </div>
                        <span class="text-3xl font-bold uppercase tracking-widest text-white">Nexo App</span>
                    </div>
                    <p class="text-[#9CA3AF] text-sm leading-relaxed max-w-sm mx-auto md:mx-0">
                        La mejor forma de conectar talento excepcional con clientes exigentes. Simplifica tus reservas y haz crecer tu negocio.
                    </p>
                    <div class="flex items-center justify-center md:justify-start gap-5 pt-2">
                        <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-twitter text-xl"></i></a>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="md:col-span-3 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-[#374151] md:border-t-0 md:border-l md:border-[#374151] md:pl-12 pt-8 md:pt-0">
                    <div class="text-center group">
                        <div class="text-4xl font-bold text-white group-hover:text-[#25B5DA] transition-colors">{{ $stats['negocios'] ?? '250+' }}</div>
                        <p class="text-[#9CA3AF] text-[10px] uppercase tracking-wider mt-3 font-semibold group-hover:text-white transition-colors">Negocios</p>
                    </div>
                    <div class="text-center group">
                        <div class="text-4xl font-bold text-white group-hover:text-[#25B5DA] transition-colors">{{ $stats['clientes'] ?? '10K+' }}</div>
                        <p class="text-[#9CA3AF] text-[10px] uppercase tracking-wider mt-3 font-semibold group-hover:text-white transition-colors">Clientes</p>
                    </div>
                    <div class="text-center group">
                        <div class="text-4xl font-bold text-white group-hover:text-[#25B5DA] transition-colors">{{ $stats['citas'] ?? '50K+' }}</div>
                        <p class="text-[#9CA3AF] text-[10px] uppercase tracking-wider mt-3 font-semibold group-hover:text-white transition-colors">Citas realizadas</p>
                    </div>
                    <div class="text-center group">
                        <div class="text-4xl font-bold text-white group-hover:text-[#25B5DA] transition-colors">{{ $stats['empleados'] ?? '500+' }}</div>
                        <p class="text-[#9CA3AF] text-[10px] uppercase tracking-wider mt-3 font-semibold group-hover:text-white transition-colors">Profesionales</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection