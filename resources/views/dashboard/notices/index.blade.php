@extends('layouts.dashboard')

@section('title', 'NexoApp - Avisos')

@section('content')

    {{-- MENSAJE DE ÉXITO CON CIERRE (X) --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" 
             class="flex justify-between items-center bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-4 mb-6 text-xs font-bold uppercase tracking-widest">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="text-emerald-500 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show"
             class="flex justify-between items-center bg-red-500/10 border border-red-500/20 text-red-500 p-4 mb-6 text-xs font-bold uppercase tracking-widest">
            <span>{{ $errors->first() }}</span>
            <button @click="show = false" class="text-red-500 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <h1 class="text-3xl font-bold uppercase tracking-wide text-white mb-8">Avisos a Negocios</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 shadow-lg h-fit">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6">Nuevo Comunicado</h2>
            
            <form action="{{ route('dashboard.notices.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Asunto</label>
                    <input type="text" name="asunto" required
                        class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors"
                        placeholder="Ej: Mantenimiento Programado">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Destinatarios</label>
                    <select name="destinatarios"
                        class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors">
                        <option value="todos">Todos los Negocios</option>
                        <option value="activos">Solo Negocios Activos</option>
                        <option value="suspendidos">Solo Negocios Suspendidos</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Mensaje</label>
                    <textarea name="mensaje" rows="6" required
                        class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors"
                        placeholder="Escribe tu mensaje importante aquí..."></textarea>
                </div>

                <!-- Opción de marcar como urgente 
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="urgente" value="1" id="urgent"
                        class="w-4 h-4 bg-[#1a1a1a] border border-[#374151] rounded focus:ring-0 text-white">
                    <label for="urgent" class="text-xs uppercase tracking-widest text-[#9CA3AF] font-bold">Marcar como Importante</label>
                </div>
                -->
                <button type="submit"
                    class="w-full py-4 bg-white text-black font-bold uppercase tracking-[0.2em] text-xs hover:bg-[#F3F4F6] transition-colors mt-4">
                    Enviar Aviso
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-6">

            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6">Historial de Enviados</h2>

            @forelse($avisos as $aviso)
                <div class="bg-[#262626] border border-[#374151] p-6 group hover:border-[#F3F4F6] transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <h3 class="text-white font-bold text-lg">{{ $aviso['asunto'] }}</h3>
                            @if($aviso['destinatarios'] == 'todos')
                                <span class="bg-blue-500/10 text-blue-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-blue-500/20">Global</span>
                            @else
                                <span class="bg-amber-500/10 text-amber-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-amber-500/20">{{ $aviso['destinatarios'] }}</span>
                            @endif
                        </div>
                        <span class="text-xs text-[#52525b]">
                            {{ \Carbon\Carbon::parse($aviso['fecha'])->diffForHumans() }}
                        </span>
                    </div>
                    
                    <p class="text-[#9CA3AF] text-sm mb-4 leading-relaxed">
                        {{ $aviso['mensaje'] }}
                    </p>
                    
                    <div class="flex gap-4 text-xs text-[#52525b] uppercase tracking-wide font-mono border-t border-[#374151] pt-4">
                        <span>Enviado a: {{ ucfirst($aviso['destinatarios']) }}</span>
                        <span>•</span>
                        <span>Total: {{ $aviso['total_enviados'] }}</span>
                    </div>
                </div>
            @empty
                <div class="text-[#52525b] text-sm italic py-10 text-center border border-dashed border-[#374151]">
                    No hay avisos enviados todavía.
                </div>
            @endforelse
        </div>

    </div>
@endsection