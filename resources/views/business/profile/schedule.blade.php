<!-- TAB 3: HORARIO LABORAL -->
<section id="tab-schedule" class="hidden animate-fade-in-up">
    <div class="flex flex-col lg:flex-row gap-12">
        
        <!-- Left: Horario semanal -->
        <div class="w-full lg:w-2/3 space-y-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold uppercase tracking-wide text-white flex items-center gap-3">
                    <i class="fas fa-clock"></i>
                    Horario de Atención
                </h2>
                <button type="button" onclick="resetHorario()" 
                        class="px-4 py-2 text-xs uppercase tracking-widest border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-white transition-all">
                    Restablecer
                </button>
            </div>
            
            <p class="text-[#9CA3AF] text-xs mb-6">
                Configura los horarios de atención para cada día de la semana. Los horarios se mostrarán en la página pública de tu negocio.
            </p>
            
            <form id="horario-form" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <!-- Lunes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="lunes_abierto" name="horarios[0][abierto]" value="1" class="w-4 h-4 accent-yellow-500" data-day="lunes">
                            <label for="lunes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Lunes</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="lunes_apertura" name="horarios[0][hora_apertura]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="lunes_cierre" name="horarios[0][hora_cierre]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[0][dia_semana]" value="lunes">
                </div>
                
                <!-- Martes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="martes_abierto" name="horarios[1][abierto]" value="1" class="w-4 h-4 accent-yellow-500" data-day="martes">
                            <label for="martes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Martes</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="martes_apertura" name="horarios[1][hora_apertura]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="martes_cierre" name="horarios[1][hora_cierre]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[1][dia_semana]" value="martes">
                </div>
                
                <!-- Miércoles -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="miercoles_abierto" name="horarios[2][abierto]" value="1" class="w-4 h-4 accent-yellow-500" data-day="miercoles">
                            <label for="miercoles_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Miércoles</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="miercoles_apertura" name="horarios[2][hora_apertura]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="miercoles_cierre" name="horarios[2][hora_cierre]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[2][dia_semana]" value="miercoles">
                </div>
                
                <!-- Jueves -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="jueves_abierto" name="horarios[3][abierto]" value="1" class="w-4 h-4 accent-yellow-500" data-day="jueves">
                            <label for="jueves_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Jueves</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="jueves_apertura" name="horarios[3][hora_apertura]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="jueves_cierre" name="horarios[3][hora_cierre]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[3][dia_semana]" value="jueves">
                </div>
                
                <!-- Viernes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="viernes_abierto" name="horarios[4][abierto]" value="1" class="w-4 h-4 accent-yellow-500" data-day="viernes">
                            <label for="viernes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Viernes</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="viernes_apertura" name="horarios[4][hora_apertura]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="viernes_cierre" name="horarios[4][hora_cierre]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[4][dia_semana]" value="viernes">
                </div>
                
                <!-- Sábado -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="sabado_abierto" name="horarios[5][abierto]" value="1" class="w-4 h-4 accent-yellow-500" data-day="sabado">
                            <label for="sabado_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Sábado</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="sabado_apertura" name="horarios[5][hora_apertura]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="sabado_cierre" name="horarios[5][hora_cierre]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="14:00" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[5][dia_semana]" value="sabado">
                </div>
                
                <!-- Domingo -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="domingo_abierto" name="horarios[6][abierto]" value="1" class="w-4 h-4 accent-yellow-500" data-day="domingo">
                            <label for="domingo_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Domingo</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="domingo_apertura" name="horarios[6][hora_apertura]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="domingo_cierre" name="horarios[6][hora_cierre]" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="14:00" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[6][dia_semana]" value="domingo">
                </div>
                
                <button type="submit" 
                        class="mt-8 w-full py-4 px-6 bg-[#1a1a1a] text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#F3F4F6] hover:text-[#1a1a1a]">
                    Guardar Horario
                </button>
            </form>
        </div>
        
        <!-- Right: Vista previa del horario -->
        <div class="w-full lg:w-1/3">
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6 sticky top-24">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-eye"></i> Vista Previa
                </h3>
                <p class="text-[#9CA3AF] text-xs mb-4">Así se verá tu horario en la página pública:</p>
                
                <div id="vista-previa" class="space-y-2 text-sm">
                    <div class="flex justify-between py-1 border-b border-[#374151]/50">
                        <span class="text-[#9CA3AF]">Lunes</span>
                        <span class="text-white">09:00 - 18:00</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#374151]/50">
                        <span class="text-[#9CA3AF]">Martes</span>
                        <span class="text-white">09:00 - 18:00</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#374151]/50">
                        <span class="text-[#9CA3AF]">Miércoles</span>
                        <span class="text-white">09:00 - 18:00</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#374151]/50">
                        <span class="text-[#9CA3AF]">Jueves</span>
                        <span class="text-white">09:00 - 18:00</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#374151]/50">
                        <span class="text-[#9CA3AF]">Viernes</span>
                        <span class="text-white">09:00 - 18:00</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-[#374151]/50">
                        <span class="text-[#9CA3AF]">Sábado</span>
                        <span class="text-white">09:00 - 14:00</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-[#9CA3AF]">Domingo</span>
                        <span class="text-white">09:00 - 14:00</span>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-[#374151]">
                    <p class="text-[10px] text-[#9CA3AF] uppercase tracking-widest">
                        <i class="fas fa-info-circle mr-1"></i> Los días desactivados se mostrarán como "Cerrado"
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Script para manejar los checkboxes y la vista previa
document.addEventListener('DOMContentLoaded', function() {
    const dias = [
        { index: 0, nombre: 'lunes', abierto: 'lunes_abierto', apertura: 'lunes_apertura', cierre: 'lunes_cierre' },
        { index: 1, nombre: 'martes', abierto: 'martes_abierto', apertura: 'martes_apertura', cierre: 'martes_cierre' },
        { index: 2, nombre: 'miercoles', abierto: 'miercoles_abierto', apertura: 'miercoles_apertura', cierre: 'miercoles_cierre' },
        { index: 3, nombre: 'jueves', abierto: 'jueves_abierto', apertura: 'jueves_apertura', cierre: 'jueves_cierre' },
        { index: 4, nombre: 'viernes', abierto: 'viernes_abierto', apertura: 'viernes_apertura', cierre: 'viernes_cierre' },
        { index: 5, nombre: 'sabado', abierto: 'sabado_abierto', apertura: 'sabado_apertura', cierre: 'sabado_cierre' },
        { index: 6, nombre: 'domingo', abierto: 'domingo_abierto', apertura: 'domingo_apertura', cierre: 'domingo_cierre' }
    ];
    
    // Función para habilitar/deshabilitar inputs de tiempo
    dias.forEach(dia => {
        const checkbox = document.getElementById(dia.abierto);
        const apertura = document.getElementById(dia.apertura);
        const cierre = document.getElementById(dia.cierre);
        
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                apertura.disabled = !this.checked;
                cierre.disabled = !this.checked;
                // Actualizar el valor del checkbox para que envíe 1 si está checked
                this.value = this.checked ? '1' : '0';
                actualizarVistaPrevia();
            });
            
            apertura.addEventListener('change', actualizarVistaPrevia);
            cierre.addEventListener('change', actualizarVistaPrevia);
        }
    });
    
    // Actualizar vista previa
    function actualizarVistaPrevia() {
        const vistaPrevia = document.getElementById('vista-previa');
        if (!vistaPrevia) return;
        
        vistaPrevia.innerHTML = '';
        
        const nombreMap = {
            'lunes': 'Lunes', 'martes': 'Martes', 'miercoles': 'Miércoles',
            'jueves': 'Jueves', 'viernes': 'Viernes', 'sabado': 'Sábado', 'domingo': 'Domingo'
        };
        
        dias.forEach(dia => {
            const checkbox = document.getElementById(dia.abierto);
            const apertura = document.getElementById(dia.apertura);
            const cierre = document.getElementById(dia.cierre);
            
            const div = document.createElement('div');
            div.className = 'flex justify-between py-1 border-b border-[#374151]/50 last:border-0';
            
            const nombreDia = document.createElement('span');
            nombreDia.className = 'text-[#9CA3AF]';
            nombreDia.textContent = nombreMap[dia.nombre];
            
            const horario = document.createElement('span');
            
            if (checkbox && checkbox.checked && apertura && cierre && apertura.value && cierre.value) {
                horario.textContent = `${apertura.value} - ${cierre.value}`;
                horario.className = 'text-white';
            } else {
                horario.textContent = 'Cerrado';
                horario.className = 'text-red-400';
            }
            
            div.appendChild(nombreDia);
            div.appendChild(horario);
            vistaPrevia.appendChild(div);
        });
    }
    
    // Envío del formulario
    const horarioForm = document.getElementById('horario-form');
    if (horarioForm) {
        horarioForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            showLoader();
            
            // Construir el array de horarios en el formato que espera la API
            const horarios = [];
            
            dias.forEach(dia => {
                const checkbox = document.getElementById(dia.abierto);
                const apertura = document.getElementById(dia.apertura);
                const cierre = document.getElementById(dia.cierre);
                
                const esAbierto = checkbox && checkbox.checked;
                
                horarios.push({
                    dia_semana: dia.nombre,
                    abierto: esAbierto,
                    hora_apertura: esAbierto && apertura ? apertura.value : null,
                    hora_cierre: esAbierto && cierre ? cierre.value : null,
                    hora_apertura_2: null,
                    hora_cierre_2: null
                });
            });
            
            try {
                const response = await fetch('/api-proxy/api/negocio/horario', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ horarios: horarios })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    showToast('Horario guardado correctamente');
                } else {
                    showToast(data.message || 'Error al guardar el horario');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error de conexión');
            } finally {
                hideLoader();
            }
        });
    }
    
    // Cargar horarios existentes al cargar la página
    async function cargarHorarios() {
        try {
            const response = await fetch('/api-proxy/api/negocio/horarios', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success && data.data) {
                data.data.forEach(horario => {
                    const dia = dias.find(d => d.nombre === horario.dia_semana);
                    if (dia) {
                        const checkbox = document.getElementById(dia.abierto);
                        const apertura = document.getElementById(dia.apertura);
                        const cierre = document.getElementById(dia.cierre);
                        
                        if (checkbox) {
                            checkbox.checked = horario.abierto;
                            checkbox.value = horario.abierto ? '1' : '0';
                            apertura.disabled = !horario.abierto;
                            cierre.disabled = !horario.abierto;
                            
                            if (horario.hora_apertura) {
                                apertura.value = horario.hora_apertura;
                            }
                            if (horario.hora_cierre) {
                                cierre.value = horario.hora_cierre;
                            }
                        }
                    }
                });
                actualizarVistaPrevia();
            }
        } catch (error) {
            console.error('Error al cargar horarios:', error);
        }
    }
    
    cargarHorarios();
});

