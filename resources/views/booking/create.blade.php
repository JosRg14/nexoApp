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
        <form id="cita-form" class="space-y-8 pb-24">
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

            <!-- Fecha y Hora — Carrusel de días + Timeline -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 space-y-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-[#25B5DA]"></i>
                    Selecciona fecha y hora
                </h3>

                <input type="hidden" id="fecha" name="fecha">
                <input type="hidden" id="hora"  name="hora_inicio">

                <!-- ── CABECERA: mes/año + navegación ── -->
                <div class="flex items-center justify-between gap-2">
                    <!-- Mes anterior (salto de mes) -->
                    <button type="button" id="btn-prev-month"
                            class="w-8 h-8 shrink-0 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                            title="Mes anterior">
                        <i class="fas fa-angle-double-left text-xs"></i>
                    </button>
                    <!-- 7 días atrás -->
                    <button type="button" id="btn-prev-week"
                            class="w-8 h-8 shrink-0 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                            title="Semana anterior">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>

                    <!-- Dropdown mes/año -->
                    <div class="relative flex-1 flex justify-center">
                        <button type="button" id="btn-month-picker"
                                class="flex items-center gap-2 px-4 py-1.5 rounded-lg bg-[#1a1a1a] border border-[#374151] text-white text-sm font-bold uppercase tracking-widest hover:border-[#25B5DA] transition-all">
                            <span id="carousel-month-label">—</span>
                            <i class="fas fa-chevron-down text-xs text-[#9CA3AF]"></i>
                        </button>

                        <!-- Picker panel -->
                        <div id="month-picker-panel"
                             class="hidden absolute top-10 z-50 bg-[#1a1a1a] border border-[#374151] rounded-xl p-4 w-72 shadow-2xl">
                            <!-- Selector de año -->
                            <div class="flex items-center justify-between mb-4">
                                <button type="button" id="picker-prev-year"
                                        class="w-7 h-7 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <span id="picker-year" class="text-white font-bold text-sm"></span>
                                <button type="button" id="picker-next-year"
                                        class="w-7 h-7 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                            <!-- Grid de meses -->
                            <div id="picker-months-grid" class="grid grid-cols-4 gap-2"></div>
                        </div>
                    </div>

                    <!-- 7 días adelante -->
                    <button type="button" id="btn-next-week"
                            class="w-8 h-8 shrink-0 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                            title="Semana siguiente">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                    <!-- Mes siguiente (salto de mes) -->
                    <button type="button" id="btn-next-month"
                            class="w-8 h-8 shrink-0 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                            title="Mes siguiente">
                        <i class="fas fa-angle-double-right text-xs"></i>
                    </button>
                </div>

                <!-- ── CARRUSEL DE DÍAS ── -->
                <div id="days-carousel" class="flex gap-2 overflow-x-auto pb-1" style="scrollbar-width:none;-ms-overflow-style:none;">
                    <!-- generado por JS -->
                </div>

                <!-- ── SELECTOR DE HORARIOS ── -->
                <div>
                    <p class="text-xs text-[#9CA3AF] uppercase tracking-widest mb-3">Horario disponible</p>
                    <div id="horarios-container" class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 min-h-[180px] max-h-[320px] overflow-y-auto">
                        <div id="horarios-placeholder" class="flex flex-col items-center justify-center py-8 text-center">
                            <i class="far fa-clock text-[#374151] text-3xl mb-3 block"></i>
                            <p class="text-[#9CA3AF] text-xs">Selecciona servicio, empleado y fecha para ver los horarios</p>
                        </div>
                        <div id="horarios-loading" class="hidden flex flex-col items-center justify-center py-8 text-center">
                            <div class="inline-block w-6 h-6 border-2 border-[#25B5DA] border-t-transparent rounded-full animate-spin mb-3"></div>
                            <p class="text-[#9CA3AF] text-xs">Cargando horarios...</p>
                        </div>
                        <div id="horarios-empty" class="hidden flex flex-col items-center justify-center py-8 text-center">
                            <i class="fas fa-calendar-times text-[#374151] text-3xl mb-3 block"></i>
                            <p class="text-[#9CA3AF] text-xs">No hay horarios disponibles para este día</p>
                        </div>
                        <div id="horarios-grid" class="hidden space-y-5">
                            <div id="franja-manana" class="hidden">
                                <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 flex items-center gap-1">
                                    <span>&#127749;</span> Mañana <span class="text-[#6B7280]">(antes de 12:00)</span>
                                </p>
                                <div id="slots-manana" class="flex flex-wrap gap-2"></div>
                            </div>
                            <div id="franja-tarde" class="hidden">
                                <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 flex items-center gap-1">
                                    <span>&#9728;&#65039;</span> Tarde <span class="text-[#6B7280]">(12:00 – 17:00)</span>
                                </p>
                                <div id="slots-tarde" class="flex flex-wrap gap-2"></div>
                            </div>
                            <div id="franja-noche" class="hidden">
                                <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-2 flex items-center gap-1">
                                    <span>&#127769;</span> Noche <span class="text-[#6B7280]">(después de 17:00)</span>
                                </p>
                                <div id="slots-noche" class="flex flex-wrap gap-2"></div>
                            </div>
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

            <!-- Botón submit oculto — se dispara desde la barra flotante -->
            <button type="submit" id="btn-submit" class="hidden" disabled></button>
        </form>
        @endif
    </div>
</div>

<!-- ── BARRA FLOTANTE DE RESUMEN ── -->
<div id="floating-bar"
     class="hidden fixed bottom-0 left-0 right-0 z-40 bg-[#0f0f0f]/95 backdrop-blur border-t border-[#374151] px-4 py-3 shadow-2xl">
    <div class="max-w-4xl mx-auto flex items-center justify-between gap-4">
        <div class="flex items-center gap-4 overflow-hidden">
            <div class="shrink-0 w-10 h-10 rounded-full bg-[#25B5DA]/20 text-[#25B5DA] flex items-center justify-center">
                <i class="fas fa-calendar-check text-sm"></i>
            </div>
            <div class="min-w-0">
                <p id="fb-resumen" class="text-white text-sm font-semibold truncate">—</p>
                <p id="fb-precio" class="text-[#25B5DA] text-xs font-bold">$0</p>
            </div>
        </div>
        <button type="button" id="btn-floating-confirm"
                class="shrink-0 px-6 py-2.5 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-bold text-sm uppercase tracking-widest rounded-lg hover:from-[#1c8fb0] hover:to-[#25B5DA] transition-all">
            Confirmar
        </button>
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
        const usuario = data.data?.usuario || data.usuario || data;
        clienteId = usuario?.cliente?.id_cliente 
                 || usuario?.id_cliente 
                 || usuario?.cliente_id 
                 || null;
        
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
        empleadoSeleccionado = { id: this.dataset.id, nombre: this.dataset.nombre };
        document.getElementById('empleado_id').value = empleadoSeleccionado.id;
        resumenEmpleado.textContent = empleadoSeleccionado.nombre;
        if (servicioSeleccionado && fechaHidden.value) cargarHorarios();
        checkFormComplete();
    });
});

