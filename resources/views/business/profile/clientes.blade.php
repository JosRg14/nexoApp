<div id="tab-clientes" class="hidden w-full space-y-6">
    <div class="bg-[#1e1e1e] border border-[#374151] p-6 rounded-lg shadow-xl" x-data="clientesFrecuentesData()" x-init="fetchClientes()">
        <div class="flex flex-col md:flex-row justify-between md:items-end gap-4 mb-6">
            <div class="flex gap-4 items-end flex-wrap">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Desde</label>
                    <input type="date" x-model="filtros.desde" class="bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#F3F4F6]">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Hasta</label>
                    <input type="date" x-model="filtros.hasta" class="bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#F3F4F6]">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Límite</label>
                    <select x-model="filtros.limit" class="bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#F3F4F6]">
                        <option value="10">10 resultados</option>
                        <option value="20">20 resultados</option>
                        <option value="50">50 resultados</option>
                        <option value="100">100 resultados</option>
                    </select>
                </div>
                <button @click="fetchClientes()" class="bg-[#F3F4F6] text-[#1a1a1a] px-4 py-2 font-bold text-xs uppercase tracking-widest hover:bg-white transition-colors h-10 shadow-sm rounded-sm">
                    Filtrar
                </button>
            </div>
            <div>
                <button @click="exportCSV()" class="border border-[#F3F4F6] text-[#F3F4F6] hover:bg-[#F3F4F6] hover:text-[#1a1a1a] px-4 py-2 font-bold text-xs uppercase tracking-widest transition-colors flex items-center gap-2 h-10 rounded-sm">
                    <i class="fa-solid fa-download"></i> Exportar CSV
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border border-[#374151] rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0f0f0f] border-b border-[#374151]">
                        <template x-for="col in columnas" :key="col.key">
                            <th @click="sortBy(col.key)" class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6] cursor-pointer hover:bg-[#1a1a1a] transition-colors whitespace-nowrap">
                                <span x-text="col.label"></span>
                                <i class="fa-solid fa-sort ml-1 text-[#9CA3AF]" x-show="sortCol !== col.key"></i>
                                <i class="fa-solid fa-sort-up ml-1 text-[#25B5DA]" x-show="sortCol === col.key && sortAsc"></i>
                                <i class="fa-solid fa-sort-down ml-1 text-[#25B5DA]" x-show="sortCol === col.key && !sortAsc"></i>
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <template x-if="loading">
                        <tr>
                            <td colspan="7" class="p-8 text-center text-[#9CA3AF]">
                                <div class="w-8 h-8 border-2 border-[#25B5DA] border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                                Cargando clientes...
                            </td>
                        </tr>
                    </template>
                    <template x-if="!loading && clientesFinal.length === 0">
                        <tr>
                            <td colspan="7" class="p-8 text-center text-[#9CA3AF]">
                                No se encontraron clientes frecuentes.
                            </td>
                        </tr>
                    </template>
                    <template x-for="cliente in clientesFinal" :key="cliente.id_usuario || Math.random()">
                        <tr class="border-b border-[#374151]/50 hover:bg-[#262626] transition-colors">
                            <td class="p-4 font-semibold text-white whitespace-nowrap" x-text="cliente.nombre_completo || 'Desconocido'"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="cliente.telefono || 'N/A'"></td>
                            <td class="p-4 font-bold text-[#F3F4F6]" x-text="cliente.total_visitas || 0"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="cliente.ultima_visita ? new Date(cliente.ultima_visita).toLocaleDateString('es-ES') : 'N/A'"></td>
                            <td class="p-4 text-[#25B5DA] font-medium whitespace-nowrap" x-text="formatearMoneda(cliente.gasto_total)"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="formatearMoneda(cliente.gasto_promedio)"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap truncate max-w-[150px]" x-text="cliente.servicio_favorito || 'N/A'" :title="cliente.servicio_favorito || ''"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function clientesFrecuentesData() {
    return {
        clientes: [],
        loading: false,
        sortCol: 'total_visitas',
        sortAsc: false,
        filtros: {
            desde: '',
            hasta: '',
            limit: '20'
        },
        columnas: [
            { key: 'nombre_completo', label: 'Cliente' },
            { key: 'telefono', label: 'Teléfono' },
            { key: 'total_visitas', label: 'Visitas' },
            { key: 'ultima_visita', label: 'Última visita' },
            { key: 'gasto_total', label: 'Gasto total' },
            { key: 'gasto_promedio', label: 'Gasto prom.' },
            { key: 'servicio_favorito', label: 'Servicio favorito' }
        ],
        
        async fetchClientes() {
            this.loading = true;
            try {
                const url = new URL(window.location.origin + '/api-proxy/clientes-frecuentes');
                if (this.filtros.limit) url.searchParams.append('limit', this.filtros.limit);
                if (this.filtros.desde) url.searchParams.append('desde', this.filtros.desde);
                if (this.filtros.hasta) url.searchParams.append('hasta', this.filtros.hasta);

                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    this.clientes = data.data || [];
                } else {
                    console.error('Error fetching data:', await response.text());
                    if (typeof showToast !== 'undefined') showToast('Error al cargar clientes');
                }
            } catch (err) {
                console.error(err);
                if (typeof showToast !== 'undefined') showToast('Error de conexión');
            } finally {
                this.loading = false;
            }
        },
        
        sortBy(key) {
            if (this.sortCol === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortCol = key;
                this.sortAsc = true;
            }
        },
        
        get clientesFinal() {
            if (!this.clientes || this.clientes.length === 0) return [];
            
            return [...this.clientes].sort((a, b) => {
                let valA = a[this.sortCol];
                let valB = b[this.sortCol];
                
                if (this.sortCol === 'ultima_visita') {
                    valA = valA ? new Date(valA).getTime() : 0;
                    valB = valB ? new Date(valB).getTime() : 0;
                }
                
                if (typeof valA === 'string') valA = valA.toLowerCase();
                if (typeof valB === 'string') valB = valB.toLowerCase();
                
                if (valA < valB) return this.sortAsc ? -1 : 1;
                if (valA > valB) return this.sortAsc ? 1 : -1;
                return 0;
            });
        },
        
        formatearMoneda(valor) {
            if (!valor || isNaN(valor)) return '$0.00';
            return '$' + parseFloat(valor).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },
        
        exportCSV() {
            if (this.clientesFinal.length === 0) {
                if (typeof showToast !== 'undefined') showToast('No hay datos para exportar');
                return;
            }
            
            let csvContent = "data:text/csv;charset=utf-8,";
            
            const colLabels = this.columnas.map(c => '"' + c.label + '"');
            csvContent += colLabels.join(",") + "\n";
            
            this.clientesFinal.forEach(c => {
                const fila = [
                    '"' + (c.nombre_completo || '').replace(/"/g, '""') + '"',
                    '"' + (c.telefono || '').replace(/"/g, '""') + '"',
                    c.total_visitas || 0,
                    '"' + (c.ultima_visita ? new Date(c.ultima_visita).toLocaleDateString('es-ES') : '') + '"',
                    c.gasto_total || 0,
                    c.gasto_promedio || 0,
                    '"' + (c.servicio_favorito || '').replace(/"/g, '""') + '"'
                ];
                csvContent += fila.join(",") + "\n";
            });
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `clientes_frecuentes_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}
</script>
