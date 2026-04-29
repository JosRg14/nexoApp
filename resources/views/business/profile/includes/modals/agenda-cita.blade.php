{{-- ============================================================
     MODAL: NUEVA CITA RÁPIDA
     ============================================================ --}}
<div id="modal-crear-cita"
     class="fixed inset-0 hidden z-[70] flex items-center justify-center bg-black/80 backdrop-blur-sm px-4 py-6 overflow-y-auto">
    <div class="bg-[#1a1a1a] border border-[#374151] w-full max-w-lg rounded-xl shadow-2xl relative my-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#374151]">
            <h3 class="text-sm font-bold uppercase tracking-widest text-white flex items-center gap-2">
                <i class="fas fa-plus-circle text-[#25B5DA]"></i>
                Nueva Cita
            </h3>
            <button onclick="cerrarModalCrearCita()"
                    class="w-7 h-7 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 space-y-5">

            {{-- ── Sección Cliente ── --}}
            <div class="space-y-3">
                <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] border-b border-[#374151] pb-1">Cliente</p>

                {{-- Radio toggle --}}
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="modo-cliente" value="buscar" id="modo-buscar" checked
                               class="accent-[#25B5DA]"
                               onchange="toggleModoCliente('buscar')">
                        <span class="text-xs text-[#9CA3AF]">Buscar existente</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="modo-cliente" value="rapido" id="modo-rapido"
                               class="accent-[#25B5DA]"
                               onchange="toggleModoCliente('rapido')">
                        <span class="text-xs text-[#9CA3AF]">Nuevo cliente rápido</span>
                    </label>
                </div>

                {{-- Buscar existente --}}
                <div id="bloque-buscar-cliente">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#6B7280] text-xs"></i>
                        <input type="text" id="modal-cita-buscar-cliente"
                               placeholder="Buscar por nombre o teléfono..."
                               oninput="buscarClienteDebounce()"
                               class="w-full bg-[#262626] border border-[#374151] rounded-lg pl-8 pr-4 py-2.5 text-sm text-white placeholder-[#6B7280] focus:outline-none focus:border-[#25B5DA] transition-colors">
                    </div>
                    <div id="modal-cita-buscar-resultados"
                         class="hidden mt-1 bg-[#262626] border border-[#374151] rounded-lg overflow-hidden max-h-40 overflow-y-auto shadow-xl">
                    </div>
                    <p id="modal-cita-cliente-seleccionado-label"
                       class="hidden mt-1.5 text-xs text-[#25B5DA] flex items-center gap-1.5">
                        <i class="fas fa-check-circle"></i>
                        <span id="modal-cita-cliente-nombre"></span>
                    </p>
                </div>

                {{-- Nuevo cliente rápido --}}
                <div id="bloque-nuevo-cliente" class="hidden space-y-2">
                    <input type="text" id="modal-cita-nuevo-nombre"
                           placeholder="Nombre completo *"
                           class="w-full bg-[#262626] border border-[#374151] rounded-lg px-4 py-2.5 text-sm text-white placeholder-[#6B7280] focus:outline-none focus:border-[#25B5DA] transition-colors">
                    <input type="tel" id="modal-cita-nuevo-telefono"
                           placeholder="Teléfono (opcional)"
                           class="w-full bg-[#262626] border border-[#374151] rounded-lg px-4 py-2.5 text-sm text-white placeholder-[#6B7280] focus:outline-none focus:border-[#25B5DA] transition-colors">
                </div>
            </div>

            {{-- ── Servicio y Empleado ── --}}
            <div class="space-y-3">
                <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] border-b border-[#374151] pb-1">Servicio & Empleado</p>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[10px] text-[#9CA3AF] mb-1 block">Servicio</label>
                        <select id="modal-cita-servicio"
                                onchange="onServicioChangeCita()"
                                class="w-full bg-[#262626] border border-[#374151] rounded-lg px-3 py-2.5 text-sm text-white focus:outline-none focus:border-[#25B5DA] transition-colors appearance-none">
                            <option value="">Selecciona...</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] text-[#9CA3AF] mb-1 block">Empleado</label>
                        <select id="modal-cita-empleado"
                                class="w-full bg-[#262626] border border-[#374151] rounded-lg px-3 py-2.5 text-sm text-white focus:outline-none focus:border-[#25B5DA] transition-colors appearance-none">
                            <option value="">Selecciona...</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- ── Fecha, Hora y Precio ── --}}
            <div class="space-y-3">
                <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] border-b border-[#374151] pb-1">Fecha & Hora</p>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="text-[10px] text-[#9CA3AF] mb-1 block">Fecha</label>
                        <input type="date" id="modal-cita-fecha"
                               class="w-full bg-[#262626] border border-[#374151] rounded-lg px-3 py-2.5 text-sm text-white focus:outline-none focus:border-[#25B5DA] transition-colors [color-scheme:dark]">
                    </div>
                    <div>
                        <label class="text-[10px] text-[#9CA3AF] mb-1 block">Hora</label>
                        <input type="time" id="modal-cita-hora"
                               class="w-full bg-[#262626] border border-[#374151] rounded-lg px-3 py-2.5 text-sm text-white focus:outline-none focus:border-[#25B5DA] transition-colors [color-scheme:dark]">
                    </div>
                    <div>
                        <label class="text-[10px] text-[#9CA3AF] mb-1 block">Precio ($)</label>
                        <input type="number" id="modal-cita-precio" min="0" step="0.01"
                               placeholder="0.00"
                               class="w-full bg-[#262626] border border-[#374151] rounded-lg px-3 py-2.5 text-sm text-white placeholder-[#6B7280] focus:outline-none focus:border-[#25B5DA] transition-colors">
                    </div>
                </div>
            </div>

            {{-- Error --}}
            <p id="modal-cita-error" class="hidden text-xs text-red-400 bg-red-500/10 border border-red-500/20 rounded-lg px-3 py-2"></p>

        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-[#374151]">
            <button onclick="cerrarModalCrearCita()"
                    class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-[#9CA3AF] hover:text-white border border-[#374151] hover:border-white rounded-lg transition-all">
                Cancelar
            </button>
            <button onclick="crearCitaRapida()"
                    id="btn-crear-cita"
                    class="px-6 py-2 text-xs font-bold uppercase tracking-widest bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black rounded-lg hover:from-[#1c8fb0] hover:to-[#25B5DA] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-check mr-1"></i> Crear Cita
            </button>
        </div>
    </div>
</div>

<script>
// ─── Estado del modal crear ──────────────────────────────────
let modalCitaClienteId      = null;
let modalCitaClienteRapidoId= null;
let _buscarTimeout          = null;

function abrirModalCrearCita() {
    // Pre-fill fecha con la seleccionada en agenda
    const fi = document.getElementById('modal-cita-fecha');
    if (fi && agendaFechaActual) fi.value = agendaFechaActual;

    resetModalCrearCita();
    document.getElementById('modal-crear-cita').classList.remove('hidden');
}

function cerrarModalCrearCita() {
    document.getElementById('modal-crear-cita').classList.add('hidden');
}

function resetModalCrearCita() {
    modalCitaClienteId       = null;
    modalCitaClienteRapidoId = null;
    document.getElementById('modal-cita-buscar-cliente').value = '';
    document.getElementById('modal-cita-buscar-resultados').innerHTML = '';
    document.getElementById('modal-cita-buscar-resultados').classList.add('hidden');
    document.getElementById('modal-cita-cliente-seleccionado-label').classList.add('hidden');
    document.getElementById('modal-cita-nuevo-nombre').value  = '';
    document.getElementById('modal-cita-nuevo-telefono').value= '';
    document.getElementById('modal-cita-hora').value  = '';
    document.getElementById('modal-cita-precio').value= '';
    document.getElementById('modal-cita-error').classList.add('hidden');
    toggleModoCliente('buscar');
}

function toggleModoCliente(modo) {
    const bloqueBuscar = document.getElementById('bloque-buscar-cliente');
    const bloqueNuevo  = document.getElementById('bloque-nuevo-cliente');
    modalCitaClienteId = null;
    modalCitaClienteRapidoId = null;
    if (modo === 'buscar') {
        bloqueBuscar.classList.remove('hidden');
        bloqueNuevo.classList.add('hidden');
    } else {
        bloqueBuscar.classList.add('hidden');
        bloqueNuevo.classList.remove('hidden');
    }
}

function onServicioChangeCita() {
    const sel = document.getElementById('modal-cita-servicio');
    const opt = sel.options[sel.selectedIndex];
    if (opt && opt.dataset.precio) {
        document.getElementById('modal-cita-precio').value = parseFloat(opt.dataset.precio).toFixed(2);
    }
}

// Autocomplete cliente
function buscarClienteDebounce() {
    clearTimeout(_buscarTimeout);
    _buscarTimeout = setTimeout(buscarCliente, 350);
}

async function buscarCliente() {
    const q   = document.getElementById('modal-cita-buscar-cliente').value.trim();
    const res = document.getElementById('modal-cita-buscar-resultados');
    if (q.length < 2) { res.classList.add('hidden'); res.innerHTML = ''; return; }

    try {
        const r    = await fetch(`/api-proxy/api/clientes/buscar?q=${encodeURIComponent(q)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await r.json();
        const list = data.data || data.clientes || data || [];
        if (!Array.isArray(list) || list.length === 0) {
            res.innerHTML = '<p class="px-4 py-3 text-xs text-[#9CA3AF]">Sin resultados</p>';
        } else {
            res.innerHTML = list.map(c => {
                const id   = c.id_cliente || c.id;
                const nom  = c.nombre_completo || c.nombre || '—';
                const tel  = c.telefono || '';
                return `<button type="button"
                            onclick="seleccionarClienteBusqueda('${id}','${nom}')"
                            class="w-full text-left px-4 py-2.5 text-sm text-white hover:bg-[#25B5DA]/10 hover:text-[#25B5DA] transition-colors border-b border-[#374151]/40 last:border-0">
                            <span class="font-medium">${nom}</span>
                            ${tel ? `<span class="text-[10px] text-[#6B7280] ml-2">${tel}</span>` : ''}
                        </button>`;
            }).join('');
        }
        res.classList.remove('hidden');
    } catch(err) { console.error(err); }
}

function seleccionarClienteBusqueda(id, nombre) {
    modalCitaClienteId = id;
    document.getElementById('modal-cita-buscar-resultados').classList.add('hidden');
    document.getElementById('modal-cita-buscar-cliente').value = nombre;
    document.getElementById('modal-cita-cliente-nombre').textContent = nombre;
    document.getElementById('modal-cita-cliente-seleccionado-label').classList.remove('hidden');
}

// ─── Crear cita ──────────────────────────────────────────────
async function crearCitaRapida() {
    const btn = document.getElementById('btn-crear-cita');
    const errEl = document.getElementById('modal-cita-error');
    errEl.classList.add('hidden');

    const modoRadio = document.querySelector('input[name="modo-cliente"]:checked')?.value || 'buscar';
    const fecha  = document.getElementById('modal-cita-fecha').value;
    const hora   = document.getElementById('modal-cita-hora').value;
    const empId  = document.getElementById('modal-cita-empleado').value;
    const srvId  = document.getElementById('modal-cita-servicio').value;
    const precio = document.getElementById('modal-cita-precio').value;

    // Validaciones básicas
    if (!fecha)  { mostrarErrorCita('Selecciona una fecha.'); return; }
    if (!hora)   { mostrarErrorCita('Selecciona una hora.'); return; }
    if (!empId)  { mostrarErrorCita('Selecciona un empleado.'); return; }
    if (!srvId)  { mostrarErrorCita('Selecciona un servicio.'); return; }

    const payload = {
        empleado_id: empId,
        servicio_id: srvId,
        fecha,
        hora_inicio: hora,
        precio: precio || 0,
        estado: 'pendiente'
    };

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Creando...';

    try {
        // 1. Gestionar cliente
        if (modoRadio === 'buscar') {
            if (!modalCitaClienteId) { mostrarErrorCita('Busca y selecciona un cliente.'); return; }
            payload.cliente_id = modalCitaClienteId;
        } else {
            const nuevoNombre = document.getElementById('modal-cita-nuevo-nombre').value.trim();
            if (!nuevoNombre) { mostrarErrorCita('Ingresa el nombre del cliente.'); return; }
            // Crear cliente rápido
            const cr = await fetch('/api-proxy/api/clientes/rapido', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    nombre: nuevoNombre,
                    telefono: document.getElementById('modal-cita-nuevo-telefono').value.trim()
                })
            });
            const cd = await cr.json();
            payload.cliente_rapido_id = cd.data?.id || cd.id;
        }

        // 2. Crear la cita
        const res  = await fetch('/api-proxy/api/empleado/servicio-rapido', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });
        const data = await res.json();

        if (res.ok && data.success !== false) {
            cerrarModalCrearCita();
            if (typeof showToast === 'function') showToast('Cita creada correctamente');
            cargarAgenda(agendaFechaActual);
        } else {
            mostrarErrorCita(data.message || 'Error al crear la cita.');
        }
    } catch(err) {
        console.error('[Agenda] Error creando cita:', err);
        mostrarErrorCita('Error de conexión. Intenta de nuevo.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-check mr-1"></i> Crear Cita';
    }
}

function mostrarErrorCita(msg) {
    const el = document.getElementById('modal-cita-error');
    el.textContent = msg;
    el.classList.remove('hidden');
    document.getElementById('btn-crear-cita').disabled = false;
    document.getElementById('btn-crear-cita').innerHTML = '<i class="fas fa-check mr-1"></i> Crear Cita';
}

// Cerrar al click fuera
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modal-crear-cita')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalCrearCita();
    });
});
</script>
