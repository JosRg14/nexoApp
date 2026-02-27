<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Avisos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
        <a href="{{ url('/') }}" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <div class="flex items-center gap-6">
            <div class="h-8 w-8 rounded-full bg-[#262626] border border-[#374151] flex items-center justify-center text-xs text-[#9CA3AF]">
                U
            </div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#262626] border-r border-[#374151]/50 hidden md:flex flex-col">
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Overview</span>
                </a>
                <a href="{{ route('dashboard.businesses') }}" class="flex items-center gap-3 px-4 py-3 text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Negocios</span>
                </a>
                 <a href="{{ route('dashboard.promotions') }}" class="flex items-center gap-3 px-4 py-3 text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Promociones</span>
                </a>
                <a href="{{ route('dashboard.notices') }}" class="flex items-center gap-3 px-4 py-3 bg-[#374151] text-white rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Avisos</span>
                </a>
            </nav>
        </aside>

        <!-- Content -->
        <div class="flex-1 overflow-auto p-8">
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
        </div>
    </div>

</body>
</html>
