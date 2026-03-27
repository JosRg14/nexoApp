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
                Configura los horarios de atención para cada día. Puedes establecer hasta dos bloques horarios (ej: mañana y tarde).
            </p>
            
            <form id="horario-form" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <!-- Lunes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-gray-500 transition-all">
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="lunes_abierto" class="dia-checkbox w-4 h-4 accent-yellow-500" data-day="lunes">
                            <label for="lunes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Lunes</label>
                        </div>
                        <button type="button" class="agregar-bloque text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="lunes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="lunes-bloques" class="bloques-container space-y-3 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[lunes][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[lunes][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[lunes][dia_semana]" value="lunes">
                </div>
                
                <!-- Martes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-gray-500 transition-all">
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="martes_abierto" class="dia-checkbox w-4 h-4 accent-yellow-500" data-day="martes">
                            <label for="martes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Martes</label>
                        </div>
                        <button type="button" class="agregar-bloque text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="martes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="martes-bloques" class="bloques-container space-y-3 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[martes][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[martes][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[martes][dia_semana]" value="martes">
                </div>
                
                <!-- Miércoles -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-gray-500 transition-all">
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="miercoles_abierto" class="dia-checkbox w-4 h-4 accent-yellow-500" data-day="miercoles">
                            <label for="miercoles_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Miércoles</label>
                        </div>
                        <button type="button" class="agregar-bloque text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="miercoles">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="miercoles-bloques" class="bloques-container space-y-3 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[miercoles][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[miercoles][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[miercoles][dia_semana]" value="miercoles">
                </div>
                
                <!-- Jueves -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-gray-500 transition-all">
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="jueves_abierto" class="dia-checkbox w-4 h-4 accent-yellow-500" data-day="jueves">
                            <label for="jueves_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Jueves</label>
                        </div>
                        <button type="button" class="agregar-bloque text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="jueves">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="jueves-bloques" class="bloques-container space-y-3 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[jueves][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[jueves][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[jueves][dia_semana]" value="jueves">
                </div>
                
                <!-- Viernes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-gray-500 transition-all">
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="viernes_abierto" class="dia-checkbox w-4 h-4 accent-yellow-500" data-day="viernes">
                            <label for="viernes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Viernes</label>
                        </div>
                        <button type="button" class="agregar-bloque text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="viernes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="viernes-bloques" class="bloques-container space-y-3 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[viernes][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[viernes][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[viernes][dia_semana]" value="viernes">
                </div>
                
                <!-- Sábado -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-gray-500 transition-all">
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="sabado_abierto" class="dia-checkbox w-4 h-4 accent-yellow-500" data-day="sabado">
                            <label for="sabado_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Sábado</label>
                        </div>
                        <button type="button" class="agregar-bloque text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="sabado">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="sabado-bloques" class="bloques-container space-y-3 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[sabado][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[sabado][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="14:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[sabado][dia_semana]" value="sabado">
                </div>
                
                <!-- Domingo -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-gray-500 transition-all">
                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="domingo_abierto" class="dia-checkbox w-4 h-4 accent-yellow-500" data-day="domingo">
                            <label for="domingo_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Domingo</label>
                        </div>
                        <button type="button" class="agregar-bloque text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="domingo">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                    <div id="domingo-bloques" class="bloques-container space-y-3 ml-6">
                        <div class="bloque-horario flex flex-wrap items-center gap-3">
                            <input type="time" name="horarios[domingo][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[domingo][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="14:00" disabled>
                            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs opacity-0 group-hover:opacity-100 transition-opacity" style="display: none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="horarios[domingo][dia_semana]" value="domingo">
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
                        <i class="fas fa-info-circle mr-1"></i> Puedes agregar múltiples bloques horarios (ej: 9:00-13:00 y 16:00-20:00)
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Script para manejar bloques horarios flexibles
document.addEventListener('DOMContentLoaded', function() {
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    
    // Función para validar formato de hora HH:MM
    function validarHora(hora) {
        if (!hora) return false;
        return /^([0-1][0-9]|2[0-3]):[0-5][0-9]$/.test(hora);
    }
    
    // Función para agregar un bloque horario
    function agregarBloque(dia) {
        const container = document.getElementById(`${dia}-bloques`);
        const bloqueCount = container.querySelectorAll('.bloque-horario').length;
        
        const nuevoBloque = document.createElement('div');
        nuevoBloque.className = 'bloque-horario flex flex-wrap items-center gap-3 group';
        nuevoBloque.innerHTML = `
            <input type="time" name="horarios[${dia}][${bloqueCount}][hora_apertura]" 
                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                   value="09:00">
            <span class="text-[#9CA3AF] text-xs">a</span>
            <input type="time" name="horarios[${dia}][${bloqueCount}][hora_cierre]" 
                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                   value="18:00">
            <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs transition-opacity">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        `;
        
        const eliminarBtn = nuevoBloque.querySelector('.eliminar-bloque');
        eliminarBtn.addEventListener('click', function() {
            nuevoBloque.remove();
            actualizarVistaPrevia();
            reindexarBloques(dia);
        });
        
        container.appendChild(nuevoBloque);
        
        const inputs = nuevoBloque.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('change', actualizarVistaPrevia);
        });
        
        actualizarVistaPrevia();
    }
    
    // Función para reindexar los bloques después de eliminar
    function reindexarBloques(dia) {
        const container = document.getElementById(`${dia}-bloques`);
        const bloques = container.querySelectorAll('.bloque-horario');
        
        bloques.forEach((bloque, index) => {
            const apertura = bloque.querySelector('input[name*="hora_apertura"]');
            const cierre = bloque.querySelector('input[name*="hora_cierre"]');
            
            if (apertura) {
                apertura.name = `horarios[${dia}][${index}][hora_apertura]`;
            }
            if (cierre) {
                cierre.name = `horarios[${dia}][${index}][hora_cierre]`;
            }
        });
    }
    
    // Configurar eventos para cada día
    dias.forEach(dia => {
        const checkbox = document.getElementById(`${dia}_abierto`);
        const container = document.getElementById(`${dia}-bloques`);
        
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                const inputs = container.querySelectorAll('input');
                inputs.forEach(input => {
                    input.disabled = !this.checked;
                });
                actualizarVistaPrevia();
            });
        }
        
        const agregarBtn = document.querySelector(`.agregar-bloque[data-day="${dia}"]`);
        if (agregarBtn) {
            agregarBtn.addEventListener('click', () => agregarBloque(dia));
        }
        
        const bloques = container.querySelectorAll('.bloque-horario');
        bloques.forEach(bloque => {
            const eliminarBtn = bloque.querySelector('.eliminar-bloque');
            if (eliminarBtn) {
                eliminarBtn.addEventListener('click', function() {
                    bloque.remove();
                    actualizarVistaPrevia();
                    reindexarBloques(dia);
                });
            }
            
            const inputs = bloque.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('change', actualizarVistaPrevia);
            });
        });
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
            const checkbox = document.getElementById(`${dia}_abierto`);
            const container = document.getElementById(`${dia}-bloques`);
            
            const div = document.createElement('div');
            div.className = 'flex justify-between py-1 border-b border-[#374151]/50 last:border-0';
            
            const nombreDia = document.createElement('span');
            nombreDia.className = 'text-[#9CA3AF]';
            nombreDia.textContent = nombreMap[dia];
            
            const horarioSpan = document.createElement('span');
            
            if (checkbox && checkbox.checked) {
                const bloques = container.querySelectorAll('.bloque-horario');
                const horarios = [];
                
                bloques.forEach(bloque => {
                    const apertura = bloque.querySelector('input[name*="hora_apertura"]');
                    const cierre = bloque.querySelector('input[name*="hora_cierre"]');
                    if (apertura && cierre && apertura.value && cierre.value && validarHora(apertura.value) && validarHora(cierre.value)) {
                        horarios.push(`${apertura.value} - ${cierre.value}`);
                    }
                });
                
                if (horarios.length > 0) {
                    horarioSpan.textContent = horarios.join(' · ');
                    horarioSpan.className = 'text-white';
                } else {
                    horarioSpan.textContent = 'Cerrado';
                    horarioSpan.className = 'text-red-400';
                }
            } else {
                horarioSpan.textContent = 'Cerrado';
                horarioSpan.className = 'text-red-400';
            }
            
            div.appendChild(nombreDia);
            div.appendChild(horarioSpan);
            vistaPrevia.appendChild(div);
        });
    }
    
    // Envío del formulario
    const horarioForm = document.getElementById('horario-form');
    if (horarioForm) {
        horarioForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            showLoader();
            
            const horarios = [];
            let tieneError = false;
            
            for (const dia of dias) {
                const checkbox = document.getElementById(`${dia}_abierto`);
                const container = document.getElementById(`${dia}-bloques`);
                const bloques = container.querySelectorAll('.bloque-horario');
                
                if (checkbox && checkbox.checked && bloques.length > 0) {
                    let bloqueIndex = 0;
                    for (const bloque of bloques) {
                        const apertura = bloque.querySelector('input[name*="hora_apertura"]');
                        const cierre = bloque.querySelector('input[name*="hora_cierre"]');
                        
                        if (apertura && cierre) {
                            const horaApertura = apertura.value;
                            const horaCierre = cierre.value;
                            
                            if (!horaApertura || !horaCierre) {
                                continue;
                            }
                            
                            if (!validarHora(horaApertura) || !validarHora(horaCierre)) {
                                showToast(`Formato de hora inválido para ${dia}. Use formato HH:MM (ej: 09:00)`);
                                tieneError = true;
                                return;
                            }
                            
                            if (bloqueIndex === 0) {
                                horarios.push({
                                    dia_semana: dia,
                                    abierto: true,
                                    hora_apertura: horaApertura,
                                    hora_cierre: horaCierre,
                                    hora_apertura_2: null,
                                    hora_cierre_2: null
                                });
                            } else if (bloqueIndex === 1) {
                                const existing = horarios.find(h => h.dia_semana === dia);
                                if (existing) {
                                    existing.hora_apertura_2 = horaApertura;
                                    existing.hora_cierre_2 = horaCierre;
                                } else {
                                    horarios.push({
                                        dia_semana: dia,
                                        abierto: true,
                                        hora_apertura: null,
                                        hora_cierre: null,
                                        hora_apertura_2: horaApertura,
                                        hora_cierre_2: horaCierre
                                    });
                                }
                            }
                            bloqueIndex++;
                        }
                    }
                } else {
                    horarios.push({
                        dia_semana: dia,
                        abierto: false,
                        hora_apertura: null,
                        hora_cierre: null,
                        hora_apertura_2: null,
                        hora_cierre_2: null
                    });
                }
            }
            
            if (tieneError) {
                hideLoader();
                return;
            }
            
            try {
                const response = await fetch('/api-proxy/negocio/horario', {
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
            const response = await fetch('/api-proxy/negocio/horarios', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success && data.data) {
                data.data.forEach(horario => {
                    const checkbox = document.getElementById(`${horario.dia_semana}_abierto`);
                    const container = document.getElementById(`${horario.dia_semana}-bloques`);
                    
                    if (checkbox && container) {
                        checkbox.checked = horario.abierto;
                        container.innerHTML = '';
                        
                        if (horario.abierto) {
                            const bloque1 = document.createElement('div');
                            bloque1.className = 'bloque-horario flex flex-wrap items-center gap-3 group';
                            bloque1.innerHTML = `
                                <input type="time" name="horarios[${horario.dia_semana}][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="${horario.hora_apertura || '09:00'}">
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[${horario.dia_semana}][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="${horario.hora_cierre || '18:00'}">
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs transition-opacity">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            `;
                            container.appendChild(bloque1);
                            
                            if (horario.hora_apertura_2 && horario.hora_cierre_2) {
                                const bloque2 = document.createElement('div');
                                bloque2.className = 'bloque-horario flex flex-wrap items-center gap-3 group';
                                bloque2.innerHTML = `
                                    <input type="time" name="horarios[${horario.dia_semana}][1][hora_apertura]" 
                                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                           value="${horario.hora_apertura_2}">
                                    <span class="text-[#9CA3AF] text-xs">a</span>
                                    <input type="time" name="horarios[${horario.dia_semana}][1][hora_cierre]" 
                                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                           value="${horario.hora_cierre_2}">
                                    <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs transition-opacity">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                `;
                                container.appendChild(bloque2);
                            }
                            
                            container.querySelectorAll('input').forEach(input => {
                                input.disabled = false;
                            });
                            
                            container.querySelectorAll('.bloque-horario').forEach(bloque => {
                                const eliminarBtn = bloque.querySelector('.eliminar-bloque');
                                if (eliminarBtn) {
                                    eliminarBtn.addEventListener('click', function() {
                                        bloque.remove();
                                        reindexarBloques(horario.dia_semana);
                                        actualizarVistaPrevia();
                                    });
                                }
                                bloque.querySelectorAll('input').forEach(input => {
                                    input.addEventListener('change', actualizarVistaPrevia);
                                });
                            });
                        } else {
                            const bloquePlaceholder = document.createElement('div');
                            bloquePlaceholder.className = 'bloque-horario flex flex-wrap items-center gap-3';
                            bloquePlaceholder.innerHTML = `
                                <input type="time" name="horarios[${horario.dia_semana}][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[${horario.dia_semana}][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="18:00" disabled>
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs transition-opacity" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            `;
                            container.appendChild(bloquePlaceholder);
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
        const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        
        dias.forEach(dia => {
            const checkbox = document.getElementById(`${dia}_abierto`);
            const container = document.getElementById(`${dia}-bloques`);
            
            if (checkbox && container) {
                checkbox.checked = true;
                container.innerHTML = '';
                
                const bloque = document.createElement('div');
                bloque.className = 'bloque-horario flex flex-wrap items-center gap-3 group';
                
                let apertura = '09:00';
                let cierre = dia === 'sabado' || dia === 'domingo' ? '14:00' : '18:00';
                
                bloque.innerHTML = `
                    <input type="time" name="horarios[${dia}][0][hora_apertura]" 
                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                           value="${apertura}">
                    <span class="text-[#9CA3AF] text-xs">a</span>
                    <input type="time" name="horarios[${dia}][0][hora_cierre]" 
                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                           value="${cierre}">
                    <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs transition-opacity">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                `;
                
                container.appendChild(bloque);
                
                container.querySelectorAll('input').forEach(input => {
                    input.disabled = false;
                });
                
                const eliminarBtn = bloque.querySelector('.eliminar-bloque');
                if (eliminarBtn) {
                    eliminarBtn.addEventListener('click', function() {
                        bloque.remove();
                        reindexarBloques(dia);
                        actualizarVistaPrevia();
                    });
                }
                bloque.querySelectorAll('input').forEach(input => {
                    input.addEventListener('change', actualizarVistaPrevia);
                });
            }
        });
        
        actualizarVistaPrevia();
        showToast('Horario restablecido');
    }
}

function reindexarBloques(dia) {
    const container = document.getElementById(`${dia}-bloques`);
    const bloques = container.querySelectorAll('.bloque-horario');
    
    bloques.forEach((bloque, index) => {
        const apertura = bloque.querySelector('input[name*="hora_apertura"]');
        const cierre = bloque.querySelector('input[name*="hora_cierre"]');
        
        if (apertura) {
            apertura.name = `horarios[${dia}][${index}][hora_apertura]`;
        }
        if (cierre) {
            cierre.name = `horarios[${dia}][${index}][hora_cierre]`;
        }
    });
}

function actualizarVistaPrevia() {
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    const vistaPrevia = document.getElementById('vista-previa');
    if (!vistaPrevia) return;
    
    vistaPrevia.innerHTML = '';
    
    const nombreMap = {
        'lunes': 'Lunes', 'martes': 'Martes', 'miercoles': 'Miércoles',
        'jueves': 'Jueves', 'viernes': 'Viernes', 'sabado': 'Sábado', 'domingo': 'Domingo'
    };
    
    function validarHora(hora) {
        if (!hora) return false;
        return /^([0-1][0-9]|2[0-3]):[0-5][0-9]$/.test(hora);
    }
    
    dias.forEach(dia => {
        const checkbox = document.getElementById(`${dia}_abierto`);
        const container = document.getElementById(`${dia}-bloques`);
        
        const div = document.createElement('div');
        div.className = 'flex justify-between py-1 border-b border-[#374151]/50 last:border-0';
        
        const nombreDia = document.createElement('span');
        nombreDia.className = 'text-[#9CA3AF]';
        nombreDia.textContent = nombreMap[dia];
        
        const horarioSpan = document.createElement('span');
        
        if (checkbox && checkbox.checked && container) {
            const bloques = container.querySelectorAll('.bloque-horario');
            const horarios = [];
            
            bloques.forEach(bloque => {
                const apertura = bloque.querySelector('input[name*="hora_apertura"]');
                const cierre = bloque.querySelector('input[name*="hora_cierre"]');
                if (apertura && cierre && apertura.value && cierre.value && validarHora(apertura.value) && validarHora(cierre.value)) {
                    horarios.push(`${apertura.value} - ${cierre.value}`);
                }
            });
            
            if (horarios.length > 0) {
                horarioSpan.textContent = horarios.join(' · ');
                horarioSpan.className = 'text-white';
            } else {
                horarioSpan.textContent = 'Cerrado';
                horarioSpan.className = 'text-red-400';
            }
        } else {
            horarioSpan.textContent = 'Cerrado';
            horarioSpan.className = 'text-red-400';
        }
        
        div.appendChild(nombreDia);
        div.appendChild(horarioSpan);
        vistaPrevia.appendChild(div);
    });
}
</script>