@extends('layouts.app')

@section('title', $negocio['nombre'] ?? 'Negocio')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen">
    <!-- Hero Section compacta -->
    <div class="relative">
        <!-- Banner -->
        <div class="h-48 md:h-56 overflow-hidden">
            @if(isset($negocio['banner']) && $negocio['banner'])
                <img src="{{ $negocio['banner'] }}" 
                     alt="{{ $negocio['nombre'] }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-gray-800 to-gray-900"></div>
            @endif
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        
        <!-- Perfil superpuesto -->
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-start md:items-end gap-4 -mt-12 md:-mt-16 relative z-10">
                <!-- Logo -->
                <div class="w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-[#1a1a1a] shadow-xl overflow-hidden bg-[#2a2a2a] flex-shrink-0">
                    @if(!empty($negocio['foto_perfil']))
                        <img src="{{ $negocio['foto_perfil'] }}" 
                             alt="{{ $negocio['nombre'] }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-2xl text-gray-500">
                            <i class="fas fa-store"></i>
                        </div>
                    @endif
                </div>
                
                <div class="flex-1 pb-2">
                    <h1 class="text-xl md:text-2xl font-bold uppercase tracking-wide text-white">{{ $negocio['nombre'] }}</h1>
                    <div class="flex flex-wrap gap-3 text-gray-300 text-xs mt-1">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-star text-[#25B5DA] text-[10px]"></i>
                            @if(isset($negocio['calificacion']) && $negocio['calificacion'] > 0)
                                {{ number_format($negocio['calificacion'], 1) }}
                            @else
                                Sin reseñas
                            @endif
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-[10px]"></i>
                            {{ $negocio['direccion']['ciudad'] ?? 'Ciudad no especificada' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-tag text-[10px]"></i>
                            {{ ucfirst($negocio['tipo_negocio'] ?? 'Servicios') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-phone text-[10px]"></i>
                            {{ $negocio['telefono'] ?? 'No disponible' }}
                        </span>
                    </div>
                    <p class="text-[#9CA3AF] text-xs mt-1 max-w-xl line-clamp-1">
                        {{ $negocio['acerca_de'] ?? '' }}
                    </p>
                </div>
                
                <!-- Botón Agendar Cita -->
                <a href="/agendar-cita?negocio_id={{ $negocio['id_negocio'] }}" 
                   class="px-4 py-2 bg-white text-black font-bold rounded-lg hover:bg-gray-200 transition-colors text-xs uppercase tracking-wide flex items-center gap-2 mb-2">
                    <i class="fas fa-calendar-alt"></i>
                    Agendar Cita
                </a>
            </div>
        </div>
    </div>
    
    <!-- Contenido principal - SIN padding superior excesivo -->
    <div class="max-w-7xl mx-auto px-6 pt-4 pb-12">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Columna izquierda -->
            <div class="lg:w-2/3 space-y-5">
                <!-- Stats Cards -->
                <div class="grid grid-cols-3 gap-3">
                    <div onclick="document.getElementById('servicios-section').scrollIntoView({ behavior: 'smooth' })" 
                         class="bg-[#262626] border border-[#374151] p-3 rounded-lg text-center cursor-pointer hover:border-[#25B5DA] transition-all">
                        <p class="text-[9px] uppercase tracking-widest text-[#9CA3AF]">Servicios</p>
                        <p class="text-xl font-bold text-white">{{ count($servicios) }}</p>
                    </div>
                    <div onclick="document.getElementById('empleados-section').scrollIntoView({ behavior: 'smooth' })" 
                         class="bg-[#262626] border border-[#374151] p-3 rounded-lg text-center cursor-pointer hover:border-[#25B5DA] transition-all">
                        <p class="text-[9px] uppercase tracking-widest text-[#9CA3AF]">Empleados</p>
                        <p class="text-xl font-bold text-white">{{ count($empleados) }}</p>
                    </div>
                    <div onclick="document.getElementById('resenas-section').scrollIntoView({ behavior: 'smooth' })" 
                         class="bg-[#262626] border border-[#374151] p-3 rounded-lg text-center cursor-pointer hover:border-[#25B5DA] transition-all">
                        <p class="text-[9px] uppercase tracking-widest text-[#9CA3AF]">Reseñas</p>
                        <p class="text-xl font-bold text-white">{{ count($resenas) }}</p>
                    </div>
                </div>
                
                <!-- Redes Sociales -->
                @if(isset($negocio['redes_sociales']) && $negocio['redes_sociales'])
                <div class="bg-[#262626] border border-[#374151] rounded-lg p-3">
                    <a href="{{ $negocio['redes_sociales'] }}" target="_blank" 
                       class="inline-flex items-center gap-2 text-[#9CA3AF] hover:text-white transition-all text-xs">
                        <i class="fab fa-instagram text-[#25B5DA]"></i>
                        {{ $negocio['redes_sociales'] }}
                    </a>
                </div>
                @endif
                
                <!-- Servicios -->
                <div id="servicios-section" class="bg-[#262626] border border-[#374151] rounded-lg p-5">
                    <h3 class="text-base font-bold uppercase tracking-widest text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-cut text-[#25B5DA] text-sm"></i> 
                        Servicios
                        <span class="text-xs text-[#9CA3AF] font-normal">({{ count($servicios) }})</span>
                    </h3>
                    
                    @if(count($servicios) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($servicios as $servicio)
                        <div class="group bg-[#1a1a1a] rounded-lg overflow-hidden border border-[#374151] hover:border-[#25B5DA] transition-all">
                            <div class="relative h-28 overflow-hidden">
                                @if(isset($servicio['imagen']) && $servicio['imagen'])
                                    <img src="{{ $servicio['imagen'] }}" 
                                         alt="{{ $servicio['nombre'] }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                        <i class="fas fa-cut text-xl text-gray-600"></i>
                                    </div>
                                @endif
                                <div class="absolute top-1 right-1 bg-black/70 px-1.5 py-0.5 rounded-full">
                                    <span class="text-[#25B5DA] font-bold text-[10px]">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="p-2">
                                <h4 class="text-white font-bold text-xs">{{ $servicio['nombre'] }}</h4>
                                <p class="text-[#9CA3AF] text-[9px] mt-1 line-clamp-2">{{ $servicio['descripcion'] ?? 'Sin descripción' }}</p>
                                <div class="mt-1 flex items-center gap-1 text-[9px] text-[#9CA3AF]">
                                    <i class="far fa-clock"></i>
                                    <span>{{ $servicio['duracion'] }} min</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-center text-[#9CA3AF] text-sm py-4">No hay servicios disponibles.</p>
                    @endif
                </div>
                
                <!-- Evidencias -->
                @if(isset($evidencias) && count($evidencias) > 0)
                <div id="evidencias-section" class="bg-[#262626] border border-[#374151] rounded-lg p-5">
                    <h3 class="text-base font-bold uppercase tracking-widest text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-camera text-[#25B5DA] text-sm"></i> 
                        Nuestros Trabajos
                    </h3>
                    <div id="evidencias-grid" class="grid grid-cols-3 md:grid-cols-4 gap-2"></div>
                </div>
                @endif

                <!-- Reseñas -->
                <div id="resenas-section" class="bg-[#262626] border border-[#374151] rounded-lg p-5">
                    <h3 class="text-base font-bold uppercase tracking-widest text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-star text-[#25B5DA] text-sm"></i> 
                        Reseñas
                        <span class="text-xs text-[#9CA3AF] font-normal">({{ count($resenas) }})</span>
                    </h3>
                    <div class="space-y-3">
                        @forelse($resenas as $resena)
                        <div class="border-b border-[#374151] pb-2 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <div class="flex text-[#25B5DA]">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($resena['calificacion'] ?? 0))
                                                <i class="fas fa-star text-[9px]"></i>
                                            @else
                                                <i class="far fa-star text-[9px] text-[#374151]"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-[9px] text-[#9CA3AF]">{{ $resena['cliente']['nombre'] ?? 'Cliente' }}</span>
                            </div>
                            @if($resena['comentario'])
                            <p class="text-[10px] text-[#D1D5DB] mt-1">"{{ $resena['comentario'] }}"</p>
                            @endif
                            <p class="text-[8px] text-[#52525b] mt-1">{{ \Carbon\Carbon::parse($resena['created_at'])->diffForHumans() }}</p>
                        </div>
                        @empty
                        <p class="text-xs text-[#52525b] italic text-center py-2">No hay reseñas aún.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Columna derecha -->
            <div class="lg:w-1/3 flex flex-col gap-5">
                <!-- Equipo de Trabajo -->
                <div id="empleados-section" class="bg-[#262626] border border-[#374151] rounded-lg p-5">
                    <h3 class="text-base font-bold uppercase tracking-widest text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-users text-[#25B5DA] text-sm"></i> 
                        Equipo
                        <span class="text-xs text-[#9CA3AF] font-normal">({{ count($empleados) }})</span>
                    </h3>
                    <div class="space-y-2">
                        @forelse($empleados as $empleado)
                        <div class="flex items-center gap-2 p-2 bg-[#1a1a1a] border border-[#374151] rounded-lg">
                            <div class="w-7 h-7 rounded-full bg-[#25B5DA]/20 text-[#25B5DA] flex items-center justify-center text-[10px] font-bold">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <span class="text-xs text-[#D1D5DB] font-bold block">
                                    {{ $empleado['nombre'] }} {{ $empleado['app_paterno'] ?? '' }}
                                </span>
                                @if(isset($empleado['especialidad']) && $empleado['especialidad'])
                                <span class="text-[8px] text-[#52525b]">{{ $empleado['especialidad'] }}</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-[#52525b] italic text-center py-2">Sin empleados registrados.</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Horario -->
                <div class="bg-[#262626] border border-[#374151] rounded-lg p-5">
                    <h3 class="text-base font-bold uppercase tracking-widest text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-clock text-[#25B5DA] text-sm"></i> 
                        Horario
                    </h3>
                    @if(isset($horariosFormateados) && count($horariosFormateados) > 0)
                    <div class="space-y-1">
                        @foreach($horariosFormateados as $horario)
                        <div class="flex justify-between text-[10px] py-1 border-b border-[#374151]/30 last:border-0">
                            <span class="text-[#9CA3AF]">{{ $horario['dia'] }}</span>
                            <div class="text-right">
                                @if($horario['abierto'])
                                    @foreach($horario['horarios'] as $bloque)
                                        @if($bloque !== 'Cerrado')
                                            <span class="text-white text-[10px]">{{ $bloque }}</span>
                                        @else
                                            <span class="text-red-400 text-[10px]">Cerrado</span>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-red-400 text-[10px]">Cerrado</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-xs text-[#52525b] italic">Horario no disponible.</p>
                    @endif
                </div>
                
                <!-- Ubicación -->
                @if(isset($negocio['direccion']))
                @php
                    $calle = $negocio['direccion']['calle'] ?? '';
                    $numero = $negocio['direccion']['numero'] ?? '';
                    $colonia = $negocio['direccion']['colonia'] ?? '';
                    $ciudad = $negocio['direccion']['ciudad'] ?? '';
                    $estado = $negocio['direccion']['estado'] ?? '';
                    $cp = $negocio['direccion']['codigo_postal'] ?? '';
                    $direccionCompleta = trim("$calle $numero, $colonia, $ciudad, $estado, CP $cp");
                    $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($direccionCompleta);
                @endphp

                <div class="bg-[#262626] border border-[#374151] rounded-lg p-5">
                    <h3 class="text-base font-bold uppercase tracking-widest text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-location-dot text-[#25B5DA] text-sm"></i> 
                        Ubicación
                    </h3>
                    <a href="{{ $googleMapsUrl }}" target="_blank" class="block">
                        <p class="text-[10px] text-[#D1D5DB] hover:text-[#25B5DA] transition-colors leading-relaxed">
                            {{ $calle }} {{ $numero }}<br>
                            {{ $colonia }}<br>
                            {{ $ciudad }}, {{ $estado }}<br>
                            CP: {{ $cp }}
                        </p>
                        <div class="flex items-center gap-1 mt-2 text-[9px] text-[#25B5DA] opacity-70 hover:opacity-100">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Google Maps</span>
                        </div>
                    </a>
                </div>
                @endif
                
                <!-- Contacto -->
                @if(isset($negocio['telefono']) && $negocio['telefono'])
                <div class="bg-[#262626] border border-[#374151] rounded-lg p-5">
                    <h3 class="text-base font-bold uppercase tracking-widest text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-phone text-[#25B5DA] text-sm"></i> 
                        Contacto
                    </h3>
                    <a href="tel:{{ $negocio['telefono'] }}" class="text-xs text-[#D1D5DB] hover:text-white transition-colors">
                        {{ $negocio['telefono'] }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<!-- Modal de Evidencias -->
<div id="modal-evidencia" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/90">
    <div class="absolute inset-0" onclick="closeEvidenciaModal()"></div>
    <div class="relative max-w-3xl w-full">
        <button onclick="closeEvidenciaModal()" class="absolute -top-8 right-0 text-white hover:text-[#25B5DA] text-xl">
            <i class="fas fa-times"></i>
        </button>
        <button id="prev-evidencia" class="absolute left-0 top-1/2 -translate-y-1/2 -left-8 text-white hover:text-[#25B5DA] text-2xl hidden">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="next-evidencia" class="absolute right-0 top-1/2 -translate-y-1/2 -right-8 text-white hover:text-[#25B5DA] text-2xl hidden">
            <i class="fas fa-chevron-right"></i>
        </button>
        <img id="evidencia-imagen-grande" src="" alt="Evidencia" class="w-full h-auto max-h-[70vh] object-contain rounded-lg">
        <div class="mt-2 text-center">
            <h4 id="evidencia-servicio-nombre" class="text-white font-bold text-xs"></h4>
            <p id="evidencia-descripcion" class="text-[#9CA3AF] text-[9px] mt-1"></p>
        </div>
    </div>
</div>

<script>
    let evidenciasData = @json($evidencias ?? []);
    let currentEvidenciaIndex = 0;

    document.addEventListener('DOMContentLoaded', () => {
        if (evidenciasData.length > 0) {
            renderEvidenciasPublic(evidenciasData);
        } else {
            const section = document.getElementById('evidencias-section');
            if (section) section.remove();
        }
            
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
        if (!grid) return;
        grid.innerHTML = '';
        evidencias.forEach((ev, index) => {
            const baseUrl = "{{ rtrim(config('services.api.url'), '/') }}";
            let imgUrl = ev.url_imagen;
            if(imgUrl && !imgUrl.startsWith('http')) {
                imgUrl = baseUrl + (imgUrl.startsWith('/') ? '' : '/') + imgUrl;
            }

            const item = document.createElement('div');
            item.className = 'relative aspect-square rounded-lg overflow-hidden cursor-pointer border border-[#374151] hover:border-[#25B5DA] transition-all';
            item.onclick = () => openEvidenciaModal(index);
            item.innerHTML = `<img src="${imgUrl}" class="w-full h-full object-cover">`;
            grid.appendChild(item);
        });
    }

    function openEvidenciaModal(index) {
        currentEvidenciaIndex = index;
        updateModalContent();
        document.getElementById('modal-evidencia').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEvidenciaModal() {
        document.getElementById('modal-evidencia').classList.add('hidden');
        document.body.style.overflow = 'auto';
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
        document.getElementById('evidencia-servicio-nombre').innerText = ev.servicio_nombre || 'Trabajo';
        document.getElementById('evidencia-descripcion').innerText = ev.descripcion || '';

        const prevBtn = document.getElementById('prev-evidencia');
        const nextBtn = document.getElementById('next-evidencia');

        if(evidenciasData.length > 1) {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            prevBtn.onclick = () => navigateEvidencia(-1);
            nextBtn.onclick = () => navigateEvidencia(1);
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