@extends('layouts.app')

@section('title', 'Agendar Cita')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="text-[#9CA3AF] hover:text-white text-sm mb-4 inline-block">
                ← Volver
            </a>
            <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Agendar Cita</h1>
            <p class="text-[#9CA3AF] text-sm mt-2">Selecciona el servicio, empleado y horario</p>
        </div>

        <!-- Formulario -->
        <form id="cita-form" class="space-y-6">
            @csrf
            
            <!-- Paso 1: Servicio -->
            <div class="bg-[#262626] border border-[#374151] rounded-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-cut"></i> 1. Selecciona un servicio
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="servicios-container">
                    @foreach($servicios as $servicio)
                    <div class="servicio-card border border-[#374151] rounded-lg p-4 cursor-pointer hover:border-yellow-500 transition-all" 
                         data-id="{{ $servicio['id'] }}"
                         data-precio="{{ $servicio['precio'] }}"
                         data-duracion="{{ $servicio['duracion'] }}">
                        <h3 class="font-bold text-white">{{ $servicio['nombre'] }}</h3>
                        <p class="text-sm text-[#9CA3AF] mt-1">{{ $servicio['descripcion'] ?? 'Sin descripción' }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-yellow-500 font-bold">${{ number_format($servicio['precio'], 0) }}</span>
                            <span class="text-xs text-[#9CA3AF]"><i class="far fa-clock"></i> {{ $servicio['duracion'] }} min</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="servicio_id" id="servicio_id">
            </div>

            <!-- Paso 2: Empleado -->
            <div class="bg-[#262626] border border-[#374151] rounded-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-users"></i> 2. Selecciona un empleado
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="empleados-container">
                    @foreach($empleados as $empleado)
                    <div class="empleado-card border border-[#374151] rounded-lg p-4 cursor-pointer hover:border-yellow-500 transition-all"
                         data-id="{{ $empleado['id_empleado'] }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-500/20 text-yellow-500 rounded-full flex items-center justify-center font-bold">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-white">{{ $empleado['nombre'] }}</h3>
                                <p class="text-xs text-[#9CA3AF]">{{ $empleado['especialidad'] ?? 'Especialista' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="empleado_id" id="empleado_id">
            </div>

            <!-- Paso 3: Fecha y Hora -->
            <div class="bg-[#262626] border border-[#374151] rounded-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i> 3. Selecciona fecha y hora
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-[#9CA3AF] mb-2">Fecha</label>
                        <input type="date" id="fecha" name="fecha" 
                               min="{{ date('Y-m-d') }}"
                               class="w-full bg-[#1a1a1a] border border-[#374151] rounded-lg px-4 py-2 text-white focus:border-yellow-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm text-[#9CA3AF] mb-2">Hora</label>
                        <select id="hora" name="hora_inicio" 
                                class="w-full bg-[#1a1a1a] border border-[#374151] rounded-lg px-4 py-2 text-white focus:border-yellow-500 focus:outline-none" disabled>
                            <option value="">Primero selecciona fecha</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Resumen -->
            <div class="bg-[#262626] border border-[#374151] rounded-lg p-6">
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-receipt"></i> Resumen de cita
                </h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-[#9CA3AF]">Servicio:</span>
                        <span id="resumen-servicio" class="text-white">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#9CA3AF]">Empleado:</span>
                        <span id="resumen-empleado" class="text-white">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#9CA3AF]">Fecha:</span>
                        <span id="resumen-fecha" class="text-white">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#9CA3AF]">Hora:</span>
                        <span id="resumen-hora" class="text-white">-</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-[#374151] mt-2">
                        <span class="font-bold text-white">Total:</span>
                        <span id="resumen-total" class="font-bold text-yellow-500">$0</span>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 text-black font-bold uppercase tracking-wider rounded-lg hover:from-yellow-400 hover:to-yellow-500 transition-all">
                Confirmar Cita
            </button>
        </form>
    </div>
</div>

<script>
let servicioSeleccionado = null;
let empleadoSeleccionado = null;

// Selección de servicio
document.querySelectorAll('.servicio-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.servicio-card').forEach(c => c.classList.remove('border-yellow-500', 'bg-yellow-500/10'));
        this.classList.add('border-yellow-500', 'bg-yellow-500/10');
        
        servicioSeleccionado = {
            id: this.dataset.id,
            nombre: this.querySelector('h3').textContent,
            precio: this.dataset.precio,
            duracion: this.dataset.duracion
        };
        
        document.getElementById('servicio_id').value = servicioSeleccionado.id;
        document.getElementById('resumen-servicio').textContent = servicioSeleccionado.nombre;
        document.getElementById('resumen-total').textContent = '$' + servicioSeleccionado.precio;
        
        // Cargar horarios disponibles si ya hay fecha y empleado
        if (document.getElementById('fecha').value && empleadoSeleccionado) {
            cargarHorariosDisponibles();
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
            nombre: this.querySelector('h3').textContent
        };
        
        document.getElementById('empleado_id').value = empleadoSeleccionado.id;
        document.getElementById('resumen-empleado').textContent = empleadoSeleccionado.nombre;
        
        // Cargar horarios disponibles si ya hay fecha y servicio
        if (document.getElementById('fecha').value && servicioSeleccionado) {
            cargarHorariosDisponibles();
        }
    });
});

// Fecha seleccionada
document.getElementById('fecha').addEventListener('change', function() {
    const fecha = this.value;
    document.getElementById('resumen-fecha').textContent = fecha ? new Date(fecha).toLocaleDateString('es-MX') : '-';
    
    if (fecha && servicioSeleccionado && empleadoSeleccionado) {
        cargarHorariosDisponibles();
    }
});

// Cargar horarios disponibles desde la API
async function cargarHorariosDisponibles() {
    const fecha = document.getElementById('fecha').value;
    const empleadoId = empleadoSeleccionado?.id;
    const servicioId = servicioSeleccionado?.id;
    
    if (!fecha || !empleadoId || !servicioId) return;
    
    try {
        const response = await fetch(`/api-proxy/disponibilidad/empleado/${empleadoId}?fecha=${fecha}&servicio_id=${servicioId}`);
        const data = await response.json();
        
        const selectHora = document.getElementById('hora');
        selectHora.innerHTML = '<option value="">Selecciona una hora</option>';
        
        if (data.success && data.data && data.data.length > 0) {
            data.data.forEach(horario => {
                const option = document.createElement('option');
                option.value = horario;
                option.textContent = horario;
                selectHora.appendChild(option);
            });
            selectHora.disabled = false;
        } else {
            selectHora.innerHTML = '<option value="">No hay horarios disponibles</option>';
            selectHora.disabled = true;
        }
    } catch (error) {
        console.error('Error cargando horarios:', error);
        const selectHora = document.getElementById('hora');
        selectHora.innerHTML = '<option value="">Error al cargar horarios</option>';
        selectHora.disabled = true;
    }
}

// Hora seleccionada
document.getElementById('hora').addEventListener('change', function() {
    const hora = this.value;
    document.getElementById('resumen-hora').textContent = hora || '-';
});

// Envío del formulario
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
    
    try {
        const response = await fetch('/api-proxy/citas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
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