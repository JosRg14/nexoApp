@extends('layouts.app')

@section('title', 'Pago Cancelado')

@section('content')
<div class="bg-[#1a1a1a] min-h-[calc(100vh-4rem)] flex items-center justify-center py-16 px-4">
    <div class="w-full max-w-lg">

        {{-- Cancel Card --}}
        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-10 text-center relative overflow-hidden">

            {{-- Decorative glow --}}
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-40 h-40 bg-yellow-500/8 rounded-full blur-3xl pointer-events-none"></div>

            {{-- Icon --}}
            <div class="w-24 h-24 mx-auto mb-7 bg-yellow-500/15 border border-yellow-500/30 rounded-full flex items-center justify-center">
                <i class="fas fa-xmark text-4xl text-yellow-400"></i>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl font-black text-white uppercase tracking-wide mb-2">Pago Cancelado</h1>
            <p class="text-yellow-500/70 text-[10px] uppercase tracking-[0.25em] font-bold mb-6">Sin cargos realizados</p>

            {{-- Message --}}
            <p class="text-[#9CA3AF] text-sm leading-relaxed mb-8">
                No se realizó ningún cargo a tu cuenta. Tu proceso de pago fue cancelado.
                Puedes intentarlo nuevamente en cualquier momento.
            </p>

            {{-- Info boxes --}}
            <div class="grid grid-cols-2 gap-3 mb-8">
                <div class="bg-[#1a1a1a] border border-[#374151]/40 rounded-xl p-4 text-left">
                    <i class="fas fa-shield-halved text-yellow-400 text-base mb-2 block"></i>
                    <p class="text-white text-xs font-bold">Sin cargo</p>
                    <p class="text-[#9CA3AF] text-[10px] mt-0.5">No se cobró nada</p>
                </div>
                <div class="bg-[#1a1a1a] border border-[#374151]/40 rounded-xl p-4 text-left">
                    <i class="fas fa-rotate-right text-[#25B5DA] text-base mb-2 block"></i>
                    <p class="text-white text-xs font-bold">Reintentar</p>
                    <p class="text-[#9CA3AF] text-[10px] mt-0.5">Cuando gustes</p>
                </div>
            </div>

            {{-- CTAs --}}
            <a href="{{ route('payment.plans') }}"
               id="btn-retry-plan"
               class="block w-full py-4 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-black text-sm uppercase tracking-widest rounded-xl hover:shadow-[0_0_30px_rgba(37,181,218,0.35)] transition-all duration-300 mb-3">
                <i class="fas fa-credit-card mr-2"></i>
                Ver Planes Nuevamente
            </a>
            <a href="{{ url('/') }}"
               class="block w-full py-3 text-[#9CA3AF] text-xs uppercase tracking-widest font-bold hover:text-white transition-colors">
                Volver al inicio
            </a>
        </div>

        {{-- Support note --}}
        <p class="text-center text-[#4B5563] text-[10px] tracking-wider mt-6">
            ¿Tuviste problemas? Contáctanos y te ayudaremos.
        </p>
    </div>
</div>
@endsection
