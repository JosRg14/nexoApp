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
                    <i class="fas fa-cut text-yellow-500"></i>
                    Selecciona un servicio
                    <span class="text-xs text-[#9CA3AF] font-normal">({{ count($servicios) }} disponibles)</span>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($servicios as $servicio)
                    <div class="servicio-card border border-[#374151] rounded-sm p-4 cursor-pointer hover:border-yellow-500 transition-all" 
                         data-id="{{ $servicio['id'] }}"
                         data-nombre="{{ $servicio['nombre'] }}"
                         data-precio="{{ $servicio['precio'] }}"
                         data-duracion="{{ $servicio['duracion'] }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-white font-bold text-sm">{{ $servicio['nombre'] }}</h4>
                                <p class="text-[#9CA3AF] text-[10px] mt-1">{{ $servicio['descripcion'] ?? 'Sin descripción' }}</p>
                            </div>
                            <span class="text-yellow-500 font-bold text-sm">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
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
                    <i class="fas fa-users text-yellow-500"></i>
                    Selecciona un empleado
                    <span class="text-xs text-[#9CA3AF] font-normal">({{ count($empleados) }} disponibles)</span>
                </h3>
                
                @if(count($empleados) > 0)
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
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-center text-[#9CA3AF] py-8">No hay empleados disponibles en este momento.</p>
                @endif
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
                            <option value="">Primero selecciona un servicio, empleado y fecha</option>
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
                    class="w-full py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-black font-bold uppercase tracking-wider rounded-lg hover:from-yellow-400 hover:to-yellow-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    id="btn-submit" disabled>
                Confirmar Cita
            </button>
        </form>
        @endif
    </div>
</div>

<script>
// Estado de la cita
let servicioSeleccionado = null;
let empleadoSeleccionado = null;

// Elementos DOM
const btnSubmit = document.getElementById('btn-submit');
const fechaInput = document.getElementById('fecha');
const horaSelect = document.getElementById('hora');
const resumenServicio = document.getElementById('resumen-servicio');
const resumenEmpleado = document.getElementById('resumen-empleado');
const resumenFecha = document.getElementById('resumen-fecha');
const resumenHora = document.getElementById('resumen-hora');
const resumenTotal = document.getElementById('resumen-total');

// Verificar si se puede habilitar el botón
function checkFormComplete() {
    if (servicioSeleccionado && empleadoSeleccionado && fechaInput.value && horaSelect.value) {
        btnSubmit.disabled = false;
    } else {
        btnSubmit.disabled = true;
    }
}

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
        resumenServicio.textContent = servicioSeleccionado.nombre;
        resumenTotal.textContent = '$' + parseInt(servicioSeleccionado.precio).toLocaleString('es-CL');
        
        // Si ya hay empleado y fecha seleccionados, cargar horarios
        if (empleadoSeleccionado && fechaInput.value) {
            cargarHorarios();
        }
        
        checkFormComplete();
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
        resumenEmpleado.textContent = empleadoSeleccionado.nombre;
        
        // Si ya hay servicio y fecha seleccionados, cargar horarios
        if (servicioSeleccionado && fechaInput.value) {
            cargarHorarios();
        }
        
        checkFormComplete();
    });
});

// Cambio de fecha
fechaInput.addEventListener('change', function() {
    const fecha = this.value;
    if (fecha) {
        const date = new Date(fecha);
        resumenFecha.textContent = date.toLocaleDateString('es-CL');
    }
    
    // Si ya hay servicio y empleado seleccionados, cargar horarios
    if (servicioSeleccionado && empleadoSeleccionado && fecha) {
        cargarHorarios();
    }
    
    checkFormComplete();
});

// Cargar horarios disponibles
async function cargarHorarios() {
    const fecha = fechaInput.value;
    const empleadoId = empleadoSeleccionado?.id;
    const duracion = parseInt(servicioSeleccionado?.duracion, 10);
    
    if (!fecha || !empleadoId || !duracion) {
        return;
    }
    
    horaSelect.innerHTML = '<option value="">Cargando horarios...</option>';
    horaSelect.disabled = true;
    
    try {
        const response = await fetch(`/api-proxy/disponibilidad/empleado/${empleadoId}?fecha=${fecha}&duracion=${duracion}`);
        const data = await response.json();
        
        horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';
        
        if (data.success && data.slots && data.slots.length > 0) {
            data.slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.hora_inicio;
                option.textContent = `${slot.hora_inicio} - ${slot.hora_fin}`;
                horaSelect.appendChild(option);
            });
            horaSelect.disabled = false;
        } else {
            horaSelect.innerHTML = '<option value="">No hay horarios disponibles para este día</option>';
            horaSelect.disabled = true;
        }
    } catch (error) {
        console.error('Error cargando horarios:', error);
        horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
        horaSelect.disabled = true;
    }
}

// Selección de hora
horaSelect.addEventListener('change', function() {
    resumenHora.textContent = this.value || '-';
    checkFormComplete();
});

// Envío del formulario
document.getElementById('cita-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const servicioId = document.getElementById('servicio_id').value;
    const empleadoId = document.getElementById('empleado_id').value;
    const fecha = fechaInput.value;
    const hora = horaSelect.value;
    const negocioId = document.getElementById('negocio_id').value;
    
    if (!servicioId || !empleadoId || !fecha || !hora) {
        alert('Por favor completa todos los campos');
        return;
    }
    
    btnSubmit.disabled = true;
    btnSubmit.textContent = 'Agendando...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                      document.querySelector('input[name="_token"]')?.value;
    
    try {
        const response = await fetch('/api-proxy/citas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                servicio_id: servicioId,
                empleado_id: empleadoId,
                fecha: fecha,
                hora_inicio: hora,
                negocio_id: negocioId
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert(data.message || 'Cita agendada correctamente');
            window.location.href = '/mis-citas';
        } else {
            alert(data.message || 'Error al agendar cita');
            btnSubmit.disabled = false;
            btnSubmit.textContent = 'Confirmar Cita';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión');
        btnSubmit.disabled = false;
        btnSubmit.textContent = 'Confirmar Cita';
    }
});
</script>
@endsection