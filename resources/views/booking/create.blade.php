@extends('layouts.app')

@section('title', 'Agendar Cita')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-8 border-b border-[#374151] pb-8">
            <a href="{{ url()->previous() }}" 
               class="text-[#9CA3AF] hover:text-white text-xs uppercase tracking-widest mb-4 inline-block flex items-center gap-2 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>

            <div>
                <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Agendar Cita</h1>
                <p class="text-[#9CA3AF] text-sm mt-2">Selecciona un servicio, un empleado y el horario que prefieras</p>
            </div>
        </div>

        @if(empty($servicios))
        <div class="bg-red-500/20 border border-red-500 text-red-500 p-6 rounded-sm text-center">
            <i class="fas fa-exclamation-triangle text-2xl mb-2 block"></i>
            <p>No hay servicios disponibles para este negocio.</p>
        </div>
        @else
        <form id="cita-form" class="space-y-8">
            @csrf
            <input type="hidden" name="negocio_id" id="negocio_id" value="{{ $negocioId }}">
            <input type="hidden" name="servicio_id" id="servicio_id">
            <input type="hidden" name="empleado_id" id="empleado_id">
            
            <!-- Servicios -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-cut text-[#25B5DA]"></i>
                    Selecciona un servicio
                    <span class="text-xs text-[#9CA3AF] font-normal">({{ count($servicios) }} disponibles)</span>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($servicios as $servicio)
                    <div class="servicio-card border border-[#374151] rounded-sm p-4 cursor-pointer hover:border-[#25B5DA] transition-all" 
                         data-id="{{ $servicio['id'] }}"
                         data-nombre="{{ $servicio['nombre'] }}"
                         data-precio="{{ $servicio['precio'] }}"
                         data-duracion="{{ $servicio['duracion'] }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-white font-bold text-sm">{{ $servicio['nombre'] }}</h4>
                                <p class="text-[#9CA3AF] text-[10px] mt-1">{{ $servicio['descripcion'] ?? 'Sin descripción' }}</p>
                            </div>
                            <span class="text-[#25B5DA] font-bold text-sm">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-2 text-[10px] text-[#9CA3AF]">
                            <i class="far fa-clock"></i>
                            <span>{{ $servicio['duracion'] }} minutos</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Empleados -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-[#25B5DA]"></i>
                    Selecciona un empleado
                    <span class="text-xs text-[#9CA3AF] font-normal">({{ count($empleados) }} disponibles)</span>
                </h3>
                
                @if(count($empleados) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($empleados as $empleado)
                    <div class="empleado-card border border-[#374151] rounded-sm p-3 cursor-pointer hover:border-[#25B5DA] transition-all text-center"
                         data-id="{{ $empleado['id_empleado'] }}"
                         data-nombre="{{ $empleado['nombre'] }}">
                        <div class="w-14 h-14 mx-auto bg-[#25B5DA]/20 text-[#25B5DA] rounded-full flex items-center justify-center text-xl font-bold mb-2">
                            {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                        </div>
                        <h4 class="text-white font-bold text-sm">{{ $empleado['nombre'] }}</h4>
                        <p class="text-[#9CA3AF] text-[10px] mt-1">{{ $empleado['especialidad'] ?? 'Especialista' }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-center text-[#9CA3AF] py-8">No hay empleados disponibles en este momento.</p>
                @endif
            </div>

            <!-- Fecha y Hora -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-[#25B5DA]"></i>
                    Selecciona fecha y hora
                </h3>

                <!-- Hidden inputs para el formulario -->
                <input type="hidden" id="fecha" name="fecha">
                <input type="hidden" id="hora" name="hora_inicio">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Calendario visual -->
                    <div>
                        <p class="text-xs text-[#9CA3AF] uppercase tracking-widest mb-3">Fecha</p>
                        <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 select-none">
                            <!-- Navegación de mes -->
                            <div class="flex justify-between items-center mb-4">
                                <button type="button" id="prev-month"
                                        class="w-8 h-8 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <h4 id="current-month" class="text-white font-bold text-sm uppercase tracking-widest"></h4>
                                <button type="button" id="next-month"
                                        class="w-8 h-8 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                            <!-- Cabecera días de la semana -->
                            <div class="grid grid-cols-7 gap-1 text-center mb-2">
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Lun</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Mar</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Mié</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Jue</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Vie</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Sáb</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Dom</div>
                            </div>
                            <!-- Cuadrícula de días -->
                            <div id="calendar-days" class="grid grid-cols-7 gap-1"></div>
                        </div>
                    </div>

                    <!-- Selector de horarios tipo pills -->
                    <div>
                        <p class="text-xs text-[#9CA3AF] uppercase tracking-widest mb-3">Horario disponible</p>
                        <div id="horarios-container" class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 min-h-[220px] flex flex-col justify-center">
                            <div id="horarios-placeholder" class="text-center">
                                <i class="far fa-clock text-[#374151] text-3xl mb-3 block"></i>
                                <p class="text-[#9CA3AF] text-xs">Selecciona un servicio, empleado y fecha para ver los horarios disponibles</p>
                            </div>
                            <div id="horarios-loading" class="text-center hidden">
                                <div class="inline-block w-6 h-6 border-2 border-[#25B5DA] border-t-transparent rounded-full animate-spin mb-3"></div>
                                <p class="text-[#9CA3AF] text-xs">Cargando horarios...</p>
                            </div>
                            <div id="horarios-empty" class="text-center hidden">
                                <i class="fas fa-calendar-times text-[#374151] text-3xl mb-3 block"></i>
                                <p class="text-[#9CA3AF] text-xs">No hay horarios disponibles para este día</p>
                            </div>
                            <div id="horarios-grid" class="grid grid-cols-3 gap-2 hidden"></div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Promociones -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 {{ $clienteId ? '' : 'hidden' }}" id="promociones-container">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-tag text-[#25B5DA]"></i>
                    ¿Tienes una promoción disponible?
                </h3>
                <div class="space-y-4">
                    <select id="promocion-select" class="w-full bg-[#1a1a1a] border border-[#374151] rounded-lg p-3 text-white focus:outline-none focus:border-[#25B5DA] transition-colors appearance-none">
                        <option value="">No usar promoción</option>
                    </select>
                    
                    <div id="promo-loading" class="text-xs text-[#9CA3AF] mt-2 hidden">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Cargando promociones...
                    </div>

                    <!-- Tarjeta de Detalle de Promoción -->
                    <div id="promo-detail-card" class="hidden border border-[#25B5DA] bg-[#25B5DA]/5 rounded-lg p-4 animate-in fade-in slide-in-from-top-2 duration-300">
                        <div class="flex items-center gap-2 text-[#25B5DA] mb-3">
                            <i class="fas fa-ticket-alt"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">Promoción Seleccionada</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <h4 id="promo-detail-title" class="text-white font-bold text-sm">--</h4>
                                <p id="promo-detail-expiry" class="text-[#9CA3AF] text-[10px] mt-1 uppercase">Vence: --</p>
                            </div>

                            <div class="pt-3 border-t border-[#374151]/50 space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-[#9CA3AF]">Precio original</span>
                                    <span id="promo-detail-original" class="text-white font-medium line-through decoration-red-500">$0</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-[#9CA3AF]">Descuento</span>
                                    <span id="promo-detail-amount" class="text-[#25B5DA] font-bold">-$0</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-[#374151]/50">
                                    <span class="text-white font-bold">Total a pagar</span>
                                    <span id="promo-detail-total" class="text-[#25B5DA] text-lg font-bold">$0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4">Resumen de cita</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-[10px] uppercase text-[#9CA3AF]">Servicio</p>
                        <p id="resumen-servicio" class="text-white font-medium mt-1">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase text-[#9CA3AF]">Empleado</p>
                        <p id="resumen-empleado" class="text-white font-medium mt-1">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase text-[#9CA3AF]">Fecha</p>
                        <p id="resumen-fecha" class="text-white font-medium mt-1">-</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase text-[#9CA3AF]">Hora</p>
                        <p id="resumen-hora" class="text-white font-medium mt-1">-</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-[#374151]">
                    <div id="resumen-promo-aplicada" class="hidden mb-3 flex items-center gap-2 px-2 py-1.5 bg-[#25B5DA]/10 rounded-lg border border-[#25B5DA]/20">
                        <i class="fas fa-tag text-[#25B5DA] text-xs"></i>
                        <span class="text-[#25B5DA] text-xs font-medium" id="resumen-promo-nombre">--</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs uppercase text-[#9CA3AF]">Subtotal</span>
                        <span id="resumen-subtotal" class="text-white font-medium">$0</span>
                    </div>
                    <div id="resumen-descuento-row" class="flex justify-between items-center mb-2 hidden">
                        <span class="text-xs uppercase text-[#25B5DA]">Descuento (<span id="resumen-promo-desc">-</span>)</span>
                        <span id="resumen-descuento" class="text-[#25B5DA] font-medium">-$0</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-[#374151]">
                        <span class="text-xs font-bold uppercase text-white">Total</span>
                        <span id="resumen-total" class="text-xl font-bold text-[#25B5DA]">$0</span>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-bold uppercase tracking-wider rounded-lg hover:from-[#1c8fb0] hover:to-[#25B5DA] transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    id="btn-submit" disabled>
                Confirmar Cita
            </button>
        </form>
        @endif
    </div>
</div>

<script>
// ============================================================
// ESTADO DE LA CITA
// ============================================================
let clienteId = null;
let promocionesDisponibles = [];
let promocionSeleccionada = null;

// Leer el promocion_id de la URL una sola vez al cargar la página
const URL_PROMO_ID = new URLSearchParams(window.location.search).get('promocion_id');

let servicioSeleccionado = null;
let empleadoSeleccionado = null;
let horaSeleccionada = null;

async function obtenerClienteId() {
    try {
        const response = await fetch('/api-proxy/api/me', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            }
        });
        const data = await response.json();
        
        // Intentar varias rutas posibles para obtener el ID del cliente
        clienteId = data.cliente?.id_cliente 
                 || data.id_cliente 
                 || data.cliente_id 
                 || data.id;
        
        console.log('[OBTENER CLIENTE ID] clienteId resuelto:', clienteId);
        
        // Una vez que tenemos el clienteId, cargar las promociones
        if (clienteId) {
            cargarPromociones();
        } else {
            console.warn('[OBTENER CLIENTE ID] No se pudo obtener clienteId');
        }
    } catch (error) {
        console.error('[OBTENER CLIENTE ID] Error:', error);
    }
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('[DIAGNÓSTICO] DOMContentLoaded ejecutado');
    obtenerClienteId();
});

// Elementos DOM
const promocionSelect = document.getElementById('promocion-select');
const promoLoading = document.getElementById('promo-loading');
const resumenSubtotal         = document.getElementById('resumen-subtotal');
const resumenDescuentoRow     = document.getElementById('resumen-descuento-row');
const resumenPromoDesc        = document.getElementById('resumen-promo-desc');
const resumenDescuento        = document.getElementById('resumen-descuento');

// Elementos del detalle de promoción
const promoDetailCard         = document.getElementById('promo-detail-card');
const promoDetailTitle        = document.getElementById('promo-detail-title');
const promoDetailExpiry       = document.getElementById('promo-detail-expiry');
const promoDetailOriginal     = document.getElementById('promo-detail-original');
const promoDetailAmount       = document.getElementById('promo-detail-amount');
const promoDetailTotal        = document.getElementById('promo-detail-total');

const btnSubmit       = document.getElementById('btn-submit');
const fechaHidden     = document.getElementById('fecha');       // <input type="hidden">
const horaHidden      = document.getElementById('hora');        // <input type="hidden">
const resumenServicio = document.getElementById('resumen-servicio');
const resumenEmpleado = document.getElementById('resumen-empleado');
const resumenFecha    = document.getElementById('resumen-fecha');
const resumenHora     = document.getElementById('resumen-hora');
const resumenTotal    = document.getElementById('resumen-total');

// ============================================================
// VALIDACIÓN DEL FORMULARIO
// ============================================================
function checkFormComplete() {
    if (servicioSeleccionado && empleadoSeleccionado && fechaHidden.value && horaHidden.value) {
        btnSubmit.disabled = false;
    } else {
        btnSubmit.disabled = true;
    }
}

// ============================================================
// SELECCIÓN DE SERVICIO
// ============================================================
document.querySelectorAll('.servicio-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.servicio-card').forEach(c => c.classList.remove('border-[#25B5DA]', 'bg-[#25B5DA]/10'));
        this.classList.add('border-[#25B5DA]', 'bg-[#25B5DA]/10');

        servicioSeleccionado = {
            id:       this.dataset.id,
            nombre:   this.dataset.nombre,
            precio:   this.dataset.precio,
            duracion: this.dataset.duracion
        };

        document.getElementById('servicio_id').value = servicioSeleccionado.id;
        resumenServicio.textContent = servicioSeleccionado.nombre;
        
        // IMPORTANTE: filtrarPromociones() primero (asigna promocionSeleccionada),
        // luego actualizarResumenPrecios() (lee promocionSeleccionada ya correcto).
        filtrarPromociones();
        // actualizarResumenPrecios() ya es llamado al final de filtrarPromociones()

        if (empleadoSeleccionado && fechaHidden.value) cargarHorarios();
        checkFormComplete();
    });
});

// ============================================================
// LOGICA DE PROMOCIONES
// ============================================================

async function cargarPromociones() {
    console.log('[DIAGNÓSTICO] cargarPromociones() ejecutada');
    console.log('[DIAGNÓSTICO] clienteId:', clienteId);
    if (document.getElementById('negocio_id')) {
        console.log('[DIAGNÓSTICO] negocioId:', document.getElementById('negocio_id').value);
    }

    if (!clienteId) return;
    
    promoLoading.classList.remove('hidden');
    promocionSelect.disabled = true;
    
    try {
        const negocioId = document.getElementById('negocio_id').value;
        const response = await fetch(`/api-proxy/api/clientes/${clienteId}/promociones/disponibles?negocio_id=${negocioId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            promocionesDisponibles = data.data || [];
        }
    } catch (e) {
        console.error('Error cargando promociones:', e);
    } finally {
        promoLoading.classList.add('hidden');
        filtrarPromociones();
    }
}

function filtrarPromociones() {
    const promoIdAnterior = promocionSelect.value; // guardar valor actual antes de reconstruir
    promocionSelect.innerHTML = '';
    
    const sid = servicioSeleccionado ? parseInt(servicioSeleccionado.id) : null;
    
    // Filtrar promociones aplicables al servicio actual (o aplicables a todos)
    const aplicables = promocionesDisponibles.filter(p => !p.servicio_id || p.servicio_id == sid);
    
    if (aplicables.length === 0) {
        const option = document.createElement('option');
        option.value = "";
        option.textContent = "Sin promociones disponibles";
        promocionSelect.appendChild(option);
        promocionSelect.disabled = true;
        promocionSeleccionada = null;
    } else {
        // Opción por defecto
        const defaultOption = document.createElement('option');
        defaultOption.value = "";
        defaultOption.textContent = "No usar promoción";
        promocionSelect.appendChild(defaultOption);

        aplicables.forEach(promo => {
            const option = document.createElement('option');
            option.value = promo.id_promocion_cliente || promo.id;
            
            let desc = promo.descripcion || promo.titulo || promo.promocion?.nombre || 'Promoción';
            let beneficio = promo.beneficio_tipo === 'descuento' ? `${promo.beneficio_valor}% OFF` : 'Servicio Gratis';
            
            option.textContent = `${desc} (${beneficio})`;
            promocionSelect.appendChild(option);
        });
        promocionSelect.disabled = false;

        // Determinar qué ID usar como candidato:
        // 1º prioridad absoluta: el param de la URL (leido una sola vez, constante URL_PROMO_ID)
        // 2º prioridad: la selección anterior del usuario
        const candidato = URL_PROMO_ID || promoIdAnterior || null;
        
        console.log('[filtrarPromociones] candidato:', candidato, '| URL_PROMO_ID:', URL_PROMO_ID, '| anterior:', promoIdAnterior);
        console.log('[filtrarPromociones] opciones disponibles:', [...promocionSelect.options].map(o => o.value));

        if (candidato) {
            const optionExiste = [...promocionSelect.options].some(o => o.value == candidato);
            if (optionExiste) {
                promocionSelect.value = candidato;
                // Buscar en promocionesDisponibles (no solo en aplicables) con comparación laxa
                promocionSeleccionada = promocionesDisponibles.find(
                    p => String(p.id_promocion_cliente || p.id) === String(candidato)
                ) || null;
                console.log('[filtrarPromociones] ✅ promo encontrada:', promocionSeleccionada);
            } else {
                console.log('[filtrarPromociones] ⚠️ candidato', candidato, 'no existe en las opciones del select filtrado');
                promocionSeleccionada = null;
            }
        } else {
            promocionSeleccionada = null;
        }
    }

    console.log('[filtrarPromociones] promocionSeleccionada final:', promocionSeleccionada);
    actualizarResumenPrecios();
}

promocionSelect.addEventListener('change', function() {
    const promoId = this.value;
    if (!promoId) {
        promocionSeleccionada = null;
    } else {
        // Buscar por id_promocion_cliente que es el valor usado en el option
        promocionSeleccionada = promocionesDisponibles.find(p => (p.id_promocion_cliente || p.id) == promoId);
    }
    actualizarResumenPrecios();
});

function actualizarResumenPrecios() {
    if (!servicioSeleccionado) {
        resumenSubtotal.textContent = '$0';
        resumenTotal.textContent = '$0';
        resumenDescuentoRow.classList.add('hidden');
        promoDetailCard.classList.add('hidden');
        return;
    }
    
    let subtotal = parseFloat(servicioSeleccionado.precio);
    let descuento = 0;
    let promoDesc = '';

    console.log('[actualizarResumenPrecios] servicio:', servicioSeleccionado);
    console.log('[actualizarResumenPrecios] promoción:', promocionSeleccionada);
    console.log('[actualizarResumenPrecios] precio base:', subtotal);
    
    if (promocionSeleccionada) {
        if (promocionSeleccionada.beneficio_tipo === 'descuento') {
            descuento = subtotal * (parseFloat(promocionSeleccionada.beneficio_valor) / 100);
            promoDesc = `${promocionSeleccionada.beneficio_valor}% de descuento`;
        } else if (promocionSeleccionada.beneficio_tipo === 'servicio_gratis') {
            descuento = subtotal;
            promoDesc = 'Servicio gratis (100%)';
        }

        console.log('[actualizarResumenPrecios] descuento:', descuento, '| total:', subtotal - descuento);

        // Actualizar tarjeta de detalles
        promoDetailTitle.textContent = promocionSeleccionada.descripcion || promocionSeleccionada.titulo || promocionSeleccionada.promocion?.nombre || 'Promoción';
        
        let fechaVence = promocionSeleccionada.vigencia || promocionSeleccionada.fecha_vencimiento || promocionSeleccionada.vigencia_fin || '--';
        if (fechaVence !== '--') {
            const dateObj = new Date(fechaVence);
            dateObj.setMinutes(dateObj.getMinutes() + dateObj.getTimezoneOffset());
            fechaVence = dateObj.toLocaleDateString('es-CL', { day: '2-digit', month: '2-digit', year: 'numeric' });
        }
        promoDetailExpiry.textContent = `Vence: ${fechaVence}`;
        
        promoDetailOriginal.textContent = '$' + subtotal.toLocaleString('es-CL');
        promoDetailAmount.textContent   = '-$' + descuento.toLocaleString('es-CL', { maximumFractionDigits: 0 });
        promoDetailTotal.textContent    = '$' + Math.max(0, subtotal - descuento).toLocaleString('es-CL');
        
        promoDetailCard.classList.remove('hidden');

        // Actualizar badge de promoción aplicada en el resumen
        const resumenPromoAplicada = document.getElementById('resumen-promo-aplicada');
        const resumenPromoNombre   = document.getElementById('resumen-promo-nombre');

        resumenPromoDesc.textContent = promoDesc;
        resumenDescuento.textContent = '-$' + descuento.toLocaleString('es-CL', { maximumFractionDigits: 0 });
        resumenDescuentoRow.classList.remove('hidden');

        if (resumenPromoAplicada && resumenPromoNombre) {
            resumenPromoNombre.textContent = promocionSeleccionada.descripcion || promocionSeleccionada.titulo || promocionSeleccionada.promocion?.nombre || 'Promoción aplicada';
            resumenPromoAplicada.classList.remove('hidden');
        }
    } else {
        resumenDescuentoRow.classList.add('hidden');
        promoDetailCard.classList.add('hidden');
        const resumenPromoAplicada = document.getElementById('resumen-promo-aplicada');
        if (resumenPromoAplicada) resumenPromoAplicada.classList.add('hidden');
    }
    
    let total = Math.max(0, subtotal - descuento);
    
    resumenSubtotal.textContent = '$' + subtotal.toLocaleString('es-CL');
    resumenTotal.textContent = '$' + total.toLocaleString('es-CL');
}

// La carga de promociones ahora se inicia desde obtenerClienteId()

// ============================================================
// SELECCIÓN DE EMPLEADO
// ============================================================
document.querySelectorAll('.empleado-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.empleado-card').forEach(c => c.classList.remove('border-[#25B5DA]', 'bg-[#25B5DA]/10'));
        this.classList.add('border-[#25B5DA]', 'bg-[#25B5DA]/10');

        empleadoSeleccionado = {
            id:     this.dataset.id,
            nombre: this.dataset.nombre
        };

        document.getElementById('empleado_id').value = empleadoSeleccionado.id;
        resumenEmpleado.textContent = empleadoSeleccionado.nombre;

        if (servicioSeleccionado && fechaHidden.value) cargarHorarios();
        checkFormComplete();
    });
});

// ============================================================
// CALENDARIO INTERACTIVO
// ============================================================
const calendarDays  = document.getElementById('calendar-days');
const currentMonthEl = document.getElementById('current-month');
const prevMonthBtn  = document.getElementById('prev-month');
const nextMonthBtn  = document.getElementById('next-month');

const today       = new Date();
today.setHours(0, 0, 0, 0);
let viewYear  = today.getFullYear();
let viewMonth = today.getMonth(); // 0-indexed

const MONTHS_ES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                   'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

function pad2(n) { return String(n).padStart(2, '0'); }

function toYMD(date) {
    return `${date.getFullYear()}-${pad2(date.getMonth()+1)}-${pad2(date.getDate())}`;
}

function renderCalendar() {
    currentMonthEl.textContent = `${MONTHS_ES[viewMonth]} ${viewYear}`;
    calendarDays.innerHTML = '';

    // Primer día del mes (0=Dom … 6=Sáb) → convertir a Lun=0
    const firstDay = new Date(viewYear, viewMonth, 1);
    const startOffset = (firstDay.getDay() + 6) % 7; // Monday-first

    // Total de días en el mes
    const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

    // Celdas vacías al inicio
    for (let i = 0; i < startOffset; i++) {
        calendarDays.insertAdjacentHTML('beforeend', '<div></div>');
    }

    const selectedYMD = fechaHidden.value;

    for (let d = 1; d <= daysInMonth; d++) {
        const cellDate = new Date(viewYear, viewMonth, d);
        const ymd      = toYMD(cellDate);
        const isPast   = cellDate < today;
        const isToday  = ymd === toYMD(today);
        const isSelected = ymd === selectedYMD;

        let classes = 'relative flex items-center justify-center rounded-lg text-sm font-medium transition-all duration-150 aspect-square cursor-pointer ';
        let attrs   = `data-date="${ymd}"`;

        if (isPast) {
            classes += 'text-[#4B5563] cursor-not-allowed opacity-40';
            attrs   += ' data-disabled="true"';
        } else if (isSelected) {
            classes += 'bg-[#25B5DA] text-black font-bold shadow-lg shadow-[#25B5DA]/30';
        } else {
            classes += 'text-white border border-[#374151] hover:border-[#25B5DA] hover:bg-[#25B5DA]/10';
        }

        const todayDot = isToday && !isSelected
            ? '<span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-[#25B5DA]"></span>'
            : '';

        calendarDays.insertAdjacentHTML('beforeend',
            `<div class="${classes}" ${attrs}>${d}${todayDot}</div>`);
    }

    // Listeners en celdas de día
    calendarDays.querySelectorAll('[data-date]').forEach(cell => {
        if (cell.dataset.disabled) return;
        cell.addEventListener('click', () => selectDate(cell.dataset.date));
    });

    // Deshabilitar flecha si estamos en el mes/año actual
    const isCurrentMonthYear = viewYear === today.getFullYear() && viewMonth === today.getMonth();
    prevMonthBtn.disabled = isCurrentMonthYear;
    prevMonthBtn.classList.toggle('opacity-30', isCurrentMonthYear);
    prevMonthBtn.classList.toggle('cursor-not-allowed', isCurrentMonthYear);
}

function selectDate(ymd) {
    fechaHidden.value = ymd;

    // Actualizar resumen con formato local
    const [y, m, d] = ymd.split('-').map(Number);
    const displayDate = new Date(y, m - 1, d);
    resumenFecha.textContent = displayDate.toLocaleDateString('es-CL', { day: 'numeric', month: 'long', year: 'numeric' });

    // Resetear hora seleccionada
    horaSeleccionada = null;
    horaHidden.value = '';
    resumenHora.textContent = '-';

    renderCalendar(); // re-render para marcar seleccionado

    if (servicioSeleccionado && empleadoSeleccionado) cargarHorarios();
    checkFormComplete();
}

prevMonthBtn.addEventListener('click', () => {
    if (prevMonthBtn.disabled) return;
    viewMonth--;
    if (viewMonth < 0) { viewMonth = 11; viewYear--; }
    renderCalendar();
});

nextMonthBtn.addEventListener('click', () => {
    viewMonth++;
    if (viewMonth > 11) { viewMonth = 0; viewYear++; }
    renderCalendar();
});

// Renderizado inicial
renderCalendar();

// ============================================================
// HORARIOS TIPO PILLS
// ============================================================
const horariosGrid        = document.getElementById('horarios-grid');
const horariosPlaceholder = document.getElementById('horarios-placeholder');
const horariosLoading     = document.getElementById('horarios-loading');
const horariosEmpty       = document.getElementById('horarios-empty');

function showHorariosState(state) {
    horariosPlaceholder.classList.add('hidden');
    horariosLoading.classList.add('hidden');
    horariosEmpty.classList.add('hidden');
    horariosGrid.classList.add('hidden');
    if (state === 'placeholder') horariosPlaceholder.classList.remove('hidden');
    if (state === 'loading')     horariosLoading.classList.remove('hidden');
    if (state === 'empty')       horariosEmpty.classList.remove('hidden');
    if (state === 'grid')        horariosGrid.classList.remove('hidden');
}

function buildHorarioPill(slot) {
    const btn = document.createElement('button');
    btn.type        = 'button';
    btn.dataset.hora = slot.hora_inicio;
    btn.textContent  = slot.hora_inicio;
    btn.title        = `${slot.hora_inicio} – ${slot.hora_fin}`;
    btn.className    = [
        'horario-pill',
        'text-xs font-semibold px-2 py-2 rounded-lg border',
        'border-[#374151] bg-[#262626] text-[#9CA3AF]',
        'hover:border-[#25B5DA] hover:text-white hover:bg-[#25B5DA]/10',
        'transition-all duration-150 cursor-pointer'
    ].join(' ');

    btn.addEventListener('click', () => selectHora(slot.hora_inicio, slot.hora_fin, btn));
    return btn;
}

function selectHora(horaInicio, horaFin, btn) {
    // Restablecer todos
    document.querySelectorAll('.horario-pill').forEach(p => {
        p.classList.remove('bg-[#25B5DA]', 'text-black', 'border-[#25B5DA]', 'shadow-lg', 'shadow-[#25B5DA]/30');
        p.classList.add('border-[#374151]', 'bg-[#262626]', 'text-[#9CA3AF]');
    });

    // Seleccionar el activo
    btn.classList.remove('border-[#374151]', 'bg-[#262626]', 'text-[#9CA3AF]');
    btn.classList.add('bg-[#25B5DA]', 'text-black', 'border-[#25B5DA]', 'shadow-lg', 'shadow-[#25B5DA]/30');

    horaSeleccionada  = horaInicio;
    horaHidden.value  = horaInicio;
    resumenHora.textContent = `${horaInicio} – ${horaFin}`;
    checkFormComplete();
}

async function cargarHorarios() {
    const fecha      = fechaHidden.value;
    const empleadoId = empleadoSeleccionado?.id;
    const duracion   = parseInt(servicioSeleccionado?.duracion, 10);

    if (!fecha || !empleadoId || !duracion) return;

    // Resetear hora al cargar nuevos horarios
    horaSeleccionada = null;
    horaHidden.value = '';
    resumenHora.textContent = '-';
    checkFormComplete();

    showHorariosState('loading');

    try {
        const res  = await fetch(`/api-proxy/disponibilidad/empleado/${empleadoId}?fecha=${fecha}&duracion=${duracion}`);
        const data = await res.json();

        if (data.success && data.slots && data.slots.length > 0) {
            horariosGrid.innerHTML = '';
            data.slots.forEach(slot => horariosGrid.appendChild(buildHorarioPill(slot)));
            showHorariosState('grid');
        } else {
            showHorariosState('empty');
        }
    } catch (err) {
        console.error('Error cargando horarios:', err);
        showHorariosState('empty');
    }
}

// ============================================================
// ENVÍO DEL FORMULARIO
// ============================================================
document.getElementById('cita-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const servicioId = document.getElementById('servicio_id').value;
    const empleadoId = document.getElementById('empleado_id').value;
    const fecha      = fechaHidden.value;
    const hora       = horaHidden.value;
    const negocioId  = document.getElementById('negocio_id').value;

    if (!servicioId || !empleadoId || !fecha || !hora) {
        showToast('Por favor completa todos los campos', 'warning');
        return;
    }

    btnSubmit.disabled = true;
    btnSubmit.textContent = 'Agendando...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                      document.querySelector('input[name="_token"]')?.value;

    try {
        const payload = {
            servicio_id: servicioId,
            empleado_id: empleadoId,
            fecha:       fecha,
            hora_inicio: hora,
            negocio_id:  negocioId
        };
        
        if (promocionSeleccionada && promocionSelect.value) {
            payload.id_promocion_cliente = promocionSelect.value;
        }

        const response = await fetch('/api-proxy/citas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        let data = {};
        try { data = await response.json(); }
        catch(e) { data = { message: 'Error procesando respuesta del servidor' }; }

        if (response.ok && data.success !== false) {
            showToast(data.message || 'Cita agendada correctamente', 'success');
            window.location.href = '/mis-citas';
        } else {
            showToast(data.message || 'Error al agendar cita', 'error');
            btnSubmit.disabled = false;
            btnSubmit.textContent = 'Confirmar Cita';
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error de conexión', 'error');
        btnSubmit.disabled = false;
        btnSubmit.textContent = 'Confirmar Cita';
    }
});
</script>
@endsection