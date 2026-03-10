<!-- TAB 4: PERSONAL -->
<section id="tab-personnel" class="hidden animate-fade-in-up">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-bold uppercase tracking-wide text-white">Equipo de Trabajo</h2>
        <button id="btn-add-employee" class="bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors rounded-sm">
            + Agregar Empleado
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Employee Card 1 -->
        <div class="bg-[#262626] border border-[#374151]/50 p-6 flex items-center justify-between group hover:border-[#F3F4F6]/30 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-white font-bold text-lg border border-[#4B5563]">J</div>
                <div>
                    <h3 class="text-white font-bold text-sm">Juan Pérez</h3>
                    <p class="text-[#9CA3AF] text-xs">Barbero Senior</p>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">Activo</span>
                <div class="flex gap-2">
                    <button class="text-[#9CA3AF] hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                    <button class="text-[#9CA3AF] hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Employee Card 2 -->
        <div class="bg-[#262626] border border-[#374151]/50 p-6 flex items-center justify-between group hover:border-[#F3F4F6]/30 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-white font-bold text-lg border border-[#4B5563]">C</div>
                <div>
                    <h3 class="text-white font-bold text-sm">Carlos Ruiz</h3>
                    <p class="text-[#9CA3AF] text-xs">Estilista</p>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">Inactivo</span>
                <div class="flex gap-2">
                    <button class="text-[#9CA3AF] hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                    <button class="text-[#9CA3AF] hover:text-red-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Agregar Empleado -->
<div id="modal-add-employee" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="toggleModal('modal-add-employee', false)"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-[#1a1a1a] border border-[#374151] shadow-2xl rounded-sm p-8 animate-fade-in-up">
        <div class="flex flex-col items-center mb-6">
            <h3 class="text-xl font-bold uppercase tracking-wide text-white mb-4">Nuevo Empleado</h3>
        </div>
        <form class="space-y-6" onsubmit="event.preventDefault(); toggleModal('modal-add-employee', false);">
            <div>
                <h4 class="text-[#9CA3AF] text-xs uppercase tracking-widest mb-4">Información Personal</h4>
                <div class="group/input relative mb-4">
                    <input type="text" id="emp_name" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Nombre Completo" />
                    <label for="emp_name" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Nombre Completo</label>
                </div>
                <div class="group/input relative">
                    <input type="tel" id="emp_phone" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Teléfono" />
                    <label for="emp_phone" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Teléfono</label>
                </div>
            </div>
            <div>
                <h4 class="text-[#9CA3AF] text-xs uppercase tracking-widest mb-4 mt-6">Detalles del Cargo</h4>
                <div class="group/input relative mb-4">
                    <input type="text" id="emp_role_text" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Cargo (ej. Barbero)" />
                    <label for="emp_role_text" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Cargo (ej. Barbero, Recepcionista)</label>
                </div>
                <div class="group/input relative mb-6">
                    <input type="number" id="emp_commission" class="peer w-full bg-transparent border-b border-[#374151] py-2 text-white placeholder-transparent focus:border-white focus:outline-none transition-colors" placeholder="Comisión (%)" />
                    <label for="emp_commission" class="absolute left-0 -top-3.5 text-xs text-[#9CA3AF] transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-[#9CA3AF] peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Comisión (%)</label>
                </div>
                <div class="bg-[#262626] p-4 rounded-sm flex items-center justify-between border border-[#374151]/50">
                    <span class="text-white text-sm font-bold">Estado Activo</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full bg-white text-black py-3 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors rounded-sm shadow-lg">Crear Empleado</button>
                <button type="button" onclick="toggleModal('modal-add-employee', false)" class="w-full mt-2 text-[#9CA3AF] py-2 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors">Cancelar</button>
            </div>
        </form>
    </div>
</div>
