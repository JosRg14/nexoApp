@extends('layouts.dashboard')

@section('title', 'NexoApp - Negocios')

@section('content')
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
                        <a href="{{ route('dashboard.businesses', 1) }}" class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">Ver Detalle</a>
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
                        <a href="{{ route('dashboard.businesses', 2) }}" class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">Ver Detalle</a>
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
                        <a href="{{ route('dashboard.businesses', 3) }}" class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">Ver Detalle</a>
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
@endsection