// ============================================================
// CARRUSEL DE DÍAS — CONSTANTES Y ESTADO
// ============================================================
const MONTHS_ES  = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
const MONTHS_ABR = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
const DAYS_ABR   = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
const MAX_MONTHS_AHEAD = 6;

const todayDate = new Date();
todayDate.setHours(0,0,0,0);

let carouselStartDate = new Date(todayDate); // primera fecha visible en el carrusel
let pickerYear = todayDate.getFullYear();

function pad2(n) { return String(n).padStart(2,'0'); }
function toYMD(d) { return `${d.getFullYear()}-${pad2(d.getMonth()+1)}-${pad2(d.getDate())}`; }
function ymdToDate(ymd) { const [y,m,d] = ymd.split('-').map(Number); return new Date(y,m-1,d); }

const daysCarousel    = document.getElementById('days-carousel');
const monthLabel      = document.getElementById('carousel-month-label');
const pickerPanel     = document.getElementById('month-picker-panel');
const pickerYearEl    = document.getElementById('picker-year');
const pickerMonthsGrid= document.getElementById('picker-months-grid');

// ── Renderizar carrusel ──
function renderCarousel() {
    daysCarousel.innerHTML = '';
    const selectedYMD = fechaHidden.value;
    const maxDate = new Date(todayDate);
    maxDate.setMonth(maxDate.getMonth() + MAX_MONTHS_AHEAD);

    // Mostrar 14 días desde carouselStartDate
    let dominantMonth = null;
    for (let i = 0; i < 14; i++) {
        const d = new Date(carouselStartDate);
        d.setDate(d.getDate() + i);
        if (d > maxDate) break;

        const ymd     = toYMD(d);
        const isPast  = d < todayDate;
        const isToday = ymd === toYMD(todayDate);
        const isSel   = ymd === selectedYMD;
        if (!dominantMonth) dominantMonth = d.getMonth();

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.dataset.date = ymd;
        btn.className = [
            'shrink-0 w-14 flex flex-col items-center justify-center gap-0.5 py-2.5 rounded-xl border transition-all duration-150',
            isSel  ? 'bg-[#25B5DA] border-[#25B5DA] text-black shadow-lg shadow-[#25B5DA]/30' :
            isPast ? 'bg-transparent border-[#374151] text-[#4B5563] opacity-30 cursor-not-allowed' :
                     'bg-[#1a1a1a] border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-white'
        ].join(' ');

        const dayName = document.createElement('span');
        dayName.className = 'text-[9px] uppercase tracking-widest font-semibold';
        dayName.textContent = DAYS_ABR[d.getDay()];

        const dayNum = document.createElement('span');
        dayNum.className = 'text-lg font-bold leading-none';
        dayNum.textContent = d.getDate();

        // Badge "Hoy"
        if (isToday && !isSel) {
            const badge = document.createElement('span');
            badge.className = 'text-[8px] font-bold uppercase text-[#25B5DA]';
            badge.textContent = 'Hoy';
            btn.appendChild(dayName); btn.appendChild(dayNum); btn.appendChild(badge);
        } else {
            btn.appendChild(dayName); btn.appendChild(dayNum);
        }

        if (!isPast) {
            btn.addEventListener('click', () => selectDate(ymd));
        } else {
            btn.disabled = true;
        }
        daysCarousel.appendChild(btn);
    }

    // Actualizar label mes
    const dm = dominantMonth !== null ? dominantMonth : carouselStartDate.getMonth();
    const dy = carouselStartDate.getFullYear();
    monthLabel.textContent = `${MONTHS_ES[dm]} ${dy}`;
}

