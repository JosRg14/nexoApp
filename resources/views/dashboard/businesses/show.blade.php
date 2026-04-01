@extends('layouts.dashboard')

@section('title', 'NexoApp - Detalle: ' . $business['nombre'])

@if ($errors->any())
    <div class="bg-red-500 text-white p-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <div class="mb-8 border-b border-[#374151] pb-8">
        <a href="{{ route('dashboard.businesses') }}"
            class="text-[#9CA3AF] hover:text-white text-xs uppercase tracking-widest mb-4 inline-block flex items-center gap-2 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a la lista
        </a>

        <div class="flex justify-between items-start mt-4">
            <div class="flex gap-6">
                <div
                    class="h-24 w-24 bg-[#374151] rounded-sm flex items-center justify-center text-2xl font-bold text-white shadow-lg">
                    {{ strtoupper(substr($business['nombre'], 0, 2)) }}
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold uppercase tracking-wide text-white">{{ $business['nombre'] }}</h1>

                        @php
                            // Normalización segura del estado
                            $currentStatus = is_array($business['estado'])
                                ? $business['estado']['nombre'] ?? 'pendiente'
                                : $business['estado'] ?? 'pendiente';
                            $status = strtolower($currentStatus);

                            $statusClass =
                                $status === 'activo'
                                    ? 'text-emerald-500 border-emerald-500/20 bg-emerald-500/10'
                                    : 'text-[#25B5DA] border-[#25B5DA]/20 bg-[#25B5DA]/10';
                        @endphp

                        <span
                            class="{{ $statusClass }} px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide border">
                            {{ $status }}
                        </span>
                    </div>
                    <p class="text-[#9CA3AF] text-sm mb-4 max-w-xl">
                        Información administrativa del negocio registrado en NexoPlatform.
                    </p>

                    <div class="flex gap-6 text-xs text-[#D1D5DB] tracking-wide">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ is_array($business['propietario']) ? $business['propietario']['name'] ?? 'Usuario' : $business['propietario'] }}
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Dueño del Negocio
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                    <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Citas Totales</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ number_format($business['citas_total'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                    <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Valoración</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $business['valoracion'] ?? 'N/A' }} ★</p>
                </div>
                <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                    <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Citas (Mes)</p>
                    <p class="text-2xl font-bold text-emerald-500 mt-1">{{ $business['citas_mes'] ?? 0 }}</p>
                </div>
            </div>

            {{-- Servicios --}}
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Servicios Ofrecidos
                    ({{ count($business['servicios'] ?? []) }})</h3>
                <div class="space-y-3">
                    @forelse($business['servicios'] ?? [] as $servicio)
                        <div
                            class="flex justify-between items-center py-2 border-b border-[#374151]/50 last:border-0 last:pb-0">
                            <div>
                                <span class="text-sm text-[#D1D5DB] block">{{ $servicio['nombre_servicio'] }}</span>
                                <span
                                    class="text-[10px] text-[#52525b] uppercase tracking-tighter">{{ $servicio['duracion_estimada'] }}
                                    MINUTOS</span>
                            </div>
                            <span
                                class="text-sm font-mono text-white">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-[#52525b] italic">Sin servicios registrados.</p>
                    @endforelse
                </div>
            </div>

            {{-- Equipo de Trabajo --}}
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Equipo de Trabajo</h3>
                <div class="grid grid-cols-2 gap-4">
                    @forelse($business['empleados'] ?? [] as $empleado)
                        <div class="flex items-center gap-3 p-3 bg-[#1a1a1a] border border-[#374151]">
                            <div
                                class="w-8 h-8 bg-blue-500/20 text-blue-500 flex items-center justify-center text-[10px] font-bold">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <span
                                class="text-xs text-[#D1D5DB] uppercase tracking-wider font-bold">{{ $empleado['nombre'] }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-[#52525b] italic col-span-2">Sin empleados registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Plan & Suscripción Dinámico --}}
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Plan & Suscripción</h3>

                @forelse($subscriptions as $sub)
                    <div
                        class="mb-6 p-4 bg-[#1a1a1a] border-l-2 {{ $sub['vencida'] ? 'border-red-500' : 'border-emerald-500' }}">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-white uppercase tracking-tighter">Plan&nbsp;
                                {{ $sub['plan'] }}</span>
                            <span
                                class="text-[10px] uppercase px-2 py-0.5 rounded {{ $sub['vencida'] ? 'bg-red-500/10 text-red-500' : 'bg-emerald-500/10 text-emerald-500' }}">
                                {{ $sub['estado'] }}
                            </span>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] text-[#9CA3AF] uppercase">Vencimiento:
                                <span
                                    class="text-white">{{ \Carbon\Carbon::parse($sub['fecha_vencimiento'])->format('d/m/Y') }}</span>
                            </p>
                            <p class="text-[10px] text-[#9CA3AF] uppercase">Costo:
                                <span class="text-white">${{ number_format($sub['costo'], 0, ',', ',') }}</span>
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-[#52525b] italic mb-4">No hay suscripciones activas.</p>
                @endforelse

                {{-- Selector de Cambio de Plan --}}
                {{-- Selector de Cambio de Plan --}}
                <form action="{{ route('dashboard.plans.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" name="negocio_id" value="{{ $business['id'] }}">

                    <div class="relative w-full mb-4">
                        <select name="suscripcion_id" required
                            class="block appearance-none w-full bg-[#1a1a1a] border border-[#374151] text-white py-3 px-4 pr-8 text-xs font-bold uppercase tracking-widest focus:outline-none focus:border-white transition-colors cursor-pointer">
                            <option value="" disabled selected>SELECCIONAR NUEVO PLAN</option>
                            @foreach ($planesDisponibles as $plan)
                                {{-- Opcional: Mostrar el costo también ayuda al admin --}}
                                <option value="{{ $plan['id'] }}">
                                    {{ strtoupper($plan['tipo']) }} - ${{ number_format($plan['costo'], 0, ',', ',') }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-emerald-500/10 border border-emerald-500/50 text-emerald-500 text-xs font-bold uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all">
                        Actualizar Plan
                    </button>
                </form>
            </div>

            {{-- Moderación --}}
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Moderación</h3>
                <p class="text-xs text-[#9CA3AF] mb-6">Estado actual:
                    {{-- Protegemos el strtoupper por si 'estado' fuera array --}}
                    <strong>{{ strtoupper(is_array($business['estado']) ? $business['estado']['nombre'] ?? 'pendiente' : $business['estado'] ?? 'pendiente') }}</strong>
                </p>

                <div class="space-y-3">
                    @php
                        // Normalizamos el estado actual para la lógica interna
                        $rawStatus = is_array($business['estado'])
                            ? $business['estado']['nombre'] ?? 'pendiente'
                            : $business['estado'] ?? 'pendiente';
                        $currentStatus = strtolower($rawStatus);

                        // Definimos qué estado enviar según el estado actual
                        $nextStatus = $currentStatus === 'activo' ? 'suspendido' : 'activo';

                        // Colores dinámicos para el botón
                        $buttonClass =
                            $currentStatus === 'activo'
                                ? 'bg-red-500/10 text-red-500 border-red-500/20 hover:bg-red-500/20'
                                : 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20 hover:bg-emerald-500/20';

                        $buttonText = $currentStatus === 'activo' ? 'Suspender Negocio' : 'Activar Negocio';
                    @endphp

                    <form action="{{ route('dashboard.businesses.updateStatus', $business['id']) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="estado" value="{{ $nextStatus }}">

                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl border {{ $buttonClass }} transition-all duration-200 font-medium">
                            @if ($currentStatus === 'activo')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                            {{ $buttonText }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
