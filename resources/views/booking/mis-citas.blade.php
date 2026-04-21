@extends('layouts.app')

@section('title', 'Mis Citas')

@section('content')

<div class="bg-[#1a1a1a] min-h-screen pt-12 py-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="mb-4">
            <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Mis Citas</h1>
            <p class="text-[#9CA3AF] text-sm mt-2">Historial de tus citas agendadas y promociones</p>
        </div>
        
        <!-- Tabs -->
        <div class="flex border-b border-[#374151] mb-6">
            <button class="tab-btn active px-6 py-3 text-xs uppercase tracking-widest text-[#25B5DA] border-b-2 border-[#25B5DA]"
                    data-tab="citas">
                <i class="fas fa-calendar-alt mr-2"></i>Mis Citas
            </button>
            <button class="tab-btn px-6 py-3 text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white"
                    data-tab="promociones">
                <i class="fas fa-ticket-alt mr-2"></i>Mis Promociones
            </button>
        </div>

        <div id="tab-citas">
        
        @if(count($citas) > 0)
        @php
            $pendientesCount = collect($citas)->whereIn('estado', ['pendiente', 'confirmada', 'en_proceso'])->count();
            $completadasCount = collect($citas)->whereIn('estado', ['completada'])->count();
            $canceladasCount = collect($citas)->whereIn('estado', ['cancelada', 'no_asistio'])->count();
        @endphp

        <!-- Filtros -->
        <div class="flex flex-wrap gap-2 mb-8">
            <button class="filter-btn active px-4 py-2 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest transition-all bg-[#25B5DA] text-black" data-filter="todas">
                Todas ({{ count($citas) }})
            </button>
            <button class="filter-btn px-4 py-2 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest transition-all bg-[#262626] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-white" data-filter="pendiente">
                Pendientes ({{ $pendientesCount }})
            </button>
            <button class="filter-btn px-4 py-2 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest transition-all bg-[#262626] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-white" data-filter="completada">
                Completadas ({{ $completadasCount }})
            </button>
            <button class="filter-btn px-4 py-2 rounded-full text-[10px] md:text-xs font-bold uppercase tracking-widest transition-all bg-[#262626] border border-[#374151] text-[#9CA3AF] hover:border-[#25B5DA] hover:text-white" data-filter="cancelada">
                Canceladas ({{ $canceladasCount }})
            </button>
        </div>

        <div class="citas-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($citas as $cita)
            @php
                $categoria_estado = 'pendiente';
                if(in_array($cita['estado'], ['completada'])) $categoria_estado = 'completada';
                if(in_array($cita['estado'], ['cancelada', 'no_asistio'])) $categoria_estado = 'cancelada';
                if(in_array($cita['estado'], ['pendiente', 'confirmada', 'en_proceso'])) $categoria_estado = 'pendiente';
            @endphp
            <div class="cita-card bg-[#262626] border border-[#374151] rounded-lg p-6 hover:border-[#25B5DA] transition-all" data-estado="{{ $categoria_estado }}">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-white text-lg">{{ $cita['servicio']['nombre'] ?? 'Servicio' }}</h3>
                        <p class="text-sm text-[#9CA3AF] mt-1">{{ $cita['negocio']['nombre'] ?? 'Negocio' }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $cita['estado'] === 'pendiente' ? 'bg-[#25B5DA]/20 text-[#25B5DA]' : '' }}
                        {{ $cita['estado'] === 'confirmada' ? 'bg-blue-500/20 text-blue-500' : '' }}
                        {{ $cita['estado'] === 'en_proceso' ? 'bg-orange-500/20 text-orange-500' : '' }}
                        {{ $cita['estado'] === 'completada' ? 'bg-emerald-500/20 text-emerald-500' : '' }}
                        {{ $cita['estado'] === 'cancelada' ? 'bg-gray-500/20 text-gray-400' : '' }}
                        {{ $cita['estado'] === 'no_asistio' ? 'bg-red-500/20 text-red-500' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $cita['estado'])) }}
                    </span>
                </div>
                
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-[#9CA3AF]">
                        <i class="fas fa-calendar-alt w-4"></i>
                        <span>{{ \Carbon\Carbon::parse($cita['fecha'])->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#9CA3AF]">
                        <i class="fas fa-clock w-4"></i>
                        <span>{{ substr($cita['hora_inicio'], 0, 5) }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#9CA3AF]">
                        <i class="fas fa-user w-4"></i>
                        <span>{{ $cita['empleado']['nombre'] ?? 'Empleado' }}</span>
                    </div>
                    
                    @if(isset($cita['promocion_aplicada']))
                    <div class="mt-4 p-3 bg-[#25B5DA]/5 border border-[#25B5DA]/20 rounded-xl relative overflow-hidden group hover:bg-[#25B5DA]/10 transition-colors">
                        <!-- Badge de Promoción -->
                        <div class="absolute -right-8 -top-8 w-16 h-16 bg-[#25B5DA]/10 rotate-45 group-hover:bg-[#25B5DA]/20 transition-all"></div>
                        
                        <div class="flex justify-between items-start mb-2 relative z-10">
                            <div>
                                <span class="bg-[#25B5DA] text-black text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-tighter">
                                    Promoción Aplicada
                                </span>
                                <p class="text-xs text-[#25B5DA] mt-1 font-medium italic">
                                    <i class="fas fa-magic mr-1"></i>{{ $cita['promocion_aplicada']['descripcion'] ?? 'Descuento especial' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-[#9CA3AF] line-through">${{ number_format($cita['precio_original'] ?? 0, 2) }}</p>
                                <p class="text-sm font-bold text-white">${{ number_format($cita['precio_final'] ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-[#25B5DA]/10 text-[10px] relative z-10">
                            <span class="text-[#9CA3AF]">Ahorraste</span>
                            <span class="text-[#25B5DA] font-bold">-${{ number_format($cita['promocion_aplicada']['descuento_aplicado'] ?? 0, 2) }}</span>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-between mt-4 p-3 bg-[#374151]/10 border border-[#374151]/20 rounded-xl">
                        <span class="text-xs text-[#9CA3AF]">Precio del servicio</span>
                        <span class="text-sm font-bold text-[#25B5DA]">${{ number_format($cita['servicio']['precio'] ?? 0, 2) }}</span>
                    </div>
                    @endif
                </div>
                
                @if(!in_array($cita['estado'], ['completada', 'cancelada', 'no_asistio']))
                <div class="mt-4 pt-4 border-t border-[#374151]">
                    <button onclick="cancelarCita({{ $cita['id'] ?? $cita['id_cita'] }}, {{ $cita['negocio_id'] ?? ($cita['negocio']['id'] ?? 'null') }})" 
                            class="w-full py-2 text-red-400 border border-red-500/30 rounded-lg hover:bg-red-500/10 transition-all text-sm">
                        Cancelar cita
                    </button>
                </div>
                @elseif($cita['estado'] === 'completada')
                <div class="mt-4 pt-4 border-t border-[#374151]">
                    @if(isset($cita['resena']))
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $cita['resena']['calificacion'] ? 'text-[#25B5DA]' : 'text-[#374151]' }} text-xs"></i>
                                @endfor
                            </div>
                        </div>
                        @if($cita['resena']['comentario'])
                        <p class="text-sm text-[#9CA3AF] italic mb-3">"{{ $cita['resena']['comentario'] }}"</p>
                        @endif
                        <div class="flex gap-2 mt-3">
                            <button onclick="abrirModalEditarResena({{ $cita['id'] ?? $cita['id_cita'] }}, {{ $cita['resena']['id'] }}, {{ $cita['resena']['calificacion'] }}, '{{ addslashes($cita['resena']['comentario'] ?? '') }}')" class="flex-1 py-1.5 text-[#25B5DA] border border-[#25B5DA]/30 rounded-lg hover:bg-[#25B5DA]/10 transition-all text-xs flex justify-center items-center gap-1">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button onclick="eliminarResena({{ $cita['resena']['id'] }})" class="flex-1 py-1.5 text-red-400 border border-red-500/30 rounded-lg hover:bg-red-500/10 transition-all text-xs flex justify-center items-center gap-1">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    @else
                        <button onclick="abrirModalResena({{ $cita['id'] ?? $cita['id_cita'] }})" 
                                class="w-full py-2 text-[#25B5DA] border border-[#25B5DA]/30 rounded-lg hover:bg-[#25B5DA]/10 transition-all text-sm flex justify-center items-center gap-2">
                            <i class="fas fa-star"></i> Calificar cita
                        </button>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
        </div> <!-- Fin tab-citas -->

        <!-- Contenedor Promociones -->
        <div id="tab-promociones" class="hidden">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white"><span id="promos-count">0</span> promociones activas</h2>
            </div>
            
            <div id="promos-loading" class="text-center py-12 hidden">
                <i class="fas fa-spinner fa-spin text-4xl text-[#25B5DA] mb-4 block"></i>
                <p class="text-[#9CA3AF]">Cargando promociones...</p>
            </div>
            
            <div id="promos-empty" class="text-center py-16 hidden">
                <i class="fas fa-ticket-alt text-6xl text-[#374151] mb-4 block"></i>
                <p class="text-[#9CA3AF] text-lg">No tienes promociones registradas</p>
            </div>

            <div id="promos-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                <!-- Se llena con JS -->
            </div>
        </div>

    </div>
</div>

<script>
async function cancelarCita(citaId, negocioId) {
    const motivo = prompt('¿Desea ingresar un motivo de cancelación? (Opcional)');
    if (motivo === null) return; // Se canceló el prompt
    
    let isConfirmed = false;
    if (typeof confirmCustom === 'function') {
        const confirmacion = await confirmCustom('¿Estás seguro de cancelar esta cita?');
        isConfirmed = confirmacion.isConfirmed;
    } else {
        isConfirmed = confirm('¿Estás seguro de cancelar esta cita?');
    }
    
    if (!isConfirmed) return;
    
    showLoader();
    
    try {
        const payload = { motivo: motivo };
        if (negocioId && negocioId !== 'null') {
            payload.negocio_id = negocioId;
        }

        const response = await fetch(`/api-proxy/citas/${citaId}/cancelar`, {
            method: 'PATCH', // <-- Cambiado a PATCH para que coincida con tu API
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        
        let data = await response.json();
        
        if (response.ok && data.success !== false) {
            showToast('Cita cancelada correctamente', 'success');
            setTimeout(() => location.reload(), 1500); 
        } else {
            // Si la API devuelve un error (ej. 403 o 400), lo capturamos aquí
            showToast(data.message || 'Error al cancelar la cita', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error de conexión con el servidor', 'error');
    } finally {
        hideLoader();
    }
}

function showLoader() {

    const loader = document.getElementById('global-loader');

    if (loader) loader.classList.remove('hidden');

}



function hideLoader() {
    const loader = document.getElementById('global-loader');
    if (loader) loader.classList.add('hidden');
}

// Lógica de Reseñas

let calificacionSeleccionada = 0;

function abrirModalResena(citaId) {
    document.getElementById('resena-cita-id').value = citaId;
    document.getElementById('resena-id').value = '';
    document.getElementById('resena-mode').value = 'create';
    document.getElementById('modal-resena-titulo').innerText = 'Calificar Cita';
    document.getElementById('btn-enviar-resena').querySelector('span').innerText = 'Enviar Reseña';
    
    resetFormularioResena();
    mostrarModalResena();
}

function abrirModalEditarResena(citaId, resenaId, calificacion, comentario) {
    document.getElementById('resena-cita-id').value = citaId;
    document.getElementById('resena-id').value = resenaId;
    document.getElementById('resena-mode').value = 'edit';
    document.getElementById('modal-resena-titulo').innerText = 'Editar Reseña';
    document.getElementById('btn-enviar-resena').querySelector('span').innerText = 'Actualizar Reseña';
    
    document.getElementById('resena-comentario').value = comentario;
    actualizarContador();
    seleccionarEstrellas(calificacion);
    
    mostrarModalResena();
}

function mostrarModalResena() {
    const modal = document.getElementById('modal-resena');
    const content = document.getElementById('modal-resena-content');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }, 10);
}

function cerrarModalResena() {
    const modal = document.getElementById('modal-resena');
    const content = document.getElementById('modal-resena-content');
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    content.classList.remove('scale-100');
    content.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function resetFormularioResena() {
    calificacionSeleccionada = 0;
    document.getElementById('resena-calificacion').value = 0;
    document.getElementById('resena-comentario').value = '';
    actualizarContador();
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach(s => {
        s.classList.remove('text-[#25B5DA]');
        s.classList.add('text-[#374151]');
    });
}

function hoverEstrellas(val) {
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach((s, index) => {
        if (index < val) {
            s.classList.remove('text-[#374151]');
            s.classList.add('text-[#25B5DA]');
        } else if (index >= calificacionSeleccionada) {
            s.classList.remove('text-[#25B5DA]');
            s.classList.add('text-[#374151]');
        }
    });
}

function resetEstrellas() {
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach((s, index) => {
        if (index < calificacionSeleccionada) {
            s.classList.remove('text-[#374151]');
            s.classList.add('text-[#25B5DA]');
        } else {
            s.classList.remove('text-[#25B5DA]');
            s.classList.add('text-[#374151]');
        }
    });
}

function seleccionarEstrellas(val) {
    calificacionSeleccionada = val;
    document.getElementById('resena-calificacion').value = val;
    resetEstrellas();
    
    // Animación de feedback en la estrella seleccionada
    const starBtn = document.querySelectorAll('.star-btn')[val-1];
    starBtn.classList.add('scale-125');
    setTimeout(() => {
        starBtn.classList.remove('scale-125');
    }, 200);
}

function actualizarContador() {
    const val = document.getElementById('resena-comentario').value;
    document.getElementById('resena-contador').innerText = val.length;
}

async function submitResena() {
    const mode = document.getElementById('resena-mode').value;
    const citaId = document.getElementById('resena-cita-id').value;
    const resenaId = document.getElementById('resena-id').value;
    const calif = document.getElementById('resena-calificacion').value;
    const coment = document.getElementById('resena-comentario').value;
    
    if (calif < 1 || calif > 5) {
        showToast('Por favor, selecciona una calificación', 'error');
        return;
    }
    
    const btn = document.getElementById('btn-enviar-resena');
    const icon = document.getElementById('resena-icon');
    const spinner = document.getElementById('resena-spinner');
    
    btn.disabled = true;
    icon.classList.add('hidden');
    spinner.classList.remove('hidden');
    
    const url = mode === 'create' ? `/api-proxy/citas/${citaId}/resena` : `/api-proxy/resenas/cita/${resenaId}`;
    const method = mode === 'create' ? 'POST' : 'PUT';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                calificacion: calif,
                comentario: coment
            })
        });
        
        let data = await response.json();
        
        if (response.ok && data.success !== false) {
            cerrarModalResena();
            if (mode === 'create' && typeof confetti === 'function') {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });
            }
            showToast(mode === 'create' ? 'Reseña enviada con éxito' : 'Reseña actualizada', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Error al guardar la reseña', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error de conexión', 'error');
    } finally {
        btn.disabled = false;
        icon.classList.remove('hidden');
        spinner.classList.add('hidden');
    }
}

async function eliminarResena(resenaId) {
    let isConfirmed = false;
    if (typeof confirmCustom === 'function') {
        const confirmacion = await confirmCustom('¿Estás seguro de eliminar esta reseña?');
        isConfirmed = confirmacion.isConfirmed;
    } else {
        isConfirmed = confirm('¿Estás seguro de eliminar esta reseña?');
    }
    
    if (!isConfirmed) return;
    
    showLoader();
    
    try {
        const response = await fetch(`/api-proxy/resenas/cita/${resenaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        let data = await response.json();
        
        if (response.ok && data.success !== false) {
            showToast('Reseña eliminada', 'success');
            setTimeout(() => location.reload(), 1500); 
        } else {
            showToast(data.message || 'Error al eliminar la reseña', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error de conexión', 'error');
    } finally {
        hideLoader();
    }
}

// Lógica de Filtros
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const citasCards = document.querySelectorAll('.cita-card');
    const container = document.querySelector('.citas-container');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Actualizar botones activos
            filterButtons.forEach(b => {
                b.classList.remove('active', 'bg-[#25B5DA]', 'text-black');
                b.classList.add('bg-[#262626]', 'border', 'border-[#374151]', 'text-[#9CA3AF]');
            });
            
            this.classList.add('active', 'bg-[#25B5DA]', 'text-black');
            this.classList.remove('bg-[#262626]', 'border', 'border-[#374151]', 'text-[#9CA3AF]');
            
            // Filtrar cards
            citasCards.forEach(card => {
                const estado = card.dataset.estado;
                
                if (filter === 'todas' || estado === filter) {
                    card.style.display = '';
                    card.classList.remove('hidden');
                } else {
                    card.style.display = 'none';
                    card.classList.add('hidden');
                }
            });
            
            // Mostrar mensaje si no hay resultados
            const visibleCards = document.querySelectorAll('.cita-card:not(.hidden)');
            let emptyMessage = document.getElementById('empty-filter-message');
            
            if (visibleCards.length === 0) {
                if (!emptyMessage) {
                    emptyMessage = document.createElement('div');
                    emptyMessage.id = 'empty-filter-message';
                    emptyMessage.className = 'col-span-full py-20 text-center animate-fade-in';
                    
                    const filterName = this.innerText.split('(')[0].trim().toLowerCase();
                    
                    emptyMessage.innerHTML = `
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-[#262626] rounded-full flex items-center justify-center mb-4 border border-[#374151]">
                                <i class="fas fa-calendar-times text-2xl text-[#9CA3AF]"></i>
                            </div>
                            <h3 class="text-white font-medium text-lg">No tienes citas ${filterName}</h3>
                            <p class="text-[#9CA3AF] text-sm mt-1 mb-6">Parece que no hay nada por aquí.</p>
                            <a href="/" class="px-6 py-2 bg-[#25B5DA] text-black font-bold rounded-lg hover:bg-[#1c8fb0] transition-all text-sm uppercase tracking-wider">
                                Agendar una cita
                            </a>
                        </div>
                    `;
                    container.appendChild(emptyMessage);
                }
            } else if (emptyMessage) {
                emptyMessage.remove();
            }
        });
    });
});

// Lógica de Tabs y Promociones
let promocionesCargadas = false;

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const tab = this.dataset.tab;
        
        // Actualizar botones
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('text-[#25B5DA]', 'border-b-2', 'border-[#25B5DA]');
            b.classList.add('text-[#9CA3AF]');
        });
        this.classList.add('text-[#25B5DA]', 'border-b-2', 'border-[#25B5DA]');
        this.classList.remove('text-[#9CA3AF]');
        
        // Mostrar contenido
        document.getElementById('tab-citas').classList.toggle('hidden', tab !== 'citas');
        document.getElementById('tab-promociones').classList.toggle('hidden', tab !== 'promociones');
        
        // Cargar promociones
        if (tab === 'promociones' && !promocionesCargadas) {
            cargarPromociones();
        }
    });
});

async function cargarPromociones() {
    const loading = document.getElementById('promos-loading');
    const empty = document.getElementById('promos-empty');
    const grid = document.getElementById('promos-grid');
    const countLabel = document.getElementById('promos-count');
    
    loading.classList.remove('hidden');
    empty.classList.add('hidden');
    grid.classList.add('hidden');
    
    try {
        const response = await fetch('/api-proxy/api/mis-promociones', {
            headers: { 'Accept': 'application/json' }
        });
        
        if (response.ok) {
            const data = await response.json();
            const promos = data.data || [];
            
            promocionesCargadas = true;
            
            if (promos.length === 0) {
                loading.classList.add('hidden');
                empty.classList.remove('hidden');
                return;
            }
            
            const activas = promos.filter(p => !p.usada && (!p.vigencia && !p.fecha_vencimiento && !p.vigencia_fin || new Date(p.vigencia || p.fecha_vencimiento || p.vigencia_fin).setMinutes(new Date(p.vigencia || p.fecha_vencimiento || p.vigencia_fin).getMinutes() + new Date(p.vigencia || p.fecha_vencimiento || p.vigencia_fin).getTimezoneOffset()) >= new Date().setHours(0,0,0,0))).length;
            countLabel.textContent = activas;
            
            let htmlDisponibles = '';
            let htmlHistorial = '';
            let countDisponibles = 0;
            let countHistorial = 0;

            promos.forEach(promo => {
                const desc = promo.descripcion || promo.titulo || promo.promocion?.nombre || 'Promoción';
                const beneficio = promo.beneficio_tipo === 'descuento' ? `${promo.beneficio_valor}% de descuento` : 'Servicio gratis';
                let fechaVenceStr = '';
                let vencida = false;
                
                const fechaVence = promo.vigencia || promo.fecha_vencimiento || promo.vigencia_fin;
                if (fechaVence) {
                    const d = new Date(fechaVence);
                    d.setMinutes(d.getMinutes() + d.getTimezoneOffset());
                    
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    if (d < today) vencida = true;

                    fechaVenceStr = `
                    <p class="text-[#6B7280] text-xs mt-1">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Vence: ${d.toLocaleDateString('es-CL', { day: '2-digit', month: '2-digit', year: 'numeric' })}
                    </p>`;
                }

                let badgeClass = '';
                let badgeText = '';
                let puedeAgendar = false;

                if (promo.usada) {
                    badgeClass = 'bg-gray-500/20 text-gray-400';
                    badgeText = 'Usada';
                } else if (vencida) {
                     badgeClass = 'bg-red-500/20 text-red-500';
                     badgeText = 'Expirada';
                } else {
                    badgeClass = 'bg-green-500/20 text-green-400';
                    badgeText = 'Disponible';
                    puedeAgendar = true;
                }
                
                const negocioNombre = promo.negocio?.nombre || promo.negocio_nombre || 'Negocio';
                const negocioId = promo.negocio_id || promo.negocio?.id;

                let btnHTML = '';
                if (puedeAgendar && negocioId) {
                    const promoClienteId = promo.id_promocion_cliente || promo.id;
                    const sId = promo.servicio_id ? `&servicio_id=${promo.servicio_id}` : '';
                    btnHTML = `
                    <a href="/agendar-cita?negocio_id=${negocioId}&promocion_id=${promoClienteId}${sId}" 
                       class="block w-full text-center bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black text-xs font-bold uppercase tracking-wider py-2.5 rounded-lg hover:shadow-[0_0_15px_rgba(37,181,218,0.4)] transition-all mt-4">
                        <i class="fas fa-bolt mr-1"></i> Usar ahora
                    </a>
                    `;
                }

                const cardHTML = `
                <div class="bg-[#262626] border border-[#374151] rounded-xl p-5 hover:border-[#25B5DA] transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="text-white font-bold">${negocioNombre}</p>
                                <p class="text-[#9CA3AF] text-sm">${desc}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-[10px] uppercase font-bold tracking-widest ${badgeClass}">
                                ${badgeText}
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <p class="text-[#25B5DA] text-sm font-medium">
                                ${beneficio}
                            </p>
                            ${fechaVenceStr}
                        </div>
                    </div>
                    
                    ${btnHTML}
                </div>
                `;

                if (!promo.usada && !vencida) {
                    htmlDisponibles += cardHTML;
                    countDisponibles++;
                } else {
                    htmlHistorial += cardHTML;
                    countHistorial++;
                }
            });

            let finalHTML = '';
            
            if (countDisponibles > 0) {
                finalHTML += `
                <div class="mb-6 mt-2">
                    <h3 class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-2 mb-4">
                        <i class="fas fa-ticket-alt text-[#25B5DA]"></i> Disponibles (${countDisponibles})
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        ${htmlDisponibles}
                    </div>
                </div>
                `;
            }

            if (countHistorial > 0) {
                finalHTML += `
                <div class="mt-8 mb-6">
                    <h3 class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-2 mb-4">
                        <i class="fas fa-history text-[#9CA3AF]"></i> Historial (${countHistorial})
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-80">
                        ${htmlHistorial}
                    </div>
                </div>
                `;
            }

            grid.innerHTML = finalHTML;
            grid.classList.remove('hidden');
            // Quitar las clases de grid sobre el contenedor principal para que las secciones se vean correctamente
            grid.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-6');
        }
    } catch (e) {
        console.error('Error cargando promociones:', e);
        loading.classList.add('hidden');
        empty.classList.remove('hidden');
    }
}
</script>

<!-- Script de Confetti CDN -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<!-- Modal Reseña -->
<div id="modal-resena" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="cerrarModalResena()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md w-[90%] pointer-events-none">
        
        <div class="bg-[#1e1e1e]/90 border border-[#374151] backdrop-blur-xl rounded-2xl p-6 shadow-2xl pointer-events-auto transform scale-95 transition-transform duration-300" id="modal-resena-content">
            <button onclick="cerrarModalResena()" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <h3 class="text-2xl font-bold text-white mb-2 text-center" id="modal-resena-titulo">Calificar Cita</h3>
            <p class="text-[#9CA3AF] text-sm text-center mb-6">Tu opinión nos ayuda a mejorar</p>
            
            <input type="hidden" id="resena-cita-id">
            <input type="hidden" id="resena-id">
            <input type="hidden" id="resena-mode" value="create">
            <input type="hidden" id="resena-calificacion" value="0">
            
            <!-- Estrellas -->
            <div class="flex justify-center gap-2 mb-6" id="resena-estrellas">
                @for($i=1; $i<=5; $i++)
                <button type="button" class="text-[#374151] hover:text-[#25B5DA] text-3xl transition-all transform hover:scale-110 focus:outline-none star-btn" data-value="{{$i}}" onmouseover="hoverEstrellas({{$i}})" onmouseout="resetEstrellas()" onclick="seleccionarEstrellas({{$i}})">
                    <i class="fas fa-star"></i>
                </button>
                @endfor
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Comentario (Opcional)</label>
                <textarea id="resena-comentario" rows="3" class="w-full bg-[#2a2a2a] border border-[#374151] rounded-lg text-white p-3 focus:outline-none focus:border-[#25B5DA] transition-colors resize-none" placeholder="¿Cómo fue tu experiencia?" maxlength="500" oninput="actualizarContador()"></textarea>
                <div class="text-right text-xs text-gray-500 mt-1"><span id="resena-contador">0</span>/500</div>
            </div>
            
            <button type="button" id="btn-enviar-resena" onclick="submitResena()" class="w-full bg-gradient-to-r from-[#25B5DA] to-blue-500 text-white font-bold py-3 px-4 rounded-lg hover:from-[#1c8fb0] hover:to-blue-600 transition-all flex justify-center items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <span>Enviar Reseña</span>
                <i class="fas fa-paper-plane" id="resena-icon"></i>
                <i class="fas fa-spinner fa-spin hidden" id="resena-spinner"></i>
            </button>
        </div>
    </div>
</div>
@endsection