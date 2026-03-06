@extends('layouts.dashboard')

@section('title', 'NexoApp - Dashboard')

@section('content')
    <h1 class="text-3xl font-bold uppercase tracking-wide text-white mb-8">Resumen General</h1>
    
    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- KPI 1 -->
        <div class="bg-[#262626] border border-[#374151] p-6 rounded-sm shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[#9CA3AF] text-xs uppercase tracking-widest font-bold">Total Negocios</p>
                    <h3 class="text-4xl font-bold text-white mt-2">124</h3>
                </div>
                <div class="p-2 bg-[#1a1a1a] rounded text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <p class="text-xs text-emerald-500 font-bold flex items-center gap-1">
                +12% <span class="text-[#52525b] font-normal">vs mes anterior</span>
            </p>
        </div>

        <!-- KPI 2 -->
        <div class="bg-[#262626] border border-[#374151] p-6 rounded-sm shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[#9CA3AF] text-xs uppercase tracking-widest font-bold">Usuarios Activos</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h3 class="text-4xl font-bold text-white">4.2k</h3>
                        <span class="text-xs text-[#52525b]">/ 4.5k Total</span>
                    </div>
                </div>
                <div class="p-2 bg-[#1a1a1a] rounded text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="w-full bg-[#1a1a1a] h-1.5 rounded-full mt-2">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 92%"></div>
            </div>
        </div>

        <!-- KPI 3 -->
        <div class="bg-[#262626] border border-[#374151] p-6 rounded-sm shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[#9CA3AF] text-xs uppercase tracking-widest font-bold">Ingresos Mensuales</p>
                    <h3 class="text-4xl font-bold text-white mt-2">$12,450</h3>
                </div>
                <div class="p-2 bg-[#1a1a1a] rounded text-purple-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-purple-500 font-bold flex items-center gap-1">
                +5% <span class="text-[#52525b] font-normal">vs mes anterior</span>
            </p>
        </div>
    </div>

    <!-- Recent Activity Table Placeholder -->
    <div class="bg-[#262626] border border-[#374151] rounded-sm shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-[#374151] flex justify-between items-center">
            <h3 class="text-sm font-bold uppercase tracking-widest text-white">Actividad Reciente</h3>
            <button class="text-xs text-[#9CA3AF] hover:text-white transition-colors">Ver Todo</button>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <!-- Item 1 -->
                <div class="flex items-center justify-between pb-4 border-b border-[#374151]/50 last:border-0 last:pb-0">
                    <div class="flex items-center gap-4">
                        <div class="h-8 w-8 rounded bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-white font-medium">Nuevo Negocio Registrado</p>
                            <p class="text-xs text-[#9CA3AF]">Barbería "El Clásico" se ha unido.</p>
                        </div>
                    </div>
                    <span class="text-xs text-[#52525b]">Hace 2 min</span>
                </div>
                <!-- Item 2 -->
                <div class="flex items-center justify-between pb-4 border-b border-[#374151]/50 last:border-0 last:pb-0">
                    <div class="flex items-center gap-4">
                        <div class="h-8 w-8 rounded bg-red-500/10 flex items-center justify-center text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-white font-medium">Reporte de Usuario</p>
                            <p class="text-xs text-[#9CA3AF]">Usuario @juanperez ha reportado un servicio.</p>
                        </div>
                    </div>
                    <span class="text-xs text-[#52525b]">Hace 1 hora</span>
                </div>
            </div>
        </div>
    </div>
@endsection