// ── Navegación del carrusel ──
document.getElementById('btn-prev-week').addEventListener('click', () => {
    const minStart = new Date(todayDate);
    carouselStartDate.setDate(carouselStartDate.getDate() - 7);
    if (carouselStartDate < minStart) carouselStartDate = new Date(minStart);
    renderCarousel();
});
document.getElementById('btn-next-week').addEventListener('click', () => {
    carouselStartDate.setDate(carouselStartDate.getDate() + 7);
    renderCarousel();
});
document.getElementById('btn-prev-month').addEventListener('click', () => {
    carouselStartDate.setMonth(carouselStartDate.getMonth() - 1);
    if (carouselStartDate < todayDate) carouselStartDate = new Date(todayDate);
    renderCarousel();
});
document.getElementById('btn-next-month').addEventListener('click', () => {
    carouselStartDate.setMonth(carouselStartDate.getMonth() + 1);
    renderCarousel();
});

// ── Picker de mes/año ──
function renderPicker() {
    pickerYearEl.textContent = pickerYear;
    pickerMonthsGrid.innerHTML = '';
    const now = new Date();
    const maxDate = new Date(todayDate);
    maxDate.setMonth(maxDate.getMonth() + MAX_MONTHS_AHEAD);

    for (let m = 0; m < 12; m++) {
        const btn = document.createElement('button');
        btn.type = 'button';
        const mDate = new Date(pickerYear, m, 1);
        const isPast = mDate < new Date(now.getFullYear(), now.getMonth(), 1);
        const isFuture = mDate > new Date(maxDate.getFullYear(), maxDate.getMonth(), 1);
        const isCurrent = pickerYear === now.getFullYear() && m === now.getMonth();

        btn.className = [
            'py-2 rounded-lg text-xs font-bold transition-all',
            isCurrent ? 'bg-[#25B5DA] text-black' :
            (isPast || isFuture) ? 'text-[#4B5563] cursor-not-allowed opacity-40' :
            'bg-[#262626] border border-[#374151] text-white hover:border-[#25B5DA]'
        ].join(' ');
        btn.textContent = MONTHS_ABR[m];
        btn.disabled = isPast || isFuture;
        btn.addEventListener('click', () => {
            carouselStartDate = new Date(pickerYear, m, 1);
            if (carouselStartDate < todayDate) carouselStartDate = new Date(todayDate);
            renderCarousel();
            pickerPanel.classList.add('hidden');
        });
        pickerMonthsGrid.appendChild(btn);
    }
}

