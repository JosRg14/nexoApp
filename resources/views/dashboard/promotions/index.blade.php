@extends('layouts.dashboard')

@section('title', 'NexoApp - Promociones')

@section('content')
    <h1 class="text-3xl font-bold uppercase tracking-wide text-white mb-8">Gestión de Promociones</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Create Form -->
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 shadow-lg h-fit">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6">Nuevo Plan</h2>
            <form onsubmit="event.preventDefault(); alert('Campaña creada (simulación)');" class="space-y-6">
                
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Título del Plan</label>
                    <input type="text" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="Ej: Descuento de Verano">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Precio</label>
                        <input type="number" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="20%">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Descripción</label>
                        <textarea class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm focus:border-white focus:outline-none transition-colors" placeholder="Detalles de la promoción..."></textarea>
                        
                    </div>
                </div>

           

                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] mb-2 font-bold">Duración</label>
                    <div class="flex gap-2">
                        <input type="date" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm uppercase">
                        <input type="date" class="w-full bg-[#1a1a1a] border border-[#374151] text-white p-3 text-sm uppercase">
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-white text-black font-bold uppercase tracking-[0.2em] text-xs hover:bg-[#F3F4F6] transition-colors mt-4">
                    Crear Plan
                </button>
            </form>
        </div>

        <!-- Active Promotions List -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-lg font-bold uppercase tracking-widest text-white mb-6">Planes Activos</h2>
            
            <!-- Card 1 -->
            <div class="bg-[#262626] border border-[#374151] p-6 flex justify-between items-center group hover:border-[#F3F4F6] transition-colors">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-white font-bold text-lg">Bienvenida 2026</h3>
                        <span class="bg-emerald-500/10 text-emerald-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-emerald-500/20">Activa</span>
                    </div>
                    <p class="text-[#9CA3AF] text-sm mb-2">15% de descuento en el primer servicio.</p>
                    <div class="flex gap-4 text-xs text-[#52525b] uppercase tracking-wide font-mono">
                        <span>Global</span>
                        <span>•</span>
                        <span>Expira: 28 Feb</span>
                    </div>
                </div>

            </div>

            <!-- Card 2 -->
            <div class="bg-[#262626] border border-[#374151] p-6 flex justify-between items-center group hover:border-[#F3F4F6] transition-colors">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-white font-bold text-lg">Semana de Barbería</h3>
                        <span class="bg-yellow-500/10 text-yellow-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-yellow-500/20">Programada</span>
                    </div>
                    <p class="text-[#9CA3AF] text-sm mb-2">2x1 en cortes clásicos.</p>
                    <div class="flex gap-4 text-xs text-[#52525b] uppercase tracking-wide font-mono">
                        <span>Solo Barberías</span>
                        <span>•</span>
                        <span>Inicia: 1 Mar</span>
                    </div>
                </div>

            </div>

            <!-- Card 3 -->
            <div class="bg-[#262626] border border-[#374151] p-6 flex justify-between items-center opacity-75">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-white font-bold text-lg">Black Friday</h3>
                        <span class="bg-red-500/10 text-red-500 px-2 py-0.5 rounded text-[10px] font-bold uppercase border border-red-500/20">Finalizada</span>
                    </div>
                    <p class="text-[#9CA3AF] text-sm mb-2">30% de descuento en todo.</p>
                    <div class="flex gap-4 text-xs text-[#52525b] uppercase tracking-wide font-mono">
                        <span>Global</span>
                        <span>•</span>
                        <span>Expiró: 30 Nov</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
