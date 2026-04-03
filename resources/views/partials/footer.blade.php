<footer class="bg-[#1a1a1a] border-t border-[#374151] py-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Grid responsivo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            
            <!-- Logo y descripción -->
            <div class="text-center sm:text-left">
                <div class="flex items-center justify-center sm:justify-start gap-3 mb-4">
                    <img src="{{ asset('logo.png') }}" alt="NexoApp Logo" class="h-8 opacity-80" onerror="this.outerHTML='<div class=\'w-8 h-8 rounded bg-[#25B5DA] flex items-center justify-center\'><span class=\'text-black font-bold text-lg\'>N</span></div>'">
                    <span class="text-lg sm:text-xl font-bold uppercase tracking-widest text-white">Nexo App</span>
                </div>
                <p class="text-[#9CA3AF] text-xs leading-relaxed max-w-xs mx-auto sm:mx-0">Conectamos necesidades con soluciones. La mejor experiencia en servicios.</p>
                <div class="flex items-center justify-center sm:justify-start gap-4 mt-6">
                    <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-instagram text-base"></i></a>
                    <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-facebook text-base"></i></a>
                    <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-twitter text-base"></i></a>
                </div>
            </div>
            
            <!-- Enlaces -->
            <div class="text-center sm:text-left">
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4 border-l-2 border-[#25B5DA] pl-2 inline-block sm:inline-block">NexoApp</h4>
                <ul class="space-y-3 text-[#9CA3AF] text-xs mt-4">
                    <li><a href="/" class="hover:text-[#25B5DA] transition-colors flex items-center justify-center sm:justify-start gap-2"><i class="fas fa-chevron-right text-[8px] text-[#25B5DA]"></i> Inicio</a></li>
                    <li><a href="#destacados" class="hover:text-[#25B5DA] transition-colors flex items-center justify-center sm:justify-start gap-2"><i class="fas fa-chevron-right text-[8px] text-[#25B5DA]"></i> Negocios</a></li>
                    <li><a href="/register" class="hover:text-[#25B5DA] transition-colors flex items-center justify-center sm:justify-start gap-2"><i class="fas fa-chevron-right text-[8px] text-[#25B5DA]"></i> Registrarse</a></li>
                </ul>
            </div>
            
            <!-- Contacto -->
            <div class="text-center sm:text-left">
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4 border-l-2 border-[#25B5DA] pl-2 inline-block sm:inline-block">Contacto</h4>
                <ul class="space-y-3 text-[#9CA3AF] text-xs mt-4">
                    <li class="flex items-center justify-center sm:justify-start gap-3">
                        <i class="fas fa-envelope text-[#25B5DA]"></i> 
                        <span class="break-all">contactodevlinkoficial@gmail.com</span>
                    </li>
                    <li class="flex items-center justify-center sm:justify-start gap-3">
                        <i class="fas fa-phone-alt text-[#25B5DA]"></i> 
                        +52 (123) 456-7890
                    </li>
                </ul>
            </div>
            
            <!-- Ventajas -->
            <div class="text-center sm:text-left">
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4 border-l-2 border-[#25B5DA] pl-2 inline-block sm:inline-block">Ventajas</h4>
                <ul class="space-y-3 text-[#9CA3AF] text-xs mt-4">
                    <li class="flex items-center justify-center sm:justify-start gap-2">
                        <i class="fas fa-clock text-[#25B5DA] text-xs"></i>
                        Reserva en minutos
                    </li>
                    <li class="flex items-center justify-center sm:justify-start gap-2">
                        <i class="fas fa-star text-[#25B5DA] text-xs"></i>
                        Calificación real
                    </li>
                    <li class="flex items-center justify-center sm:justify-start gap-2">
                        <i class="fas fa-shield-alt text-[#25B5DA] text-xs"></i>
                        Seguridad garantizada
                    </li>
                    <li class="flex items-center justify-center sm:justify-start gap-2">
                        <i class="fas fa-headset text-[#25B5DA] text-xs"></i>
                        Atención personalizada
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright - Responsivo -->
        <div class="border-t border-[#374151] mt-10 pt-8 flex flex-col md:flex-row justify-between items-center text-[#9CA3AF] text-[10px] tracking-wider uppercase gap-4">
            <div class="text-center md:text-left">
                © {{ date('Y') }} 
                <span onclick="openTeamModal()" class="cursor-pointer hover:text-[#25B5DA] transition-colors border-b border-dotted border-[#374151] hover:border-[#25B5DA]">DevLink</span>
                . Todos los derechos reservados.
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-[#25B5DA] transition-colors">Términos</a>
                <a href="#" class="hover:text-[#25B5DA] transition-colors">Privacidad</a>
            </div>
        </div>
    </div>
</footer>

<!-- Modal del equipo de desarrollo (responsivo) -->
<div id="teamModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50 p-4" onclick="closeTeamModal()">
    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-5 sm:p-6 max-w-sm w-full mx-auto shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-[#25B5DA] flex items-center justify-center">
                    <i class="fas fa-code text-black text-sm"></i>
                </div>
                <h3 class="text-white font-bold uppercase tracking-wide text-sm sm:text-base">Equipo DevLink</h3>
            </div>
            <button onclick="closeTeamModal()" class="text-[#9CA3AF] hover:text-white transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <div class="space-y-2">
            <div class="flex items-center gap-3 p-3 bg-[#262626] rounded-lg border border-[#374151]">
                <div class="w-10 h-10 rounded-full bg-[#25B5DA]/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-code text-[#25B5DA] text-sm"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Betanzo Alva Abimael Enrique</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 p-3 bg-[#262626] rounded-lg border border-[#374151]">
                <div class="w-10 h-10 rounded-full bg-[#25B5DA]/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-database text-[#25B5DA] text-sm"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Ginez Pérez Josué Iván</p>
                </div>
            </div>

            <div class="flex items-center gap-3 p-3 bg-[#262626] rounded-lg border border-[#374151]">
                <div class="w-10 h-10 rounded-full bg-[#25B5DA]/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-palette text-[#25B5DA] text-sm"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">González Martínez Josué Rubén</p>
                </div>
            </div>

            <div class="flex items-center gap-3 p-3 bg-[#262626] rounded-lg border border-[#374151]">
                <div class="w-10 h-10 rounded-full bg-[#25B5DA]/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lock text-[#25B5DA] text-sm"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Gonzalez Contreras Osbaldo</p>
                </div>
            </div>

            <div class="flex items-center gap-3 p-3 bg-[#262626] rounded-lg border border-[#374151]">
                <div class="w-10 h-10 rounded-full bg-[#25B5DA]/20 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-cog text-[#25B5DA] text-sm"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Morales Martínez Alan</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
function openTeamModal() {
    const modal = document.getElementById('teamModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    // Prevenir scroll del body
    document.body.style.overflow = 'hidden';
}

function closeTeamModal() {
    const modal = document.getElementById('teamModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    // Restaurar scroll del body
    document.body.style.overflow = '';
}

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeTeamModal();
    }
});
</script>