document.getElementById('btn-month-picker').addEventListener('click', (e) => {
    e.stopPropagation();
    pickerYear = carouselStartDate.getFullYear();
    renderPicker();
    pickerPanel.classList.toggle('hidden');
});
document.getElementById('picker-prev-year').addEventListener('click', () => { pickerYear--; renderPicker(); });
document.getElementById('picker-next-year').addEventListener('click', () => { pickerYear++; renderPicker(); });
document.addEventListener('click', (e) => {
    if (!pickerPanel.contains(e.target) && e.target.id !== 'btn-month-picker') {
        pickerPanel.classList.add('hidden');
    }
});

// ── Selección de fecha ──
function selectDate(ymd) {
    fechaHidden.value = ymd;
    const [y, m, d] = ymd.split('-').map(Number);
    const displayDate = new Date(y, m-1, d);
    resumenFecha.textContent = displayDate.toLocaleDateString('es-CL', { day:'numeric', month:'long', year:'numeric' });
    horaSeleccionada = null;
    horaHidden.value = '';
    resumenHora.textContent = '-';
    actualizarBarraFlotante();
    renderCarousel();
    if (servicioSeleccionado && empleadoSeleccionado) cargarHorarios();
    checkFormComplete();
}

// Renderizado inicial
renderCarousel();

// ── Barra flotante ──
const floatingBar = document.getElementById('floating-bar');
const fbResumen   = document.getElementById('fb-resumen');
const fbPrecio    = document.getElementById('fb-precio');

function actualizarBarraFlotante() {
    if (servicioSeleccionado && empleadoSeleccionado && fechaHidden.value && horaHidden.value) {
        const [y,m,d] = fechaHidden.value.split('-').map(Number);
        const fechaDisp = new Date(y,m-1,d).toLocaleDateString('es-CL',{day:'numeric',month:'short'});
        fbResumen.textContent = `${servicioSeleccionado.nombre} • ${empleadoSeleccionado.nombre} • ${fechaDisp} • ${horaHidden.value}`;
        const subtotal = parseFloat(servicioSeleccionado.precio);
        let desc = 0;
        if (promocionSeleccionada) {
            if (promocionSeleccionada.beneficio_tipo === 'descuento') desc = subtotal * parseFloat(promocionSeleccionada.beneficio_valor) / 100;
            else if (promocionSeleccionada.beneficio_tipo === 'servicio_gratis') desc = subtotal;
        }
        fbPrecio.textContent = '$' + Math.max(0, subtotal - desc).toLocaleString('es-CL');
        floatingBar.classList.remove('hidden');
    } else {
        floatingBar.classList.add('hidden');
    }
}

document.getElementById('btn-floating-confirm').addEventListener('click', () => {
    document.getElementById('btn-submit').click();
});

// ============================================================
// HORARIOS TIPO PILLS — VARIABLES DOM Y HELPERS
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

