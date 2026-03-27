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
                <button onclick="resetHorario()" 
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
                            <input type="checkbox" id="lunes_activo" name="lunes_activo" class="w-4 h-4 accent-yellow-500">
                            <label for="lunes_activo" class="text-white font-bold uppercase tracking-wider text-sm">Lunes</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="lunes_apertura" name="lunes_apertura" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="lunes_cierre" name="lunes_cierre" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                </div>
                
                <!-- Martes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="martes_activo" name="martes_activo" class="w-4 h-4 accent-yellow-500">
                            <label for="martes_activo" class="text-white font-bold uppercase tracking-wider text-sm">Martes</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="martes_apertura" name="martes_apertura" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="martes_cierre" name="martes_cierre" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                </div>
                
                <!-- Miércoles -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="miercoles_activo" name="miercoles_activo" class="w-4 h-4 accent-yellow-500">
                            <label for="miercoles_activo" class="text-white font-bold uppercase tracking-wider text-sm">Miércoles</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="miercoles_apertura" name="miercoles_apertura" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="miercoles_cierre" name="miercoles_cierre" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                </div>
                
                <!-- Jueves -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="jueves_activo" name="jueves_activo" class="w-4 h-4 accent-yellow-500">
                            <label for="jueves_activo" class="text-white font-bold uppercase tracking-wider text-sm">Jueves</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="jueves_apertura" name="jueves_apertura" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="jueves_cierre" name="jueves_cierre" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                </div>
                
                <!-- Viernes -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="viernes_activo" name="viernes_activo" class="w-4 h-4 accent-yellow-500">
                            <label for="viernes_activo" class="text-white font-bold uppercase tracking-wider text-sm">Viernes</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="viernes_apertura" name="viernes_apertura" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="viernes_cierre" name="viernes_cierre" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="18:00" disabled>
                        </div>
                    </div>
                </div>
                
                <!-- Sábado -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="sabado_activo" name="sabado_activo" class="w-4 h-4 accent-yellow-500">
                            <label for="sabado_activo" class="text-white font-bold uppercase tracking-wider text-sm">Sábado</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="sabado_apertura" name="sabado_apertura" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="sabado_cierre" name="sabado_cierre" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="14:00" disabled>
                        </div>
                    </div>
                </div>
                
                <!-- Domingo -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="domingo_activo" name="domingo_activo" class="w-4 h-4 accent-yellow-500">
                            <label for="domingo_activo" class="text-white font-bold uppercase tracking-wider text-sm">Domingo</label>
                        </div>
                        <div class="flex gap-3 items-center">
                            <input type="time" id="domingo_apertura" name="domingo_apertura" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF]">a</span>
                            <input type="time" id="domingo_cierre" name="domingo_cierre" 
                                   class="bg-[#262626] border border-[#374151] rounded px-3 py-2 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                   value="14:00" disabled>
                        </div>
                    </div>
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
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    
    // Función para habilitar/deshabilitar inputs de tiempo
    dias.forEach(dia => {
        const checkbox = document.getElementById(`${dia}_activo`);
        const apertura = document.getElementById(`${dia}_apertura`);
        const cierre = document.getElementById(`${dia}_cierre`);
        
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                apertura.disabled = !this.checked;
                cierre.disabled = !this.checked;
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
        
        dias.forEach(dia => {
            const checkbox = document.getElementById(`${dia}_activo`);
            const apertura = document.getElementById(`${dia}_apertura`);
            const cierre = document.getElementById(`${dia}_cierre`);
            
            const div = document.createElement('div');
            div.className = 'flex justify-between py-1 border-b border-[#374151]/50 last:border-0';
            
            const nombreDia = document.createElement('span');
            nombreDia.className = 'text-[#9CA3AF]';
            nombreDia.textContent = dia.charAt(0).toUpperCase() + dia.slice(1);
            
            const horario = document.createElement('span');
            horario.className = 'text-white';
            
            if (checkbox && checkbox.checked && apertura && cierre) {
                horario.textContent = `${apertura.value} - ${cierre.value}`;
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
            
            const formData = new FormData();
            dias.forEach(dia => {
                const checkbox = document.getElementById(`${dia}_activo`);
                const apertura = document.getElementById(`${dia}_apertura`);
                const cierre = document.getElementById(`${dia}_cierre`);
                
                formData.append(`${dia}_activo`, checkbox.checked ? '1' : '0');
                if (checkbox.checked) {
                    formData.append(`${dia}_apertura`, apertura.value);
                    formData.append(`${dia}_cierre`, cierre.value);
                }
            });
            formData.append('_method', 'PUT');
            
            try {
                const response = await fetch('/api-proxy/api/negocio/horario', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
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
});

function resetHorario() {
    if (confirm('¿Deseas restablecer el horario a los valores predeterminados?')) {
        const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        
        dias.forEach(dia => {
            const checkbox = document.getElementById(`${dia}_activo`);
            const apertura = document.getElementById(`${dia}_apertura`);
            const cierre = document.getElementById(`${dia}_cierre`);
            
            if (checkbox) {
                if (dia === 'domingo' || dia === 'sabado') {
                    checkbox.checked = true;
                    apertura.value = '09:00';
                    cierre.value = dia === 'sabado' ? '14:00' : '14:00';
                } else {
                    checkbox.checked = true;
                    apertura.value = '09:00';
                    cierre.value = '18:00';
                }
                apertura.disabled = false;
                cierre.disabled = false;
            }
        });
        
        actualizarVistaPrevia();
        showToast('Horario restablecido');
    }
}

function actualizarVistaPrevia() {
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    const vistaPrevia = document.getElementById('vista-previa');
    if (!vistaPrevia) return;
    
    vistaPrevia.innerHTML = '';
    
    dias.forEach(dia => {
        const checkbox = document.getElementById(`${dia}_activo`);
        const apertura = document.getElementById(`${dia}_apertura`);
        const cierre = document.getElementById(`${dia}_cierre`);
        
        const div = document.createElement('div');
        div.className = 'flex justify-between py-1 border-b border-[#374151]/50 last:border-0';
        
        const nombreDia = document.createElement('span');
        nombreDia.className = 'text-[#9CA3AF]';
        const nombreMap = {
            'lunes': 'Lunes', 'martes': 'Martes', 'miercoles': 'Miércoles',
            'jueves': 'Jueves', 'viernes': 'Viernes', 'sabado': 'Sábado', 'domingo': 'Domingo'
        };
        nombreDia.textContent = nombreMap[dia];
        
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