@extends('layouts.dashboard')

@section('title', 'NexoApp - Detalle Negocio')

@section('content')
    <!-- Header -->
    <div class="mb-8 border-b border-[#374151] pb-8">
        <a href="{{ route('dashboard.businesses') }}" class="text-[#9CA3AF] hover:text-white text-xs uppercase tracking-widest mb-4 inline-block flex items-center gap-2">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver a la lista
        </a>
        
        <div class="flex justify-between items-start mt-4">
            <div class="flex gap-6">
                <div class="h-24 w-24 bg-[#374151] rounded-sm flex items-center justify-center text-2xl font-bold text-white shadow-lg">GC</div>
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold uppercase tracking-wide text-white">The Gentlemen's Club</h1>
                        <span class="bg-emerald-500/10 text-emerald-500 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide border border-emerald-500/20">Activo</span>
                    </div>
                    <p class="text-[#9CA3AF] text-sm mb-4 max-w-xl">Corte clásico y afeitado tradicional con toalla caliente. Una experiencia de lujo atemporal ubicada en el corazón de la ciudad.</p>
                    
                    <div class="flex gap-6 text-xs text-[#D1D5DB] tracking-wide">
                        <span class="flex items-center gap-2"><svg class="w-4 h-4 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Carlos Martinez</span>
                        <span class="flex items-center gap-2"><svg class="w-4 h-4 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> carlos@example.com</span>
                        <span class="flex items-center gap-2"><svg class="w-4 h-4 text-[#9CA3AF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +52 555 123 4567</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Info Column -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Stats mocked -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                    <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Citas Totales</p>
                    <p class="text-2xl font-bold text-white mt-1">1,245</p>
                </div>
                <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                    <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Valoración</p>
                    <p class="text-2xl font-bold text-white mt-1">4.9 ★</p>
                </div>
                <div class="bg-[#262626] border border-[#374151] p-4 rounded-sm text-center">
                     <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Ingresos (Mes)</p>
                    <p class="text-2xl font-bold text-emerald-500 mt-1">$3,450</p>
                </div>
            </div>

            <!-- Services Block -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Servicios Ofrecidos</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-[#374151]/50 last:border-0 last:pb-0">
                        <span class="text-sm text-[#D1D5DB]">Corte Clásico</span>
                        <span class="text-sm font-mono text-white">$250</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-[#374151]/50 last:border-0 last:pb-0">
                        <span class="text-sm text-[#D1D5DB]">Afeitado con Toalla</span>
                        <span class="text-sm font-mono text-white">$200</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-[#374151]/50 last:border-0 last:pb-0">
                        <span class="text-sm text-[#D1D5DB]">Paquete Completo</span>
                        <span class="text-sm font-mono text-white">$400</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Actions Column -->
        <div class="space-y-6">
            <!-- Plan Management -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 mb-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Plan & Suscripción</h3>
                
                <div class="relative w-full mb-4">
                    <select class="block appearance-none w-full bg-[#1a1a1a] border border-[#374151] text-white py-3 px-4 pr-8 text-xs font-bold uppercase tracking-widest focus:outline-none focus:border-white transition-colors cursor-pointer">
                        <option>Plan Activo</option>
                        <option>Plan Inactivo (Vencido)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <button class="w-full py-3 bg-emerald-500/10 border border-emerald-500/50 text-emerald-500 text-xs font-bold uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all">
                    Actualizar Plan
                </button>
            </div>

            <!-- Moderation Actions -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Moderación</h3>
                <p class="text-xs text-[#9CA3AF] mb-6">Gestiona el estado de este negocio en la plataforma.</p>
                
                <div class="space-y-3">
                    <button class="w-full py-3 bg-red-500/10 border border-red-500/50 text-red-500 text-xs font-bold uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">
                        Suspender Negocio
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