function selectHora(horaInicio, horaFin, btn) {
    // Restablecer todos los pills activos
    document.querySelectorAll('.horario-pill').forEach(p => {
        p.classList.remove('bg-[#25B5DA]', 'text-black', 'border-[#25B5DA]', 'shadow-lg', 'shadow-[#25B5DA]/30');
        p.classList.add('border-[#374151]', 'bg-[#1a1a1a]', 'text-white');
    });
    // Marcar el seleccionado
    btn.classList.remove('border-[#374151]', 'bg-[#1a1a1a]', 'text-white');
    btn.classList.add('bg-[#25B5DA]', 'text-black', 'border-[#25B5DA]', 'shadow-lg', 'shadow-[#25B5DA]/30');
    horaSeleccionada        = horaInicio;
    horaHidden.value        = horaInicio;
    resumenHora.textContent = `${horaInicio} – ${horaFin}`;
    actualizarBarraFlotante();
    checkFormComplete();
}

function filtrarSlotsPasados(slots) {
    const ahora = new Date();
    const fechaSeleccionada = fechaHidden.value; // YYYY-MM-DD
    const hoy = new Date();
    const hoyStr = `${hoy.getFullYear()}-${pad2(hoy.getMonth()+1)}-${pad2(hoy.getDate())}`;

    if (fechaSeleccionada === hoyStr) {
        const horaActual = ahora.getHours() * 60 + ahora.getMinutes(); // minutos desde medianoche

        return slots.filter(slot => {
            const [h, m] = slot.hora_inicio.split(':').map(Number);
            const slotMinutos = h * 60 + m;
            return slotMinutos > horaActual; // solo mostrar slots futuros
        });
    }

    return slots;
}

function getFranjaHoraria(horaStr) {
    const [h] = horaStr.split(':').map(Number);
    if (h < 12) return 'manana';
    if (h < 17) return 'tarde';
    return 'noche';
}

function buildHorarioPill(slot, available = true) {
    const btn = document.createElement('button');
    btn.type         = 'button';
    btn.dataset.hora = slot.hora_inicio;
    btn.textContent  = slot.hora_inicio;
    btn.title        = `${slot.hora_inicio} – ${slot.hora_fin}`;

    if (available) {
        btn.className = [
            'horario-pill',
            'text-xs font-semibold px-4 py-2 rounded-full border',
            'border-[#374151] bg-[#1a1a1a] text-white',
            'hover:border-[#25B5DA] hover:bg-[#25B5DA] hover:text-black',
            'transition-all duration-150 cursor-pointer'
        ].join(' ');
        btn.addEventListener('click', () => selectHora(slot.hora_inicio, slot.hora_fin, btn));
    } else {
        btn.className = [
            'horario-pill-disabled',
            'text-xs font-semibold px-4 py-2 rounded-full border',
            'border-transparent bg-[#262626] text-[#6B7280]',
            'opacity-30 cursor-not-allowed'
        ].join(' ');
        btn.disabled = true;
    }

    return btn;
}

function renderizarSlots(slots) {
    // Limpiar franjas
    const contenedores = { manana: document.getElementById('slots-manana'), tarde: document.getElementById('slots-tarde'), noche: document.getElementById('slots-noche') };
    const franjas      = { manana: document.getElementById('franja-manana'), tarde: document.getElementById('franja-tarde'), noche: document.getElementById('franja-noche') };
    Object.values(contenedores).forEach(c => c.innerHTML = '');
    Object.values(franjas).forEach(f => f.classList.add('hidden'));

    if (!slots || slots.length === 0) {
        showHorariosState('empty');
        return;
    }

    slots.forEach(slot => {
        const franja = getFranjaHoraria(slot.hora_inicio);
        const pill   = buildHorarioPill(slot, true);
        contenedores[franja].appendChild(pill);
        franjas[franja].classList.remove('hidden');
    });

    showHorariosState('grid');
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
            const slotsFiltrados = filtrarSlotsPasados(data.slots);
            renderizarSlots(slotsFiltrados);
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