function resetHorario() {
    if (confirm('¿Deseas restablecer el horario a los valores predeterminados?')) {
        const dias = [
            { nombre: 'lunes', apertura: '09:00', cierre: '18:00', activo: true },
            { nombre: 'martes', apertura: '09:00', cierre: '18:00', activo: true },
            { nombre: 'miercoles', apertura: '09:00', cierre: '18:00', activo: true },
            { nombre: 'jueves', apertura: '09:00', cierre: '18:00', activo: true },
            { nombre: 'viernes', apertura: '09:00', cierre: '18:00', activo: true },
            { nombre: 'sabado', apertura: '09:00', cierre: '14:00', activo: true },
            { nombre: 'domingo', apertura: '09:00', cierre: '14:00', activo: true }
        ];
        
        const idMap = {
            'lunes': { abierto: 'lunes_abierto', apertura: 'lunes_apertura', cierre: 'lunes_cierre' },
            'martes': { abierto: 'martes_abierto', apertura: 'martes_apertura', cierre: 'martes_cierre' },
            'miercoles': { abierto: 'miercoles_abierto', apertura: 'miercoles_apertura', cierre: 'miercoles_cierre' },
            'jueves': { abierto: 'jueves_abierto', apertura: 'jueves_apertura', cierre: 'jueves_cierre' },
            'viernes': { abierto: 'viernes_abierto', apertura: 'viernes_apertura', cierre: 'viernes_cierre' },
            'sabado': { abierto: 'sabado_abierto', apertura: 'sabado_apertura', cierre: 'sabado_cierre' },
            'domingo': { abierto: 'domingo_abierto', apertura: 'domingo_apertura', cierre: 'domingo_cierre' }
        };
        
        dias.forEach(dia => {
            const ids = idMap[dia.nombre];
            if (ids) {
                const checkbox = document.getElementById(ids.abierto);
                const apertura = document.getElementById(ids.apertura);
                const cierre = document.getElementById(ids.cierre);
                
                if (checkbox) {
                    checkbox.checked = dia.activo;
                    checkbox.value = dia.activo ? '1' : '0';
                    apertura.disabled = !dia.activo;
                    cierre.disabled = !dia.activo;
                    apertura.value = dia.apertura;
                    cierre.value = dia.cierre;
                }
            }
        });
        
        actualizarVistaPrevia();
        showToast('Horario restablecido');
    }
}

