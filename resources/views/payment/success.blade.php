@extends('layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
<div class="bg-[#1a1a1a] min-h-[calc(100vh-4rem)] flex items-center justify-center py-16 px-4">
    <div class="w-full max-w-lg">

        {{-- Success Card --}}
        <div class="bg-[#262626] border border-[#374151] rounded-2xl p-10 text-center relative overflow-hidden">

            {{-- Decorative glow --}}
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-40 h-40 bg-green-500/10 rounded-full blur-3xl pointer-events-none"></div>

            {{-- Animated check icon --}}
            <div class="relative w-24 h-24 mx-auto mb-7">
                <div class="absolute inset-0 bg-green-500/15 rounded-full animate-ping animation-delay-300"></div>
                <div class="relative w-24 h-24 bg-green-500/20 border border-green-500/40 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-4xl text-green-400"></i>
                </div>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl font-black text-white uppercase tracking-wide mb-2">¡Pago Exitoso!</h1>
            <p class="text-[#25B5DA] text-[10px] uppercase tracking-[0.25em] font-bold mb-6">Transacción completada</p>

            {{-- Business name --}}
            @if(session('nombre_negocio'))
            <div class="bg-[#1a1a1a] border border-[#374151]/50 rounded-xl p-4 mb-6 text-left">
                <p class="text-[#9CA3AF] text-xs uppercase tracking-widest mb-1">Negocio registrado</p>
                <p class="text-white font-bold text-lg">{{ session('nombre_negocio') }}</p>
            </div>
            @endif

            {{-- Message --}}
            <p class="text-[#9CA3AF] text-sm leading-relaxed mb-8">
                Tu suscripción está activa. Ya puedes comenzar a usar todas las funcionalidades de NexoApp para gestionar tu negocio.
            </p>

            {{-- Details --}}
            <div class="grid grid-cols-3 gap-3 mb-8">
                <div class="bg-[#1a1a1a] border border-[#374151]/40 rounded-xl p-3">
                    <i class="fas fa-circle-check text-green-400 text-lg mb-1.5 block"></i>
                    <p class="text-[#9CA3AF] text-[10px] uppercase tracking-widest">Estado</p>
                    <p class="text-white text-xs font-bold mt-0.5">Activo</p>
                </div>
                <div class="bg-[#1a1a1a] border border-[#374151]/40 rounded-xl p-3">
                    <i class="fab fa-stripe text-[#25B5DA] text-lg mb-1.5 block"></i>
                    <p class="text-[#9CA3AF] text-[10px] uppercase tracking-widest">Método</p>
                    <p class="text-white text-xs font-bold mt-0.5">Stripe</p>
                </div>
                <div class="bg-[#1a1a1a] border border-[#374151]/40 rounded-xl p-3">
                    <i class="fas fa-calendar-check text-[#25B5DA] text-lg mb-1.5 block"></i>
                    <p class="text-[#9CA3AF] text-[10px] uppercase tracking-widest">Fecha</p>
                    <p class="text-white text-xs font-bold mt-0.5">{{ now()->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- CTA --}}
            <a href="/business/profile"
               id="btn-go-to-panel"
               class="block w-full py-4 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-black text-sm uppercase tracking-widest rounded-xl hover:shadow-[0_0_30px_rgba(37,181,218,0.35)] transition-all duration-300 mb-3">
                <i class="fas fa-arrow-right mr-2"></i>
                Ir al Panel de Administración
            </a>
            <a href="{{ route('payment.mi-suscripcion') }}"
               class="block w-full py-3 text-[#9CA3AF] text-xs uppercase tracking-widest font-bold hover:text-white transition-colors">
                Ver mi suscripción
            </a>
        </div>

        {{-- Footer note --}}
        <p class="text-center text-[#4B5563] text-[10px] tracking-wider mt-6">
            Recibirás un correo de confirmación vía Stripe. Si tienes dudas, contacta a soporte.
        </p>
    </div>
</div>

<style>
.animation-delay-300 { animation-delay: 0.3s; }
</style>
@endsection
