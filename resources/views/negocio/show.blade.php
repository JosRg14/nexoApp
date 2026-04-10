@extends('layouts.app')

@section('title', $negocio['nombre'] ?? 'Negocio')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen">
    <!-- Hero Section con imagen de fondo -->
    <div class="relative h-80 md:h-96 overflow-hidden">
        <div class="absolute inset-0 z-0">
            @if(isset($negocio['banner']) && $negocio['banner'])
                <img src="{{ $negocio['banner'] }}" 
                     alt="{{ $negocio['nombre'] }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-gray-800 to-gray-900"></div>
            @endif
        </div>
        <div class="absolute inset-0 bg-black/60 z-0"></div>
        
        <div class="relative z-10 w-full p-6 pt-24 md:p-10">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-end gap-6">
                <!-- Logo -->
                <div class="w-28 h-28 md:w-36 md:h-36 shrink-0 rounded-full border-4 border-[#1a1a1a] shadow-xl overflow-hidden bg-[#2a2a2a]">
                    @if(!empty($negocio['foto_perfil']))
                        <img src="{{ $negocio['foto_perfil'] }}" 
                             alt="{{ $negocio['nombre'] }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl text-gray-500">
                            <i class="fas fa-store"></i>
                        </div>
                    @endif
                </div>
                
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                        <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wide text-white">{{ $negocio['nombre'] }}</h1>
                    </div>
                    
                    <div class="flex flex-wrap gap-4 text-gray-300 text-sm">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-[#25B5DA]"></i>
                            @if(isset($negocio['calificacion']) && $negocio['calificacion'] > 0)
                                {{ number_format($negocio['calificacion'], 1)}}
                            @else
                                Sin reseñas
                            @endif
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $negocio['direccion']['ciudad'] ?? 'Ciudad no especificada' }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-tag"></i>
                            {{ ucfirst($negocio['tipo_negocio'] ?? 'Barbería') }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-phone"></i>
                            {{ $negocio['telefono'] ?? 'No disponible' }}
                        </span>
                    </div>
                    
                    <p class="text-[#9CA3AF] text-xs mt-3 max-w-xl">
                        {{ $negocio['acerca_de'] ?? 'Información del negocio registrado en NexoPlatform.' }}
                    </p>
                </div>
                
                <!-- ÚNICO BOTÓN: Agendar Cita -->
               <a href="/agendar-cita?negocio_id={{ $negocio['id_negocio'] }}" 
                    class="px-6 py-3 bg-white text-black font-bold rounded-lg hover:bg-gray-200 transition-colors text-sm uppercase tracking-wide flex items-center gap-2">
                        <i class="fas fa-calendar-alt"></i>
                        Agendar Cita
                </a>
            </div>
        </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row gap-8 items-stretch">
            <!-- Columna izquierda - Servicios (ocupa 2/3) -->
            <div class="lg:w-2/3 space-y-6">
                <!-- Stats Cards con navegación smooth-scroll -->
                <div class="grid grid-cols-3 gap-4">
                    <div onclick="document.getElementById('servicios-section').scrollIntoView({ behavior: 'smooth' })" 
                         class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center cursor-pointer hover:border-[#25B5DA] hover:bg-[#25B5DA]/5 transition-all duration-300 group">
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] group-hover:text-[#25B5DA] transition-colors">Servicios</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ count($servicios) }}</p>
                        <i class="fas fa-scissors text-[#374151] group-hover:text-[#25B5DA]/40 text-xs mt-1 transition-colors"></i>
                    </div>
                    <div onclick="document.getElementById('empleados-section').scrollIntoView({ behavior: 'smooth' })" 
                         class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center cursor-pointer hover:border-[#25B5DA] hover:bg-[#25B5DA]/5 transition-all duration-300 group">
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] group-hover:text-[#25B5DA] transition-colors">Empleados</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ count($empleados) }}</p>
                        <i class="fas fa-users text-[#374151] group-hover:text-[#25B5DA]/40 text-xs mt-1 transition-colors"></i>
                    </div>
                    <div onclick="document.getElementById('resenas-section').scrollIntoView({ behavior: 'smooth' })" 
                         class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center cursor-pointer hover:border-[#25B5DA] hover:bg-[#25B5DA]/5 transition-all duration-300 group">
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] group-hover:text-[#25B5DA] transition-colors">Reseñas</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ count($resenas) }}</p>
                        <i class="fas fa-star text-[#374151] group-hover:text-[#25B5DA]/40 text-xs mt-1 transition-colors"></i>
                    </div>
                </div>
                
                <!-- Redes Sociales -->
                @if(isset($negocio['redes_sociales']) && $negocio['redes_sociales'])
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fab fa-instagram text-[#25B5DA]"></i> Redes Sociales
                    </h3>
                    <a href="{{ $negocio['redes_sociales'] }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-white transition-all text-xs uppercase tracking-wider">
                        <i class="fab fa-instagram text-[#25B5DA]"></i>
                        {{ $negocio['redes_sociales'] }}
                    </a>
                </div>
                @endif
                
                <!-- Servicios - Solo mostrar información, sin botón de selección -->
                <div id="servicios-section" class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold uppercase tracking-widest text-white flex items-center gap-3">
                            <i class="fas fa-cut text-2xl text-[#25B5DA]"></i> 
                            Nuestros Servicios
                            <span class="text-sm text-[#9CA3AF] font-normal">({{ count($servicios) }})</span>
                        </h3>
                    </div>
                    
                    @if(count($servicios) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($servicios as $servicio)
                        <div class="group bg-[#1a1a1a] rounded-xl overflow-hidden border border-[#374151] hover:border-[#F3F4F6] transition-all duration-300 hover:shadow-xl hover:shadow-black/50">
                            <!-- Imagen del servicio -->
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-800 to-gray-900">
                                @if(isset($servicio['imagen']) && $servicio['imagen'])
                                    <img src="{{ $servicio['imagen'] }}" 
                                         alt="{{ $servicio['nombre'] }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-500">
                                        <i class="fas fa-cut text-5xl mb-3 opacity-50"></i>
                                        <span class="text-xs uppercase tracking-wider">Sin imagen</span>
                                    </div>
                                @endif
                                
                                <div class="absolute top-3 right-3 bg-black/70 backdrop-blur-sm px-3 py-1 rounded-full">
                                    <span class="text-[#25B5DA] font-bold">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="absolute bottom-3 left-3 bg-black/60 backdrop-blur-sm px-2 py-1 rounded-full">
                                    <span class="text-white text-xs flex items-center gap-1">
                                        <i class="far fa-clock text-[#25B5DA]"></i> {{ $servicio['duracion'] ?? 30 }} min
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <h4 class="text-lg font-bold text-white uppercase tracking-wide group-hover:text-[#9CA3AF] transition-colors">
                                    {{ $servicio['nombre'] }}
                                </h4>
                                <p class="text-[#9CA3AF] text-xs leading-relaxed mt-2 line-clamp-2">
                                    {{ $servicio['descripcion'] ?? 'Descripción no disponible' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <i class="fas fa-scissors text-5xl text-[#374151] mb-4"></i>
                        <p class="text-[#9CA3AF]">No hay servicios disponibles aún.</p>
                    </div>
                    @endif
                </div>
                
                <!-- Nuestros Trabajos (Evidencias) -->
                @if(count($evidencias) > 0)
                <div id="evidencias-section" class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold uppercase tracking-widest text-white flex items-center gap-3">
                            <i class="fas fa-camera text-2xl text-[#25B5DA]"></i> 
                            Nuestros Trabajos
                        </h3>
                    </div>
                    
                    <div id="evidencias-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Las evidencias se cargarán con JavaScript -->
                    </div>
                </div>
                @endif

                <!-- Reseñas -->
                <div id="resenas-section" class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-star text-[#25B5DA]"></i> Reseñas ({{ count($resenas) }})
                    </h3>
                    <div class="space-y-4">
                        @forelse($resenas as $resena)
                        @php
                            $cal = $resena['calificacion'] ?? 0;
                            $starColor = $cal >= 4 ? 'text-emerald-400' : ($cal <= 2 ? 'text-red-400' : 'text-yellow-400');
                            $clienteNombre = $resena['cliente']['nombre_completo']
                                ?? $resena['cliente']['nombre']
                                ?? 'Cliente';
                        @endphp
                        <div class="border-b border-[#374151] pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex {{ $starColor }}">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $cal)
                                                <i class="fas fa-star text-xs"></i>
                                            @else
                                                <i class="far fa-star text-xs text-[#374151]"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-xs font-bold {{ $starColor }}">{{ $cal }}/5</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-[#374151] flex items-center justify-center text-[10px] font-bold text-[#9CA3AF]">
                                        {{ strtoupper(substr($clienteNombre, 0, 1)) }}
                                    </div>
                                    <span class="text-xs text-[#9CA3AF]">{{ $clienteNombre }}</span>
                                </div>
                            </div>
                            @if($resena['comentario'])
                            <p class="text-sm text-[#D1D5DB] leading-relaxed">"{{ $resena['comentario'] }}"</p>
                            @endif
                            <p class="text-[10px] text-[#52525b] mt-2">{{ \Carbon\Carbon::parse($resena['created_at'])->diffForHumans() }}</p>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <i class="far fa-star text-3xl text-[#374151] mb-2"></i>
                            <p class="text-xs text-[#52525b] italic">No hay reseñas aún. ¡Sé el primero en calificar!</p>
                        </div>
                        @endforelse
                    </div>
                </div>


            
            <!-- Columna derecha -->
            <div class="lg:w-1/3 flex flex-col gap-6">
                <!-- Equipo de Trabajo - Solo mostrar información, sin botón de agendar -->
                <div id="empleados-section" class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-users text-[#25B5DA]"></i> Nuestro Equipo ({{ count($empleados) }})
                    </h3>
                    <div class="space-y-3">
                        @forelse($empleados as $empleado)
                        <div class="flex items-center gap-3 p-3 bg-[#1a1a1a] border border-[#374151] rounded-lg">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#25B5DA]/20 to-[#1c8fb0]/20 text-[#25B5DA] flex items-center justify-center text-sm font-bold rounded-full">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <span class="text-sm text-[#D1D5DB] uppercase tracking-wider font-bold block">
                                    {{ $empleado['nombre'] }} {{ $empleado['app_paterno'] ?? '' }}
                                </span>
                                @if(isset($empleado['especialidad']) && $empleado['especialidad'])
                                <span class="text-[10px] text-[#52525b]">{{ $empleado['especialidad'] }}</span>
                                @endif
                            </div>
                            @if(isset($empleado['calificacion']))
                            <div class="flex items-center gap-1 text-[10px] text-[#25B5DA]">
                                <i class="fas fa-star text-[#25B5DA]"></i>
                                <span>{{ number_format($empleado['calificacion'], 1) }}</span>
                            </div>
                            @endif
                        </div>
                        @empty
                        <p class="text-xs text-[#52525b] italic">Sin empleados registrados.</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Horario -->
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-clock text-[#25B5DA]"></i> Horario de Atención
                    </h3>
                    @if(isset($horariosFormateados) && count($horariosFormateados) > 0)
                    <div class="space-y-2">
                        @foreach($horariosFormateados as $horario)
                        <div class="flex justify-between text-sm py-1 border-b border-[#374151]/50 last:border-0">
                            <span class="text-[#9CA3AF] font-medium">{{ $horario['dia'] }}</span>
                            <div class="text-right">
                                @if($horario['abierto'])
                                    @foreach($horario['horarios'] as $bloque)
                                        @if($bloque !== 'Cerrado')
                                            <span class="text-white block text-sm">{{ $bloque }}</span>
                                        @else
                                            <span class="text-red-400">Cerrado</span>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-red-400">Cerrado</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-xs text-[#52525b] italic">Horario no disponible.</p>
                    @endif
                </div>
                
                <!-- Ubicación con enlace a Google Maps -->
                @if(isset($negocio['direccion']))
                @php
                    // Construir la dirección completa para Google Maps
                    $calle = $negocio['direccion']['calle'] ?? '';
                    $numero = $negocio['direccion']['numero'] ?? '';
                    $colonia = $negocio['direccion']['colonia'] ?? '';
                    $ciudad = $negocio['direccion']['ciudad'] ?? '';
                    $estado = $negocio['direccion']['estado'] ?? '';
                    $cp = $negocio['direccion']['codigo_postal'] ?? '';
                    
                    $direccionCompleta = trim("$calle $numero, $colonia, $ciudad, $estado, CP $cp");
                    
                    // URL de Google Maps (búsqueda)
                    $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($direccionCompleta);
                    
                    // Alternativa: URL con coordenadas si las tuvieras
                    // $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . $latitud . ',' . $longitud;
                @endphp

                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 group hover:border-[#25B5DA]/50 transition-all duration-300">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-location-dot text-[#25B5DA]"></i> Ubicación
                    </h3>
                    
                    <a href="{{ $googleMapsUrl }}" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="block group/link">
                        <div class="space-y-1 text-sm">
                            <p class="text-[#D1D5DB] group-hover/link:text-[#25B5DA] transition-colors">
                                {{ $calle }} {{ $numero }}<br>
                                {{ $colonia }}<br>
                                {{ $ciudad }}, {{ $estado }}<br>
                                <span class="text-[#9CA3AF] group-hover/link:text-[#25B5DA]/70 transition-colors">CP: {{ $cp }}</span>
                            </p>
                            <div class="flex items-center gap-2 mt-3 text-xs text-[#25B5DA] opacity-0 group-hover/link:opacity-100 transition-opacity">
                                <i class="fas fa-external-link-alt"></i>
                                <span>Abrir en Google Maps</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                
                <!-- Contacto -->
                @if(isset($negocio['telefono']) && $negocio['telefono'])
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-phone text-[#25B5DA]"></i> Contacto
                    </h3>
                    <div class="flex items-center gap-3">
                        <a href="tel:{{ $negocio['telefono'] }}" 
                           class="text-[#D1D5DB] hover:text-white transition-colors text-sm">
                            {{ $negocio['telefono'] }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<!-- Modal de Evidencias -->
<div id="modal-evidencia" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-sm">
    <div class="absolute inset-0" onclick="closeEvidenciaModal()"></div>
    <div class="relative w-full max-w-4xl max-h-[90vh] flex flex-col items-center justify-center">
        <!-- Close button -->
        <button onclick="closeEvidenciaModal()" class="absolute -top-10 right-0 sm:-right-10 text-white hover:text-[#25B5DA] transition-colors text-3xl focus:outline-none z-10">
            <i class="fas fa-times"></i>
        </button>

        <!-- Navigation Buttons -->
        <button id="prev-evidencia" class="absolute left-0 top-1/2 -translate-y-1/2 sm:-left-12 text-white hover:text-[#25B5DA] text-4xl p-2 transition-colors hidden focus:outline-none bg-black/40 hover:bg-black/80 rounded-full w-12 h-12 flex items-center justify-center z-10">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="next-evidencia" class="absolute right-0 top-1/2 -translate-y-1/2 sm:-right-12 text-white hover:text-[#25B5DA] text-4xl p-2 transition-colors hidden focus:outline-none bg-black/40 hover:bg-black/80 rounded-full w-12 h-12 flex items-center justify-center z-10">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Contenido principal (imagen grande) -->
        <div class="relative w-full flex items-center justify-center overflow-hidden rounded-lg shadow-2xl bg-[#1a1a1a] border border-[#374151]">
            <img id="evidencia-imagen-grande" src="" alt="Evidencia" class="max-h-[70vh] w-auto object-contain drop-shadow-lg">
        </div>
        
        <!-- Info inferior -->
        <div class="mt-4 w-full bg-[#262626] p-4 rounded-lg border border-[#374151] flex flex-col gap-2 relative z-10">
            <div class="flex items-center gap-2 border-b border-[#374151] pb-2">
                <i class="fas fa-cut text-[#25B5DA]"></i>
                <h4 id="evidencia-servicio-nombre" class="font-bold text-white text-lg uppercase tracking-wide"></h4>
            </div>
            <p id="evidencia-descripcion" class="text-gray-300 text-sm mt-1"></p>
        </div>
    </div>
</div>

<script>
    let evidenciasData = @json($evidencias);
    let currentEvidenciaIndex = 0;

    document.addEventListener('DOMContentLoaded', () => {
        if (evidenciasData.length > 0) {
            renderEvidenciasPublic(evidenciasData);
        }
            
        // Key bindings para navegación modal
        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('modal-evidencia');
            if(!modal.classList.contains('hidden')) {
                if(e.key === 'Escape') closeEvidenciaModal();
                if(e.key === 'ArrowLeft') navigateEvidencia(-1);
                if(e.key === 'ArrowRight') navigateEvidencia(1);
            }
        });
    });

    function renderEvidenciasPublic(evidencias) {
        const grid = document.getElementById('evidencias-grid');
        grid.innerHTML = '';
        evidencias.forEach((ev, index) => {
            // Solo mostramos las evidencias que sean públicas (es un control extra aunque la API ya debe filtrarlas)
            // No obstante, confiamos en la API public.
            const baseUrl = "{{ rtrim(config('services.api.url'), '/') }}";
            let imgUrl = ev.url_imagen;
            if(imgUrl && !imgUrl.startsWith('http')) {
                imgUrl = baseUrl + (imgUrl.startsWith('/') ? '' : '/') + imgUrl;
            }

            const item = document.createElement('div');
            item.className = 'group relative rounded-xl overflow-hidden cursor-pointer aspect-square bg-[#1a1a1a] border border-[#374151] hover:border-[#25B5DA] transition-all duration-300 transform hover:scale-105';
            item.onclick = () => openEvidenciaModal(index);

            item.innerHTML = `
                <img src="${imgUrl}" alt="${ev.servicio?.nombre || 'Evidencia'}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                    <span class="text-white font-bold text-xs md:text-sm truncate uppercase tracking-widest">${ev.servicio?.nombre || 'General'}</span>
                </div>
            `;
            grid.appendChild(item);
        });
    }

    function openEvidenciaModal(index) {
        currentEvidenciaIndex = index;
        updateModalContent();
        document.getElementById('modal-evidencia').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // prevent scrolling
    }

    function closeEvidenciaModal() {
        document.getElementById('modal-evidencia').classList.add('hidden');
        document.body.style.overflow = 'auto'; // allow scrolling
    }

    function updateModalContent() {
        if(evidenciasData.length === 0) return;
        const ev = evidenciasData[currentEvidenciaIndex];
        
        const baseUrl = "{{ rtrim(config('services.api.url'), '/') }}";
        let imgUrl = ev.url_imagen;
        if(imgUrl && !imgUrl.startsWith('http')) {
            imgUrl = baseUrl + (imgUrl.startsWith('/') ? '' : '/') + imgUrl;
        }

        document.getElementById('evidencia-imagen-grande').src = imgUrl;
        document.getElementById('evidencia-servicio-nombre').innerText = ev.servicio?.nombre || 'Trabajo General';
        document.getElementById('evidencia-descripcion').innerText = ev.descripcion || 'Sin descripción adicional.';

        // Navigation buttons
        const prevBtn = document.getElementById('prev-evidencia');
        const nextBtn = document.getElementById('next-evidencia');

        if(evidenciasData.length > 1) {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            
            // Re-assign listeners
            prevBtn.onclick = (e) => { e.stopPropagation(); navigateEvidencia(-1); };
            nextBtn.onclick = (e) => { e.stopPropagation(); navigateEvidencia(1); };
        } else {
            prevBtn.classList.add('hidden');
            nextBtn.classList.add('hidden');
        }
    }

    function navigateEvidencia(direction) {
        currentEvidenciaIndex += direction;
        if(currentEvidenciaIndex < 0) currentEvidenciaIndex = evidenciasData.length - 1;
        if(currentEvidenciaIndex >= evidenciasData.length) currentEvidenciaIndex = 0;
        updateModalContent();
    }
</script>

@endsection