@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>

    <!-- Main Content -->
    <main class="flex-grow bg-[#1a1a1a]">
        
        <!-- Hero Section -->
        <section class="relative max-w-7xl mx-auto px-6 py-20 md:py-28 overflow-hidden rounded-b-3xl">
            <!-- Background Decoration -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-5xl opacity-20 pointer-events-none">
                <div class="absolute top-[-100px] right-[-100px] w-96 h-96 bg-[#25B5DA] rounded-full mix-blend-screen filter blur-[100px] opacity-30"></div>
                <div class="absolute bottom-[-50px] left-[-50px] w-72 h-72 bg-[#1c8fb0] rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
            </div>

            <div class="relative max-w-3xl space-y-8 animate-fade-in-up z-10 mx-auto text-center">
                @if(session('rol') === 'cliente' && session()->has('usuario'))
                    <h1 class="text-4xl md:text-6xl font-black uppercase tracking-wide text-white leading-tight drop-shadow-lg">
                        Listo para tu cita, <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0]">{{ session('usuario')['nombre_completo'] ?? session('usuario')['nombre'] ?? 'Usuario' }}?</span>
                    </h1>
                    <p class="text-[#9CA3AF] text-lg leading-relaxed max-w-2xl mx-auto">
                        Encuentra los profesionales mejor calificados cerca de ti. Reserva sin esperas.
                    </p>
                @else
                    <h1 class="text-4xl md:text-6xl font-black uppercase tracking-wide text-white leading-tight drop-shadow-lg">
                        Reserva tu estilo <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0]">en Segundos</span>
                    </h1>
                    <p class="text-[#9CA3AF] text-lg leading-relaxed max-w-2xl mx-auto">
                        Los mejores salones, barberías y spas de la ciudad. Sin llamadas, sin demoras y a un click.
                    </p>
                @endif

                <!-- Buscador Visual -->
                <div class="mt-10 max-w-2xl mx-auto bg-[#262626] p-2 rounded-full border border-[#374151] flex items-center shadow-2xl shadow-[#25B5DA]/10 transition-all focus-within:border-[#25B5DA]/50 focus-within:shadow-[#25B5DA]/20">
                    <div class="flex-1 flex items-center px-4 border-r border-[#374151]">
                        <i class="fas fa-search text-[#9CA3AF] mr-3"></i>
                        <input type="text" placeholder="¿Qué servicio buscas? (ej. Corte, Spa)" class="w-full bg-transparent border-none focus:ring-0 text-white placeholder-[#9CA3AF] text-sm cursor-text" onkeypress="if(event.key === 'Enter') document.getElementById('resultados').scrollIntoView({behavior: 'smooth'})">
                    </div>
                    <div class="hidden sm:flex flex-1 items-center px-4">
                        <i class="fas fa-map-marker-alt text-[#9CA3AF] mr-3"></i>
                        <input type="text" placeholder="Tú ubicación actual" class="w-full bg-transparent border-none focus:ring-0 text-white placeholder-[#9CA3AF] text-sm outline-none cursor-pointer" readonly onclick="document.getElementById('resultados').scrollIntoView({behavior: 'smooth'})">
                    </div>
                    <button class="bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-bold uppercase tracking-wider text-sm px-8 py-3.5 rounded-full hover:from-white hover:to-white hover:text-[#25B5DA] transition-all transform hover:scale-105" onclick="document.getElementById('resultados').scrollIntoView({behavior: 'smooth'})">
                        Buscar
                    </button>
                </div>

                <!-- Chips Sugerencias -->
                <div class="flex flex-wrap justify-center items-center gap-2 mt-6">
                    <span class="text-[#9CA3AF] text-[10px] uppercase tracking-widest mr-2">Populares:</span>
                    <a href="{{ route('home') }}?categoria=barberia" class="px-3 py-1 bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] text-[10px] rounded-full uppercase tracking-wider hover:border-[#25B5DA] hover:text-[#25B5DA] transition-colors shadow-sm">Cortes</a>
                    <a href="{{ route('home') }}?categoria=salon" class="px-3 py-1 bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] text-[10px] rounded-full uppercase tracking-wider hover:border-[#25B5DA] hover:text-[#25B5DA] transition-colors shadow-sm">Manicura</a>
                    <a href="{{ route('home') }}?categoria=spa" class="px-3 py-1 bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] text-[10px] rounded-full uppercase tracking-wider hover:border-[#25B5DA] hover:text-[#25B5DA] transition-colors shadow-sm">Masajes</a>
                </div>

                <!-- Social Proof Stats (Simulated) -->
                <div class="grid grid-cols-3 gap-4 pt-12 max-w-lg mx-auto border-t border-[#374151]/50 mt-12 animate-fade-in-up" style="animation-delay: 200ms;">
                    <div class="text-center group">
                        <div class="text-white font-bold text-2xl group-hover:text-[#25B5DA] transition-colors">+{{ rtrim(number_format(count($negocios) * 12 + 50, 0, '', '.'), '0') }}</div>
                        <div class="text-[#9CA3AF] text-[10px] uppercase tracking-wider mt-1">Negocios</div>
                    </div>
                    <div class="text-center border-l border-r border-[#374151]/50 group">
                        <div class="text-[#25B5DA] font-bold text-2xl flex items-center justify-center gap-1 group-hover:drop-shadow-[0_0_8px_rgba(37,181,218,0.5)] transition-all">
                            <i class="fas fa-star text-sm"></i> 4.8
                        </div>
                        <div class="text-[#9CA3AF] text-[10px] uppercase tracking-wider mt-1">Calif. Media</div>
                    </div>
                    <div class="text-center group">
                        <div class="text-white font-bold text-2xl group-hover:text-[#25B5DA] transition-colors">+10k</div>
                        <div class="text-[#9CA3AF] text-[10px] uppercase tracking-wider mt-1">Reservas</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Visual Categories Menu -->
        <section class="max-w-7xl mx-auto px-6 py-8 border-b border-[#374151]/50 sticky top-0 bg-[#1a1a1a]/95 backdrop-blur-md z-40">
            <div class="flex overflow-x-auto hide-scrollbar gap-4 sm:gap-8 pb-2 pt-2 items-center sm:justify-center">
                @php
                    $cats = [
                        ['id' => 'todos', 'icon' => 'fa-border-all', 'name' => 'Todos'],
                        ['id' => 'barberia', 'icon' => 'fa-cut', 'name' => 'Barbería'],
                        ['id' => 'salon', 'icon' => 'fa-paint-brush', 'name' => 'Salón'],
                        ['id' => 'peluqueria', 'icon' => 'fa-scissors', 'name' => 'Peluquería'],
                        ['id' => 'spa', 'icon' => 'fa-spa', 'name' => 'Spa'],
                        ['id' => 'otros', 'icon' => 'fa-ellipsis-h', 'name' => 'Otros'],
                    ];
                    $currentCat = request('categoria') ?? 'todos';
                @endphp
                @foreach($cats as $cat)
                    <a href="{{ route('home') }}?categoria={{ $cat['id'] }}" 
                       class="group min-w-[80px] flex flex-col items-center gap-3 transition-transform hover:scale-105">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 {{ ($currentCat === $cat['id'] || (empty($categoria) && $cat['id'] === 'todos')) ? 'bg-gradient-to-br from-[#25B5DA] to-[#1c8fb0] text-black shadow-lg shadow-[#25B5DA]/40 scale-110' : 'bg-[#262626] border border-[#374151] text-[#9CA3AF] group-hover:bg-[#374151] group-hover:text-white group-hover:border-white/20' }}">
                            <i class="fas {{ $cat['icon'] }} text-xl"></i>
                        </div>
                        <span class="text-[10px] uppercase tracking-widest font-bold transition-colors {{ ($currentCat === $cat['id'] || (empty($categoria) && $cat['id'] === 'todos')) ? 'text-[#25B5DA]' : 'text-[#9CA3AF] group-hover:text-white' }}">
                            {{ $cat['name'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Negocios Grid Area -->
        <section id="resultados" class="max-w-7xl mx-auto px-6 py-16 scroll-mt-24">
            
            <div class="flex justify-between items-end mb-10 animate-fade-in-up">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-wide text-white flex items-center gap-3">
                        Cerca de ti
                        <div class="h-1 w-24 bg-gradient-to-r from-[#25B5DA] to-transparent rounded-full"></div>
                    </h2>
                    <p class="text-[#9CA3AF] text-sm mt-2">Explora los negocios recomendados para hoy.</p>
                </div>
                <div class="text-[#9CA3AF] text-[10px] uppercase tracking-widest hidden sm:block bg-[#262626] px-4 py-2 rounded-full border border-[#374151]">
                    Viendo <span class="text-white font-bold">{{ count($negocios) }}</span> resultados
                </div>
            </div>

            @if(count($negocios) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                    @foreach ($negocios as $index => $negocio)
                    @php
                        // Variables visuales dummy
                        $distanciaSimulada = number_format(rand(5, 45) / 10, 1) . ' km';
                        $abiertoAhora = rand(0, 1) == 1; // Booleano aleatorio 50/50
                    @endphp
                    
                    <article class="group relative bg-[#262626] rounded-2xl overflow-hidden border border-[#374151] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(37,181,218,0.2)] hover:border-[#25B5DA]/40 flex flex-col animate-fade-in-up"
                             style="animation-delay: {{ min(100 + ($index * 100), 500) }}ms;">
                        
                        <!-- Imagen Contenedor -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-black cursor-pointer group" onclick="window.location.href='/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}'">
                            @if(!empty($negocio['foto_perfil']))
                                <img src="{{ $negocio['foto_perfil'] }}" alt="{{ $negocio['nombre'] }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#1a1a1a] to-[#262626] group-hover:scale-105 transition-transform duration-700 ease-out">
                                    <i class="fas fa-store text-5xl text-[#374151] group-hover:text-[#25B5DA] transition-colors duration-500"></i>
                                </div>
                            @endif
                            <!-- Overlay Gradiente -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] via-[#1a1a1a]/20 to-transparent opacity-90"></div>
                            
                            <!-- Rating -->
                            <div class="absolute top-3 right-3 bg-black/70 backdrop-blur-md px-2.5 py-1.5 rounded-lg border border-white/10 flex items-center gap-1.5 shadow-lg transform translate-y-0 group-hover:-translate-y-1 transition-transform duration-300">
                                <i class="fas fa-star text-[#25B5DA] text-[10px]"></i>
                                <span class="text-white text-xs font-bold font-mono">
                                    @if(isset($negocio['calificacion']) && $negocio['calificacion'] > 0)
                                        {{ number_format($negocio['calificacion'], 1) }}
                                    @else
                                        NUEVO
                                    @endif
                                </span>
                            </div>

                            <!-- Etiqueta Distancia -->
                            <div class="absolute top-3 left-3 bg-white/10 backdrop-blur-md px-2.5 py-1.5 rounded-lg border border-white/10 shadow-lg">
                                <span class="text-white text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-location-arrow text-[#25B5DA]"></i> {{ $distanciaSimulada }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Cuerpo Card -->
                        <div class="p-5 flex-grow flex flex-col relative z-10 bg-[#262626]">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-white font-black text-lg leading-tight group-hover:text-[#25B5DA] transition-colors line-clamp-1 cursor-pointer truncate pr-2" onclick="window.location.href='/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}'">
                                    {{ $negocio['nombre'] }}
                                </h3>
                            </div>
                            
                            <div class="text-[#9CA3AF] text-[10px] mb-4 font-bold uppercase tracking-widest flex items-center gap-2">
                                <span class="text-[#25B5DA]">{{ ucfirst($negocio['tipo_negocio'] ?? 'Servicios') }}</span>
                                <span class="w-1 h-1 rounded-full bg-[#374151]"></span>
                                @php
                                    $ciudad = 'Ubicación no especificada';
                                    if (isset($negocio['direccion']) && is_array($negocio['direccion'])) {
                                        $ciudad = $negocio['direccion']['ciudad'] ?? 'Ubicación no especificada';
                                    } elseif (isset($negocio['ciudad'])) {
                                        $ciudad = $negocio['ciudad'];
                                    }
                                @endphp
                                <span class="truncate">{{ $ciudad }}</span>
                            </div>

                            <!-- Estado Disponibilidad -->
                            <div class="mt-auto pt-4 border-t border-[#374151]/50 flex items-center justify-between">
                                <div class="flex items-center gap-2 bg-[#1a1a1a] px-3 py-1.5 rounded-md border border-[#374151]">
                                    <span class="relative flex h-2.5 w-2.5">
                                      @if($abiertoAhora)
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                      @else
                                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                                      @endif
                                    </span>
                                    <span class="text-[9px] uppercase font-bold tracking-widest {{ $abiertoAhora ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $abiertoAhora ? 'Disponible' : 'Cerrado' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Acciones -->
                            <div class="mt-4 grid grid-cols-2 gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 absolute bottom-0 left-0 w-full p-5 bg-gradient-to-t from-[#262626] via-[#262626] to-transparent transform translate-y-4 group-hover:translate-y-0">
                                <a href="/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}" class="flex items-center justify-center py-2.5 bg-[#1a1a1a] border-2 border-[#374151] rounded-lg text-[#9CA3AF] text-[10px] font-black uppercase tracking-widest hover:border-white hover:text-white transition-colors">
                                    Visitar
                                </a>
                                <a href="/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}#agendar" class="flex items-center justify-center py-2.5 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] rounded-lg text-black text-[10px] font-black uppercase tracking-widest hover:shadow-[0_0_15px_rgba(37,181,218,0.4)] transition-shadow">
                                    Reservar
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            @else
                <!-- Redesigned Empty State PRO -->
                <div class="max-w-3xl mx-auto text-center py-20 px-6 animate-fade-in-up mt-8 relative">
                    <!-- Glow en fondo -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-[#25B5DA] rounded-full mix-blend-screen filter blur-[120px] opacity-10"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-24 h-24 mb-6 rounded-3xl bg-gradient-to-br from-[#262626] to-[#1a1a1a] border border-[#374151] flex items-center justify-center shadow-2xl rotate-3">
                            <i class="fas fa-search-location text-4xl text-[#25B5DA]"></i>
                        </div>
                        <h3 class="text-3xl font-black text-white uppercase tracking-wide mb-4">Aún no hay descubrimientos</h3>
                        <p class="text-[#9CA3AF] text-base leading-relaxed mb-10 max-w-lg">
                            Parece que no hay negocios disponibles en esta categoría o área por el momento. ¡Sé el primero en dominar este espacio en Nexo App!
                        </p>
                        
                        @if(!session()->has('rol'))
                            <div class="flex flex-col sm:flex-row gap-4 justify-center w-full sm:w-auto">
                                <a href="/register" class="py-4 px-10 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-black text-xs uppercase tracking-widest rounded-full hover:shadow-[0_0_20px_rgba(37,181,218,0.4)] hover:scale-105 transition-all duration-300">
                                    Publicar Mi Negocio
                                </a>
                                <a href="{{ route('home') }}?categoria=todos" class="py-4 px-10 bg-[#262626] border-2 border-[#374151] text-white font-bold text-xs uppercase tracking-widest rounded-full hover:border-[#25B5DA] transition-colors">
                                    Limpiar Filtros
                                </a>
                            </div>
                        @else
                             <a href="{{ route('home') }}?categoria=todos" class="py-4 px-10 bg-[#262626] border-2 border-[#374151] text-white font-bold text-xs uppercase tracking-widest rounded-full hover:border-[#25B5DA] transition-colors">
                                Ver Todos los Negocios
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </section>

        <!-- Call to Action Footer (Registrar negocio) -->
        @if(!session()->has('rol') && count($negocios) > 0)
            <section class="max-w-7xl mx-auto px-6 pb-20 mt-10 animate-fade-in-up">
                <div class="bg-gradient-to-r from-[#262626] to-[#1a1a1a] border border-[#374151] rounded-[2rem] p-8 md:p-14 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-2xl">
                    <div class="absolute -top-32 -right-32 w-80 h-80 bg-[#25B5DA] rounded-full filter blur-[100px] opacity-10"></div>
                    <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-[#1c8fb0] rounded-full filter blur-[100px] opacity-10"></div>
                    
                    <div class="relative z-10 max-w-xl text-center md:text-left">
                        <span class="text-[#25B5DA] text-[10px] font-black uppercase tracking-widest mb-2 block">Haz crecer tu marca</span>
                        <h3 class="text-3xl md:text-4xl font-black text-white uppercase tracking-wide mb-4 leading-tight">Impulsa tu negocio al siguiente nivel</h3>
                        <p class="text-[#9CA3AF] text-sm md:text-base leading-relaxed">Únete a la plataforma elegida por los mejores profesionales. Gestiona citas, aumenta visibilidad y mejora tus ingresos hoy.</p>
                    </div>
                    <a href="/register" class="relative z-10 flex items-center justify-center gap-3 whitespace-nowrap py-4 px-10 bg-white text-black font-black text-xs uppercase tracking-widest rounded-full hover:bg-[#25B5DA] transition-colors duration-300 group">
                        Unirse a Nexo App
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </section>
        @endif

    </main>

@endsection