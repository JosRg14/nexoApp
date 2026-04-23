@extends('layouts.app')

@section('title', 'Planes de Suscripción')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen py-20" x-data="{ annual: false }">

    {{-- Hero Header --}}
    <div class="max-w-4xl mx-auto px-6 text-center mb-16">
        <p class="text-[#25B5DA] text-[10px] uppercase tracking-[0.3em] font-bold mb-4">
            Impulsa tu negocio
        </p>
        <h1 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tight leading-none mb-5">
            Elige tu <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0]">Plan</span>
        </h1>
        <p class="text-[#9CA3AF] text-lg max-w-xl mx-auto leading-relaxed">
            Accede a todas las herramientas que tu negocio necesita para crecer. Sin complicaciones, sin sorpresas.
        </p>
    </div>

    {{-- Flash Messages --}}
    @if(session('error'))
    <div class="max-w-2xl mx-auto px-6 mb-10">
        <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 flex items-start gap-3">
            <i class="fas fa-circle-exclamation text-red-400 mt-0.5"></i>
            <p class="text-red-400 text-sm">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    {{-- Plans Grid --}}
    <div class="max-w-7xl mx-auto px-6">
        @if(empty($planes))
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-[#262626] border border-[#374151] rounded-2xl flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-wifi-slash text-3xl text-[#9CA3AF]"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No se pudieron cargar los planes</h3>
            <p class="text-[#9CA3AF] text-sm mb-6">Verifica tu conexión e intenta nuevamente.</p>
            <a href="{{ route('payment.plans') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#262626] border border-[#374151] text-white rounded-lg text-sm font-bold hover:border-[#25B5DA] transition-all">
                <i class="fas fa-rotate-right"></i> Reintentar
            </a>
        </div>
        @else

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ count($planes) <= 3 ? count($planes) : '4' }} gap-6 items-stretch">
            @foreach($planes as $index => $plan)
            @php
                $isPopular = ($plan['nivel_visibilidad'] ?? 0) == 2 || ($index == 1 && count($planes) >= 2);
                $costoMensual = $plan['costo_mensual'] ?? (isset($plan['costo'], $plan['duracion_meses']) ? $plan['costo'] / $plan['duracion_meses'] : ($plan['costo'] ?? 0));
                $costoTotal = $plan['costo'] ?? 0;
            @endphp

            <div class="relative flex flex-col bg-[#262626] border {{ $isPopular ? 'border-[#25B5DA] shadow-[0_0_40px_rgba(37,181,218,0.12)]' : 'border-[#374151] hover:border-[#4B5563]' }} rounded-2xl p-7 transition-all duration-300 group">

                @if($isPopular)
                <div class="absolute -top-4 inset-x-0 flex justify-center">
                    <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black text-[10px] font-black uppercase tracking-widest px-5 py-1.5 rounded-full shadow-lg">
                        <i class="fas fa-star text-[9px]"></i> Más Popular
                    </span>
                </div>
                @endif

                {{-- Plan Header --}}
                <div class="mb-6 {{ $isPopular ? 'mt-3' : '' }}">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 {{ $isPopular ? 'bg-[#25B5DA]/20' : 'bg-[#374151]/60' }} rounded-xl flex items-center justify-center">
                            <i class="fas fa-{{ $index === 0 ? 'seedling' : ($index === 1 ? 'rocket' : ($index === 2 ? 'crown' : 'building')) }} text-{{ $isPopular ? '[#25B5DA]' : '[#9CA3AF]' }} text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white uppercase tracking-wide">{{ $plan['tipo'] ?? $plan['nombre'] ?? 'Plan' }}</h3>
                            <p class="text-[10px] text-[#9CA3AF] uppercase tracking-widest">Suscripción</p>
                        </div>
                    </div>

                    <div class="flex items-end gap-1 mb-1">
                        <span class="text-4xl font-black text-white">${{ number_format($costoMensual, 0) }}</span>
                        <span class="text-[#9CA3AF] text-sm mb-1.5">/ mes</span>
                    </div>
                    @if(isset($plan['duracion_meses']) && $plan['duracion_meses'] > 1)
                    <p class="text-[#9CA3AF] text-xs">
                        Pago único de <span class="text-white font-semibold">${{ number_format($costoTotal, 0) }} MXN</span>
                        · {{ $plan['duracion_meses'] }} meses
                    </p>
                    @endif
                </div>

                {{-- Description --}}
                @if($plan['descripcion'] ?? null)
                <p class="text-[#9CA3AF] text-sm leading-relaxed mb-6 flex-grow">{{ $plan['descripcion'] }}</p>
                @else
                <div class="flex-grow"></div>
                @endif

                {{-- Divider --}}
                <div class="border-t border-[#374151]/50 mb-6"></div>

                {{-- CTA Button --}}
                @if($plan['stripe_price_id'] ?? null)
                <form action="{{ route('payment.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="price_id" value="{{ $plan['stripe_price_id'] }}">
                    <button type="submit"
                        id="btn-plan-{{ $plan['id'] ?? $index }}"
                        class="w-full py-3.5 {{ $isPopular
                            ? 'bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black hover:shadow-[0_0_25px_rgba(37,181,218,0.35)]'
                            : 'bg-[#374151]/60 text-white hover:bg-[#374151] border border-[#374151] hover:border-[#4B5563]' }} font-black text-xs uppercase tracking-widest rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fab fa-stripe text-base"></i>
                        Pagar con Stripe
                    </button>
                </form>
                @else
                <div class="w-full py-3.5 bg-[#374151]/30 text-[#9CA3AF] font-bold text-xs uppercase tracking-widest rounded-xl text-center border border-[#374151]/30 cursor-not-allowed">
                    No disponible
                </div>
                @endif

            </div>
            @endforeach
        </div>

        {{-- Trust Badges --}}
        <div class="mt-14 flex flex-wrap items-center justify-center gap-8">
            <div class="flex items-center gap-2.5 text-[#9CA3AF] text-xs">
                <i class="fas fa-shield-halved text-[#25B5DA]"></i>
                <span>Pago 100% seguro con Stripe</span>
            </div>
            <div class="flex items-center gap-2.5 text-[#9CA3AF] text-xs">
                <i class="fas fa-rotate-left text-[#25B5DA]"></i>
                <span>Cancela cuando quieras</span>
            </div>
            <div class="flex items-center gap-2.5 text-[#9CA3AF] text-xs">
                <i class="fas fa-headset text-[#25B5DA]"></i>
                <span>Soporte incluido</span>
            </div>
            <div class="flex items-center gap-2.5 text-[#9CA3AF] text-xs">
                <i class="fab fa-stripe text-[#25B5DA]"></i>
                <span>Procesado por Stripe</span>
            </div>
        </div>

        @endif
    </div>

    {{-- FAQ Section --}}
    <div class="max-w-3xl mx-auto px-6 mt-20" x-data="{ open: null }">
        <h2 class="text-2xl font-black text-white uppercase tracking-wide text-center mb-10">Preguntas Frecuentes</h2>
        <div class="space-y-3">
            @foreach([
                ['¿Puedo cancelar en cualquier momento?', 'Sí. Puedes cancelar tu suscripción desde el panel en cualquier momento. Conservarás el acceso hasta el final del período pagado.'],
                ['¿Mis datos de pago están seguros?', 'Absolutamente. No almacenamos datos de tarjeta. Todo el procesamiento es manejado por Stripe, líder mundial en pagos seguros.'],
                ['¿Puedo cambiar de plan?', 'Sí. Contáctanos por soporte y te ayudaremos a migrar tu plan sin perder datos.'],
            ] as $i => [$q, $a])
            <div class="bg-[#262626] border border-[#374151] rounded-xl overflow-hidden">
                <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                    class="w-full px-6 py-4 flex items-center justify-between text-left group">
                    <span class="text-sm font-bold text-white">{{ $q }}</span>
                    <i class="fas fa-chevron-down text-[#9CA3AF] text-xs transition-transform duration-200"
                        :class="open === {{ $i }} ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open === {{ $i }}" x-collapse class="px-6 pb-4">
                    <p class="text-[#9CA3AF] text-sm leading-relaxed">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
