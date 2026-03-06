@extends('layouts.dashboard')

@section('title', 'NexoApp - Avisos')

@section('content')
    <h1 class="text-3xl font-bold uppercase tracking-wide text-white mb-8">Avisos a Negocios</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Send Notice Form -->
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 shadow-lg h-fit">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6">Nuevo Comunicado</h2>
            <form onsubmit="event.preventDefault(); alert('Aviso enviado (simulación)');" class="space-y-6">
                
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Asunto</label>
                    <input type="text" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="Ej: Mantenimiento Programado">
                </div>

                 <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Destinatarios</label>
                    <select class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors">
                        <option>Todos los Negocios</option>
                        <option>Negocios Suspendidos</option>
                        <option>Nuevos Registros (Últimos 30 días)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Mensaje</label>
                    <textarea rows="6" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="Escribe tu mensaje importante aquí..."></textarea>
                </div>

                 <div class="flex items-center gap-2">
                     <input type="checkbox" id="urgent" class="w-4 h-4 bg-[#1a1a1a] border border-[#374151] rounded focus:ring-0 text-white">
                     <label for="urgent" class="text-xs uppercase tracking-widest text-[#9CA3AF] font-bold">Marcar como Importante</label>
                </div>

                <button type="submit" class="w-full py-4 bg-white text-black font-bold uppercase tracking-[0.2em] text-xs hover:bg-[#F3F4F6] transition-colors mt-4">
                    Enviar Aviso
                </button>
            </form>
        </div>

        <!-- Notices History -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6">Historial de Enviados</h2>
            
            <!-- Notice 1 -->
            <div class="bg-[#262626] border border-[#374151] p-6 group hover:border-[#F3F4F6] transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <h3 class="text-white font-bold text-lg">Actualización de Políticas</h3>
                        <span class="bg-red-500/10 text-red-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-red-500/20">Importante</span>
                    </div>
                    <span class="text-xs text-[#52525b]">Hace 2 días</span>
                </div>
                <p class="text-[#9CA3AF] text-sm mb-4 leading-relaxed">Se han actualizado las políticas de comisiones. Por favor revisen su panel de facturación para más detalles sobre los nuevos cargos aplicables a partir del próximo mes.</p>
                <div class="flex gap-4 text-xs text-[#52525b] uppercase tracking-wide font-mono border-t border-[#374151] pt-4">
                    <span>Enviado a: Todos</span>
                    <span>•</span>
                    <span>Leído por: 85%</span>
                </div>
            </div>

            <!-- Notice 2 -->
            <div class="bg-[#262626] border border-[#374151] p-6 group hover:border-[#F3F4F6] transition-colors">
                 <div class="flex justify-between items-start mb-4">
                    <h3 class="text-white font-bold text-lg">Felices Fiestas</h3>
                    <span class="text-xs text-[#52525b]">Hace 1 mes</span>
                </div>
                <p class="text-[#9CA3AF] text-sm mb-4 leading-relaxed">El equipo de NexoApp les desea unas felices fiestas. El soporte técnico operará con horario reducido los días 24 y 25.</p>
                 <div class="flex gap-4 text-xs text-[#52525b] uppercase tracking-wide font-mono border-t border-[#374151] pt-4">
                    <span>Enviado a: Todos</span>
                    <span>•</span>
                    <span>Leído por: 92%</span>
                </div>
            </div>

        </div>

    </div>
@endsection