function actualizarVistaPrevia() {
    const dias = [
        { nombre: 'lunes', abierto: 'lunes_abierto', apertura: 'lunes_apertura', cierre: 'lunes_cierre' },
        { nombre: 'martes', abierto: 'martes_abierto', apertura: 'martes_apertura', cierre: 'martes_cierre' },
        { nombre: 'miercoles', abierto: 'miercoles_abierto', apertura: 'miercoles_apertura', cierre: 'miercoles_cierre' },
        { nombre: 'jueves', abierto: 'jueves_abierto', apertura: 'jueves_apertura', cierre: 'jueves_cierre' },
        { nombre: 'viernes', abierto: 'viernes_abierto', apertura: 'viernes_apertura', cierre: 'viernes_cierre' },
        { nombre: 'sabado', abierto: 'sabado_abierto', apertura: 'sabado_apertura', cierre: 'sabado_cierre' },
        { nombre: 'domingo', abierto: 'domingo_abierto', apertura: 'domingo_apertura', cierre: 'domingo_cierre' }
    ];
    
    const vistaPrevia = document.getElementById('vista-previa');
    if (!vistaPrevia) return;
    
    vistaPrevia.innerHTML = '';
    
    const nombreMap = {
        'lunes': 'Lunes', 'martes': 'Martes', 'miercoles': 'Miércoles',
        'jueves': 'Jueves', 'viernes': 'Viernes', 'sabado': 'Sábado', 'domingo': 'Domingo'
    };
    
    dias.forEach(dia => {
        const checkbox = document.getElementById(dia.abierto);
        const apertura = document.getElementById(dia.apertura);
        const cierre = document.getElementById(dia.cierre);
        
        const div = document.createElement('div');
        div.className = 'flex justify-between py-1 border-b border-[#374151]/50 last:border-0';
        
        const nombreDia = document.createElement('span');
        nombreDia.className = 'text-[#9CA3AF]';
        nombreDia.textContent = nombreMap[dia.nombre];
        
        const horario = document.createElement('span');
        
        if (checkbox && checkbox.checked && apertura && cierre && apertura.value && cierre.value) {
            horario.textContent = `${apertura.value} - ${cierre.value}`;
            horario.className = 'text-white';
        } else {
            horario.textContent = 'Cerrado';
            horario.className = 'text-red-400';
        }
        
        div.appendChild(nombreDia);
        div.appendChild(horario);
        vistaPrevia.appendChild(div);
    });
}
</script>