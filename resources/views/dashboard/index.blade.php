@extends('layouts.dashboard')

@section('title', 'NexoApp - Dashboard')

@section('content')
    <h1 class="text-3xl font-bold uppercase tracking-wide text-white mb-8">Resumen General</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-[#262626] border border-[#374151] p-6 rounded-sm shadow-lg">
        <div class="flex justify-between items-start mb-4">
            <!-- Total Negocios -->
            <div>
                <p class="text-[#9CA3AF] text-xs uppercase tracking-widest font-bold">Total Negocios</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $metrics['negocios']['total'] ?? 0 }}</h3>
            </div>
            <div class="p-2 bg-[#1a1a1a] rounded text-emerald-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
        <p class="text-xs {{ ($metrics['negocios']['variacion'] ?? 0) >= 0 ? 'text-emerald-500' : 'text-red-500' }} font-bold flex items-center gap-1">
            {{ $metrics['negocios']['variacion'] ?? 0 }}% <span class="text-[#52525b] font-normal">vs mes anterior</span>
        </p>
    </div>

    <!-- Usuarios Totales -->
    <div class="bg-[#262626] border border-[#374151] p-6 rounded-sm shadow-lg">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-[#9CA3AF] text-xs uppercase tracking-widest font-bold">Usuarios Totales</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $metrics['usuarios_activos'] ?? 0 }}</h3>
            </div>
            <div class="p-2 bg-[#1a1a1a] rounded text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <p class="text-xs text-[#52525b]">Clientes y empleados registrados</p>
    </div>

    <!-- Ingresos Mensuales -->
    <div class="bg-[#262626] border border-[#374151] p-6 rounded-sm shadow-lg opacity-80">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-[#9CA3AF] text-xs uppercase tracking-widest font-bold">Ingresos Mensuales</p>
                <h3 class="text-xl font-bold text-[#52525b] mt-4 tracking-widest italic uppercase">Próximamente</h3>
            </div>
            <div class="p-2 bg-[#1a1a1a] rounded text-purple-500 opacity-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

    <!-- Recent Activity Table Placeholder -->
    <div class="bg-[#262626] border border-[#374151] rounded-sm shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-[#374151] flex justify-between items-center">
        <h3 class="text-sm font-bold uppercase tracking-widest text-white">Actividad Reciente</h3>
        <a href="#" class="text-xs text-[#9CA3AF] hover:text-white transition-colors">Ver Todo</a>
    </div>
    
    <div class="p-6">
        <div class="space-y-4">
            @forelse($activities as $activity)
                <div class="flex items-center justify-between pb-4 border-b border-[#374151]/50 last:border-0 last:pb-0">
                    <div class="flex items-center gap-4">
                        @php
                            $config = match($activity['tipo']) {
                                'negocio_registrado' => ['color' => 'emerald', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                                'cita_creada' => ['color' => 'blue', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                'cliente_registrado' => ['color' => 'purple', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                default => ['color' => 'gray', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
                            };
                        @endphp

                        <div class="h-8 w-8 rounded bg-{{ $config['color'] }}-500/10 flex items-center justify-center text-{{ $config['color'] }}-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white font-medium">{{ $activity['descripcion'] }}</p>
                            <p class="text-xs text-[#9CA3AF]">{{ $activity['detalle'] ?? 'Sin detalles adicionales' }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-[#52525b]">{{ \Carbon\Carbon::parse($activity['fecha'])->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-center text-[#52525b] py-4 text-xs italic">No hay actividad reciente para mostrar</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
