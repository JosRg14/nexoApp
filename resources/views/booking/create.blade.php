@extends('layouts.app')

@section('title', 'Agendar Cita')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-6">
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

        @if(empty($servicios) && empty($empleados))
        <div class="bg-red-500/20 border border-red-500 text-red-500 p-6 rounded-sm text-center">
            <i class="fas fa-exclamation-triangle text-2xl mb-2 block"></i>
            <p>No hay servicios o empleados disponibles para este negocio.</p>
        </div>
        @else
        <form id="cita-form" class="space-y-8">
            @csrf
            
            <!-- Servicios en Carrusel -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white flex items-center gap-2">
                        <i class="fas fa-cut text-yellow-500"></i>
                        Selecciona un servicio
                        <span class="text-xs text-[#9CA3AF] font-normal">({{ count($servicios) }} disponibles)</span>
                    </h3>
                    
                    @if(count($servicios) > 3)
                    <div class="flex gap-2">
                        <button type="button" id="prevServicio" class="w-8 h-8 rounded-full bg-[#1a1a1a] border border-[#374151] text-white hover:bg-white hover:text-black transition-all flex items-center justify-center">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </button>
                        <button type="button" id="nextServicio" class="w-8 h-8 rounded-full bg-[#1a1a1a] border border-[#374151] text-white hover:bg-white hover:text-black transition-all flex items-center justify-center">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                    @endif
                </div>
                
                <div class="relative overflow-hidden">
                    <div id="serviciosCarousel" class="flex transition-transform duration-500 ease-out gap-5">
                        @foreach($servicios as $index => $servicio)
                        <div class="servicio-card flex-shrink-0 w-full md:w-[calc(33.333%-1rem)] cursor-pointer border border-[#374151] rounded-sm hover:border-yellow-500 transition-all" 
                             data-id="{{ $servicio['id'] }}"
                             data-nombre="{{ $servicio['nombre'] }}"
                             data-precio="{{ $servicio['precio'] }}"
                             data-duracion="{{ $servicio['duracion'] }}">
                            <div class="relative h-44 overflow-hidden rounded-t-sm bg-[#1a1a1a]">
                                @if(isset($servicio['imagen']) && $servicio['imagen'])
                                <img src="{{ $servicio['imagen'] }}" alt="{{ $servicio['nombre'] }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-cut text-5xl text-[#374151]"></i>
                                </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-black/70 px-2 py-1 rounded-full">
                                    <span class="text-yellow-500 font-bold text-sm">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h4 class="text-white font-bold uppercase tracking-wide text-sm">{{ $servicio['nombre'] }}</h4>
                                <p class="text-[#9CA3AF] text-xs mt-1 line-clamp-2">{{ $servicio['descripcion'] ?? 'Sin descripción' }}</p>
                                <div class="mt-3 flex items-center gap-2 text-[10px] text-[#9CA3AF]">
                                    <i class="far fa-clock"></i>
                                    <span>{{ $servicio['duracion'] }} minutos</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <input type="hidden" name="servicio_id" id="servicio_id">
            </div>

            <!-- Empleados en Grid -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-yellow-500"></i>
                    Selecciona un empleado
                    <span class="text-xs text-[#9CA3AF] font-normal">({{ count($empleados) }} disponibles)</span>
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($empleados as $empleado)
                    <div class="empleado-card border border-[#374151] rounded-sm p-3 cursor-pointer hover:border-yellow-500 transition-all text-center"
                         data-id="{{ $empleado['id_empleado'] }}"
                         data-nombre="{{ $empleado['nombre'] }}">
                        <div class="w-14 h-14 mx-auto bg-yellow-500/20 text-yellow-500 rounded-full flex items-center justify-center text-xl font-bold mb-2">
                            {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                        </div>
                        <h4 class="text-white font-bold text-sm">{{ $empleado['nombre'] }}</h4>
                        <p class="text-[#9CA3AF] text-[10px] mt-1">{{ $empleado['especialidad'] ?? 'Especialista' }}</p>
                        @if(isset($empleado['calificacion']))
                        <div class="flex items-center justify-center gap-1 mt-1">
                            <i class="fas fa-star text-yellow-500 text-[8px]"></i>
                            <span class="text-[10px] text-white">{{ number_format($empleado['calificacion'], 1) }}</span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="empleado_id" id="empleado_id">
            </div>

            <!-- Fecha y Hora -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-yellow-500"></i>
                    Selecciona fecha y hora
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">Fecha</label>
                        <input type="date" id="fecha" name="fecha" 
                               min="{{ date('Y-m-d') }}"
                               class="w-full bg-[#1a1a1a] border border-[#374151] rounded-sm px-4 py-2 text-white focus:border-yellow-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">Hora</label>
                        <select id="hora" name="hora_inicio" 
                                class="w-full bg-[#1a1a1a] border border-[#374151] rounded-sm px-4 py-2 text-white focus:border-yellow-500 focus:outline-none" disabled>
                            <option value="">Primero selecciona fecha</option>
                        </select>
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
                <div class="mt-4 pt-4 border-t border-[#374151] flex justify-between items-center">
                    <span class="text-xs font-bold uppercase text-white">Total</span>
                    <span id="resumen-total" class="text-xl font-bold text-yellow-500">$0</span>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-black font-bold uppercase tracking-wider rounded-lg hover:from-yellow-400 hover:to-yellow-500 transition-all">
                Confirmar Cita
            </button>
        </form>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
let servicioSeleccionado = null;
let empleadoSeleccionado = null;
let currentServicioIndex = 0;
const itemsPerPage = 3;

// Configurar carrusel
function updateCarousel() {
    const carousel = document.getElementById('serviciosCarousel');
    if (!carousel) return;
    const totalItems = carousel.children.length;
    const maxIndex = Math.ceil(totalItems / itemsPerPage) - 1;
    if (currentServicioIndex > maxIndex) currentServicioIndex = maxIndex;
    const offset = -currentServicioIndex * (100 / itemsPerPage);
    carousel.style.transform = `translateX(${offset}%)`;
}

document.getElementById('prevServicio')?.addEventListener('click', () => {
    if (currentServicioIndex > 0) {
        currentServicioIndex--;
        updateCarousel();
    }
});

document.getElementById('nextServicio')?.addEventListener('click', () => {
    const totalItems = document.querySelectorAll('.servicio-card').length;
    const maxIndex = Math.ceil(totalItems / itemsPerPage) - 1;
    if (currentServicioIndex < maxIndex) {
        currentServicioIndex++;
        updateCarousel();
    }
});

// Selección de servicio
document.querySelectorAll('.servicio-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.servicio-card').forEach(c => c.classList.remove('border-yellow-500', 'bg-yellow-500/10'));
        this.classList.add('border-yellow-500', 'bg-yellow-500/10');
        
        servicioSeleccionado = {
            id: this.dataset.id,
            nombre: this.dataset.nombre,
            precio: this.dataset.precio,
            duracion: this.dataset.duracion
        };
        
        document.getElementById('servicio_id').value = servicioSeleccionado.id;
        document.getElementById('resumen-servicio').textContent = servicioSeleccionado.nombre;
        document.getElementById('resumen-total').textContent = '$' + parseInt(servicioSeleccionado.precio).toLocaleString('es-CL');
        
        if (document.getElementById('fecha').value && empleadoSeleccionado) {
            cargarHorarios();
        }
    });
});

