<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Negocios</title>
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Overview</span>
                </a>
                <a href="{{ route('dashboard.businesses') }}" class="flex items-center gap-3 px-4 py-3 bg-[#374151] text-white rounded-md transition-colors">
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
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Gestión de Negocios</h1>
                <div class="flex gap-4">
                    <input type="text" id="searchInput" placeholder="BUSCAR NEGOCIO..." class="bg-[#262626] border border-[#374151] text-white text-xs tracking-widest px-4 py-2 rounded-sm focus:outline-none focus:border-white placeholder-[#9CA3AF] transition-colors w-64">
                     <select id="statusFilter" class="bg-[#262626] border border-[#374151] text-[#9CA3AF] text-xs uppercase tracking-widest px-4 py-2 rounded-sm focus:outline-none focus:border-white transition-colors cursor-pointer">
                        <option value="">Todos los Estados</option>
                        <option value="activo">Activos</option>
                        <option value="suspendido">Suspendidos</option>
                        <option value="en revisión">En Revisión</option>
                    </select>
                </div>
            </div>

            <!-- Business Table -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm shadow-xl overflow-hidden">
                <table class="w-full text-left border-collapse" id="businessTable">
                    <thead>
                        <tr class="border-b border-[#374151] bg-[#1a1a1a]">
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Negocio</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Propietario</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Estado</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-[#9CA3AF] text-right">Ingresos</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-[#9CA3AF] text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#374151]">
                        <!-- Row 1 -->
                        <tr class="hover:bg-[#1a1a1a]/50 transition-colors group">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded bg-[#374151] flex items-center justify-center text-xs font-bold text-white">GC</div>
                                    <div>
                                        <p class="text-white font-bold text-sm">Gentlemen's Club</p>
                                        <p class="text-[#52525b] text-xs">Barbería • Premium</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-[#D1D5DB]">Carlos M.</td>
                            <td class="p-4">
                                <span class="bg-emerald-500/10 text-emerald-500 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide border border-emerald-500/20">Activo</span>
                            </td>
                            <td class="p-4 text-sm text-white text-right font-mono">$3,450</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('dashboard.businesses.show', 1) }}" class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">Ver Detalle</a>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-[#1a1a1a]/50 transition-colors group">
                             <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded bg-[#374151] flex items-center justify-center text-xs font-bold text-white">UF</div>
                                    <div>
                                        <p class="text-white font-bold text-sm">Urban Fade</p>
                                        <p class="text-[#52525b] text-xs">Estilismo • Urbano</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-[#D1D5DB]">Kevin J.</td>
                            <td class="p-4">
                                <span class="bg-yellow-500/10 text-yellow-500 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide border border-yellow-500/20">En Revisión</span>
                            </td>
                            <td class="p-4 text-sm text-white text-right font-mono">$0</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('dashboard.businesses.show', 2) }}" class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">Ver Detalle</a>
                            </td>
                        </tr>
                         <!-- Row 3 -->
                        <tr class="hover:bg-[#1a1a1a]/50 transition-colors group">
                             <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded bg-[#374151] flex items-center justify-center text-xs font-bold text-white">RB</div>
                                    <div>
                                        <p class="text-white font-bold text-sm">Razor & Blade</p>
                                        <p class="text-[#52525b] text-xs">Barbería • Clásica</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-[#D1D5DB]">Daniel S.</td>
                            <td class="p-4">
                                <span class="bg-red-500/10 text-red-500 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide border border-red-500/20">Suspendido</span>
                            </td>
                            <td class="p-4 text-sm text-white text-right font-mono">$1,200</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('dashboard.businesses.show', 3) }}" class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">Ver Detalle</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Mock -->
            <div class="flex justify-between items-center mt-6">
                 <p class="text-xs text-[#52525b] uppercase tracking-wider">Mostrando 1-3 de 12 negocios</p>
                 <div class="flex gap-2">
                     <button class="px-3 py-1 border border-[#374151] text-[#9CA3AF] text-xs hover:border-white hover:text-white transition-colors disabled:opacity-50" disabled><</button>
                     <button class="px-3 py-1 border border-[#374151] text-[#9CA3AF] text-xs hover:border-white hover:text-white transition-colors">></button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const table = document.getElementById('businessTable');
            const rows = table.getElementsByTagName('tr');

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();

                // Start loop at 1 to skip header row
                for (let i = 1; i < rows.length; i++) { 
                    const nameCell = rows[i].getElementsByTagName('td')[0];
                    const statusCell = rows[i].getElementsByTagName('td')[2];

                    if (nameCell && statusCell) {
                        const nameText = (nameCell.textContent || nameCell.innerText).toLowerCase();
                        const statusText = (statusCell.textContent || statusCell.innerText).toLowerCase();

                        // Check if row matches both search and status filters
                        const matchesSearch = nameText.indexOf(searchText) > -1;
                        const matchesStatus = statusValue === '' || statusText.indexOf(statusValue) > -1;

                        if (matchesSearch && matchesStatus) {
                            rows[i].style.display = "";
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            }

            // Add event listeners for both inputs
            searchInput.addEventListener('keyup', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>
</body>
</html>
