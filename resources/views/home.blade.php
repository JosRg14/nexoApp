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
        <section class="relative max-w-7xl mx-auto px-6 pt-16 md:pt-20 pb-8 md:pb-12 overflow-hidden rounded-b-3xl">
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
                    <div class="flex-1 flex items-center px-4">
                        <i class="fas fa-search text-[#9CA3AF] mr-3"></i>
                        <input type="text" id="searchInput" placeholder="Buscar negocio por nombre..." class="w-full bg-transparent border-none focus:ring-0 text-white placeholder-[#9CA3AF] text-sm cursor-text" onkeyup="filterBusinesses()" onkeypress="if(event.key === 'Enter') document.getElementById('resultados').scrollIntoView({behavior: 'smooth'})">
                    </div>
                    <button class="bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-bold uppercase tracking-wider text-sm px-8 py-3.5 rounded-full hover:from-white hover:to-white hover:text-[#25B5DA] transition-all transform hover:scale-105" onclick="document.getElementById('resultados').scrollIntoView({behavior: 'smooth'})">
                        Buscar
                    </button>
                </div>
                
                <script>
                    function filterBusinesses() {
                        const input = document.getElementById('searchInput').value.toLowerCase();
                        const cards = document.querySelectorAll('.business-card');
                        
                        cards.forEach(card => {
                            const name = card.getAttribute('data-name').toLowerCase();
                            if (name.includes(input)) {
                                card.style.display = ''; // Restaurar display original
                                card.classList.remove('hidden');
                            } else {
                                card.style.display = 'none';
                                card.classList.add('hidden');
                            }
                        });
                    }
                </script>
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
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-4 animate-fade-in-up">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-wide text-white flex items-center gap-3">
                        Cerca de ti
                        <div class="h-1 w-24 bg-gradient-to-r from-[#25B5DA] to-transparent rounded-full"></div>
                    </h2>
                    <p class="text-[#9CA3AF] text-sm mt-2">Explora los negocios recomendados para hoy.</p>
                </div>
                
                <form method="GET" action="{{ route('home') }}" class="flex items-center gap-2">
                    @if(request('categoria'))
                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    @endif
                    <select name="sort" onchange="this.form.submit()" class="bg-[#262626] text-white border border-[#374151] rounded-full px-4 py-2 text-sm focus:ring-[#25B5DA] focus:border-[#25B5DA] outline-none">
                        <option value="recientes" {{ request('sort') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Mejor calificados</option>
                    </select>
                </form>
            </div>

            @if(count($negocios) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                    @foreach ($negocios as $index => $negocio)
                    @php
                        $isNuevo = false;
                        if(isset($negocio['created_at'])) {
                            $isNuevo = \Carbon\Carbon::parse($negocio['created_at'])->diffInDays(now()) <= 7;
                        }

                        $ciudad = 'Ubicación no especificada';
                        if (isset($negocio['direccion']) && is_array($negocio['direccion'])) {
                            $ciudad = $negocio['direccion']['ciudad'] ?? 'Ubicación no especificada';
                        } elseif (isset($negocio['ciudad'])) {
                            $ciudad = $negocio['ciudad'];
                        }
                    @endphp
                    
                    <article class="business-card group relative bg-[#262626] rounded-xl overflow-hidden border border-[#374151] hover:border-[#25B5DA]/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-[#25B5DA]/10 cursor-pointer animate-fade-in-up block"
                             data-name="{{ htmlspecialchars($negocio['nombre'], ENT_QUOTES) }}"
                             onclick="window.location.href='/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}'"
                             style="animation-delay: {{ 300 + ($index * 100) }}ms;">

                        <!-- Imagen con overlay -->
                        <div class="relative aspect-[4/5] overflow-hidden">
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
                            <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-full border border-white/10 shadow-lg z-10">
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

                            @if($isNuevo)
                                <!-- Badge NUEVO -->
                                <div class="absolute top-3 left-3 bg-[#25B5DA] text-black px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg z-10 animate-pulse">
                                    Nuevo
                                </div>
                            @endif

                            <!-- Badge tipo de negocio -->
                            <div class="absolute bottom-4 left-4 bg-[#25B5DA]/20 backdrop-blur-sm px-3 py-1.5 rounded-full border border-[#25B5DA]/30 z-10 transition-transform group-hover:scale-105">
                                <span class="text-[#25B5DA] text-[10px] font-bold uppercase tracking-wider">
                                    {{ ucfirst($negocio['tipo_negocio'] ?? 'Servicios') }}
                                </span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-5 flex flex-col h-full relative">
                            <h3 class="text-white font-bold text-base uppercase tracking-wide group-hover:text-[#25B5DA] transition-colors line-clamp-1">
                                {{ $negocio['nombre'] }}
                            </h3>

                            <p class="text-[#9CA3AF] text-xs mt-2 line-clamp-2 leading-relaxed min-h-[2.5rem]">
                                {{ $negocio['acerca_de'] ?? 'Descubre los mejores servicios en ' . $negocio['nombre'] }}
                            </p>

                            <div class="flex items-center gap-1.5 mt-4 text-[10px] text-[#9CA3AF] uppercase tracking-wider bg-[#1a1a1a] rounded px-2 py-1.5 w-max">
                                <svg class="w-3.5 h-3.5 text-[#25B5DA]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="truncate max-w-[150px]">{{ $ciudad }}</span>
                            </div>

                            <!-- Botones en Hover -->
                            <div class="mt-6 grid grid-cols-2 gap-3 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                <a href="/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}" 
                                   class="flex items-center justify-center py-2.5 bg-[#1a1a1a] border border-[#374151] rounded-lg text-[#9CA3AF] text-[10px] font-black uppercase tracking-widest hover:border-white hover:text-white transition-colors"
                                   onclick="event.stopPropagation();">
                                    Visitar
                                </a>
                                <a href="/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}#agendar" 
                                   class="flex items-center justify-center py-2.5 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] rounded-lg text-black text-[10px] font-black uppercase tracking-widest hover:shadow-[0_0_15px_rgba(37,181,218,0.4)] transition-shadow"
                                   onclick="event.stopPropagation();">
                                    Reservar
                                </a>
                            </div>
                        </div>

                        <!-- Barra inferior animada -->
                        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </article>
                    @endforeach
                </div>

                <!-- Paginación SaaS -->
                @if(isset($meta) && $meta['last_page'] > 1)
                <div class="mt-16 flex flex-col items-center justify-center animate-fade-in-up">
                    <div class="flex items-center bg-[#262626] rounded-full border border-[#374151] p-1 shadow-lg">
                        
                        <!-- Anterior -->
                        @if($meta['current_page'] > 1)
                            <a href="{{ route('home', array_merge(request()->query(), ['page' => $meta['current_page'] - 1])) }}" class="px-4 py-2 text-sm text-[#9CA3AF] hover:text-white font-medium flex items-center gap-2 transition-colors">
                                <i class="fas fa-arrow-left"></i> Anterior
                            </a>
                        @else
                            <span class="px-4 py-2 text-sm text-[#374151] font-medium flex items-center gap-2 cursor-not-allowed">
                                <i class="fas fa-arrow-left"></i> Anterior
                            </span>
                        @endif

                        <div class="flex items-center px-2 gap-1 border-l border-r border-[#374151] mx-2">
                            @for ($i = max(1, $meta['current_page'] - 2); $i <= min($meta['last_page'], $meta['current_page'] + 2); $i++)
                                <a href="{{ route('home', array_merge(request()->query(), ['page' => $i])) }}" 
                                   class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold transition-all {{ $meta['current_page'] == $i ? 'bg-[#25B5DA] text-black shadow-[0_0_10px_rgba(37,181,218,0.3)]' : 'text-[#9CA3AF] hover:bg-[#374151] hover:text-white' }}">
                                    {{ $i }}
                                </a>
                            @endfor
                        </div>

                        <!-- Siguiente -->
                        @if($meta['current_page'] < $meta['last_page'])
                            <a href="{{ route('home', array_merge(request()->query(), ['page' => $meta['current_page'] + 1])) }}" class="px-4 py-2 text-sm text-[#9CA3AF] hover:text-white font-medium flex items-center gap-2 transition-colors">
                                Siguiente <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <span class="px-4 py-2 text-sm text-[#374151] font-medium flex items-center gap-2 cursor-not-allowed">
                                Siguiente <i class="fas fa-arrow-right"></i>
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 text-[#9CA3AF] text-xs font-medium">
                        Mostrando {{ count($negocios) }} de {{ $meta['total'] ?? '...' }} negocios
                    </div>
                </div>
                @endif
                
            @else
                <!-- Redesigned Empty State PRO -->
                <div class="max-w-3xl mx-auto text-center py-20 px-6 animate-fade-in-up mt-8 relative">
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

        @if(!session()->has('rol'))
            <!-- CTA Negocios: Sección Beneficios -->
            <section class="border-t border-[#374151] bg-[#1a1a1a] py-20 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-[#25B5DA]/5 via-transparent to-transparent"></div>
                
                <div class="max-w-7xl mx-auto px-6 relative z-10">
                    <div class="text-center mb-16 animate-fade-in-up">
                        <span class="text-[#25B5DA] font-black uppercase tracking-widest text-sm mb-3 block">Para Dueños de Negocio</span>
                        <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight">Haz crecer tu negocio con NexoApp</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 100ms;">
                        <!-- Beneficio 1 -->
                        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-8 hover:border-[#25B5DA] hover:-translate-y-1 transition-all">
                            <div class="w-12 h-12 bg-[#25B5DA]/10 rounded-xl flex items-center justify-center mb-6">
                                <i class="fas fa-calendar-check text-[#25B5DA] text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Gestión de Citas</h3>
                            <p class="text-[#9CA3AF] text-sm leading-relaxed">Olvídate del WhatsApp y la libreta. Permite que tus clientes agenden 24/7 de forma automática.</p>
                        </div>
                        
                        <!-- Beneficio 2 -->
                        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-8 hover:border-[#25B5DA] hover:-translate-y-1 transition-all">
                            <div class="w-12 h-12 bg-[#25B5DA]/10 rounded-xl flex items-center justify-center mb-6">
                                <i class="fas fa-users text-[#25B5DA] text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Gestión de Empleados</h3>
                            <p class="text-[#9CA3AF] text-sm leading-relaxed">Administra horarios, asigna comisiones por servicio y mide el rendimiento de tu equipo.</p>
                        </div>

                        <!-- Beneficio 3 -->
                        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-8 hover:border-[#25B5DA] hover:-translate-y-1 transition-all">
                            <div class="w-12 h-12 bg-[#25B5DA]/10 rounded-xl flex items-center justify-center mb-6">
                                <i class="fas fa-images text-[#25B5DA] text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Galería de Trabajos</h3>
                            <p class="text-[#9CA3AF] text-sm leading-relaxed">Muestra tus mejores resultados. Construye un portafolio visual que atraiga a más clientes.</p>
                        </div>

                        <!-- Beneficio 4 -->
                        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-8 hover:border-[#25B5DA] hover:-translate-y-1 transition-all">
                            <div class="w-12 h-12 bg-[#25B5DA]/10 rounded-xl flex items-center justify-center mb-6">
                                <i class="fas fa-tag text-[#25B5DA] text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Promociones y Descuentos</h3>
                            <p class="text-[#9CA3AF] text-sm leading-relaxed">Fideliza a tus clientes aplicando descuentos personalizados y campañas de temporada.</p>
                        </div>

                        <!-- Beneficio 5 -->
                        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-8 hover:border-[#25B5DA] hover:-translate-y-1 transition-all">
                            <div class="w-12 h-12 bg-[#25B5DA]/10 rounded-xl flex items-center justify-center mb-6">
                                <i class="fas fa-chart-line text-[#25B5DA] text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Dashboard de Finanzas</h3>
                            <p class="text-[#9CA3AF] text-sm leading-relaxed">Conoce tus ingresos, servicios más rentables y estadísticas en tiempo real.</p>
                        </div>

                        <!-- Beneficio 6 -->
                        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-8 hover:border-[#25B5DA] hover:-translate-y-1 transition-all">
                            <div class="w-12 h-12 bg-[#25B5DA]/10 rounded-xl flex items-center justify-center mb-6">
                                <i class="fas fa-star text-[#25B5DA] text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Reseñas de Clientes</h3>
                            <p class="text-[#9CA3AF] text-sm leading-relaxed">Construye confianza digital con calificaciones verificadas de tus servicios.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Negocios: Planes API -->
            <section class="bg-[#1a1a1a] pb-24 relative">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="text-center mb-16 animate-fade-in-up">
                        <h2 class="text-4xl text-white font-black tracking-tight mb-4">Planes que se ajustan a ti</h2>
                        <p class="text-[#9CA3AF] text-lg max-w-2xl mx-auto">Comienza ahora y digitaliza tu salón, barbería o spa al instante.</p>
                    </div>

                    @if(isset($planes) && count($planes) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                            @foreach($planes as $plan)
                            @php
                                $isPopular = stripos($plan['tipo'], 'Estándar') !== false || stripos($plan['tipo'], 'Estandar') !== false;
                            @endphp
                            <div class="bg-[#262626] border border-[#374151] rounded-3xl p-8 relative flex flex-col hover:border-[#25B5DA] transition-all transform hover:-translate-y-2 group {{ $isPopular ? 'border-[#25B5DA] shadow-[0_0_30px_rgba(37,181,218,0.15)] ring-1 ring-[#25B5DA]' : '' }}">
                                @if($isPopular)
                                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-black text-[10px] uppercase tracking-widest px-4 py-1.5 rounded-full shadow-lg">
                                        🌟 Más Popular
                                    </div>
                                @endif
                                
                                <h3 class="text-2xl font-bold text-white mb-2">{{ ucfirst($plan['tipo']) }}</h3>
                                <div class="flex items-end gap-1 mb-6">
                                    <span class="text-4xl font-black text-white">${{ number_format($plan['costo'], 2) }}</span>
                                    <span class="text-[#9CA3AF] text-sm mb-1 pb-1">/ {{ $plan['duracion'] ?? 'mes' }}</span>
                                </div>
                                
                                <div class="text-[#9CA3AF] text-sm leading-relaxed mb-8 border-t border-[#374151] pt-6 flex-grow text-left">
                                    {{ $plan['descripcion'] ?? 'Obtén acceso a las características premium de NexoApp con este plan.' }}
                                </div>
                                
                                <a href="/register/business" class="mt-auto py-3 px-6 rounded-xl font-black text-sm uppercase tracking-widest text-center transition-all {{ $isPopular ? 'bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black hover:shadow-[0_0_20px_rgba(37,181,218,0.4)]' : 'bg-[#1a1a1a] text-white border border-[#374151] hover:border-white' }}">
                                    Elegir Plan
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-[#9CA3AF] py-8 border border-[#374151] rounded-xl max-w-2xl mx-auto bg-[#262626]">
                            <i class="fas fa-info-circle text-[#25B5DA] text-2xl mb-3"></i>
                            <p>No se encontraron planes disponibles en este momento.</p>
                        </div>
                    @endif
                    
                    <div class="mt-16 text-center animate-fade-in-up">
                         <a href="/register" class="inline-flex items-center justify-center gap-3 py-4 px-12 bg-white text-black font-black text-sm uppercase tracking-widest rounded-full hover:bg-[#25B5DA] transition-colors duration-300 group">
                            Registrar mi negocio
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <div class="mt-4">
                            <a href="/login" class="text-[#9CA3AF] text-sm hover:text-white transition-colors underline decoration-[#374151] hover:decoration-white underline-offset-4">¿Ya tienes cuenta? Iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </main>

@endsection