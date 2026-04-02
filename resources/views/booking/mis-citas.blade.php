@extends('layouts.app')

@section('title', 'Mis Citas')

@section('content')

<div class="bg-[#1a1a1a] min-h-screen pt-12 py-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Mis Citas</h1>
            <p class="text-[#9CA3AF] text-sm mt-2">Historial de tus citas agendadas</p>
        </div>
        
        @if(count($citas) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($citas as $cita)
            <div class="bg-[#262626] border border-[#374151] rounded-lg p-6 hover:border-[#25B5DA] transition-all">
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
                    <div class="flex items-center gap-2 text-[#25B5DA]">
                        <i class="fas fa-dollar-sign w-4"></i>
                        <span>${{ number_format($cita['servicio']['precio'] ?? 0, 2) }}</span>
                    </div>
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
                                    <i class="fas fa-star {{ $i <= $cita['resena']['calificacion'] ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                @endfor
                                <span class="ml-2 text-xl">{{ ['😡', '😞', '😐', '😊', '😍'][$cita['resena']['calificacion'] - 1] ?? '😐' }}</span>
                            </div>
                        </div>
                        @if($cita['resena']['comentario'])
                        <p class="text-sm text-gray-400 italic mb-3">"{{ $cita['resena']['comentario'] }}"</p>
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
        @else
        <div class="text-center py-16">
            <i class="fas fa-calendar-alt text-6xl text-[#374151] mb-4"></i>
            <p class="text-[#9CA3AF] text-lg">No tienes citas agendadas</p>
            <a href="/" class="inline-block mt-4 text-[#25B5DA] hover:text-[#1c8fb0]">Explorar negocios</a>
        </div>
        @endif
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

const emojis = ['😡', '😞', '😐', '😊', '😍'];
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
    document.getElementById('resena-emoji').innerText = '🤔';
    document.getElementById('resena-emoji').classList.add('scale-100');
    actualizarContador();
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach(s => {
        s.classList.remove('text-yellow-400');
        s.classList.add('text-gray-500');
    });
}

function hoverEstrellas(val) {
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach((s, index) => {
        if (index < val) {
            s.classList.remove('text-gray-500');
            s.classList.add('text-yellow-400');
        } else if (index >= calificacionSeleccionada) {
            s.classList.remove('text-yellow-400');
            s.classList.add('text-gray-500');
        }
    });
    actualizarEmoji(val);
}

function resetEstrellas() {
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach((s, index) => {
        if (index < calificacionSeleccionada) {
            s.classList.remove('text-gray-500');
            s.classList.add('text-yellow-400');
        } else {
            s.classList.remove('text-yellow-400');
            s.classList.add('text-gray-500');
        }
    });
    actualizarEmoji(calificacionSeleccionada || 0);
}

function seleccionarEstrellas(val) {
    calificacionSeleccionada = val;
    document.getElementById('resena-calificacion').value = val;
    resetEstrellas();
    
    const emojiEl = document.getElementById('resena-emoji');
    emojiEl.classList.add('scale-125', 'rotate-12');
    setTimeout(() => {
        emojiEl.classList.remove('scale-125', 'rotate-12');
    }, 200);
}

function actualizarEmoji(val) {
    const emojiEl = document.getElementById('resena-emoji');
    if (val === 0) {
        emojiEl.innerText = '🤔';
    } else {
        emojiEl.innerText = emojis[val - 1];
    }
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
            
            <!-- Emojis flotantes -->
            <div class="text-center text-5xl mb-4 h-16 flex items-center justify-center transition-all duration-300" id="resena-emoji">🤔</div>
            
            <!-- Estrellas -->
            <div class="flex justify-center gap-2 mb-6" id="resena-estrellas">
                @for($i=1; $i<=5; $i++)
                <button type="button" class="text-gray-500 hover:text-yellow-400 text-3xl transition-colors transform hover:scale-110 focus:outline-none star-btn" data-value="{{$i}}" onmouseover="hoverEstrellas({{$i}})" onmouseout="resetEstrellas()" onclick="seleccionarEstrellas({{$i}})">
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