// Selección de empleado
document.querySelectorAll('.empleado-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.empleado-card').forEach(c => c.classList.remove('border-yellow-500', 'bg-yellow-500/10'));
        this.classList.add('border-yellow-500', 'bg-yellow-500/10');
        
        empleadoSeleccionado = {
            id: this.dataset.id,
            nombre: this.dataset.nombre
        };
        
        document.getElementById('empleado_id').value = empleadoSeleccionado.id;
        document.getElementById('resumen-empleado').textContent = empleadoSeleccionado.nombre;
        
        if (document.getElementById('fecha').value && servicioSeleccionado) {
            cargarHorarios();
        }
    });
});

// Fecha
document.getElementById('fecha').addEventListener('change', function() {
    const fecha = this.value;
    if (fecha) {
        const date = new Date(fecha);
        document.getElementById('resumen-fecha').textContent = date.toLocaleDateString('es-CL');
    }
    if (fecha && servicioSeleccionado && empleadoSeleccionado) {
        cargarHorarios();
    }
});

async function cargarHorarios() {
    const fecha = document.getElementById('fecha').value;
    const empleadoId = empleadoSeleccionado?.id;
    const duracion = parseInt(servicioSeleccionado?.duracion, 10);
    
    if (!fecha || !empleadoId || !duracion) {
        console.log('Faltan datos:', { fecha, empleadoId, duracion });
        return;
    }
    
    const selectHora = document.getElementById('hora');
    selectHora.innerHTML = '<option value="">Cargando horarios...</option>';
    selectHora.disabled = true;
    
    try {
        // Usar la API directa (pública) en lugar del proxy para disponibilidad
        const response = await fetch(`https://devlink-servidorapi.td60xq.easypanel.host/api/disponibilidad/empleado/${empleadoId}?fecha=${fecha}&duracion=${duracion}`);
        const data = await response.json();
        
        selectHora.innerHTML = '<option value="">Selecciona una hora</option>';
        
        console.log('Respuesta disponibilidad:', data);
        
        if (data.success && data.slots && data.slots.length > 0) {
            data.slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.hora_inicio;
                option.textContent = `${slot.hora_inicio} - ${slot.hora_fin}`;
                selectHora.appendChild(option);
            });
            selectHora.disabled = false;
        } else {
            selectHora.innerHTML = '<option value="">No hay horarios disponibles para este día</option>';
            selectHora.disabled = true;
        }
    } catch (error) {
        console.error('Error cargando horarios:', error);
        selectHora.innerHTML = '<option value="">Error al cargar horarios</option>';
        selectHora.disabled = true;
    }
}

document.getElementById('hora').addEventListener('change', function() {
    document.getElementById('resumen-hora').textContent = this.value || '-';
});

// Envío
document.getElementById('cita-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const servicioId = document.getElementById('servicio_id').value;
    const empleadoId = document.getElementById('empleado_id').value;
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    
    if (!servicioId || !empleadoId || !fecha || !hora) {
        alert('Por favor completa todos los campos');
        return;
    }
    
    showLoader();
    
    //  Obtener el token CSRF correctamente
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                      document.querySelector('input[name="_token"]')?.value;
    
    try {
        const response = await fetch('/api-proxy/citas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin', // 🔥 Importante para enviar cookies
            body: JSON.stringify({
                servicio_id: servicioId,
                empleado_id: empleadoId,
                fecha: fecha,
                hora_inicio: hora
            })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            alert(data.message || 'Cita agendada correctamente');
            window.location.href = '/mis-citas';
        } else {
            alert(data.message || 'Error al agendar cita');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
    } finally {
        hideLoader();
    }
});

function showLoader() {
    const loader = document.getElementById('global-loader');
    if (loader) loader.classList.remove('hidden');
}

function hideLoader() {
    const loader = document.getElementById('global-loader');
    if (loader) loader.classList.add('hidden');
}
</script>
@endsection