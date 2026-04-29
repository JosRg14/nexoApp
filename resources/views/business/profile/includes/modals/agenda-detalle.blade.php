{{-- ============================================================
     MODAL: DETALLE / ACCIONES DE CITA
     ============================================================ --}}
<div id="modal-detalle-cita"
     class="fixed inset-0 hidden z-[70] flex items-center justify-center bg-black/80 backdrop-blur-sm px-4 py-6 overflow-y-auto">
    <div class="bg-[#1a1a1a] border border-[#374151] w-full max-w-md rounded-xl shadow-2xl relative my-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#374151]">
            <h3 class="text-sm font-bold uppercase tracking-widest text-white flex items-center gap-2">
                <i class="fas fa-clipboard-list text-[#25B5DA]"></i>
                Detalle de Cita
            </h3>
            <button onclick="cerrarModalDetalle()"
                    class="w-7 h-7 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- Badge de estado --}}
        <div class="px-6 pt-4 pb-2">
            <div class="flex items-center gap-2">
                <span id="detalle-estado-dot" class="w-3 h-3 rounded-full shrink-0"></span>
                <span id="detalle-estado-label" class="text-sm font-bold uppercase tracking-widest text-white"></span>
            </div>
        </div>

        {{-- Info grid --}}
        <div class="px-6 py-4">
            <div class="bg-[#262626] border border-[#374151] rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <tbody id="detalle-info-tbody">
                        {{-- Rows rellenados por JS --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Acciones --}}
        <div id="detalle-acciones" class="px-6 pb-5 flex flex-wrap gap-2">
            {{-- Botones dinámicos según estado --}}
        </div>

        {{-- Motivo cancelar (oculto por defecto) --}}
        <div id="detalle-bloque-motivo" class="hidden px-6 pb-4 space-y-2">
            <label class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Motivo de cancelación</label>
            <textarea id="detalle-motivo"
                      rows="2"
                      placeholder="Describe el motivo (opcional)..."
                      class="w-full bg-[#262626] border border-[#374151] rounded-lg px-3 py-2 text-sm text-white placeholder-[#6B7280] focus:outline-none focus:border-[#25B5DA] transition-colors resize-none"></textarea>
            <div class="flex gap-2 justify-end">
                <button onclick="document.getElementById('detalle-bloque-motivo').classList.add('hidden')"
                        class="px-3 py-1.5 text-xs text-[#9CA3AF] hover:text-white border border-[#374151] hover:border-white rounded-lg transition-all">
                    Atrás
                </button>
                <button onclick="confirmarCancelarCita()"
                        class="px-4 py-1.5 text-xs font-bold bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all uppercase tracking-widest">
                    Confirmar cancelación
                </button>
            </div>
        </div>

        {{-- Error --}}
        <p id="detalle-error" class="hidden mx-6 mb-4 text-xs text-red-400 bg-red-500/10 border border-red-500/20 rounded-lg px-3 py-2"></p>

    </div>
</div>

<script>
// ─── Estado del modal detalle ────────────────────────────────
let detalleCitaActual = null;

function abrirModalDetalle(cita) {
    detalleCitaActual = cita;
    document.getElementById('detalle-bloque-motivo').classList.add('hidden');
    document.getElementById('detalle-motivo').value = '';
    document.getElementById('detalle-error').classList.add('hidden');

    // Badge estado
    const { dot, label } = agendaEstadoBadge(cita.estado);
    document.getElementById('detalle-estado-dot').className   = `w-3 h-3 rounded-full shrink-0 ${dot}`;
    document.getElementById('detalle-estado-label').textContent = label;

    // Filas de información
    const cliente  = cita.cliente?.nombre_completo  || cita.cliente_rapido?.nombre || cita.nombre_cliente || '—';
    const telefono = cita.cliente?.telefono         || cita.cliente_rapido?.telefono || cita.telefono || '—';
    const servicio = cita.servicio?.nombre          || cita.nombre_servicio       || '—';
    const duracion = cita.servicio?.duracion        || cita.duracion              || '';
    const empleado = cita.empleado?.nombre          || cita.nombre_empleado       || '—';
    const fecha    = cita.fecha ? (() => {
        const [y,m,d] = cita.fecha.split('-').map(Number);
        return new Date(y,m-1,d).toLocaleDateString('es-CL',{day:'2-digit',month:'2-digit',year:'numeric'});
    })() : '—';
    const horaI    = cita.hora_inicio || '—';
    const horaF    = cita.hora_fin    || '';
    const precio   = cita.precio !== undefined && cita.precio !== null
                        ? '$' + parseFloat(cita.precio).toLocaleString('es-CL')
                        : '—';

    const rows = [
        ['Cliente',   cliente],
        ['Teléfono',  telefono],
        ['Servicio',  duracion ? `${servicio} (${duracion} min)` : servicio],
        ['Empleado',  empleado],
        ['Fecha',     fecha],
        ['Hora',      horaF ? `${horaI} – ${horaF}` : horaI],
        ['Precio',    precio],
    ];

    document.getElementById('detalle-info-tbody').innerHTML = rows.map(([k, v], i) => `
        <tr class="${i%2===0 ? 'bg-[#1a1a1a]' : 'bg-[#262626]'}">
            <td class="px-4 py-2.5 text-[10px] uppercase tracking-widest text-[#6B7280] whitespace-nowrap w-28">${k}</td>
            <td class="px-4 py-2.5 text-sm text-white font-medium">${v}</td>
        </tr>
    `).join('');

    // Botones de acción según estado
    renderDetalleAcciones(cita.estado, cita.id_cita || cita.id);

    document.getElementById('modal-detalle-cita').classList.remove('hidden');
}

function cerrarModalDetalle() {
    document.getElementById('modal-detalle-cita').classList.add('hidden');
    detalleCitaActual = null;
}

function renderDetalleAcciones(estado, id) {
    const container = document.getElementById('detalle-acciones');
    container.innerHTML = '';

    const btnBase = 'flex items-center gap-1.5 px-4 py-2 text-xs font-bold uppercase tracking-widest rounded-lg transition-all';

    if (estado === 'pendiente' || estado === 'confirmada') {
        container.innerHTML = `
            <button onclick="accionCita('iniciar','${id}')"
                    class="${btnBase} bg-[#25B5DA]/10 border border-[#25B5DA] text-[#25B5DA] hover:bg-[#25B5DA] hover:text-black">
                <i class="fas fa-play"></i> Iniciar
            </button>
            <button onclick="abrirCancelarCita()"
                    class="${btnBase} bg-red-500/10 border border-red-500 text-red-400 hover:bg-red-500 hover:text-white">
                <i class="fas fa-times"></i> Cancelar
            </button>
        `;
    } else if (estado === 'en_proceso') {
        container.innerHTML = `
            <button onclick="accionCita('completar','${id}')"
                    class="${btnBase} bg-green-500/10 border border-green-500 text-green-400 hover:bg-green-500 hover:text-white">
                <i class="fas fa-check"></i> Completar
            </button>
            <button onclick="abrirCancelarCita()"
                    class="${btnBase} bg-red-500/10 border border-red-500 text-red-400 hover:bg-red-500 hover:text-white">
                <i class="fas fa-times"></i> Cancelar
            </button>
        `;
    } else {
        // completada / cancelada — solo historial
        container.innerHTML = `
            <p class="text-xs text-[#6B7280] italic">Esta cita no puede ser modificada.</p>
        `;
    }
}

function abrirCancelarCita() {
    document.getElementById('detalle-bloque-motivo').classList.remove('hidden');
}

async function confirmarCancelarCita() {
    const id = detalleCitaActual?.id_cita || detalleCitaActual?.id;
    const motivo = document.getElementById('detalle-motivo').value.trim();
    await accionCita('cancelar', id, { motivo });
}

async function accionCita(accion, id, extra = {}) {
    const errEl = document.getElementById('detalle-error');
    errEl.classList.add('hidden');
    try {
        const res  = await fetch(`/api-proxy/api/citas/${id}/${accion}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(extra)
        });
        const data = await res.json();
        if (res.ok && data.success !== false) {
            cerrarModalDetalle();
            if (typeof showToast === 'function') {
                const msgs = { iniciar: 'Cita iniciada', completar: 'Cita completada', cancelar: 'Cita cancelada' };
                showToast(msgs[accion] || 'Operación exitosa');
            }
            cargarAgenda(agendaFechaActual);
        } else {
            errEl.textContent = data.message || 'Error al procesar la acción.';
            errEl.classList.remove('hidden');
        }
    } catch(err) {
        console.error('[Agenda] Error en acción cita:', err);
        errEl.textContent = 'Error de conexión.';
        errEl.classList.remove('hidden');
    }
}

// Cerrar al click fuera
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modal-detalle-cita')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalDetalle();
    });
});
</script>
