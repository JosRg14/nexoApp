@extends('layouts.app')

@section('title', $negocio['nombre'] ?? 'Negocio')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen">
    <!-- Hero Section con imagen de fondo -->
    <div class="relative h-80 md:h-96 overflow-hidden">
        @if(isset($negocio['banner']) && $negocio['banner'])
            <img src="{{ $negocio['banner'] }}" 
                 alt="{{ $negocio['nombre'] }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-r from-gray-800 to-gray-900"></div>
        @endif
        <div class="absolute inset-0 bg-black/50"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-end gap-6">
                <!-- Logo -->
                <div class="w-28 h-28 md:w-36 md:h-36 rounded-full border-4 border-white overflow-hidden bg-[#2a2a2a]">
                    @if(isset($negocio['foto_perfil']) && $negocio['foto_perfil'])
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
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide border 
                            {{ isset($negocio['estado']) && strtolower($negocio['estado']) === 'activo' 
                                ? 'text-emerald-500 border-emerald-500/20 bg-emerald-500/10' 
                                : 'text-yellow-500 border-yellow-500/20 bg-yellow-500/10' }}">
                            {{ $negocio['estado'] ?? 'pendiente' }}
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap gap-4 text-gray-300 text-sm">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-star text-yellow-500"></i>
                            {{ isset($negocio['calificacion']) ? number_format($negocio['calificacion'], 1) . ' ★' : 'Nuevo' }}
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
                
                @if(!session()->has('rol'))
                <a href="/register" class="px-6 py-3 bg-white text-black font-bold rounded-lg hover:bg-gray-200 transition-colors text-sm uppercase tracking-wide flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    Agendar Cita
                </a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna izquierda -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Servicios</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ count($servicios) }}</p>
                    </div>
                    <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Empleados</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ count($empleados) }}</p>
                    </div>
                    <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Reseñas</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ count($resenas) }}</p>
                    </div>
                </div>
                
                <!-- Redes Sociales -->
                @if(isset($negocio['redes_sociales']) && $negocio['redes_sociales'])
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fab fa-instagram"></i> Redes Sociales
                    </h3>
                    <a href="{{ $negocio['redes_sociales'] }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-white transition-all text-xs uppercase tracking-wider">
                        <i class="fab fa-instagram"></i>
                        {{ $negocio['redes_sociales'] }}
                    </a>
                </div>
                @endif
                
                <!-- Servicios -->
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-cut"></i> Servicios Ofrecidos ({{ count($servicios) }})
                    </h3>
                    <div class="space-y-3">
                        @forelse($servicios as $servicio)
                        <div class="flex justify-between items-center py-2 border-b border-[#374151]/50 last:border-0 last:pb-0">
                            <div>
                                <span class="text-sm text-[#D1D5DB] block">{{ $servicio['nombre'] }}</span>
                                <span class="text-[10px] text-[#52525b] uppercase tracking-tighter">
                                    {{ $servicio['duracion'] ?? 30 }} MINUTOS
                                </span>
                                @if(isset($servicio['descripcion']) && $servicio['descripcion'])
                                <p class="text-xs text-[#9CA3AF] mt-1">{{ $servicio['descripcion'] }}</p>
                                @endif
                            </div>
                            <span class="text-sm font-mono text-white">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
                        </div>
                        @empty
                        <p class="text-xs text-[#52525b] italic">Sin servicios registrados.</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Reseñas -->
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-star"></i> Reseñas ({{ count($resenas) }})
                    </h3>
                    <div class="space-y-4">
                        @forelse($resenas as $resena)
                        <div class="border-b border-[#374151] pb-4 last:border-0 last:pb-0">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $resena['calificacion'])
                                            <i class="fas fa-star text-xs"></i>
                                        @else
                                            <i class="far fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs text-[#9CA3AF]">{{ $resena['cliente']['nombre'] ?? 'Cliente' }}</span>
                            </div>
                            <p class="text-sm text-[#D1D5DB]">{{ $resena['comentario'] }}</p>
                            <p class="text-[10px] text-[#52525b] mt-1">{{ \Carbon\Carbon::parse($resena['created_at'])->diffForHumans() }}</p>
                        </div>
                        @empty
                        <p class="text-xs text-[#52525b] italic">No hay reseñas aún. ¡Sé el primero en calificar!</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Columna derecha -->
            <div class="space-y-6">
                <!-- Equipo de Trabajo -->
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-users"></i> Nuestro Equipo ({{ count($empleados) }})
                    </h3>
                    <div class="space-y-3">
                        @forelse($empleados as $empleado)
                        <div class="flex items-center gap-3 p-3 bg-[#1a1a1a] border border-[#374151]">
                            <div class="w-8 h-8 bg-blue-500/20 text-blue-500 flex items-center justify-center text-[10px] font-bold rounded-full">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <div>
                                <span class="text-xs text-[#D1D5DB] uppercase tracking-wider font-bold block">{{ $empleado['nombre'] }}</span>
                                @if(isset($empleado['especialidad']) && $empleado['especialidad'])
                                <span class="text-[10px] text-[#52525b]">{{ $empleado['especialidad'] }}</span>
                                @endif
                            </div>
                            @if(isset($empleado['calificacion']))
                            <div class="ml-auto flex items-center gap-1 text-[10px] text-yellow-500">
                                <i class="fas fa-star"></i>
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
                        <i class="fas fa-clock"></i> Horario de Atención
                    </h3>
                    @if(isset($negocio['horarios']) && count($negocio['horarios']) > 0)
                    <div class="space-y-2">
                        @foreach($negocio['horarios'] as $horario)
                        <div class="flex justify-between text-sm py-1 border-b border-[#374151]/50 last:border-0">
                            <span class="text-[#9CA3AF]">{{ $horario['dia'] }}</span>
                            <span class="text-white">{{ $horario['hora_apertura'] }} - {{ $horario['hora_cierre'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-xs text-[#52525b] italic">Horario no disponible.</p>
                    @endif
                </div>
                
                <!-- Ubicación -->
                @if(isset($negocio['direccion']))
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-location-dot"></i> Ubicación
                    </h3>
                    <div class="space-y-1 text-sm">
                        <p class="text-[#D1D5DB]">
                            {{ $negocio['direccion']['calle'] ?? '' }} {{ $negocio['direccion']['numero'] ?? '' }}<br>
                            {{ $negocio['direccion']['colonia'] ?? '' }}<br>
                            {{ $negocio['direccion']['ciudad'] ?? '' }}, {{ $negocio['direccion']['estado'] ?? '' }}<br>
                            <span class="text-[#9CA3AF]">CP: {{ $negocio['direccion']['codigo_postal'] ?? '' }}</span>
                        </p>
                    </div>
                </div>
                @endif
                
                <!-- Contacto -->
                @if(isset($negocio['telefono']) && $negocio['telefono'])
                <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-phone"></i> Contacto
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
@endsection