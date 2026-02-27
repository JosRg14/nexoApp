<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
        <a href="{{ url('/') }}" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <div class="flex items-center gap-6">
            <!-- User Menu Placeholder -->
            <div class="h-8 w-8 rounded-full bg-[#262626] border border-[#374151] flex items-center justify-center text-xs text-[#9CA3AF]">
                U
            </div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#262626] border-r border-[#374151]/50 hidden md:flex flex-col">
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-[#374151] text-white rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
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
                <a href="{{ route('dashboard.notices') }}" class="flex items-center gap-3 px-4 py-3 text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Avisos</span>
                </a>
            </nav>
        </aside>

        <!-- Content -->
        <div class="flex-1 overflow-auto p-8">
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

        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="border-t border-[#374151]/30 py-8 bg-black mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="text-[10px] text-[#52525b] tracking-wider uppercase">
                © 2026 NexoApp Inc.
            </div>
        </div>
    </footer>

</body>
</html>
