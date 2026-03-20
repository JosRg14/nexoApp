@extends('layouts.dashboard')

@section('title', 'NexoApp - Gestión de Planes')

@section('content')
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold uppercase tracking-[0.2em] text-white">Gestión de Planes</h1>
        <p class="text-[#52525b] text-xs uppercase mt-2 tracking-widest font-bold">Configuración de suscripciones de la plataforma</p>
    </div>

    <div class="flex flex-col lg:flex-row items-start gap-8">
        
        <div class="w-full lg:w-[400px] flex-shrink-0 bg-[#262626] border border-[#374151] rounded-sm p-6 shadow-lg">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6 border-b border-[#374151] pb-4">Nuevo Plan</h2>
            
            {{-- Cambiar la ruta según tu controlador --}}
            <form action="{{ route('dashboard.planes.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Tipo de Plan</label>
                    <input type="text" name="tipo" required class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="Ej: Anual, Mensual, Premium">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Costo ($)</label>
                        <input type="number" name="costo" step="0.01" required class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="3999">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Meses</label>
                        <input type="number" name="duracion_meses" required class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="12">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Nivel de Visibilidad (1-5)</label>
                    <select name="nivel_visibilidad" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors">
                        <option value="1">1 - Básico</option>
                        <option value="2">2 - Estándar</option>
                        <option value="3">3 - Destacado</option>
                        <option value="4">4 - Premium</option>
                        <option value="5">5 - Máximo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Descripción</label>
                    <textarea name="descripcion" rows="3" required class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="Beneficios del plan..."></textarea>
                </div>

                <button type="submit" class="w-full py-4 bg-white text-black font-bold uppercase tracking-[0.2em] text-[10px] hover:bg-[#F3F4F6] transition-colors shadow-lg">
                    Guardar Plan
                </button>
            </form>
        </div>

        <div class="flex-1 w-full space-y-6">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6 border-b border-[#374151] pb-4">Planes Configurables</h2>
            
            <div class="grid grid-cols-1 gap-4">
                {{-- Aquí iterarías con @forelse($planes as $plan) --}}
                
                <div class="bg-[#262626] border border-[#374151] p-6 group hover:border-white transition-all shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-white font-bold text-xl tracking-tight">Plan Anual</h3>
                                <span class="bg-blue-500/10 text-blue-500 px-2 py-0.5 rounded text-[9px] font-bold uppercase border border-blue-500/20">Visibilidad Lvl 4</span>
                            </div>
                            <p class="text-[#9CA3AF] text-sm italic">El plan con mayor visibilidad de la plataforma.</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-white font-bold text-2xl">$3,999</span>
                            <span class="text-[10px] text-[#52525b] uppercase font-bold tracking-tighter">Por 12 meses</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-[#374151] pt-4">
                        <div class="flex gap-4 text-[10px] text-[#52525b] uppercase font-bold tracking-widest">
                            <span class="text-emerald-500">Activo</span>
                            <span>•</span>
                            <span>ID: #3</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="text-[10px] uppercase font-bold tracking-widest text-[#9CA3AF] hover:text-white transition-colors">Editar</button>
                            <span class="text-[#374151]">|</span>
                            <button class="text-[10px] uppercase font-bold tracking-widest text-red-500/70 hover:text-red-500 transition-colors">Eliminar</button>
                        </div>
                    </div>
                </div>

                <div class="bg-[#262626] border border-[#374151] p-6 group hover:border-white transition-all shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-white font-bold text-xl tracking-tight">Plan Mensual</h3>
                                <span class="bg-gray-500/10 text-gray-400 px-2 py-0.5 rounded text-[9px] font-bold uppercase border border-gray-500/20">Visibilidad Lvl 1</span>
                            </div>
                            <p class="text-[#9CA3AF] text-sm italic">Acceso básico para nuevos negocios.</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-white font-bold text-2xl">$499</span>
                            <span class="text-[10px] text-[#52525b] uppercase font-bold tracking-tighter">Por 1 mes</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-[#374151] pt-4">
                        <div class="flex gap-4 text-[10px] text-[#52525b] uppercase font-bold tracking-widest">
                            <span class="text-emerald-500">Activo</span>
                            <span>•</span>
                            <span>ID: #1</span>
                        </div>
                        <div class="flex gap-2">
                            <button class="text-[10px] uppercase font-bold tracking-widest text-[#9CA3AF] hover:text-white transition-colors">Editar</button>
                            <span class="text-[#374151]">|</span>
                            <button class="text-[10px] uppercase font-bold tracking-widest text-red-500/70 hover:text-red-500 transition-colors">Eliminar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection