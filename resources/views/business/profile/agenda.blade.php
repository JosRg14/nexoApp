{{-- ============================================================
     TAB: AGENDA MAESTRA
     ============================================================ --}}
<div id="tab-agenda" class="hidden">

    {{-- Cabecera --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold uppercase tracking-widest text-white flex items-center gap-2">
                <i class="fas fa-calendar-alt text-[#25B5DA]"></i>
                Agenda Maestra
            </h2>
            <p id="agenda-subtitle" class="text-[#9CA3AF] text-xs mt-1 uppercase tracking-widest">Cargando...</p>
        </div>
        <button onclick="abrirModalCrearCita()"
                class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black text-xs font-bold uppercase tracking-widest rounded-lg hover:from-[#1c8fb0] hover:to-[#25B5DA] transition-all shadow-lg shadow-[#25B5DA]/20 shrink-0">
            <i class="fas fa-plus"></i> Nueva Cita
        </button>
    </div>

    {{-- Carrusel de días --}}
    <div class="bg-[#262626] border border-[#374151] rounded-lg p-4 mb-4">
        {{-- Navegación mes/año --}}
        <div class="flex items-center justify-between mb-4">
            <button type="button" onclick="agendaPrevMonth()"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                    title="Mes anterior">
                <i class="fas fa-angle-double-left text-xs"></i>
            </button>
            <button type="button" onclick="agendaPrevWeek()"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                    title="Semana anterior">
                <i class="fas fa-chevron-left text-xs"></i>
            </button>

            <span id="agenda-month-label" class="text-white font-bold text-sm uppercase tracking-widest">—</span>

            <button type="button" onclick="agendaNextWeek()"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                    title="Semana siguiente">
                <i class="fas fa-chevron-right text-xs"></i>
            </button>
            <button type="button" onclick="agendaNextMonth()"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-[#25B5DA] transition-all"
                    title="Mes siguiente">
                <i class="fas fa-angle-double-right text-xs"></i>
            </button>
        </div>

        {{-- Días --}}
        <div id="agenda-days-carousel"
             class="grid grid-cols-7 gap-2 w-full"></div>
    </div>

    {{-- Filtros --}}
    <div class="bg-[#262626] border border-[#374151] rounded-lg p-4 mb-4 flex flex-wrap gap-4 items-center">
        <div class="flex items-center gap-2">
            <label class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Empleado:</label>
            <select id="agenda-filtro-empleado"
                    onchange="aplicarFiltrosAgenda()"
                    class="bg-[#1a1a1a] border border-[#374151] text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-[#25B5DA] transition-colors">
                <option value="">Todos</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <label class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Estado:</label>
            <select id="agenda-filtro-estado"
                    onchange="aplicarFiltrosAgenda()"
                    class="bg-[#1a1a1a] border border-[#374151] text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-[#25B5DA] transition-colors">
                <option value="">Todos</option>
                <option value="pendiente">Pendiente</option>
                <option value="confirmada">Confirmada</option>
                <option value="en_proceso">En Proceso</option>
                <option value="completada">Completada</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>
        <div class="ml-auto flex items-center gap-2">
            <span id="agenda-citas-count" class="text-[10px] text-[#6B7280] uppercase tracking-widest"></span>
            <button onclick="cargarAgenda(agendaFechaActual)"
                    class="w-7 h-7 flex items-center justify-center rounded-full bg-[#1a1a1a] border border-[#374151] text-[#9CA3AF] hover:text-[#25B5DA] hover:border-[#25B5DA] transition-all"
                    title="Actualizar">
                <i class="fas fa-sync-alt text-xs"></i>
            </button>
        </div>
    </div>

    {{-- Tabla de citas --}}
    <div class="bg-[#262626] border border-[#374151] rounded-lg overflow-hidden">
        {{-- Estado: cargando --}}
        <div id="agenda-loading" class="hidden flex flex-col items-center justify-center py-16 text-center">
            <div class="inline-block w-8 h-8 border-2 border-[#25B5DA] border-t-transparent rounded-full animate-spin mb-4"></div>
            <p class="text-[#9CA3AF] text-xs uppercase tracking-widest">Cargando citas...</p>
        </div>

        {{-- Estado: vacío --}}
        <div id="agenda-empty" class="hidden flex flex-col items-center justify-center py-16 text-center">
            <i class="fas fa-calendar-day text-[#374151] text-4xl mb-4 block"></i>
            <p class="text-[#9CA3AF] text-sm">No hay citas para este día</p>
            <button onclick="abrirModalCrearCita()"
                    class="mt-4 px-4 py-2 text-xs font-bold uppercase tracking-widest border border-[#25B5DA] text-[#25B5DA] rounded-lg hover:bg-[#25B5DA]/10 transition-all">
                <i class="fas fa-plus mr-1"></i> Crear primera cita
            </button>
        </div>

        {{-- Tabla --}}
        <div id="agenda-table-wrap" class="hidden overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead>
                    <tr class="bg-[#1a1a1a] border-b border-[#374151]">
                        <th class="text-left px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-[#6B7280] w-24">Hora</th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-[#6B7280]">Cliente</th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-[#6B7280]">Servicio</th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-[#6B7280]">Empleado</th>
                        <th class="text-left px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-[#6B7280] w-32">Estado</th>
                        <th class="text-right px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-[#6B7280] w-24">Precio</th>
                    </tr>
                </thead>
                <tbody id="agenda-tbody"></tbody>
            </table>
        </div>
    </div>

</div>

{{-- ============================================================
     MODALES
     ============================================================ --}}
@include('business.profile.includes.modals.agenda-cita')
@include('business.profile.includes.modals.agenda-detalle')

{{-- ============================================================
     JAVASCRIPT DE LA AGENDA
     ============================================================ --}}
<script>
// ─── Estado global ────────────────────────────────────────────
let agendaFechaActual  = '';
let agendaStartDate    = new Date();
let agendaCitasRaw     = [];   // todas las citas cargadas
let agendaEmpleadosList = [];  // empleados del negocio
let agendaServiciosList = [];  // servicios del negocio

// Helpers de fecha
function agPad(n) { return String(n).padStart(2,'0'); }
function agToYMD(d) { return `${d.getFullYear()}-${agPad(d.getMonth()+1)}-${agPad(d.getDate())}`; }

const AG_MONTHS_ES  = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
const AG_DAYS_ABR   = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];

// ─── Carrusel de días ─────────────────────────────────────────
function renderAgendaCarousel() {
    const carousel = document.getElementById('agenda-days-carousel');
    const label    = document.getElementById('agenda-month-label');
    carousel.innerHTML = '';

    const today = new Date(); today.setHours(0,0,0,0);
    let dominantMonth = null;

    for (let i = 0; i < 7; i++) {
        const d = new Date(agendaStartDate);
        d.setDate(d.getDate() + i);
        const ymd    = agToYMD(d);
        const isPast = d < today;
        const isSel  = ymd === agendaFechaActual;
        if (!dominantMonth) dominantMonth = d.getMonth();

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.dataset.date = ymd;
        btn.className = [
            'flex flex-col items-center justify-center gap-0.5 py-2.5 rounded-xl border transition-all duration-150 w-full',
            isSel  ? 'bg-[#25B5DA] border-[#25B5DA] text-black shadow-lg shadow-[#25B5DA]/30' :
            isPast ? 'bg-transparent border-[#374151] text-[#4B5563] opacity-30 cursor-not-allowed' :
                     'bg-[#1a1a1a] border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-white'
        ].join(' ');

        const span1 = document.createElement('span');
        span1.className = 'text-[9px] uppercase tracking-widest font-semibold';
        span1.textContent = AG_DAYS_ABR[d.getDay()];

        const span2 = document.createElement('span');
        span2.className = 'text-lg font-bold leading-none';
        span2.textContent = d.getDate();

        btn.appendChild(span1); btn.appendChild(span2);

        if (!isPast) {
            btn.addEventListener('click', () => selectAgendaDate(ymd));
        } else {
            btn.disabled = true;
        }
        carousel.appendChild(btn);
    }

    const dm = dominantMonth !== null ? dominantMonth : agendaStartDate.getMonth();
    label.textContent = `${AG_MONTHS_ES[dm]} ${agendaStartDate.getFullYear()}`;
}

function agendaPrevWeek()  { agendaStartDate.setDate(agendaStartDate.getDate()-7);  const t=new Date();t.setHours(0,0,0,0);if(agendaStartDate<t)agendaStartDate=new Date(t); renderAgendaCarousel(); }
function agendaNextWeek()  { agendaStartDate.setDate(agendaStartDate.getDate()+7);  renderAgendaCarousel(); }
function agendaPrevMonth() { agendaStartDate.setMonth(agendaStartDate.getMonth()-1);const t=new Date();t.setHours(0,0,0,0);if(agendaStartDate<t)agendaStartDate=new Date(t); renderAgendaCarousel(); }
function agendaNextMonth() { agendaStartDate.setMonth(agendaStartDate.getMonth()+1);renderAgendaCarousel(); }

function selectAgendaDate(ymd) {
    agendaFechaActual = ymd;
    renderAgendaCarousel();

    const [y,m,d] = ymd.split('-').map(Number);
    const disp = new Date(y,m-1,d).toLocaleDateString('es-CL',{weekday:'long',day:'numeric',month:'long',year:'numeric'});
    document.getElementById('agenda-subtitle').textContent = disp;

    cargarAgenda(ymd);
}

// ─── Carga de citas ───────────────────────────────────────────
function agendaShowState(state) {
    document.getElementById('agenda-loading').classList.toggle('hidden',   state !== 'loading');
    document.getElementById('agenda-empty').classList.toggle('hidden',     state !== 'empty');
    document.getElementById('agenda-table-wrap').classList.toggle('hidden',state !== 'table');
}

async function cargarAgenda(fecha) {
    agendaShowState('loading');
    try {
        const timestamp = new Date().getTime();
        const res  = await fetch(`/api-proxy/api/citas?fecha=${fecha}&_t=${timestamp}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        agendaCitasRaw = (data.data || data.citas || data || []);
        if (!Array.isArray(agendaCitasRaw)) agendaCitasRaw = [];
        aplicarFiltrosAgenda();
    } catch(err) {
        console.error('[Agenda] Error cargando citas:', err);
        agendaShowState('empty');
    }
}

function aplicarFiltrosAgenda() {
    const filtroEmp    = document.getElementById('agenda-filtro-empleado')?.value  || '';
    const filtroEst    = document.getElementById('agenda-filtro-estado')?.value    || '';

    let citas = agendaCitasRaw.slice();

    if (filtroEmp) citas = citas.filter(c => {
        const eid = c.empleado_id || c.empleado?.id_empleado || c.empleado?.id;
        return String(eid) === filtroEmp;
    });
    if (filtroEst) citas = citas.filter(c => c.estado === filtroEst);

    // Ordenar por hora_inicio
    citas.sort((a,b) => (a.hora_inicio||'').localeCompare(b.hora_inicio||''));

    renderizarTabla(citas);
}

// ─── Helper: formateo de fecha ─────────────────────────────
function formatearFecha(fecha) {
    if (!fecha) return 'Sin fecha';
    if (fecha.includes('T')) {
        fecha = fecha.split('T')[0];
    }
    const partes = fecha.split('-');
    if (partes.length === 3) {
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }
    return fecha;
}

// ─── Helper: nombre legible del cliente ──────────────────────
function getNombreCliente(cita) {
    if (cita.cliente_rapido?.nombre) {
        return cita.cliente_rapido.nombre;
    }
    if (cita.cliente?.nombre) {
        return `${cita.cliente.nombre} ${cita.cliente.app_paterno || ''}`.trim();
    }
    return 'Sin cliente';
}

function getNombreEmpleado(cita) {
    if (!cita.empleado) return cita.nombre_empleado || '—';
    const e = cita.empleado;
    if (e.nombre_completo) return e.nombre_completo;
    const partes = [e.nombre, e.app_paterno].filter(Boolean);
    return partes.length ? partes.join(' ') : '—';
}

function renderizarTabla(citas) {
    const tbody  = document.getElementById('agenda-tbody');
    const countEl = document.getElementById('agenda-citas-count');
    tbody.innerHTML = '';

    if (!citas || citas.length === 0) {
        agendaShowState('empty');
        if(countEl) countEl.textContent = '';
        return;
    }

    agendaShowState('table');
    if(countEl) countEl.textContent = `${citas.length} cita${citas.length>1?'s':''}`;

    citas.forEach((cita, i) => {
        console.log('Cita recibida:', cita);
        console.log('Cliente rápido:', cita.cliente_rapido);

        const tr = document.createElement('tr');
        tr.className = [
            i % 2 === 0 ? 'bg-[#1a1a1a]' : 'bg-[#262626]',
            'border-b border-[#374151]/40 cursor-pointer',
            'hover:bg-[#25B5DA]/10 hover:border-l-2 hover:border-l-[#25B5DA]',
            'transition-all duration-150 group'
        ].join(' ');

        const cliente  = getNombreCliente(cita);
        const telefono = cita.cliente?.telefono || cita.cliente_rapido?.telefono || '';
        const servicio = cita.servicio?.nombre_servicio || cita.servicio?.nombre || cita.nombre_servicio || '—';
        const empleado = getNombreEmpleado(cita);
        const precioValue = parseFloat(cita.servicio?.precio || cita.precio || 0).toFixed(2);

        const { dot, label } = agendaEstadoBadge(cita.estado);

        tr.innerHTML = `
            <td class="px-4 py-3 text-sm font-bold text-white font-mono">${cita.hora_inicio || '—'}</td>
            <td class="px-4 py-3">
                <p class="text-sm text-white font-medium">${cliente}</p>
                ${telefono ? `<p class="text-[10px] text-[#6B7280]">${telefono}</p>` : ''}
            </td>
            <td class="px-4 py-3 text-sm text-[#9CA3AF]">${servicio}</td>
            <td class="px-4 py-3 text-sm text-[#9CA3AF]">${empleado}</td>
            <td class="px-4 py-3">
                <span class="flex items-center gap-1.5 text-xs">
                    <span class="w-2 h-2 rounded-full ${dot} shrink-0"></span>
                    <span class="text-[#D1D5DB]">${label}</span>
                </span>
            </td>
            <td class="px-4 py-3 text-right text-[#25B5DA] text-sm font-medium">$${precioValue}</td>
        `;

        tr.addEventListener('click', () => abrirModalDetalle(cita));
        tbody.appendChild(tr);
    });
}

function agendaEstadoBadge(estado) {
    const map = {
        pendiente:  { dot: 'bg-yellow-500', label: 'Pendiente' },
        confirmada: { dot: 'bg-green-500',  label: 'Confirmada' },
        en_proceso: { dot: 'bg-green-400',  label: 'En proceso' },
        completada: { dot: 'bg-gray-500',   label: 'Completada' },
        cancelada:  { dot: 'bg-red-500',    label: 'Cancelada' },
    };
    return map[estado] || { dot: 'bg-gray-600', label: estado || 'Desconocido' };
}

// ─── Carga inicial de empleados y servicios ───────────────────
async function cargarEmpleadosFiltro() {
    try {
        const res  = await fetch('/api-proxy/api/mis-empleados', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        agendaEmpleadosList = data.data || data.empleados || data || [];

        const sel  = document.getElementById('agenda-filtro-empleado');
        const selM = document.getElementById('modal-cita-empleado');
        agendaEmpleadosList.forEach(e => {
            const id  = e.id_empleado || e.id;
            const nom = e.nombre || e.nombre_completo || 'Empleado';
            [sel, selM].forEach(s => {
                if (!s) return;
                const opt = document.createElement('option');
                opt.value = id; opt.textContent = nom;
                s.appendChild(opt);
            });
        });
    } catch(err) { console.error('[Agenda] Error cargando empleados:', err); }
}

async function cargarServiciosModal() {
    try {
        const res  = await fetch('/api-proxy/api/mis-servicios', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        agendaServiciosList = data.data || data.servicios || data || [];

        const selM = document.getElementById('modal-cita-servicio');
        if (!selM) return;
        selM.innerHTML = '<option value="">Selecciona un servicio</option>';
        agendaServiciosList.forEach(s => {
            const opt = document.createElement('option');
            opt.value       = s.id_servicio || s.id;
            opt.textContent = s.nombre;
            opt.dataset.precio  = s.precio  || 0;
            opt.dataset.duracion= s.duracion|| 0;
            selM.appendChild(opt);
        });
    } catch(err) { console.error('[Agenda] Error cargando servicios:', err); }
}

// ─── Inicialización al entrar al tab ─────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    // Observar cuando el tab agenda se hace visible
    const tabAgenda = document.getElementById('tab-agenda');
    if (!tabAgenda) return;

    const observer = new MutationObserver(() => {
        if (!tabAgenda.classList.contains('hidden')) {
            inicializarAgenda();
            observer.disconnect(); // solo una vez
        }
    });
    observer.observe(tabAgenda, { attributes: true, attributeFilter: ['class'] });
});

function inicializarAgenda() {
    agendaStartDate = new Date();
    agendaStartDate.setHours(0,0,0,0);
    agendaFechaActual = agToYMD(agendaStartDate);

    renderAgendaCarousel();
    cargarEmpleadosFiltro();
    cargarServiciosModal();
    selectAgendaDate(agendaFechaActual);
}
</script>
