@extends('layouts.app')

@section('title', 'Agendar Cita')

@section('content')
<div class="bg-[#1a1a1a] min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        <!-- Header con botón volver -->
        <div class="mb-8 border-b border-[#374151] pb-8">
            <a href="{{ url()->previous() }}" 
               class="text-[#9CA3AF] hover:text-white text-xs uppercase tracking-widest mb-4 inline-block flex items-center gap-2 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>

            <div class="flex justify-between items-start mt-4">
                <div>
                    <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Agendar Cita</h1>
                    <p class="text-[#9CA3AF] text-sm mt-2 max-w-xl">
                        Selecciona el servicio, empleado y horario para tu cita.
                    </p>
                </div>
            </div>
        </div>

        <form id="cita-form" class="space-y-6">
            @csrf
            
            <!-- Paso 1: Servicio -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-cut text-yellow-500"></i>
                    1. Selecciona un servicio
                </h3>
                
                @if(count($servicios) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($servicios as $servicio)
                    <div class="servicio-card border border-[#374151] rounded-sm p-4 cursor-pointer hover:border-yellow-500 transition-all {{ $servicioId == $servicio['id'] ? 'border-yellow-500 bg-yellow-500/10' : '' }}" 
                         data-id="{{ $servicio['id'] }}"
                         data-precio="{{ $servicio['precio'] }}"
                         data-duracion="{{ $servicio['duracion'] }}">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-white font-bold uppercase tracking-wide text-sm">{{ $servicio['nombre'] }}</h4>
                            <span class="text-yellow-500 font-bold text-sm">${{ number_format($servicio['precio'], 0, ',', '.') }}</span>
                        </div>
                        <p class="text-[#9CA3AF] text-xs leading-relaxed">
                            {{ $servicio['descripcion'] ?? 'Sin descripción' }}
                        </p>
                        <div class="mt-2 flex items-center gap-2 text-[10px] text-[#9CA3AF] uppercase tracking-wider">
                            <i class="far fa-clock"></i>
                            <span>{{ $servicio['duracion'] }} minutos</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-[#52525b] italic">No hay servicios disponibles para este negocio.</p>
                @endif
                <input type="hidden" name="servicio_id" id="servicio_id" value="{{ $servicioId }}">
            </div>

            <!-- Paso 2: Empleado -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-yellow-500"></i>
                    2. Selecciona un empleado
                </h3>
                
                @if(count($empleados) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($empleados as $empleado)
                    <div class="empleado-card border border-[#374151] rounded-sm p-4 cursor-pointer hover:border-yellow-500 transition-all {{ $empleadoId == $empleado['id_empleado'] ? 'border-yellow-500 bg-yellow-500/10' : '' }}"
                         data-id="{{ $empleado['id_empleado'] }}">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-500/20 text-yellow-500 rounded-full flex items-center justify-center text-sm font-bold">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-white font-bold uppercase tracking-wide text-sm">{{ $empleado['nombre'] }}</h4>
                                <p class="text-[#9CA3AF] text-[10px] uppercase tracking-wider">{{ $empleado['especialidad'] ?? 'Especialista' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-xs text-[#52525b] italic">No hay empleados disponibles para este negocio.</p>
                @endif
                <input type="hidden" name="empleado_id" id="empleado_id" value="{{ $empleadoId }}">
            </div>

            <!-- Paso 3: Fecha y Hora -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-yellow-500"></i>
                    3. Selecciona fecha y hora
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">Fecha</label>
                        <input type="date" id="fecha" name="fecha" 
                               min="{{ date('Y-m-d') }}"
                               class="w-full bg-[#1a1a1a] border border-[#374151] rounded-sm px-4 py-2 text-white focus:border-yellow-500 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">Hora</label>
                        <select id="hora" name="hora_inicio" 
                                class="w-full bg-[#1a1a1a] border border-[#374151] rounded-sm px-4 py-2 text-white focus:border-yellow-500 focus:outline-none transition-colors" disabled>
                            <option value="">Primero selecciona fecha</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Resumen de cita -->
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-receipt text-yellow-500"></i>
                    Resumen de cita
                </h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-[#374151]/50">
                        <span class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Servicio</span>
                        <span id="resumen-servicio" class="text-xs text-white font-medium">-</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#374151]/50">
                        <span class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Empleado</span>
                        <span id="resumen-empleado" class="text-xs text-white font-medium">-</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#374151]/50">
                        <span class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Fecha</span>
                        <span id="resumen-fecha" class="text-xs text-white font-medium">-</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-[#374151]/50">
                        <span class="text-[10px] uppercase tracking-widest text-[#9CA3AF]">Hora</span>
                        <span id="resumen-hora" class="text-xs text-white font-medium">-</span>
                    </div>
                    <div class="flex justify-between py-2 pt-3">
                        <span class="text-xs font-bold text-white uppercase tracking-widest">Total</span>
                        <span id="resumen-total" class="text-sm font-bold text-yellow-500">$0</span>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-[#1a1a1a] text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#F3F4F6] hover:text-[#1a1a1a] mt-4">
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
            nombre: this.querySelector('h4').textContent,
            precio: this.dataset.precio,
            duracion: this.dataset.duracion
        };
        
        document.getElementById('servicio_id').value = servicioSeleccionado.id;
        document.getElementById('resumen-servicio').textContent = servicioSeleccionado.nombre;
        document.getElementById('resumen-total').textContent = '$' + parseInt(servicioSeleccionado.precio).toLocaleString('es-CL');
        
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
            nombre: this.querySelector('h4').textContent
        };
        
        document.getElementById('empleado_id').value = empleadoSeleccionado.id;
        document.getElementById('resumen-empleado').textContent = empleadoSeleccionado.nombre;
        
        if (document.getElementById('fecha').value && servicioSeleccionado) {
            cargarHorariosDisponibles();
        }
    });
});

// Fecha seleccionada
document.getElementById('fecha').addEventListener('change', function() {
    const fecha = this.value;
    if (fecha) {
        const date = new Date(fecha);
        document.getElementById('resumen-fecha').textContent = date.toLocaleDateString('es-CL');
    } else {
        document.getElementById('resumen-fecha').textContent = '-';
    }
    
    if (fecha && servicioSeleccionado && empleadoSeleccionado) {
        cargarHorariosDisponibles();
    }
});

// Cargar horarios disponibles
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