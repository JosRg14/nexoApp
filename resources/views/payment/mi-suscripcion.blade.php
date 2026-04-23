@extends('layouts.app')

@section('title', 'Mi Suscripción')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-10">
            <p class="text-[#25B5DA] text-[10px] uppercase tracking-[0.3em] font-bold mb-2">Cuenta</p>
            <h1 class="text-4xl font-black text-white uppercase tracking-tight">Mi Suscripción</h1>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-500/10 border border-green-500/30 rounded-xl p-4 flex items-start gap-3">
            <i class="fas fa-circle-check text-green-400 mt-0.5"></i>
            <p class="text-green-400 text-sm">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-500/10 border border-red-500/30 rounded-xl p-4 flex items-start gap-3">
            <i class="fas fa-circle-exclamation text-red-400 mt-0.5"></i>
            <p class="text-red-400 text-sm">{{ session('error') }}</p>
        </div>
        @endif

        @if($suscripcion)
        {{-- Active Subscription --}}
        <div class="space-y-5">

            {{-- Main Plan Card --}}
            <div class="bg-[#262626] border border-[#374151] rounded-2xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#25B5DA]/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-[#25B5DA]/15 rounded-xl flex items-center justify-center">
                                <i class="fas fa-crown text-[#25B5DA]"></i>
                            </div>
                            <div>
                                <p class="text-[#25B5DA] text-[10px] uppercase tracking-widest font-bold">Plan Activo</p>
                                <h2 class="text-2xl font-black text-white">{{ $suscripcion['plan_nombre'] ?? $suscripcion['plan'] ?? 'Plan NexoApp' }}</h2>
                            </div>
                        </div>
                    </div>

                    @php
                        $estado = strtolower($suscripcion['estado'] ?? 'activo');
                        $statusColor = match($estado) {
                            'activo', 'active' => 'green',
                            'cancelado', 'cancelled' => 'red',
                            'pendiente', 'pending' => 'yellow',
                            default => 'gray'
                        };
                    @endphp
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-{{ $statusColor }}-500/15 border border-{{ $statusColor }}-500/30 text-{{ $statusColor }}-400 rounded-full text-xs font-black uppercase tracking-widest">
                        <span class="w-1.5 h-1.5 bg-{{ $statusColor }}-400 rounded-full {{ $estado === 'activo' || $estado === 'active' ? 'animate-pulse' : '' }}"></span>
                        {{ ucfirst($estado) }}
                    </span>
                </div>

                {{-- Dates Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    @if($suscripcion['fecha_inicio'] ?? null)
                    <div class="bg-[#1a1a1a] border border-[#374151]/40 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-calendar-plus text-[#25B5DA] text-sm"></i>
                            <p class="text-[#9CA3AF] text-[10px] uppercase tracking-widest">Inicio</p>
                        </div>
                        <p class="text-white font-bold text-lg">
                            {{ \Carbon\Carbon::parse($suscripcion['fecha_inicio'])->format('d/m/Y') }}
                        </p>
                    </div>
                    @endif

                    @if($suscripcion['fecha_vencimiento'] ?? null)
                    @php
                        $vence = \Carbon\Carbon::parse($suscripcion['fecha_vencimiento']);
                        $diasRestantes = now()->diffInDays($vence, false);
                        $urgente = $diasRestantes <= 7 && $diasRestantes >= 0;
                    @endphp
                    <div class="bg-[#1a1a1a] border {{ $urgente ? 'border-yellow-500/30' : 'border-[#374151]/40' }} rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-calendar-xmark text-{{ $urgente ? 'yellow' : '[#25B5DA]' }}-{{ $urgente ? '400' : '' }} text-sm {{ !$urgente ? 'text-[#25B5DA]' : '' }}"></i>
                            <p class="text-[#9CA3AF] text-[10px] uppercase tracking-widest">Vencimiento</p>
                        </div>
                        <p class="text-white font-bold text-lg">{{ $vence->format('d/m/Y') }}</p>
                        @if($urgente)
                        <p class="text-yellow-400 text-[10px] mt-1 font-bold">{{ $diasRestantes }} días restantes</p>
                        @elseif($diasRestantes > 0)
                        <p class="text-[#9CA3AF] text-[10px] mt-1">{{ $diasRestantes }} días restantes</p>
                        @else
                        <p class="text-red-400 text-[10px] mt-1 font-bold">Vencida</p>
                        @endif
                    </div>
                    @endif

                    @if($suscripcion['metodo_pago'] ?? null)
                    <div class="bg-[#1a1a1a] border border-[#374151]/40 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-credit-card text-[#25B5DA] text-sm"></i>
                            <p class="text-[#9CA3AF] text-[10px] uppercase tracking-widest">Método de pago</p>
                        </div>
                        <p class="text-white font-bold capitalize">{{ $suscripcion['metodo_pago'] }}</p>
                    </div>
                    @endif
                </div>

                {{-- Stripe Info (si aplica) --}}
                @if(($suscripcion['metodo_pago'] ?? '') === 'stripe')
                <div class="flex items-center gap-3 p-4 bg-[#1a1a1a] border border-[#374151]/40 rounded-xl mb-8">
                    <i class="fab fa-stripe text-[#25B5DA] text-2xl"></i>
                    <div>
                        <p class="text-white text-sm font-bold">Gestionado por Stripe</p>
                        <p class="text-[#9CA3AF] text-xs">Tu suscripción se renueva automáticamente. Puedes cancelarla aquí en cualquier momento.</p>
                    </div>
                </div>
                @endif

                {{-- Cancel Button --}}
                @if(in_array($estado, ['activo', 'active']))
                <div class="border-t border-[#374151]/30 pt-6">
                    <p class="text-[#9CA3AF] text-xs mb-4">Conservarás el acceso hasta el final del período pagado.</p>
                    <form action="{{ route('payment.cancelar') }}" method="POST"
                          x-data="{}"
                          @submit.prevent="
                            const r = await confirmCustom('¿Cancelar suscripción?', 'Perderás el acceso al finalizar el período.');
                            if (r.isConfirmed) $el.submit();
                          ">
                        @csrf
                        <button type="submit"
                            id="btn-cancelar-suscripcion"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl hover:bg-red-500/20 hover:border-red-500/50 transition-all text-xs font-black uppercase tracking-widest">
                            <i class="fas fa-ban"></i>
                            Cancelar Suscripción
                        </button>
                    </form>
                </div>
                @endif
            </div>

            {{-- Upgrade Notice --}}
            <div class="bg-gradient-to-r from-[#25B5DA]/10 to-transparent border border-[#25B5DA]/20 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#25B5DA]/20 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-rocket text-[#25B5DA]"></i>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm">¿Necesitas más funcionalidades?</p>
                        <p class="text-[#9CA3AF] text-xs mt-0.5">Explora nuestros planes y lleva tu negocio al siguiente nivel.</p>
                    </div>
                </div>
                <a href="{{ route('payment.plans') }}"
                   class="shrink-0 px-6 py-3 bg-[#25B5DA] text-black font-black text-xs uppercase tracking-widest rounded-xl hover:bg-[#1c8fb0] transition-all whitespace-nowrap">
                    Ver Planes
                </a>
            </div>
        </div>

        @else
        {{-- No Subscription --}}
        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-14 text-center">
            <div class="w-20 h-20 bg-[#1a1a1a] border border-[#374151] rounded-2xl flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-credit-card text-3xl text-[#9CA3AF]"></i>
            </div>
            <h3 class="text-2xl font-black text-white uppercase tracking-wide mb-2">Sin suscripción activa</h3>
            <p class="text-[#9CA3AF] text-sm max-w-sm mx-auto leading-relaxed mb-8">
                Actualmente no tienes ningún plan activo. Elige el plan que mejor se adapte a tu negocio y comienza hoy.
            </p>
            <a href="{{ route('payment.plans') }}"
               id="btn-ver-planes"
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-black text-sm uppercase tracking-widest rounded-xl hover:shadow-[0_0_30px_rgba(37,181,218,0.3)] transition-all">
                <i class="fas fa-credit-card"></i>
                Ver Planes Disponibles
            </a>
        </div>
        @endif

    </div>
</div>
@endsection
