@extends('layouts.dashboard')

@section('title', 'NexoApp - Negocios')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Gestión de Negocios</h1>
        <div class="flex gap-4">
            <input type="text" id="searchInput" placeholder="BUSCAR NEGOCIO..."
                class="bg-[#262626] border border-[#374151] text-white text-xs tracking-widest px-4 py-2 rounded-sm focus:outline-none focus:border-white placeholder-[#9CA3AF] transition-colors w-64">
            
            <select id="statusFilter"
                class="bg-[#262626] border border-[#374151] text-[#9CA3AF] text-xs uppercase tracking-widest px-4 py-2 rounded-sm focus:outline-none focus:border-white transition-colors cursor-pointer">
                <option value="" {{ request('estado') == '' ? 'selected' : '' }}>Todos los Estados</option>
                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendidos</option>
                {{-- Mantenemos el value como en_revision para que coincida con tu DB/API --}}
                <option value="en_revision" {{ request('estado') == 'en_revision' ? 'selected' : '' }}>Pendientes</option>
            </select>
        </div>
    </div>

    <div class="mb-6 border-b border-[#374151]">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('dashboard.businesses') }}"
                class="{{ !request('estado') ? 'border-emerald-500 text-emerald-500' : 'border-transparent text-[#9CA3AF] hover:text-white' }} whitespace-nowrap pb-4 px-1 border-b-2 font-bold text-xs uppercase tracking-widest transition-all">
                Todos los Negocios
            </a>


        </nav>
    </div>

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
                @foreach ($businesses as $business)
                    @php
                        // Normalizamos el string del estado para poner el color
                        $rawStatus = strtolower($business['status']);
                        
                        $statusClasses = [
                            'activo'      => 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20',
                            'en_revision' => 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20',
                            'en revision' => 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20',
                            'suspendido'  => 'bg-red-500/10 text-red-500 border border-red-500/20',
                        ];

                        $isBlocked = in_array($rawStatus, ['suspendido', 'en_revision', 'en revision']);
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
                            {{-- Si el estado es en_revision, mostramos "EN REVISIÓN" en amarillo --}}
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide {{ $statusClasses[$rawStatus] ?? $statusClasses['activo'] }}">
                                {{ str_replace('_', ' ', $rawStatus) }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-white text-right font-mono">
                            ${{ number_format($business['revenue'], 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('dashboard.businesses.show', $business['id']) }}"
                                class="text-[#9CA3AF] hover:text-white text-xs font-bold uppercase tracking-wider underline decoration-transparent hover:decoration-white transition-all">
                                {{ str_contains($rawStatus, 'revision') ? 'Revisar' : 'Gestionar' }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('businessTable');
        const rows = table.getElementsByTagName('tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            // Si el filtro es 'en_revision', buscamos 'en revision' en el texto de la celda
            const statusValue = statusFilter.value.toLowerCase().replace('_', ' ').trim();

            for (let i = 1; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByTagName('td')[0];
                const statusCell = rows[i].getElementsByTagName('td')[2];

                if (nameCell && statusCell) {
                    const nameText = (nameCell.textContent || nameCell.innerText).toLowerCase();
                    const statusText = (statusCell.textContent || statusCell.innerText).toLowerCase().trim();

                    const matchesSearch = nameText.indexOf(searchText) > -1;
                    const matchesStatus = statusValue === '' || statusText === statusValue;

                    if (matchesSearch && matchesStatus) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }

        searchInput.addEventListener('keyup', filterTable);
        statusFilter.addEventListener('change', filterTable);

        // Se ejecuta al cargar para respetar el filtro que venga de la URL (el de la pestaña Pendientes)
        filterTable(); 
    });
    </script>
@endsection