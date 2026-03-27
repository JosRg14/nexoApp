<!-- TAB 3: HORARIO LABORAL -->
<section id="tab-schedule" class="hidden animate-fade-in-up">
    <div class="flex flex-col gap-8">
        
        <!-- Sección 1: Horario del Negocio -->
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold uppercase tracking-wide text-white flex items-center gap-3">
                    <i class="fas fa-building"></i>
                    Horario del Negocio
                </h2>
                <button type="button" onclick="resetHorarioNegocio()" 
                        class="px-4 py-2 text-xs uppercase tracking-widest border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-white transition-all">
                    Restablecer
                </button>
            </div>
            
            <p class="text-[#9CA3AF] text-xs mb-4">
                Configura los horarios generales de atención. Estos serán la base para los horarios de los empleados.
            </p>
            
            <form id="horario-negocio-form" class="space-y-3">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <!-- Días de la semana (mismo código que tenías) -->
                <!-- Lunes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                    <div class="flex flex-wrap items-center gap-4 mb-2">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="negocio_lunes_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500" data-day="lunes">
                            <label for="negocio_lunes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Lunes</label>
                        </div>
                        <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="lunes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="negocio_lunes_bloques" class="bloques-container space-y-2 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[lunes][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[lunes][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[lunes][dia_semana]" value="lunes">
                </div>
                
                <!-- Martes a Domingo - similar estructura, solo cambia el id -->
                <!-- Puedes copiar el mismo patrón para martes, miercoles, jueves, viernes, sabado, domingo -->
                <!-- ... (mantén la estructura que ya tenías pero con prefijo negocio_) ... -->
                
                <button type="submit" class="mt-4 w-full py-2 bg-[#1a1a1a] text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#F3F4F6] hover:text-[#1a1a1a]">
                    Guardar Horario del Negocio
                </button>
            </form>
        </div>
        
        <!-- Sección 2: Horario del Personal -->
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold uppercase tracking-wide text-white flex items-center gap-3">
                    <i class="fas fa-user-clock"></i>
                    Horario del Personal
                </h2>
            </div>
            
            <p class="text-[#9CA3AF] text-xs mb-4">
                Configura horarios específicos para cada empleado. Si no se configura, usarán el horario general del negocio.
            </p>
            
            <!-- Lista de empleados con sus horarios -->
            <div class="space-y-3 max-h-96 overflow-y-auto custom-scroll pr-2">
                @forelse($empleados as $empleado)
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-yellow-500/50 transition-all">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-500/20 text-yellow-500 rounded-full flex items-center justify-center font-bold">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-white font-bold">{{ $empleado['nombre'] }}</h4>
                                <p class="text-[#9CA3AF] text-xs">{{ $empleado['especialidad'] ?? 'Empleado' }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="abrirModalHorarioEmpleado({{ $empleado['id_empleado'] }}, '{{ $empleado['nombre'] }}')" 
                                class="px-4 py-2 text-xs bg-yellow-500/10 border border-yellow-500/30 text-yellow-500 rounded hover:bg-yellow-500 hover:text-black transition-all">
                            <i class="fas fa-clock mr-1"></i> Configurar Horario
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-[#9CA3AF]">
                    <i class="fas fa-users text-4xl mb-2 opacity-50"></i>
                    <p>No hay empleados registrados aún.</p>
                    <a href="#" onclick="switchTab('personnel')" class="text-yellow-500 text-sm hover:underline mt-2 inline-block">
                        Agregar empleados
                    </a>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Vista previa del horario (opcional) -->
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
            <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                <i class="fas fa-eye"></i> Vista Previa - Horario del Negocio
            </h3>
            <div id="vista-previa-negocio" class="space-y-2 text-sm">
                <div class="flex justify-between py-1 border-b border-[#374151]/50">
                    <span class="text-[#9CA3AF]">Lunes</span>
                    <span class="text-white">09:00 - 18:00</span>
                </div>
                <!-- ... resto de días ... -->
            </div>
        </div>
    </div>
</section>

<!-- Modal para configurar horario de empleado -->
<div id="modal-empleado-horario" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="cerrarModalHorarioEmpleado()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-white font-bold uppercase flex items-center gap-2">
                <i class="fas fa-user-clock"></i> Horario de <span id="empleado-nombre" class="text-yellow-500"></span>
            </h3>
            <button onclick="cerrarModalHorarioEmpleado()" class="text-[#9CA3AF] hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <p class="text-[#9CA3AF] text-xs mb-4">
            Configura los horarios de trabajo para este empleado. Los campos vacíos usarán el horario general del negocio.
        </p>
        
        <form id="horario-empleado-form" class="space-y-3">
            @csrf
            <input type="hidden" name="empleado_id" id="empleado_id_input">
            
            <!-- Lunes -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_lunes_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Lunes</label>
                    <span class="text-[10px] text-[#9CA3AF] ml-auto">Usar horario propio</span>
                </div>
                <div id="emp_lunes_bloques" class="ml-6 space-y-2">
                    <div class="flex gap-3 items-center">
                        <input type="time" id="emp_lunes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_lunes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                    </div>
                    <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="lunes">
                        <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                    </button>
                </div>
            </div>
            
            <!-- Martes -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_martes_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Martes</label>
                    <span class="text-[10px] text-[#9CA3AF] ml-auto">Usar horario propio</span>
                </div>
                <div id="emp_martes_bloques" class="ml-6 space-y-2">
                    <div class="flex gap-3 items-center">
                        <input type="time" id="emp_martes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_martes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                    </div>
                    <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="martes">
                        <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                    </button>
                </div>
            </div>
            
            <!-- Miércoles, Jueves, Viernes, Sábado, Domingo - similar estructura -->
            <!-- ... -->
            
            <div class="flex gap-3 mt-6 pt-4 border-t border-[#374151]">
                <button type="submit" class="flex-1 py-2 bg-yellow-500 text-black font-bold rounded hover:bg-yellow-400 transition">
                    Guardar Horario
                </button>
                <button type="button" onclick="cerrarModalHorarioEmpleado()" class="flex-1 py-2 border border-[#374151] text-white rounded hover:bg-[#374151] transition">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let empleadoActual = null;

function abrirModalHorarioEmpleado(empleadoId, nombre) {
    empleadoActual = { id: empleadoId, nombre: nombre };
    document.getElementById('empleado-nombre').textContent = nombre;
    document.getElementById('empleado_id_input').value = empleadoId;
    
    // Cargar horarios existentes del empleado
    cargarHorarioEmpleado(empleadoId);
    
    document.getElementById('modal-empleado-horario').classList.remove('hidden');
}

function cerrarModalHorarioEmpleado() {
    document.getElementById('modal-empleado-horario').classList.add('hidden');
}

async function cargarHorarioEmpleado(empleadoId) {
    try {
        const response = await fetch(`/api-proxy/empleados/${empleadoId}/horarios`);
        const data = await response.json();
        
        if (data.success && data.data) {
            data.data.forEach(horario => {
                const dia = horario.dia_semana;
                const activo = horario.activo;
                const checkbox = document.getElementById(`emp_${dia}_activo`);
                const inicio = document.getElementById(`emp_${dia}_inicio`);
                const fin = document.getElementById(`emp_${dia}_fin`);
                
                if (checkbox) {
                    checkbox.checked = activo;
                    inicio.disabled = !activo;
                    fin.disabled = !activo;
                    
                    if (horario.hora_inicio) inicio.value = horario.hora_inicio.substring(0, 5);
                    if (horario.hora_fin) fin.value = horario.hora_fin.substring(0, 5);
                }
            });
        }
    } catch (error) {
        console.error('Error al cargar horario:', error);
    }
}

// Activar/desactivar inputs al cambiar checkbox
document.querySelectorAll('.empleado-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const id = this.id;
        const dia = id.replace('emp_', '').replace('_activo', '');
        const inicio = document.getElementById(`emp_${dia}_inicio`);
        const fin = document.getElementById(`emp_${dia}_fin`);
        
        if (inicio && fin) {
            inicio.disabled = !this.checked;
            fin.disabled = !this.checked;
        }
    });
});

// Guardar horario del empleado
document.getElementById('horario-empleado-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const empleadoId = document.getElementById('empleado_id_input').value;
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    const horarios = [];
    
    dias.forEach(dia => {
        const checkbox = document.getElementById(`emp_${dia}_activo`);
        const inicio = document.getElementById(`emp_${dia}_inicio`);
        const fin = document.getElementById(`emp_${dia}_fin`);
        
        horarios.push({
            dia_semana: dia,
            activo: checkbox?.checked || false,
            hora_inicio: checkbox?.checked ? inicio.value : null,
            hora_fin: checkbox?.checked ? fin.value : null,
            hora_inicio_2: null,
            hora_fin_2: null
        });
    });
    
    showLoader();
    
    try {
        const response = await fetch(`/api-proxy/empleados/${empleadoId}/horarios`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ horarios: horarios })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToast('Horario guardado correctamente');
            cerrarModalHorarioEmpleado();
        } else {
            showToast(data.message || 'Error al guardar');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error de conexión');
    } finally {
        hideLoader();
    }
});

// Función para agregar bloques en horario de empleado
document.querySelectorAll('.agregar-bloque-empleado').forEach(btn => {
    btn.addEventListener('click', function() {
        const dia = this.dataset.dia;
        const container = document.getElementById(`emp_${dia}_bloques`);
        const bloqueCount = container.querySelectorAll('.bloque-horario-empleado').length;
        
        const nuevoBloque = document.createElement('div');
        nuevoBloque.className = 'bloque-horario-empleado flex flex-wrap items-center gap-3 mt-2';
        nuevoBloque.innerHTML = `
            <input type="time" name="horarios[${dia}][${bloqueCount + 1}][hora_inicio]" 
                   class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm"
                   value="16:00">
            <span class="text-[#9CA3AF]">a</span>
            <input type="time" name="horarios[${dia}][${bloqueCount + 1}][hora_fin]" 
                   class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm"
                   value="20:00">
            <button type="button" class="eliminar-bloque-empleado text-red-500 hover:text-red-400 text-xs">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        `;
        
        const eliminarBtn = nuevoBloque.querySelector('.eliminar-bloque-empleado');
        eliminarBtn.addEventListener('click', () => nuevoBloque.remove());
        
        container.appendChild(nuevoBloque);
    });
});
</script>