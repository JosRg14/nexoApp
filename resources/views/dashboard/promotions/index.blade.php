@extends('layouts.dashboard')

@section('title', 'NexoApp - Gestión de Planes')

@section('content')
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold uppercase tracking-[0.2em] text-white">Gestión de Planes</h1>
        <p class="text-[#52525b] text-xs uppercase mt-2 tracking-widest font-bold">Configuración de suscripciones de la plataforma</p>
    </div>

    {{-- Contenedor principal con Alpine.js --}}
    <div x-data="{ openEdit: false, currentPlan: {} }" class="flex flex-col lg:flex-row items-start gap-8">

        <div class="w-full lg:w-[400px] flex-shrink-0 bg-[#262626] border border-[#374151] rounded-sm p-6 shadow-lg">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6 border-b border-[#374151] pb-4">Nuevo Plan</h2>

            <form action="{{ route('dashboard.planes.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Tipo de Plan</label>
                    <input type="text" name="tipo" required maxlength="50"
                        class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors"
                        placeholder="Ej: Anual, Mensual, Premium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Costo ($)</label>
                        {{-- min="0" evita costos negativos --}}
                        <input type="number" name="costo" step="0.01" min="0" required
                            class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors"
                            placeholder="3999">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Meses</label>
                        {{-- min="1" evita planes de 0 meses --}}
                        <input type="number" name="duracion_meses" min="1" max="60" required
                            class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors"
                            placeholder="12">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Nivel de Visibilidad (1-4)</label>
                    <select name="nivel_visibilidad" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors">
                        <option value="1">1 - Básico</option>
                        <option value="2">2 - Estándar</option>
                        <option value="3">3 - Destacado</option>
                        <option value="4">4 - Premium</option>
                        {{-- Nivel 5 eliminado según solicitud --}}
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Descripción</label>
                    <textarea name="descripcion" rows="3" required maxlength="255"
                        class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors"
                        placeholder="Beneficios del plan..."></textarea>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-white text-black font-bold uppercase tracking-[0.2em] text-[10px] hover:bg-[#F3F4F6] transition-colors shadow-lg">
                    Guardar Plan
                </button>
            </form>
        </div>

        <div class="flex-1 w-full">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6 border-b border-[#374151] pb-4">
                Planes Configurables
            </h2>

            {{-- max-h-[700px] permite ver aproximadamente 3.5 planes antes de scrollear --}}
            <div class="grid grid-cols-1 gap-4 overflow-y-auto max-h-[750px] pr-2 custom-scrollbar">
                @forelse($planes as $plan)
                    <div class="bg-[#262626] border border-[#374151] p-6 group hover:border-white transition-all shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="text-white font-bold text-xl tracking-tight">{{ $plan['tipo'] }}</h3>
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase border 
                                        {{ $plan['nivel_visibilidad'] == 4 ? 'bg-purple-500/10 text-purple-400 border-purple-500/20' : 'bg-blue-500/10 text-blue-500 border-blue-500/20' }}">
                                        Lvl {{ $plan['nivel_visibilidad'] }} ({{ $plan['etiqueta_visibilidad'] ?? 'Normal' }})
                                    </span>
                                </div>
                                <p class="text-[#9CA3AF] text-sm italic">{{ $plan['descripcion'] }}</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-white font-bold text-2xl">${{ number_format($plan['costo'], 2) }}</span>
                                <span class="text-[10px] text-[#52525b] uppercase font-bold tracking-tighter">Por&nbsp; {{ $plan['duracion'] }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t border-[#374151] pt-4">
                            <div class="flex gap-4 text-[10px] text-[#52525b] uppercase font-bold tracking-widest">
                                <span class="{{ $plan['activo'] ? 'text-emerald-500' : 'text-red-500' }}">
                                    {{ $plan['activo'] ? 'Activo' : 'Inactivo' }}
                                </span>
                                <span>•</span>
                                <span>ID: #{{ $plan['id'] }}</span>
                                <span>•</span>
                                <span>{{ $plan['negocios_activos'] ?? 0 }} Negocios</span>
                            </div>
                            <div class="flex gap-4 items-center">
                                <button @click="openEdit = true; currentPlan = { id: '{{ $plan['id'] }}', tipo: '{{ $plan['tipo'] }}', costo: '{{ $plan['costo'] }}', desc: '{{ $plan['descripcion'] }}' }"
                                    class="text-[10px] uppercase font-bold tracking-widest text-[#9CA3AF] hover:text-white transition-colors">
                                    Editar
                                </button>
                                <span class="text-[#374151]">|</span>
                                <form action="{{ route('dashboard.planes.destroy', $plan['id']) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este plan? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] uppercase font-bold tracking-widest text-red-500/70 hover:text-red-500 transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center border border-dashed border-[#374151]">
                        <p class="text-[#52525b] uppercase tracking-widest text-xs font-bold">No hay planes disponibles</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm" x-cloak>
            <div @click.away="openEdit = false" class="bg-[#262626] border border-[#374151] p-8 w-full max-w-md shadow-2xl rounded-sm">
                <h2 class="text-white font-bold uppercase tracking-widest mb-6 border-b border-[#374151] pb-4">Editar Plan: <span x-text="currentPlan.tipo" class="text-blue-400"></span></h2>

                <form :action="'{{ route('dashboard.planes.index') }}/' + currentPlan.id" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Nuevo Costo ($)</label>
                        <input type="number" name="costo" step="0.01" min="0" x-model="currentPlan.costo" required
                            class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Descripción</label>
                        <textarea name="descripcion" x-model="currentPlan.desc" rows="3" required maxlength="255"
                            class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none"></textarea>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="openEdit = false" class="flex-1 py-3 border border-[#374151] text-[#9CA3AF] font-bold uppercase text-[10px] hover:bg-[#374151] transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-white text-black font-bold uppercase text-[10px] hover:bg-gray-200 transition-colors">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Estilo opcional para el scrollbar para que se vea más acorde al tema oscuro --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1a1a1a; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #4b5563; }
    </style>
@endsection