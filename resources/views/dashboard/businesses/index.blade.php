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
    @foreach($businesses as $business)
        @php
            $status = strtolower($business['status']);
            // Mapeo de estilos según tu diseño
            $statusClasses = [
                'activo' => 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20',
                'en revisión' => 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20',
                'pendiente' => 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20',
                'suspendido' => 'bg-red-500/10 text-red-500 border border-red-500/20',
            ];
            
            $isBlocked = ($status === 'suspendido' || $status === 'pendiente' || $status === 'en revisión');
        @endphp

        <tr class="hover:bg-[#1a1a1a]/50 transition-colors group {{ $isBlocked ? 'opacity-75' : '' }}">
            <td class="p-4">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded bg-[#374151] flex items-center justify-center text-xs font-bold text-white">
                        {{ strtoupper(substr($business['name'], 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm">{{ $business['name'] }}</p>
                        <p class="text-[#52525b] text-xs">{{ $business['category'] }}</p>
                    </div>
                </div>
            </td>
            <td class="p-4 text-sm text-[#D1D5DB]">{{ $business['owner'] }}</td>
            <td class="p-4">
                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide {{ $statusClasses[$status] ?? $statusClasses['activo'] }}">
                    {{ $status }}
                </span>
            </td>
            <td class="p-4 text-sm text-white text-right font-mono">${{ number_format($business['revenue'], 0, ',', '.') }}</td>
            <td class="p-4 text-right">
                    <a href="{{ route('dashboard.businesses.show', $business['id']) }}" 
                       class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">
                       {{ ($status === 'pendiente' || $status === 'en revisión') ? 'Revisar' : 'Gestionar' }}
                    </a>
            </td>
        </tr>
    @endforeach
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
