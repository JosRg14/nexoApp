<!-- TAB 3: HORARIO LABORAL -->
<section id="tab-schedule" class="hidden animate-fade-in-up">
    <div class="flex flex-col gap-8">
        
        <!-- Dos columnas: Horario del Negocio y Horario del Personal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Columna Izquierda: Horario del Negocio -->
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
                
                <form id="horario-negocio-form" class="space-y-3 max-h-[500px] overflow-y-auto custom-scroll pr-2">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    
                    <!-- Lunes -->
                    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="negocio_lunes_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500">
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
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="horarios[lunes][dia_semana]" value="lunes">
                    </div>
                    
                    <!-- Martes -->
                    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="negocio_martes_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500">
                                <label for="negocio_martes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Martes</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="martes">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_martes_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[martes][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[martes][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="18:00" disabled>
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="horarios[martes][dia_semana]" value="martes">
                    </div>
                    
                    <!-- Miércoles -->
                    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="negocio_miercoles_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500">
                                <label for="negocio_miercoles_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Miércoles</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="miercoles">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_miercoles_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[miercoles][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[miercoles][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="18:00" disabled>
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="horarios[miercoles][dia_semana]" value="miercoles">
                    </div>
                    
                    <!-- Jueves -->
                    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="negocio_jueves_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500">
                                <label for="negocio_jueves_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Jueves</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="jueves">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_jueves_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[jueves][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[jueves][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="18:00" disabled>
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="horarios[jueves][dia_semana]" value="jueves">
                    </div>
                    
                    <!-- Viernes -->
                    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="negocio_viernes_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500">
                                <label for="negocio_viernes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Viernes</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="viernes">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_viernes_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[viernes][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[viernes][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="18:00" disabled>
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="horarios[viernes][dia_semana]" value="viernes">
                    </div>
                    
                    <!-- Sábado -->
                    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="negocio_sabado_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500">
                                <label for="negocio_sabado_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Sábado</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="sabado">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_sabado_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[sabado][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[sabado][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="14:00" disabled>
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="horarios[sabado][dia_semana]" value="sabado">
                    </div>
                    
                    <!-- Domingo -->
                    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                        <div class="flex flex-wrap items-center gap-4 mb-2">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="negocio_domingo_abierto" class="negocio-checkbox w-4 h-4 accent-yellow-500">
                                <label for="negocio_domingo_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Domingo</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-day="domingo">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_domingo_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[domingo][0][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[domingo][0][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                                       value="14:00" disabled>
                                <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs" style="display: none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="horarios[domingo][dia_semana]" value="domingo">
                    </div>
                    
                    <button type="submit" class="mt-4 w-full py-2 bg-[#1a1a1a] text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#F3F4F6] hover:text-[#1a1a1a]">
                        Guardar Horario del Negocio
                    </button>
                </form>
            </div>
            
            <!-- Columna Derecha: Horario del Personal -->
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
                <div class="space-y-3 max-h-[500px] overflow-y-auto custom-scroll pr-2">
                    @forelse($employees as $empleado)
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
        </div>
        
        <!-- Vista previa del horario (abajo) -->
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
            <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                <i class="fas fa-eye"></i> Vista Previa - Horario del Negocio
            </h3>
            <div id="vista-previa-negocio" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <!-- Lunes -->
                <div class="flex justify-between py-2 border-b border-[#374151]/50">
                    <span class="text-[#9CA3AF] font-medium">Lunes</span>
                    <span class="text-white">09:00 - 18:00</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#374151]/50">
                    <span class="text-[#9CA3AF] font-medium">Martes</span>
                    <span class="text-white">09:00 - 18:00</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#374151]/50">
                    <span class="text-[#9CA3AF] font-medium">Miércoles</span>
                    <span class="text-white">09:00 - 18:00</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#374151]/50">
                    <span class="text-[#9CA3AF] font-medium">Jueves</span>
                    <span class="text-white">09:00 - 18:00</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#374151]/50">
                    <span class="text-[#9CA3AF] font-medium">Viernes</span>
                    <span class="text-white">09:00 - 18:00</span>
                </div>
                <div class="flex justify-between py-2 border-b border-[#374151]/50">
                    <span class="text-[#9CA3AF] font-medium">Sábado</span>
                    <span class="text-white">09:00 - 14:00</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-[#9CA3AF] font-medium">Domingo</span>
                    <span class="text-white">09:00 - 14:00</span>
                </div>
            </div>
            <p class="text-[10px] text-[#9CA3AF] uppercase tracking-widest mt-4 pt-4 border-t border-[#374151]">
                <i class="fas fa-info-circle mr-1"></i> Los días desactivados se mostrarán como "Cerrado"
            </p>
        </div>
    </div>
</section>

<!-- Modal para configurar horario de empleado -->
<div id="modal-empleado-horario" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="cerrarModalHorarioEmpleado()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-6 w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-white font-bold uppercase flex items-center gap-2">
                <i class="fas fa-user-clock"></i> Horario de <span id="empleado-nombre" class="text-yellow-500"></span>
            </h3>
            <button onclick="cerrarModalHorarioEmpleado()" class="text-[#9CA3AF] hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <p class="text-[#9CA3AF] text-xs mb-4">
            Configura los horarios de trabajo para este empleado. 
            <span class="text-yellow-500">✔ Marca "Usar horario propio"</span> para establecer un horario específico. 
            Si no se marca, usará el horario general del negocio.
        </p>
        
        <form id="horario-empleado-form" class="space-y-3">
            @csrf
            <input type="hidden" name="empleado_id" id="empleado_id_input">
            
            <!-- Lunes -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_lunes_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Lunes</label>
                    <span class="text-[10px] text-yellow-500 ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_lunes_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_lunes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_lunes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="lunes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div id="emp_lunes_extra" class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <!-- Martes -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_martes_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Martes</label>
                    <span class="text-[10px] text-yellow-500 ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_martes_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_martes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_martes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="martes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <!-- Miércoles -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_miercoles_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Miércoles</label>
                    <span class="text-[10px] text-yellow-500 ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_miercoles_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_miercoles_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_miercoles_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="miercoles">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <!-- Jueves -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_jueves_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Jueves</label>
                    <span class="text-[10px] text-yellow-500 ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_jueves_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_jueves_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_jueves_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="jueves">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <!-- Viernes -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_viernes_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Viernes</label>
                    <span class="text-[10px] text-yellow-500 ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_viernes_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_viernes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_viernes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="viernes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <!-- Sábado -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_sabado_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Sábado</label>
                    <span class="text-[10px] text-yellow-500 ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_sabado_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_sabado_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_sabado_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="14:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="sabado">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <!-- Domingo -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_domingo_activo" class="empleado-checkbox w-4 h-4 accent-yellow-500">
                    <label class="text-white font-bold text-sm">Domingo</label>
                    <span class="text-[10px] text-yellow-500 ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_domingo_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_domingo_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_domingo_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="14:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-yellow-500 transition-colors" data-dia="domingo">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
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
                    if (inicio && fin) {
                        inicio.disabled = !activo;
                        fin.disabled = !activo;
                    }
                    
                    if (activo && horario.hora_inicio && horario.hora_fin) {
                        inicio.value = horario.hora_inicio.substring(0, 5);
                        fin.value = horario.hora_fin.substring(0, 5);
                    } else {
                        // Valores por defecto si no hay horario guardado
                        inicio.value = '09:00';
                        fin.value = dia === 'sabado' || dia === 'domingo' ? '14:00' : '18:00';
                    }
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
        
        // Si el checkbox está marcado, usamos horario propio
        if (checkbox && checkbox.checked) {
            horarios.push({
                dia_semana: dia,
                activo: true,
                hora_inicio: inicio?.value || null,
                hora_fin: fin?.value || null,
                hora_inicio_2: null,
                hora_fin_2: null
            });
        } else {
            // No usar horario propio - la API lo manejará como null
            horarios.push({
                dia_semana: dia,
                activo: false,
                hora_inicio: null,
                hora_fin: null,
                hora_inicio_2: null,
                hora_fin_2: null
            });
        }
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
            showToast('Horario del empleado guardado correctamente');
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

function resetHorarioNegocio() {
    if (confirm('¿Deseas restablecer el horario del negocio a los valores predeterminados?')) {
        const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        
        dias.forEach(dia => {
            const checkbox = document.getElementById(`negocio_${dia}_abierto`);
            const container = document.getElementById(`negocio_${dia}_bloques`);
            
            if (checkbox && container) {
                checkbox.checked = true;
                container.innerHTML = '';
                
                const bloque = document.createElement('div');
                bloque.className = 'bloque-horario flex flex-wrap items-center gap-3';
                
                let apertura = '09:00';
                let cierre = (dia === 'sabado' || dia === 'domingo') ? '14:00' : '18:00';
                
                bloque.innerHTML = `
                    <input type="time" name="horarios[${dia}][0][hora_apertura]" 
                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                           value="${apertura}">
                    <span class="text-[#9CA3AF] text-xs">a</span>
                    <input type="time" name="horarios[${dia}][0][hora_cierre]" 
                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-yellow-500 focus:outline-none"
                           value="${cierre}">
                    <button type="button" class="eliminar-bloque text-red-500 hover:text-red-400 text-xs">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                `;
                
                container.appendChild(bloque);
                
                container.querySelectorAll('input').forEach(input => {
                    input.disabled = false;
                });
            }
        });
        
        actualizarVistaPreviaNegocio();
        showToast('Horario del negocio restablecido');
    }
}

function actualizarVistaPreviaNegocio() {
    const vistaPrevia = document.getElementById('vista-previa-negocio');
    if (!vistaPrevia) return;
    
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    const nombreMap = {
        'lunes': 'Lunes', 'martes': 'Martes', 'miercoles': 'Miércoles',
        'jueves': 'Jueves', 'viernes': 'Viernes', 'sabado': 'Sábado', 'domingo': 'Domingo'
    };
    
    vistaPrevia.innerHTML = '';
    
    dias.forEach(dia => {
        const checkbox = document.getElementById(`negocio_${dia}_abierto`);
        const container = document.getElementById(`negocio_${dia}_bloques`);
        
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
                if (apertura && cierre && apertura.value && cierre.value) {
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

// Guardar horario del negocio
document.getElementById('horario-negocio-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    const horarios = [];
    
    for (const dia of dias) {
        const checkbox = document.getElementById(`negocio_${dia}_abierto`);
        const container = document.getElementById(`negocio_${dia}_bloques`);
        const bloques = container.querySelectorAll('.bloque-horario');
        
        if (checkbox && checkbox.checked) {
            const primerBloque = bloques[0];
            const segundoBloque = bloques[1];
            
            if (primerBloque) {
                let apertura = primerBloque.querySelector('input[name*="hora_apertura"]');
                let cierre = primerBloque.querySelector('input[name*="hora_cierre"]');
                
                let horaApertura = apertura ? (apertura.value || '09:00') : '09:00';
                let horaCierre = cierre ? (cierre.value || '18:00') : '18:00';
                
                horaApertura = horaApertura.substring(0, 5);
                horaCierre = horaCierre.substring(0, 5);
                
                const horarioBase = {
                    dia_semana: dia,
                    abierto: true,
                    hora_apertura: horaApertura,
                    hora_cierre: horaCierre,
                    hora_apertura_2: null,
                    hora_cierre_2: null
                };
                
                if (segundoBloque) {
                    let apertura2 = segundoBloque.querySelector('input[name*="hora_apertura"]');
                    let cierre2 = segundoBloque.querySelector('input[name*="hora_cierre"]');
                    
                    if (apertura2 && cierre2 && apertura2.value && cierre2.value) {
                        horarioBase.hora_apertura_2 = apertura2.value.substring(0, 5);
                        horarioBase.hora_cierre_2 = cierre2.value.substring(0, 5);
                    }
                }
                
                horarios.push(horarioBase);
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
    
    showLoader();
    
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
            actualizarVistaPreviaNegocio();
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

function showToast(message) {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.innerText = message;
        toast.classList.remove('hidden');
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            toast.style.transition = 'all 0.3s ease';
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300);
        }, 3000);
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

// Inicializar vista previa al cargar
document.addEventListener('DOMContentLoaded', function() {
    actualizarVistaPreviaNegocio();
});
</script>

<style>
.custom-scroll::-webkit-scrollbar {
    width: 4px;
}
.custom-scroll::-webkit-scrollbar-track {
    background: #374151;
    border-radius: 10px;
}
.custom-scroll::-webkit-scrollbar-thumb {
    background: #9CA3AF;
    border-radius: 10px;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
    background: #F3F4F6;
}
.bloque-horario-empleado {
    transition: all 0.2s ease;
}
</style>