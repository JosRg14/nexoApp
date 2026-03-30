@extends('layouts.app')

@section('title', 'Mis Citas')

@section('content')

<div class="bg-[#1a1a1a] min-h-screen py-<12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Mis Citas</h1>
            <p class="text-[#9CA3AF] text-sm mt-2">Historial de tus citas agendadas</p>
        </div>
        
        @if(count($citas) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($citas as $cita)
            <div class="bg-[#262626] border border-[#374151] rounded-lg p-6 hover:border-yellow-500 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-white text-lg">{{ $cita['servicio']['nombre'] ?? 'Servicio' }}</h3>
                        <p class="text-sm text-[#9CA3AF] mt-1">{{ $cita['negocio']['nombre'] ?? 'Negocio' }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $cita['estado'] === 'pendiente' ? 'bg-yellow-500/20 text-yellow-500' : '' }}
                        {{ $cita['estado'] === 'confirmada' ? 'bg-emerald-500/20 text-emerald-500' : '' }}
                        {{ $cita['estado'] === 'completada' ? 'bg-blue-500/20 text-blue-500' : '' }}
                        {{ $cita['estado'] === 'cancelada' ? 'bg-red-500/20 text-red-500' : '' }}">
                        {{ ucfirst($cita['estado']) }}
                    </span>
                </div>
                
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-[#9CA3AF]">
                        <i class="fas fa-calendar-alt w-4"></i>
                        <span>{{ \Carbon\Carbon::parse($cita['fecha'])->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#9CA3AF]">
                        <i class="fas fa-clock w-4"></i>
                        <span>{{ substr($cita['hora_inicio'], 0, 5) }} - {{ substr($cita['hora_fin'], 0, 5) }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#9CA3AF]">
                        <i class="fas fa-user w-4"></i>
                        <span>{{ $cita['empleado']['nombre'] ?? 'Empleado' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-yellow-500">
                        <i class="fas fa-dollar-sign w-4"></i>
                        <span>${{ number_format($cita['servicio']['precio'] ?? 0, 0) }}</span>
                    </div>
                </div>
                
                @if($cita['estado'] === 'pendiente')
                <div class="mt-4 pt-4 border-t border-[#374151]">
                    <button onclick="cancelarCita({{ $cita['id_cita'] }})" 
                            class="w-full py-2 text-red-400 border border-red-500/30 rounded-lg hover:bg-red-500/10 transition-all text-sm">
                        Cancelar cita
                    </button>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-calendar-alt text-6xl text-[#374151] mb-4"></i>
            <p class="text-[#9CA3AF] text-lg">No tienes citas agendadas</p>
            <a href="/" class="inline-block mt-4 text-yellow-500 hover:text-yellow-400">Explorar negocios</a>
        </div>
        @endif
    </div>
</div>

<script>
async function cancelarCita(citaId) {
    if (!confirm('¿Estás seguro de cancelar esta cita?')) return;
    
    showLoader();
    
    try {
        const response = await fetch(`/api-proxy/citas/${citaId}/cancelar`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        });
        
        const data = await response.json();
        
        if (response.ok) {
            alert('Cita cancelada correctamente');
            location.reload();
        } else {
            alert(data.message || 'Error al cancelar la cita');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    } finally {
        hideLoader();
    }
}

function showLoader() {
    const loader = document.getElementById('global-loader');
    if (loader) loader.classList.remove('hidden');
}

function hideLoader() {
    const loader = document.getElementById('global-loader');
    if (loader) loader.classList.add('hidden');
}
</script>
@endsection