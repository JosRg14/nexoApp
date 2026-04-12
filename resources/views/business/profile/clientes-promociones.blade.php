<div id="tab-clientes-promociones" class="hidden animate-fade-in-up w-full space-y-6" x-data="clientesPromociones()" x-init="initData()">
    
    <!-- SECCIÓN A: Clientes Frecuentes -->
    <div class="bg-[#1e1e1e] border border-[#374151] p-4 md:p-6 rounded-lg shadow-xl">
        <div class="flex flex-col md:flex-row justify-between md:items-end gap-4 mb-6">
            <h2 class="text-xl font-bold uppercase tracking-widest text-white">Clientes Frecuentes</h2>
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
        </div>

        <div class="overflow-x-auto border border-[#374151] rounded-lg">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-[#0f0f0f] border-b border-[#374151]">
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Cliente</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Contacto</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Total Visitas</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Gasto Total</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Última Visita</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6] text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <template x-if="loading.clientes">
                        <tr>
                            <td colspan="6" class="p-8 text-center text-[#9CA3AF]">
                                <div class="w-8 h-8 border-2 border-[#25B5DA] border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
                                Cargando clientes...
                            </td>
                        </tr>
                    </template>
                    <template x-if="!loading.clientes && clientes.length === 0">
                        <tr>
                            <td colspan="6" class="p-8 text-center text-[#9CA3AF]">No se encontraron clientes frecuentes.</td>
                        </tr>
                    </template>
                    <template x-for="cliente in clientes" :key="cliente.id_usuario || cliente.cliente_id">
                        <tr class="border-b border-[#374151]/50 hover:bg-[#262626] transition-colors">
                            <td class="p-4 font-semibold text-white whitespace-nowrap" x-text="cliente.nombre ? `${cliente.nombre} ${cliente.app_paterno} ${cliente.app_materno}`.trim() : 'Desconocido'"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap">
                                <div x-text="cliente.telefono || 'Sin teléfono'"></div>
                                <div class="text-[10px] opacity-70" x-text="cliente.correo || ''"></div>
                            </td>
                            <td class="p-4 font-bold text-[#F3F4F6]" x-text="cliente.total_visitas || 0"></td>
                            <td class="p-4 text-[#25B5DA] font-medium whitespace-nowrap" x-text="formatearMoneda(cliente.gasto_total)"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="cliente.ultima_visita ? new Date(cliente.ultima_visita).toLocaleDateString('es-ES') : 'N/A'"></td>
                            <td class="p-4 text-right flex items-center justify-end gap-3 flex-wrap">
                                <button @click="abrirModalHistorial(cliente)" class="text-[#9CA3AF] hover:text-white transition-colors" title="Ver Historial de Promociones">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </button>
                                <button @click="abrirModalAsignar(cliente)" class="text-[#25B5DA] font-bold text-[10px] uppercase tracking-widest hover:text-white transition-colors">
                                    Asignar Promoción
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECCIÓN B: Promociones -->
    <div class="bg-[#1e1e1e] border border-[#374151] p-4 md:p-6 rounded-lg shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold uppercase tracking-widest text-white">Promociones (Plantillas)</h2>
            <button @click="abrirModalCrear()" class="bg-[#F3F4F6] text-[#1a1a1a] px-4 py-2 font-bold text-xs uppercase tracking-widest hover:bg-white transition-colors rounded-sm shadow-sm">
                ➕ Crear Plantilla
            </button>
        </div>

        <div class="overflow-x-auto border border-[#374151] rounded-lg">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-[#0f0f0f] border-b border-[#374151]">
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Nombre</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Beneficio</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Servicio</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Vigencia</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Estado</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6] text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <template x-if="loading.promociones">
                        <tr>
                            <td colspan="6" class="p-8 text-center text-[#9CA3AF]">Cargando promociones...</td>
                        </tr>
                    </template>
                    <template x-if="!loading.promociones && promociones.length === 0">
                        <tr>
                            <td colspan="6" class="p-8 text-center text-[#9CA3AF]">No hay promociones configuradas.</td>
                        </tr>
                    </template>
                    <template x-for="promo in promociones" :key="promo.id_promocion">
                        <tr class="border-b border-[#374151]/50 hover:bg-[#262626] transition-colors">
                            <td class="p-4 font-semibold text-white whitespace-nowrap" x-text="promo.nombre"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="formatearBeneficio(promo)"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="promo.servicio ? promo.servicio.nombre : 'N/A'"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="promo.vigencia_dias ? promo.vigencia_dias + ' días' : 'Sin límite'"></td>
                            <td class="p-4">
                                <button @click="toggleActivo(promo)" :class="promo.activo ? 'text-green-400' : 'text-red-400'" class="font-bold text-[10px] uppercase tracking-widest transition-colors flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full" :class="promo.activo ? 'bg-green-400' : 'bg-red-400'"></span>
                                    <span x-text="promo.activo ? 'Activa' : 'Inactiva'"></span>
                                </button>
                            </td>
                            <td class="p-4 text-right flex items-center justify-end gap-3">
                                <button @click="abrirModalEditar(promo)" class="text-[#9CA3AF] hover:text-white transition-colors" title="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button @click="abrirModalEliminar(promo)" class="text-[#9CA3AF] hover:text-red-400 transition-colors" title="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECCIÓN C: Asignaciones Recientes -->
    <div class="bg-[#1e1e1e] border border-[#374151] p-4 md:p-6 rounded-lg shadow-xl" x-show="asignacionesRecientes.length > 0">
        <h2 class="text-xl font-bold uppercase tracking-widest text-white mb-6">Asignaciones Recientes</h2>
        <div class="overflow-x-auto border border-[#374151] rounded-lg">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-[#0f0f0f] border-b border-[#374151]">
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Cliente</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Promoción</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Beneficio</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Vigencia</th>
                        <th class="p-4 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Estado</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <template x-for="asig in asignacionesRecientes" :key="asig.id">
                        <tr class="border-b border-[#374151]/50 hover:bg-[#262626] transition-colors">
                            <td class="p-4 font-semibold text-white whitespace-nowrap" x-text="asig.cliente_nombre"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="asig.titulo"></td>
                            <td class="p-4 text-[#9CA3AF] whitespace-nowrap" x-text="asig.beneficio_tipo === 'descuento' ? (asig.beneficio_valor + '% de descuento') : 'Servicio Gratis'"></td>
                            <td class="p-4 text-[#9CA3AF]" x-text="asig.vigencia ? new Date(asig.vigencia).toLocaleDateString('es-ES') : 'N/A'"></td>
                            <td class="p-4">
                                <span :class="asig.usada ? 'text-gray-400' : 'text-green-400'" class="font-bold text-[10px] uppercase tracking-widest" x-text="asig.usada ? 'Usada' : 'Disponible'"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>


    <!-- MODALES -->

    <!-- Modal Formulario Promo -->
    <div x-show="modales.formulario" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4" style="display: none;">
        <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg shadow-2xl w-full max-w-lg overflow-hidden" @click.away="modales.formulario = false">
            <div class="px-6 py-4 border-b border-[#374151] flex justify-between items-center bg-[#0f0f0f]">
                <h3 class="text-lg font-bold text-white uppercase tracking-widest" x-text="formPromo.id ? 'Editar Promoción' : 'Crear Promoción'"></h3>
                <button @click="modales.formulario = false" class="text-[#9CA3AF] hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Nombre</label>
                    <input type="text" x-model="formPromo.nombre" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Descripción (Opcional)</label>
                    <textarea x-model="formPromo.descripcion" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]" rows="2"></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Tipo de Beneficio</label>
                        <select x-model="formPromo.beneficio_tipo" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]">
                            <option value="descuento">Descuento (%)</option>
                            <option value="servicio_gratis">Servicio Gratis</option>
                        </select>
                    </div>
                    <div x-show="formPromo.beneficio_tipo === 'descuento'">
                        <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Valor (%)</label>
                        <input type="number" x-model="formPromo.beneficio_valor" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]">
                    </div>
                </div>

                <div x-show="formPromo.beneficio_tipo === 'servicio_gratis'">
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Servicio Aplicable</label>
                    <select x-model="formPromo.servicio_id" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]">
                        <option value="">Seleccione un servicio (Opcional)</option>
                        @foreach($services as $s)
                        <option value="{{ $s['id'] }}">{{ $s['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Vigencia (Días)</label>
                        <input type="number" placeholder="Ej. 30" x-model="formPromo.vigencia_dias" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]">
                    </div>
                    <div class="flex items-center mt-6">
                        <label class="flex items-center cursor-pointer gap-2">
                            <input type="checkbox" x-model="formPromo.activo" class="w-4 h-4 rounded border-[#374151] bg-[#0f0f0f] text-[#25B5DA] focus:ring-[#25B5DA]">
                            <span class="text-xs uppercase tracking-widest text-[#9CA3AF] font-bold">Activo</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-[#374151] flex justify-end gap-3 bg-[#0f0f0f]">
                <button @click="modales.formulario = false" class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">Cancelar</button>
                <button @click="guardarPromo()" class="bg-[#F3F4F6] text-[#1a1a1a] px-6 py-2 text-xs font-bold uppercase tracking-widest rounded-sm hover:bg-white transition-colors">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Promo -->
    <div x-show="modales.eliminar" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4" style="display: none;">
        <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg shadow-2xl w-full max-w-sm overflow-hidden" @click.away="modales.eliminar = false">
            <div class="p-6 text-center space-y-4">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4 text-red-600">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-widest">Eliminar Promoción</h3>
                <p class="text-sm text-[#9CA3AF]">¿Estás seguro de que deseas eliminar la promoción? Esta acción no se puede deshacer y fallará si la plantilla ya está asignada a algún cliente.</p>
            </div>
            <div class="px-6 py-4 border-t border-[#374151] flex flex-row-reverse gap-3 bg-[#0f0f0f]">
                <button @click="confirmarEliminar()" class="bg-red-600 text-white px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-sm hover:bg-red-500 transition-colors">Sí, Eliminar</button>
                <button @click="modales.eliminar = false" class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- Modal Asignar Promo -->
    <div x-show="modales.asignar" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4" style="display: none;">
        <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg shadow-2xl w-full max-w-md overflow-hidden" @click.away="modales.asignar = false">
            <div class="px-6 py-4 border-b border-[#374151] flex justify-between items-center bg-[#0f0f0f]">
                <h3 class="text-lg font-bold text-white uppercase tracking-widest">Asignar Promoción</h3>
                <button @click="modales.asignar = false" class="text-[#9CA3AF] hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-[#262626] p-3 rounded text-sm text-white mb-4">
                    Cliente: <strong x-text="formAsignar.cliente_nombre"></strong>
                </div>
                
                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Seleccionar Plantilla</label>
                    <select x-model="formAsignar.promocion_id" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]">
                        <option value="">Seleccione una plantilla activa...</option>
                        <template x-for="p in promocionesActivas" :key="p.id_promocion">
                            <option :value="p.id_promocion" x-text="p.nombre + ' (' + formatearBeneficio(p) + ')'"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-widest text-[#9CA3AF] font-bold mb-1">Vigencia Fija (Opcional)</label>
                    <input type="date" x-model="formAsignar.vigencia_fija" class="w-full bg-[#0f0f0f] border border-[#374151] rounded px-3 py-2 text-sm text-white focus:outline-none focus:border-[#25B5DA]">
                    <p class="text-[10px] text-[#9CA3AF] mt-1">Si se deja vacío, se usarán los días de vigencia configurados en la plantilla.</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-[#374151] flex justify-end gap-3 bg-[#0f0f0f]">
                <button @click="modales.asignar = false" class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">Cancelar</button>
                <button @click="confirmarAsignar()" class="bg-[#25B5DA] text-white px-6 py-2 text-xs font-bold uppercase tracking-widest rounded-sm hover:bg-[#25B5DA]/80 transition-colors">
                    Asignar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Historial Promociones -->
    <div x-show="modales.historial" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4" style="display: none;">
        <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col" @click.away="modales.historial = false">
            <div class="px-6 py-4 border-b border-[#374151] flex justify-between items-center bg-[#0f0f0f] shrink-0">
                <h3 class="text-lg font-bold text-white uppercase tracking-widest">
                    Promociones de <span class="text-[#25B5DA]" x-text="historialClienteNombre"></span>
                </h3>
                <button @click="modales.historial = false" class="text-[#9CA3AF] hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-0">
                <!-- TABS -->
                <div class="flex border-b border-[#374151]">
                    <button @click="historialTab = 'disponibles'" 
                            :class="historialTab === 'disponibles' ? 'border-[#25B5DA] text-white' : 'border-transparent text-[#9CA3AF] hover:text-gray-300'"
                            class="px-6 py-3 font-bold text-xs uppercase tracking-widest border-b-2 transition-colors">
                        Disponibles (<span x-text="historialDisponibles.length"></span>)
                    </button>
                    <button @click="historialTab = 'historial'" 
                            :class="historialTab === 'historial' ? 'border-[#25B5DA] text-white' : 'border-transparent text-[#9CA3AF] hover:text-gray-300'"
                            class="px-6 py-3 font-bold text-xs uppercase tracking-widest border-b-2 transition-colors">
                        Historial Uso (<span x-text="historialUsadas.length"></span>)
                    </button>
                </div>

                <div class="p-6">
                    <template x-if="loading.historial">
                        <div class="text-center py-8">
                            <i class="fas fa-spinner fa-spin text-[#25B5DA] text-2xl mb-2"></i>
                            <p class="text-[#9CA3AF] text-xs uppercase tracking-widest">Cargando...</p>
                        </div>
                    </template>

                    <template x-if="!loading.historial">
                        <div>
                            <!-- TAB DISPONIBLES -->
                            <div x-show="historialTab === 'disponibles'">
                                <template x-if="historialDisponibles.length === 0">
                                    <div class="text-center py-8 text-[#9CA3AF] text-sm bg-[#1e1e1e] rounded-lg border border-[#374151]">
                                        El cliente no tiene promociones disponibles.
                                    </div>
                                </template>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="historialDisponibles.length > 0">
                                    <template x-for="promo in historialDisponibles" :key="promo.id">
                                        <div class="bg-[#262626] border border-[#374151] rounded-lg p-4 flex justify-between items-start">
                                            <div>
                                                <h4 class="text-white font-bold text-sm mb-1" x-text="promo.titulo || promo.promocion?.nombre"></h4>
                                                <div class="flex gap-2">
                                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] uppercase font-bold tracking-widest bg-[#25B5DA]/20 text-[#25B5DA]" 
                                                          x-text="(promo.beneficio_tipo === 'descuento' ? promo.beneficio_valor + '% OFF' : 'GRATIS')">
                                                    </span>
                                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] uppercase font-bold tracking-widest bg-green-500/10 text-green-500">
                                                        Disponible
                                                    </span>
                                                </div>
                                                <p class="text-[10px] text-[#9CA3AF] mt-2">
                                                    Asignada el: <span x-text="new Date(promo.created_at).toLocaleDateString()"></span>
                                                    <template x-if="promo.vigencia">
                                                        <span> • Vence: <span x-text="new Date(promo.vigencia).toLocaleDateString()"></span></span>
                                                    </template>
                                                </p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- TAB HISTORIAL -->
                            <div x-show="historialTab === 'historial'">
                                <template x-if="historialUsadas.length === 0">
                                    <div class="text-center py-8 text-[#9CA3AF] text-sm bg-[#1e1e1e] rounded-lg border border-[#374151]">
                                        El cliente no tiene un historial de uso.
                                    </div>
                                </template>

                                <div class="overflow-x-auto border border-[#374151] rounded-lg" x-show="historialUsadas.length > 0">
                                    <table class="w-full text-left border-collapse min-w-[600px]">
                                        <thead>
                                            <tr class="bg-[#0f0f0f] border-b border-[#374151]">
                                                <th class="p-3 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Promoción</th>
                                                <th class="p-3 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Beneficio</th>
                                                <th class="p-3 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Cita Fecha</th>
                                                <th class="p-3 text-[10px] uppercase tracking-widest font-bold text-[#F3F4F6]">Estado Cita</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm">
                                            <template x-for="uso in historialUsadas" :key="uso.id">
                                                <tr class="border-b border-[#374151]/50 hover:bg-[#262626] transition-colors">
                                                    <td class="p-3 font-semibold text-white">
                                                        <div x-text="uso.promocion?.titulo || uso.promocion?.promocion?.nombre || 'Promoción'"></div>
                                                        <div class="text-[10px] text-[#9CA3AF] font-normal" x-text="'Usada: ' + new Date(uso.created_at).toLocaleDateString()"></div>
                                                    </td>
                                                    <td class="p-3 text-[#25B5DA]" x-text="'-$' + (uso.descuento_aplicado || 0)"></td>
                                                    <td class="p-3 text-[#9CA3AF]" x-text="uso.cita ? new Date(uso.cita.fecha).toLocaleDateString() + ' ' + uso.cita.hora_inicio : 'N/A'"></td>
                                                    <td class="p-3">
                                                        <span class="text-[10px] uppercase font-bold tracking-widest" 
                                                              :class="uso.cita?.estado === 'completada' ? 'text-green-400' : 'text-orange-400'" 
                                                              x-text="uso.cita ? (uso.cita.estado || 'agendada') : 'Uso registrado'">
                                                        </span>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
           document.querySelector('input[name="_token"]')?.value;
}

function clientesPromociones() {
    return {
        clientes: [],
        promociones: [],
        asignacionesRecientes: [],
        
        loading: {
            clientes: false,
            promociones: false,
            historial: false
        },
        
        filtros: {
            desde: '',
            hasta: '',
            limit: '20'
        },

        modales: {
            formulario: false,
            eliminar: false,
            asignar: false,
            historial: false
        },

        historialClienteNombre: '',
        historialDisponibles: [],
        historialUsadas: [],
        historialTab: 'disponibles',

        formPromo: {
            id_promocion: null,
            nombre: '',
            descripcion: '',
            beneficio_tipo: 'descuento',
            beneficio_valor: '',
            servicio_id: '',
            vigencia_dias: '',
            activo: true
        },

        formAsignar: {
            cliente_id: null,
            cliente_nombre: '',
            promocion_id: '',
            vigencia_fija: ''
        },

        promoSeleccionada: null,

        async initData() {
            await Promise.all([
                this.fetchClientes(),
                this.fetchPromociones()
            ]);
        },

        // --- CLIENTES ---

        async fetchClientes() {
            this.loading.clientes = true;
            try {
                const url = new URL(window.location.origin + '/api-proxy/clientes-frecuentes');
                if (this.filtros.limit) url.searchParams.append('limit', this.filtros.limit);
                if (this.filtros.desde) url.searchParams.append('desde', this.filtros.desde);
                if (this.filtros.hasta) url.searchParams.append('hasta', this.filtros.hasta);

                const response = await fetch(url.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                
                if (response.ok) {
                    const res = await response.json();
                    this.clientes = res.data || [];
                    this.cargarAsignacionesRecientes(this.clientes);
                }
            } catch (err) {
                console.error(err);
                if (typeof showToast !== 'undefined') showToast('Error al cargar clientes');
            } finally {
                this.loading.clientes = false;
            }
        },

        formatearMoneda(valor) {
            if (!valor || isNaN(valor)) return '$0.00';
            return '$' + parseFloat(valor).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },

        // --- PROMOCIONES ---

        async fetchPromociones() {
            this.loading.promociones = true;
            try {
                const url = '/api-proxy/promociones';
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (response.ok) {
                    const res = await response.json();
                    this.promociones = res.data || [];
                }
            } catch (err) {
                console.error(err);
            } finally {
                this.loading.promociones = false;
            }
        },

        get promocionesActivas() {
            console.log('Promociones activas:', this.promociones.filter(p => p.activo));
            return this.promociones.filter(p => p.activo);
        },

        abrirModalCrear() {
            this.formPromo = { id_promocion: null, nombre: '', descripcion: '', beneficio_tipo: 'descuento', beneficio_valor: '', servicio_id: '', vigencia_dias: '', activo: true };
            this.modales.formulario = true;
        },

        abrirModalEditar(promo) {
            this.formPromo = { ...promo, activo: promo.activo == 1 || promo.activo === true };
            this.modales.formulario = true;
        },

        abrirModalEliminar(promo) {
            this.promoSeleccionada = promo;
            this.modales.eliminar = true;
        },

        async guardarPromo() {
            if (!this.formPromo.nombre) {
                if (typeof showToast !== 'undefined') showToast('El nombre es requerido');
                return;
            }
            if (this.formPromo.beneficio_tipo === 'descuento' && !this.formPromo.beneficio_valor) {
                if (typeof showToast !== 'undefined') showToast('El valor del descuento es requerido');
                return;
            }

            try {
                if (typeof showLoader !== 'undefined') showLoader();
                const isEdit = !!this.formPromo.id_promocion;
                const url = isEdit ? `/api-proxy/promociones/${this.formPromo.id_promocion}` : '/api-proxy/promociones';
                const method = isEdit ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value
                    },
                    body: JSON.stringify(this.formPromo)
                });

                if (response.ok) {
                    await this.fetchPromociones();
                    this.modales.formulario = false;
                    if (typeof showToast !== 'undefined') showToast(isEdit ? 'Promoción actualizada' : 'Promoción creada');
                } else {
                    const errorMsg = await response.text();
                    console.error(errorMsg);
                    if (typeof showToast !== 'undefined') showToast('Error al guardar la promoción');
                }
            } catch (err) {
                console.error(err);
            } finally {
                if (typeof hideLoader !== 'undefined') hideLoader();
            }
        },

        async confirmarEliminar() {
            if (!this.promoSeleccionada) return;
            try {
                if (typeof showLoader !== 'undefined') showLoader();
                const response = await fetch(`/api-proxy/promociones/${this.promoSeleccionada.id_promocion}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value
                    }
                });

                const resData = await response.json();
                if (response.ok && resData.success !== false) {
                    await this.fetchPromociones();
                    this.modales.eliminar = false;
                    if (typeof showToast !== 'undefined') showToast('Promoción eliminada');
                } else {
                    if (typeof showToast !== 'undefined') showToast(resData.message || 'Error: la plantilla puede tener asignaciones activas');
                }
            } catch (err) {
                console.error(err);
            } finally {
                if (typeof hideLoader !== 'undefined') hideLoader();
            }
        },

        async toggleActivo(promo) {
            try {
                if (typeof showLoader !== 'undefined') showLoader();
                // To toggle easily we can just make a quick PUT with contrary state
                const payload = { ...promo, activo: !promo.activo };
                
                const response = await fetch(`/api-proxy/promociones/${promo.id_promocion}`, {
                    method: 'PUT',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    await this.fetchPromociones();
                    if (typeof showToast !== 'undefined') showToast('Estado actualizado');
                }
            } catch (err) {
                console.error(err);
            } finally {
                if (typeof hideLoader !== 'undefined') hideLoader();
            }
        },

        formatearBeneficio(promo) {
            if (promo.beneficio_tipo === 'descuento') {
                return promo.beneficio_valor + '% OFF';
            }
            return 'Servicio Gratis';
        },

        // --- ASIGNACIONES E HISTORIAL ---

        async abrirModalHistorial(cliente) {
            const cid = cliente.cliente_id || cliente.id_cliente || cliente.id_usuario || cliente.id;
            if (!cid) return;
            
            this.historialClienteNombre = cliente.nombre_completo || 'Cliente Frecuente';
            this.historialTab = 'disponibles';
            this.modales.historial = true;
            this.loading.historial = true;
            this.historialDisponibles = [];
            this.historialUsadas = [];

            try {
                // Fetch disponibles
                const resDisp = await fetch(`/api-proxy/api/clientes/${cid}/promociones/disponibles`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (resDisp.ok) {
                    const data = await resDisp.json();
                    this.historialDisponibles = data.data || [];
                }

                // Fetch historial
                const resHist = await fetch(`/api-proxy/api/clientes/${cid}/promociones/historial`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (resHist.ok) {
                    const data = await resHist.json();
                    this.historialUsadas = data.data || [];
                }
            } catch (e) {
                console.error(e);
                if (typeof showToast !== 'undefined') showToast('Error al cargar historial', 'error');
            } finally {
                this.loading.historial = false;
            }
        },

        abrirModalAsignar(cliente) {
            // Usar el campo correcto según la estructura de datos
            const cid = cliente.cliente_id || cliente.id_cliente || cliente.id_usuario || cliente.id;
            
            if (!cid) {
                console.error('No se pudo obtener el ID del cliente', cliente);
                if (typeof showToast !== 'undefined') showToast('Error: ID de cliente no encontrado');
                return;
            }
            
            this.formAsignar = {
                cliente_id: cid,
                cliente_nombre: cliente.nombre_completo || 'Cliente Frecuente',
                promocion_id: '',
                vigencia_fija: ''
            };
            this.modales.asignar = true;
        },

        async confirmarAsignar() {
            console.log('=== confirmarAsignar ===');
            console.log('cliente_id:', this.formAsignar.cliente_id);
            console.log('promocion_id:', this.formAsignar.promocion_id);
            console.log('tipo promocion_id:', typeof this.formAsignar.promocion_id);
            
            if (!this.formAsignar.cliente_id) {
                console.error('cliente_id es null/undefined');
                if (typeof showToast !== 'undefined') showToast('Error: ID de cliente no válido');
                return;
            }

            if (!this.formAsignar.promocion_id || isNaN(parseInt(this.formAsignar.promocion_id))) {
                if (typeof showToast !== 'undefined') showToast('Seleccione una promoción válida');
                return;
            }

            try {
                if (typeof showLoader !== 'undefined') showLoader();
                const payload = { promocion_id: this.formAsignar.promocion_id };
                if (this.formAsignar.vigencia_fija) {
                    payload.vigencia = this.formAsignar.vigencia_fija;
                }

                const response = await fetch(`/api-proxy/clientes/${this.formAsignar.cliente_id}/promociones`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    this.modales.asignar = false;
                    if (typeof showToast !== 'undefined') showToast('Promoción asignada correctamente');
                    // Recargar las recientes pasándole la misma lista base
                    this.cargarAsignacionesRecientes(this.clientes);
                } else {
                    const resData = await response.json();
                    if (typeof showToast !== 'undefined') showToast(resData.message || 'Error al asignar');
                }
            } catch (err) {
                console.error(err);
            } finally {
                if (typeof hideLoader !== 'undefined') hideLoader();
            }
        },

        async cargarAsignacionesRecientes(listaClientesBase) {
            // Intentar recuperar los más recientes de los top clientes de la vista
            // Solo para mostrar algo interesante limitamos a los 5 primeros clientes
            if (!listaClientesBase || listaClientesBase.length === 0) return;
            let topClientes = listaClientesBase.slice(0, 5);
            let todasLasAsignaciones = [];

            try {
                for (let c of topClientes) {
                    const cid = c.cliente_id || c.id_usuario || c.id;
                    if(!cid) continue;

                    const response = await fetch(`/api-proxy/clientes/${cid}/promociones`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        if (data.data && data.data.length > 0) {
                            // Injectar en cada una el nombre del cliente para la tabla
                            data.data.forEach(asig => asig.cliente_nombre = c.nombre_completo);
                            todasLasAsignaciones = todasLasAsignaciones.concat(data.data);
                        }
                    }
                }

                // Ordenar por más recientes primero
                todasLasAsignaciones.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                
                // Mostrar solo los últimos 10
                this.asignacionesRecientes = todasLasAsignaciones.slice(0, 10);
                
            } catch (err) {
                console.error(err);
            }
        }
    }
}
</script>
