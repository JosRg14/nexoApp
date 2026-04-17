<!-- TAB 3: HORARIO LABORAL -->
<section id="tab-schedule" class="hidden animate-fade-in-up">
    <!-- SUB-TABS OVERVIEW -->
    <div class="flex space-x-1 bg-[#0f0f0f] border border-[#374151]/50 p-1 rounded-sm mb-6 inline-flex overflow-x-auto w-full md:w-auto">
        <button type="button" onclick="switchScheduleSubTab('negocio')" id="subtab-btn-negocio" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all bg-[#F3F4F6] text-[#1a1a1a] rounded-sm">
            Horario del Negocio
        </button>
        <button type="button" onclick="switchScheduleSubTab('empleados')" id="subtab-btn-empleados" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white rounded-sm">
            Horario de Empleados
        </button>
        <button type="button" onclick="switchScheduleSubTab('excepciones')" id="subtab-btn-excepciones" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white rounded-sm">
            Excepciones
        </button>
    </div>

    <!-- SUB-TAB: NEGOCIO -->
    <div id="subtab-content-negocio" class="block animate-fade-in-up">
        <div class="flex flex-col gap-8">
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <!-- Horario del Negocio form previously in left col -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold uppercase tracking-wide text-white flex items-center gap-3">
                        <i class="fas fa-building"></i> Horario del Negocio
                    </h2>
                    <button type="button" onclick="resetHorarioNegocio()" class="px-4 py-2 text-xs uppercase tracking-widest border border-[#374151] text-[#9CA3AF] hover:text-white hover:border-white transition-all">
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
                                <input type="checkbox" id="negocio_lunes_abierto" class="negocio-checkbox w-4 h-4 accent-[#25B5DA]">
                                <label for="negocio_lunes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Lunes</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-day="lunes">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_lunes_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[lunes][0][hora_apertura]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[lunes][0][hora_cierre]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="18:00" disabled>
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs" style="display: none;">
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
                                <input type="checkbox" id="negocio_martes_abierto" class="negocio-checkbox w-4 h-4 accent-[#25B5DA]">
                                <label for="negocio_martes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Martes</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-day="martes">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_martes_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[martes][0][hora_apertura]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[martes][0][hora_cierre]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="18:00" disabled>
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs" style="display: none;">
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
                                <input type="checkbox" id="negocio_miercoles_abierto" class="negocio-checkbox w-4 h-4 accent-[#25B5DA]">
                                <label for="negocio_miercoles_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Miércoles</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-day="miercoles">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_miercoles_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[miercoles][0][hora_apertura]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[miercoles][0][hora_cierre]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="18:00" disabled>
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs" style="display: none;">
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
                                <input type="checkbox" id="negocio_jueves_abierto" class="negocio-checkbox w-4 h-4 accent-[#25B5DA]">
                                <label for="negocio_jueves_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Jueves</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-day="jueves">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_jueves_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[jueves][0][hora_apertura]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[jueves][0][hora_cierre]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="18:00" disabled>
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs" style="display: none;">
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
                                <input type="checkbox" id="negocio_viernes_abierto" class="negocio-checkbox w-4 h-4 accent-[#25B5DA]">
                                <label for="negocio_viernes_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Viernes</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-day="viernes">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_viernes_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[viernes][0][hora_apertura]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[viernes][0][hora_cierre]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="18:00" disabled>
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs" style="display: none;">
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
                                <input type="checkbox" id="negocio_sabado_abierto" class="negocio-checkbox w-4 h-4 accent-[#25B5DA]">
                                <label for="negocio_sabado_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Sábado</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-day="sabado">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_sabado_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[sabado][0][hora_apertura]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[sabado][0][hora_cierre]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="14:00" disabled>
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs" style="display: none;">
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
                                <input type="checkbox" id="negocio_domingo_abierto" class="negocio-checkbox w-4 h-4 accent-[#25B5DA]">
                                <label for="negocio_domingo_abierto" class="text-white font-bold uppercase tracking-wider text-sm">Domingo</label>
                            </div>
                            <button type="button" class="agregar-bloque-negocio text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-day="domingo">
                                <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                            </button>
                        </div>
                        <div id="negocio_domingo_bloques" class="bloques-container space-y-2 ml-6">
                            <div class="bloque-horario flex flex-wrap items-center gap-3">
                                <input type="time" name="horarios[domingo][0][hora_apertura]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="09:00" disabled>
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[domingo][0][hora_cierre]" class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none" value="14:00" disabled>
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs" style="display: none;">
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
            
            <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
                <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-eye"></i> Vista Previa - Horario del Negocio
                </h3>
                <div id="vista-previa-negocio" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                    <!-- Dinámico -->
                </div>
                <p class="text-[10px] text-[#9CA3AF] uppercase tracking-widest mt-4 pt-4 border-t border-[#374151]">
                    <i class="fas fa-info-circle mr-1"></i> Los días desactivados se mostrarán como "Cerrado"
                </p>
            </div>
        </div>
    </div>

    <!-- SUB-TAB: EMPLEADOS -->
    <div id="subtab-content-empleados" class="hidden animate-fade-in-up">
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold uppercase tracking-wide text-white flex items-center gap-3">
                    <i class="fas fa-user-clock"></i> Horario del Personal
                </h2>
            </div>
            
            <p class="text-[#9CA3AF] text-xs mb-4">
                Configura horarios específicos para cada empleado. Si no se configura, usarán el horario general del negocio.
            </p>
            
            <div class="space-y-3 max-h-[500px] overflow-y-auto custom-scroll pr-2">
                @forelse($employees as $empleado)
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 hover:border-[#25B5DA]/50 transition-all">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#25B5DA]/20 text-[#25B5DA] rounded-full flex items-center justify-center font-bold">
                                {{ strtoupper(substr($empleado['nombre'], 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-white font-bold">{{ $empleado['nombre'] }}</h4>
                                <p class="text-[#9CA3AF] text-xs">{{ $empleado['especialidad'] ?? 'Empleado' }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="abrirModalHorarioEmpleado({{ $empleado['id_empleado'] }}, '{{ $empleado['nombre'] }}')" class="px-4 py-2 text-xs bg-[#25B5DA]/10 border border-[#25B5DA]/30 text-[#25B5DA] rounded hover:bg-[#25B5DA] hover:text-black transition-all">
                            <i class="fas fa-clock mr-1"></i> Configurar Horario
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-[#9CA3AF]">
                    <i class="fas fa-users text-4xl mb-2 opacity-50"></i>
                    <p>No hay empleados registrados aún.</p>
                    <a href="#" onclick="switchTab('personnel')" class="text-[#25B5DA] text-sm hover:underline mt-2 inline-block">
                        Agregar empleados
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- SUB-TAB: EXCEPCIONES -->
    <div id="subtab-content-excepciones" class="hidden animate-fade-in-up">
        <div class="bg-[#262626] border border-[#374151] rounded-sm p-6">
            <h2 class="text-xl font-bold uppercase tracking-wide text-white flex items-center gap-3 mb-2">
                <i class="fas fa-calendar-times"></i> Excepciones de Horario
            </h2>
            <p class="text-[#9CA3AF] text-xs mb-6">
                Gestiona días no laborales, vacaciones, feriados y horarios especiales. Aplica a todo el negocio o a empleados específicos.
            </p>

            <!-- Filtros & Acciones -->
            <div class="flex flex-col sm:flex-row justify-between items-end sm:items-center gap-4 mb-6 p-4 bg-[#1a1a1a] border border-[#374151] rounded-lg">
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <!-- Filtro Empleados -->
                    <select id="filter-excepcion-empleado" class="bg-[#262626] border border-[#374151] text-white text-xs rounded px-3 py-2 focus:outline-none focus:border-[#25B5DA]">
                        <option value="">Todos los empleados</option>
                        @foreach($employees as $empleado)
                            <option value="{{ $empleado['id_empleado'] }}">{{ $empleado['nombre'] }}</option>
                        @endforeach
                    </select>
                    <!-- Filtro Tipo -->
                    <select id="filter-excepcion-tipo" class="bg-[#262626] border border-[#374151] text-white text-xs rounded px-3 py-2 focus:outline-none focus:border-[#25B5DA]">
                        <option value="">Todos los tipos</option>
                        <option value="feriado">Feriado</option>
                        <option value="vacaciones">Vacaciones</option>
                        <option value="enfermedad">Enfermedad</option>
                        <option value="capacitacion">Capacitación</option>
                        <option value="horario_especial">Horario Especial</option>
                        <option value="bloqueo_agenda">Bloqueo de agenda</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <button type="button" onclick="abrirModalExcepcion()" class="w-full sm:w-auto px-4 py-2 bg-[#25B5DA] text-black text-xs font-bold uppercase tracking-widest rounded hover:bg-[#1c8fb0] transition-colors">
                    <i class="fas fa-plus mr-1"></i> Nueva Excepción
                </button>
            </div>

            <!-- Calendario & Lista -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Columna Izquierda: Calendario -->
                <div class="flex justify-center lg:justify-start">
                    <div class="w-full">
                        <p class="text-xs text-[#9CA3AF] uppercase tracking-widest mb-3">Fecha</p>
                        <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 select-none">
                            <!-- Navegación de mes -->
                            <div class="flex justify-between items-center mb-4">
                                <button type="button" id="prev-month"
                                        class="w-8 h-8 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                                    <i class="fas fa-chevron-left text-xs"></i>
                                </button>
                                <h4 id="current-month" class="text-white font-bold text-sm uppercase tracking-widest"></h4>
                                <button type="button" id="next-month"
                                        class="w-8 h-8 flex items-center justify-center rounded-full text-[#9CA3AF] hover:text-white hover:bg-[#374151] transition-all">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                            <!-- Cabecera días de la semana -->
                            <div class="grid grid-cols-7 gap-1 text-center mb-2">
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Lun</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Mar</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Mié</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Jue</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Vie</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Sáb</div>
                                <div class="text-[10px] text-[#9CA3AF] uppercase tracking-wider py-1">Dom</div>
                            </div>
                            <!-- Cuadrícula de días -->
                            <div id="calendar-days" class="grid grid-cols-7 gap-1"></div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Lista max 10 -->
                <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-4 custom-scroll max-h-[400px] overflow-y-auto">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-white mb-4 border-b border-[#374151]/50 pb-2">Lista de Excepciones</h3>
                    <div id="lista-excepciones" class="space-y-3">
                        <!-- Lista dinámica -->
                        <div class="text-center py-8 text-[#9CA3AF]">
                            <i class="fas fa-spinner fa-spin text-2xl mb-2 opacity-50"></i>
                            <p class="text-xs">Cargando...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal para configurar horario de empleado -->
<div id="modal-empleado-horario" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="cerrarModalHorarioEmpleado()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-6 w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-white font-bold uppercase flex items-center gap-2">
                <i class="fas fa-user-clock"></i> Horario de <span id="empleado-nombre" class="text-[#25B5DA]"></span>
            </h3>
            <button onclick="cerrarModalHorarioEmpleado()" class="text-[#9CA3AF] hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <p class="text-[#9CA3AF] text-xs mb-4">
            Configura los horarios de trabajo para este empleado. 
            <span class="text-[#25B5DA]">✔ Marca "Usar horario propio"</span> para establecer un horario específico. 
            Si no se marca, usará el horario general del negocio.
        </p>
        
        <form id="horario-empleado-form" class="space-y-3">
            @csrf
            <input type="hidden" name="empleado_id" id="empleado_id_input">
            
            <!-- Lunes -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_lunes_activo" class="empleado-checkbox w-4 h-4 accent-[#25B5DA]">
                    <label class="text-white font-bold text-sm">Lunes</label>
                    <span class="text-[10px] text-[#25B5DA] ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_lunes_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_lunes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_lunes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-dia="lunes">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <!-- Martes -->
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-3">
                <div class="flex items-center gap-3 mb-2">
                    <input type="checkbox" id="emp_martes_activo" class="empleado-checkbox w-4 h-4 accent-[#25B5DA]">
                    <label class="text-white font-bold text-sm">Martes</label>
                    <span class="text-[10px] text-[#25B5DA] ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_martes_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_martes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_martes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-dia="martes">
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
                    <input type="checkbox" id="emp_miercoles_activo" class="empleado-checkbox w-4 h-4 accent-[#25B5DA]">
                    <label class="text-white font-bold text-sm">Miércoles</label>
                    <span class="text-[10px] text-[#25B5DA] ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_miercoles_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_miercoles_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_miercoles_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-dia="miercoles">
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
                    <input type="checkbox" id="emp_jueves_activo" class="empleado-checkbox w-4 h-4 accent-[#25B5DA]">
                    <label class="text-white font-bold text-sm">Jueves</label>
                    <span class="text-[10px] text-[#25B5DA] ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_jueves_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_jueves_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_jueves_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-dia="jueves">
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
                    <input type="checkbox" id="emp_viernes_activo" class="empleado-checkbox w-4 h-4 accent-[#25B5DA]">
                    <label class="text-white font-bold text-sm">Viernes</label>
                    <span class="text-[10px] text-[#25B5DA] ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_viernes_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_viernes_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_viernes_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="18:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-dia="viernes">
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
                    <input type="checkbox" id="emp_sabado_activo" class="empleado-checkbox w-4 h-4 accent-[#25B5DA]">
                    <label class="text-white font-bold text-sm">Sábado</label>
                    <span class="text-[10px] text-[#25B5DA] ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_sabado_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_sabado_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_sabado_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="14:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-dia="sabado">
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
                    <input type="checkbox" id="emp_domingo_activo" class="empleado-checkbox w-4 h-4 accent-[#25B5DA]">
                    <label class="text-white font-bold text-sm">Domingo</label>
                    <span class="text-[10px] text-[#25B5DA] ml-auto">
                        <i class="fas fa-check-circle mr-1"></i> Usar horario propio
                    </span>
                </div>
                <div id="emp_domingo_bloques" class="ml-6 space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <input type="time" id="emp_domingo_inicio" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="09:00" disabled>
                        <span class="text-[#9CA3AF]">a</span>
                        <input type="time" id="emp_domingo_fin" class="bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm" value="14:00" disabled>
                        <button type="button" class="agregar-bloque-empleado text-xs text-[#9CA3AF] hover:text-[#25B5DA] transition-colors" data-dia="domingo">
                            <i class="fas fa-plus-circle mr-1"></i> Agregar bloque
                        </button>
                    </div>
                </div>
                <div class="ml-6 mt-2 text-[10px] text-[#52525b]">
                    <i class="fas fa-info-circle"></i> Si no se marca, usará el horario del negocio
                </div>
            </div>
            
            <div class="flex gap-3 mt-6 pt-4 border-t border-[#374151]">
                <button type="submit" class="flex-1 py-2 bg-[#25B5DA] text-black font-bold rounded hover:bg-[#1c8fb0] transition">
                    Guardar Horario
                </button>
                <button type="button" onclick="cerrarModalHorarioEmpleado()" class="flex-1 py-2 border border-[#374151] text-white rounded hover:bg-[#374151] transition">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Excepciones -->
<div id="modal-excepcion-horario" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="cerrarModalExcepcion()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-6 w-full max-w-xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-white font-bold uppercase flex items-center gap-2">
                <i class="fas fa-calendar-plus"></i> <span id="excepcion-modal-title">Nueva Excepción</span>
            </h3>
            <button type="button" onclick="cerrarModalExcepcion()" class="text-[#9CA3AF] hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="excepcion-form" class="space-y-4">
            @csrf
            <input type="hidden" id="excepcion_id_input">
            
            <div>
                <label class="block text-[#9CA3AF] text-xs font-bold uppercase tracking-widest mb-1">Aplica a</label>
                <select id="excepcion_empleado_id" class="w-full bg-[#262626] border border-[#374151] text-white text-sm rounded px-4 py-2 focus:outline-none focus:border-[#25B5DA]">
                    <option value="">Todo el negocio</option>
                    @foreach($employees as $empleado)
                        <option value="{{ $empleado['id_empleado'] }}">{{ $empleado['nombre'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[#9CA3AF] text-xs font-bold uppercase tracking-widest mb-1">Tipo de excepción</label>
                <select id="excepcion_tipo" required onchange="toggleHorarioEspecial()" class="w-full bg-[#262626] border border-[#374151] text-white text-sm rounded px-4 py-2 focus:outline-none focus:border-[#25B5DA]">
                    <option value="">Seleccionar tipo</option>
                    <option value="feriado">Feriado</option>
                    <option value="vacaciones">Vacaciones</option>
                    <option value="enfermedad">Enfermedad</option>
                    <option value="capacitacion">Capacitación</option>
                    <option value="horario_especial">Horario Especial</option>
                    <option value="bloqueo_agenda">Bloqueo de agenda</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#9CA3AF] text-xs font-bold uppercase tracking-widest mb-1">Desde</label>
                    <input type="date" id="excepcion_fecha_inicio" required class="w-full bg-[#262626] border border-[#374151] text-white text-sm rounded px-4 py-2 focus:outline-none focus:border-[#25B5DA]">
                </div>
                <div>
                    <label class="block text-[#9CA3AF] text-xs font-bold uppercase tracking-widest mb-1">Hasta (opcional)</label>
                    <input type="date" id="excepcion_fecha_fin" class="w-full bg-[#262626] border border-[#374151] text-white text-sm rounded px-4 py-2 focus:outline-none focus:border-[#25B5DA]">
                </div>
            </div>

            <div id="excepcion_horario_container" class="hidden grid-cols-2 gap-4 pt-4 border-t border-[#374151]">
                <div>
                    <label class="block text-[#9CA3AF] text-xs font-bold uppercase tracking-widest mb-1">Hora Apertura</label>
                    <input type="time" id="excepcion_hora_inicio" class="w-full bg-[#262626] border border-[#374151] text-white text-sm rounded px-4 py-2 focus:outline-none focus:border-[#25B5DA]">
                </div>
                <div>
                    <label class="block text-[#9CA3AF] text-xs font-bold uppercase tracking-widest mb-1">Hora Cierre</label>
                    <input type="time" id="excepcion_hora_fin" class="w-full bg-[#262626] border border-[#374151] text-white text-sm rounded px-4 py-2 focus:outline-none focus:border-[#25B5DA]">
                </div>
            </div>

            <div>
                <label class="block text-[#9CA3AF] text-xs font-bold uppercase tracking-widest mb-1">Motivo / Descripción (Opcional)</label>
                <textarea id="excepcion_descripcion" rows="2" class="w-full bg-[#262626] border border-[#374151] text-white text-sm rounded px-4 py-2 focus:outline-none focus:border-[#25B5DA] resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-4 border-t border-[#374151]">
                <button type="submit" class="flex-1 py-2 bg-[#25B5DA] text-black font-bold uppercase tracking-widest text-xs rounded hover:bg-[#1c8fb0] transition">
                    Guardar
                </button>
                <button type="button" onclick="cerrarModalExcepcion()" class="flex-1 py-2 border border-[#374151] text-white uppercase tracking-widest text-xs rounded hover:bg-[#374151] transition">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ============================================
// VARIABLES GLOBALES
// ============================================
let empleadoActual = null;

// ============================================
// FUNCIONES DEL HORARIO DEL NEGOCIO
// ============================================

// Función para agregar bloque en horario del negocio
function agregarBloqueNegocio(dia) {
    const container = document.getElementById(`negocio_${dia}_bloques`);
    if (!container) return;
    
    const bloqueCount = container.querySelectorAll('.bloque-horario').length;
    
    const nuevoBloque = document.createElement('div');
    nuevoBloque.className = 'bloque-horario flex flex-wrap items-center gap-3 mt-2';
    nuevoBloque.innerHTML = `
        <input type="time" name="horarios[${dia}][${bloqueCount}][hora_apertura]" 
               class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
               value="16:00">
        <span class="text-[#9CA3AF] text-xs">a</span>
        <input type="time" name="horarios[${dia}][${bloqueCount}][hora_cierre]" 
               class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
               value="20:00">
        <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs">
            <i class="fas fa-trash-alt"></i> Eliminar
        </button>
    `;
    
    const eliminarBtn = nuevoBloque.querySelector('.eliminar-bloque-negocio');
    eliminarBtn.addEventListener('click', function() {
        nuevoBloque.remove();
        reindexarBloquesNegocio(dia);
        actualizarVistaPreviaNegocio();
    });
    
    container.appendChild(nuevoBloque);
    
    nuevoBloque.querySelectorAll('input').forEach(input => {
        input.addEventListener('change', actualizarVistaPreviaNegocio);
    });
    
    actualizarVistaPreviaNegocio();
}

// Reindexar bloques del negocio después de eliminar
function reindexarBloquesNegocio(dia) {
    const container = document.getElementById(`negocio_${dia}_bloques`);
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

// Actualizar vista previa del horario del negocio
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
        div.className = 'flex justify-between py-2 border-b border-[#374151]/50 last:border-0';
        
        const nombreDia = document.createElement('span');
        nombreDia.className = 'text-[#9CA3AF] font-medium';
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

// Cargar horarios del negocio desde la API
async function cargarHorariosNegocio() {
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
                const dia = horario.dia_semana;
                const checkbox = document.getElementById(`negocio_${dia}_abierto`);
                const container = document.getElementById(`negocio_${dia}_bloques`);
                
                if (checkbox && container) {
                    checkbox.checked = horario.abierto;
                    container.innerHTML = '';
                    
                    if (horario.abierto) {
                        const horaApertura = horario.hora_apertura ? horario.hora_apertura.substring(0, 5) : '09:00';
                        const horaCierre = horario.hora_cierre ? horario.hora_cierre.substring(0, 5) : '18:00';
                        
                        const bloque1 = document.createElement('div');
                        bloque1.className = 'bloque-horario flex flex-wrap items-center gap-3';
                        bloque1.innerHTML = `
                            <input type="time" name="horarios[${dia}][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                                   value="${horaApertura}">
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[${dia}][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                                   value="${horaCierre}">
                            <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        `;
                        container.appendChild(bloque1);
                        
                        if (horario.hora_apertura_2 && horario.hora_cierre_2) {
                            const horaApertura2 = horario.hora_apertura_2.substring(0, 5);
                            const horaCierre2 = horario.hora_cierre_2.substring(0, 5);
                            
                            const bloque2 = document.createElement('div');
                            bloque2.className = 'bloque-horario flex flex-wrap items-center gap-3 mt-2';
                            bloque2.innerHTML = `
                                <input type="time" name="horarios[${dia}][1][hora_apertura]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                                       value="${horaApertura2}">
                                <span class="text-[#9CA3AF] text-xs">a</span>
                                <input type="time" name="horarios[${dia}][1][hora_cierre]" 
                                       class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                                       value="${horaCierre2}">
                                <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            `;
                            container.appendChild(bloque2);
                        }
                        
                        container.querySelectorAll('input').forEach(input => {
                            input.disabled = false;
                        });
                        
                        container.querySelectorAll('.eliminar-bloque-negocio').forEach(btn => {
                            btn.addEventListener('click', function() {
                                this.closest('.bloque-horario').remove();
                                reindexarBloquesNegocio(dia);
                                actualizarVistaPreviaNegocio();
                            });
                        });
                    } else {
                        const bloquePlaceholder = document.createElement('div');
                        bloquePlaceholder.className = 'bloque-horario flex flex-wrap items-center gap-3';
                        bloquePlaceholder.innerHTML = `
                            <input type="time" name="horarios[${dia}][0][hora_apertura]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                                   value="09:00" disabled>
                            <span class="text-[#9CA3AF] text-xs">a</span>
                            <input type="time" name="horarios[${dia}][0][hora_cierre]" 
                                   class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                                   value="18:00" disabled>
                        `;
                        container.appendChild(bloquePlaceholder);
                    }
                }
            });
            actualizarVistaPreviaNegocio();
        }
    } catch (error) {
        console.error('Error al cargar horarios del negocio:', error);
    }
}

// Restablecer horario del negocio
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
                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                           value="${apertura}">
                    <span class="text-[#9CA3AF] text-xs">a</span>
                    <input type="time" name="horarios[${dia}][0][hora_cierre]" 
                           class="hora-input bg-[#262626] border border-[#374151] rounded px-3 py-1 text-white text-sm focus:border-[#25B5DA] focus:outline-none"
                           value="${cierre}">
                    <button type="button" class="eliminar-bloque-negocio text-red-500 hover:text-red-400 text-xs">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                `;
                
                container.appendChild(bloque);
                
                container.querySelectorAll('input').forEach(input => {
                    input.disabled = false;
                });
                
                const eliminarBtn = bloque.querySelector('.eliminar-bloque-negocio');
                if (eliminarBtn) {
                    eliminarBtn.addEventListener('click', function() {
                        bloque.remove();
                        reindexarBloquesNegocio(dia);
                        actualizarVistaPreviaNegocio();
                    });
                }
            }
        });
        
        actualizarVistaPreviaNegocio();
        showToast('Horario del negocio restablecido');
    }
}

// ============================================
// FUNCIONES DEL HORARIO DEL EMPLEADO
// ============================================

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

// ============================================
// EVENT LISTENERS
// ============================================

// Event listeners para botones de agregar bloque del negocio
document.querySelectorAll('.agregar-bloque-negocio').forEach(btn => {
    btn.addEventListener('click', function() {
        const dia = this.dataset.day;
        agregarBloqueNegocio(dia);
    });
});

// Activar/desactivar inputs del negocio al cambiar checkbox
document.querySelectorAll('.negocio-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const id = this.id;
        const dia = id.replace('negocio_', '').replace('_abierto', '');
        const container = document.getElementById(`negocio_${dia}_bloques`);
        
        if (container) {
            const inputs = container.querySelectorAll('input');
            inputs.forEach(input => {
                input.disabled = !this.checked;
            });
        }
        actualizarVistaPreviaNegocio();
    });
});

// Event listeners para checkboxes de empleado
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

// Event listeners para agregar bloques de empleado
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
            await cargarHorariosNegocio();
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

// ============================================
// FUNCIONES UTILITARIAS
// ============================================

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

// ============================================
// FUNCIONES SUB-PESTAÑAS & EXCEPCIONES
// ============================================
let fhInicio, fhFin, fCalendario;
let excepcionesList = [];

function switchScheduleSubTab(tab) {
    // Esconder todas las sub-pestañas
    ['negocio', 'empleados', 'excepciones'].forEach(t => {
        document.getElementById('subtab-content-' + t).classList.add('hidden');
        document.getElementById('subtab-content-' + t).classList.remove('block');
        // Quitar estilos activos del botón
        const btn = document.getElementById('subtab-btn-' + t);
        if (btn) {
            btn.classList.remove('bg-[#F3F4F6]', 'text-[#1a1a1a]');
            btn.classList.add('text-[#9CA3AF]', 'bg-transparent');
        }
    });

    // Mostrar activa
    document.getElementById('subtab-content-' + tab).classList.remove('hidden');
    document.getElementById('subtab-content-' + tab).classList.add('block');
    
    // Poner estilos activos al botón
    const btnActivo = document.getElementById('subtab-btn-' + tab);
    if (btnActivo) {
        btnActivo.classList.remove('text-[#9CA3AF]', 'bg-transparent');
        btnActivo.classList.add('bg-[#F3F4F6]', 'text-[#1a1a1a]');
    }

    if (tab === 'excepciones') {
        cargarExcepciones();
    }
}

function initFlatpickr() {
    if (typeof flatpickr !== 'undefined') {
        // Calendario vista principal
        fCalendario = flatpickr("#excepciones-calendario", {
            inline: true,
            locale: "es",
            theme: "dark",
            onChange: function(selectedDates, dateStr, instance) {
                // Filtrar lista por la fecha
                renderListaExcepciones(dateStr);
            },
            onMonthChange: function() {
                // Al cambiar el mes no está filtrando la lista a corto plazo, pero podríamos cargar datos del mes nuevo si pagináramos
            }
        });

        // Modales
        fhInicio = flatpickr("#excepcion_fecha_inicio", {
            locale: "es",
            theme: "dark",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr) {
                fhFin.set('minDate', dateStr);
            }
        });

        fhFin = flatpickr("#excepcion_fecha_fin", {
            locale: "es",
            theme: "dark",
            dateFormat: "Y-m-d"
        });
    }
}

function getColorByType(tipo) {
    const colores = {
        feriado: '#EF4444',
        vacaciones: '#F59E0B',
        horario_especial: '#25B5DA',
        enfermedad: '#6B7280',
        capacitacion: '#6B7280',
        bloqueo_agenda: '#6B7280',
        otro: '#8B5CF6'
    };
    return colores[tipo] || '#9CA3AF';
}

function getLabelByType(tipo) {
    const tipos = {
        feriado: 'Feriado',
        vacaciones: 'Vacaciones',
        horario_especial: 'Horario Especial',
        enfermedad: 'Enfermedad',
        capacitacion: 'Capacitación',
        bloqueo_agenda: 'Bloqueo agenda',
        otro: 'Otro'
    };
    return tipos[tipo] || tipo;
}

function toggleHorarioEspecial() {
    const tipo = document.getElementById('excepcion_tipo').value;
    const container = document.getElementById('excepcion_horario_container');
    const inicio = document.getElementById('excepcion_hora_inicio');
    const fin = document.getElementById('excepcion_hora_fin');
    
    if (tipo === 'horario_especial') {
        container.classList.remove('hidden');
        container.classList.add('grid');
        inicio.required = true;
        fin.required = true;
    } else {
        container.classList.add('hidden');
        container.classList.remove('grid');
        inicio.required = false;
        fin.required = false;
        inicio.value = '';
        fin.value = '';
    }
}

function abrirModalExcepcion(excepcion = null, defaultDate = null) {
    const modal = document.getElementById('modal-excepcion-horario');
    const form = document.getElementById('excepcion-form');
    form.reset();
    document.getElementById('excepcion_id_input').value = '';
    document.getElementById('excepcion-modal-title').innerText = 'Nueva Excepción';
    toggleHorarioEspecial();

    if (defaultDate) {
        document.getElementById('excepcion_fecha_inicio').value = defaultDate;
    }

    if (excepcion) {
        document.getElementById('excepcion-modal-title').innerText = 'Editar Excepción';
        document.getElementById('excepcion_id_input').value = excepcion.id_excepcion;
        document.getElementById('excepcion_empleado_id').value = excepcion.empleado_id || '';
        document.getElementById('excepcion_tipo').value = excepcion.tipo_excepcion;
        
        document.getElementById('excepcion_fecha_inicio').value = excepcion.fecha_inicio || '';
        document.getElementById('excepcion_fecha_fin').value = excepcion.fecha_fin || '';
        
        toggleHorarioEspecial();
        if (excepcion.tipo_excepcion === 'horario_especial') {
            document.getElementById('excepcion_hora_inicio').value = excepcion.hora_inicio || '';
            document.getElementById('excepcion_hora_fin').value = excepcion.hora_fin || '';
        }
        
        document.getElementById('excepcion_descripcion').value = excepcion.descripcion || '';
    }

    modal.classList.remove('hidden');
}

function cerrarModalExcepcion() {
    document.getElementById('modal-excepcion-horario').classList.add('hidden');
}

async function cargarExcepciones() {
    const empFil = document.getElementById('filter-excepcion-empleado').value;
    const tipoFil = document.getElementById('filter-excepcion-tipo').value;

    let url = '/business/exceptions/list?v=' + Date.now();
    if (empFil) url += '&empleado_id=' + empFil;
    if (tipoFil) url += '&tipo_excepcion=' + tipoFil;

    try {
        const res = await fetch(url);
        const data = await res.json();
        
        if (data && data.success && data.data) {
            excepcionesList = data.data;
            renderListaExcepciones();
            renderCalendar(currentDate, excepcionesList);
        } else {
            excepcionesList = [];
            renderListaExcepciones();
            renderCalendar(currentDate, excepcionesList);
        }
    } catch (e) {
        console.error("Error cargando excepciones", e);
    }
}

function renderListaExcepciones(filtroFecha = null) {
    const lista = document.getElementById('lista-excepciones');
    lista.innerHTML = '';

    let filtrados = excepcionesList;
    if (filtroFecha) {
        filtrados = filtrados.filter(e => {
            const fi = e.fecha_inicio;
            const ff = e.fecha_fin || e.fecha_inicio;
            return filtroFecha >= fi && filtroFecha <= ff;
        });
    }

    if (filtrados.length === 0) {
        lista.innerHTML = `<div class="text-center py-4 text-[#9CA3AF] text-xs">No hay excepciones${filtroFecha?' para esta fecha':''}.</div>`;
        return;
    }

    // Top 10
    filtrados.slice(0, 10).forEach(e => {
        const color = getColorByType(e.tipo_excepcion);
        const fi = e.fecha_inicio;
        const ff = e.fecha_fin ? ` al ${e.fecha_fin}` : '';
        const hs = (e.tipo_excepcion === 'horario_especial') ? ` (${e.hora_inicio} a ${e.hora_fin})` : '';
        const owner = e.empleado ? e.empleado.nombre : 'Todo el Negocio';
        
        const item = document.createElement('div');
        item.className = 'flex items-center justify-between p-3 bg-[#262626] border border-[#374151] rounded text-xs';
        item.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full" style="background-color: ${color}"></div>
                <div>
                    <div class="font-bold text-white">${getLabelByType(e.tipo_excepcion)}</div>
                    <div class="text-[#9CA3AF]">${fi}${ff}${hs} • <i class="fas fa-user text-[10px]"></i> ${owner}</div>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="button" class="text-[#25B5DA] hover:text-white transition-colors edit-btn"><i class="fas fa-edit"></i></button>
                <button type="button" class="text-red-500 hover:text-red-400 transition-colors del-btn"><i class="fas fa-trash"></i></button>
            </div>
        `;
        
        item.querySelector('.edit-btn').onclick = () => abrirModalExcepcion(e);
        item.querySelector('.del-btn').onclick = () => eliminarExcepcion(e.id_excepcion);
        
        lista.appendChild(item);
    });
}

// Variables globales para el calendario personalizado
let currentDate = new Date();
let excepcionesData = [];

function renderCalendar(date, excepciones) {
    const calendarDays = document.getElementById('calendar-days');
    const monthEl = document.getElementById('current-month');
    
    if(!calendarDays || !monthEl) return;
    calendarDays.innerHTML = '';
    
    const year = date.getFullYear();
    const month = date.getMonth();
    
    // Nombres de meses simples
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    monthEl.textContent = `${monthNames[month]} ${year}`;
    
    // Primer día del mes
    const firstDay = new Date(year, month, 1);
    // Ajustar para que Lunes sea el primer día de la semana (0) en vez de Domingo (0) del getDay()
    let startingDay = firstDay.getDay() - 1;
    if (startingDay < 0) startingDay = 6;
    
    // Cantidad de días en el mes
    const monthLength = new Date(year, month + 1, 0).getDate();
    
    // Días vacíos iniciales
    for (let i = 0; i < startingDay; i++) {
        const emptyDiv = document.createElement('div');
        emptyDiv.className = 'py-2';
        calendarDays.appendChild(emptyDiv);
    }
    
    // Generar días
    for (let day = 1; day <= monthLength; day++) {
        // String fecha local
        const currentLoopDateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        
        const tieneExcepcion = excepciones.find(e => {
            const fi = e.fecha_inicio;
            const ff = e.fecha_fin || e.fecha_inicio;
            return currentLoopDateStr >= fi && currentLoopDateStr <= ff;
        });

        const dayDiv = document.createElement('div');
        dayDiv.className = `relative py-2 text-center text-xs rounded hover:bg-[#374151] cursor-pointer transition-colors ${tieneExcepcion ? 'font-bold': 'text-white'}`;
        
        // Si el día de hoy
        const today = new Date();
        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
             dayDiv.classList.add('bg-[#262626]', 'border', 'border-[#374151]');
        }
        
        dayDiv.innerHTML = `<span class="text-white text-xs">${day}</span>`;
        if (tieneExcepcion) {
            dayDiv.innerHTML += `<span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full" style="background-color: ${getColorByType(tieneExcepcion.tipo_excepcion)}"></span>`;
        }

        dayDiv.onclick = () => {
             // Abrir modal con la fecha preseleccionada
             abrirModalExcepcion(null, currentLoopDateStr);
             renderListaExcepciones(currentLoopDateStr);
        };
        
        calendarDays.appendChild(dayDiv);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Configurar event listeners del calendario personalizado
    const prevBtn = document.getElementById('prev-month');
    const nextBtn = document.getElementById('next-month');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate, excepcionesList);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate, excepcionesList);
        });
    }
});

async function eliminarExcepcion(id) {
    if(!confirm('¿Seguro que deseas eliminar esta excepción?')) return;
    showLoader();
    try {
        const res = await fetch(`/business/exceptions/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (data.success) {
            showToast('Excepción eliminada');
            cargarExcepciones();
        } else {
            showToast(data.message || 'Error al eliminar');
        }
    } catch(e) {
        showToast('Error de conexión');
    }
    hideLoader();
}

// Event Listeners Adicionales
document.getElementById('filter-excepcion-empleado').addEventListener('change', cargarExcepciones);
document.getElementById('filter-excepcion-tipo').addEventListener('change', cargarExcepciones);

document.getElementById('excepcion-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('excepcion_id_input').value;
    
    const payload = {
        empleado_id: document.getElementById('excepcion_empleado_id').value,
        tipo_excepcion: document.getElementById('excepcion_tipo').value,
        fecha_inicio: document.getElementById('excepcion_fecha_inicio').value,
        fecha_fin: document.getElementById('excepcion_fecha_fin').value,
        hora_inicio: document.getElementById('excepcion_hora_inicio').value,
        hora_fin: document.getElementById('excepcion_hora_fin').value,
        descripcion: document.getElementById('excepcion_descripcion').value,
    };

    let url = '/business/exceptions';
    let method = 'POST';

    if (id) {
        url += `/${id}`;
        method = 'PUT';
    }

    showLoader();
    try {
        const res = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
            showToast('Excepción guardada');
            cerrarModalExcepcion();
            cargarExcepciones();
        } else {
            showToast(data.message || 'Error al guardar');
        }
    } catch(err) {
        showToast('Error de red');
    }
    hideLoader();
});

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarHorariosNegocio();
    actualizarVistaPreviaNegocio();
    renderCalendar(currentDate, excepcionesList);
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