<footer class="bg-[#1a1a1a] border-t border-[#374151] py-12 mt-auto">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo y descripción -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="NexoApp Logo" class="h-8 opacity-80" onerror="this.outerHTML='<div class=\'w-8 h-8 rounded bg-[#25B5DA] flex items-center justify-center\'><span class=\'text-black font-bold text-lg\'>N</span></div>'">
                    <span class="text-xl font-bold uppercase tracking-widest text-white">Nexo App</span>
                </div>
                <p class="text-[#9CA3AF] text-xs leading-relaxed">Conectamos necesidades con soluciones. La mejor experiencia en servicios.</p>
                <div class="flex items-center gap-4 mt-6">
                    <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-instagram text-base"></i></a>
                    <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-facebook text-base"></i></a>
                    <a href="#" class="text-[#9CA3AF] hover:text-[#25B5DA] transition-colors"><i class="fab fa-twitter text-base"></i></a>
                </div>
            </div>
            
            <!-- Enlaces -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4 border-l-2 border-[#25B5DA] pl-2">NexoApp</h4>
                <ul class="space-y-3 text-[#9CA3AF] text-xs">
                    <li><a href="/" class="hover:text-[#25B5DA] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#25B5DA]"></i> Inicio</a></li>
                    <li><a href="/negocios" class="hover:text-[#25B5DA] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#25B5DA]"></i> Negocios</a></li>
                    <li><a href="/register" class="hover:text-[#25B5DA] transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-[#25B5DA]"></i> Registrarse</a></li>
                </ul>
            </div>
            
            <!-- Contacto -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4 border-l-2 border-[#25B5DA] pl-2">Contacto</h4>
                <ul class="space-y-3 text-[#9CA3AF] text-xs">
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-[#25B5DA]"></i> 
                        contacto@nexoapp.com
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone-alt text-[#25B5DA]"></i> 
                        +52 (123) 456-7890
                    </li>
                </ul>
            </div>
            
            <!-- Estadísticas (opcional, desde API) -->
            <div>
                <h4 class="text-white text-sm font-bold uppercase tracking-wider mb-4 border-l-2 border-[#25B5DA] pl-2">Plataforma</h4>
                <ul class="space-y-3 text-[#9CA3AF] text-xs font-medium">
                    <li class="flex items-center gap-2">
                        <span class="text-[#25B5DA] font-bold">{{ $stats['negocios'] ?? '250+' }}</span> Negocios
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#25B5DA] font-bold">{{ $stats['clientes'] ?? '10K+' }}</span> Clientes
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#25B5DA] font-bold">{{ $stats['citas'] ?? '50K+' }}</span> Citas
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-[#374151] mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-[#9CA3AF] text-[10px] tracking-wider uppercase">
            <div>
                © {{ date('Y') }} NexoApp. Todos los derechos reservados.
            </div>
            <div class="mt-4 md:mt-0 flex gap-4">
                <a href="#" class="hover:text-[#25B5DA] transition-colors">Términos</a>
                <a href="#" class="hover:text-[#25B5DA] transition-colors">Privacidad</a>
            </div>
        </div>
    </div>
</footer>