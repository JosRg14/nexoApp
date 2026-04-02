<header class="w-full border-b border-[#374151]/50 bg-[#1a1a1a] z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center gap-4">

        <div class="flex items-center gap-8">
            <div class="text-xl md:text-2xl font-bold tracking-widest uppercase text-white shrink-0">
                <a href="{{ url('/') }}">NEXOAPP</a>
            </div>
        </div>

        

        <nav class="flex items-center gap-4 justify-end">

            @if(session()->has('rol'))

                @if(session('rol') === 'superusuario')
                    <a href="/dashboard"
                       class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">
                        Dashboard
                    </a>
                @elseif(session('rol') === 'admin')
                    <a href="/business/profile"
                       class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">
                        Tu Negocio
                    </a>
                @endif

                 @if(session('rol') === 'cliente')
                    <a href="{{ route('booking.mis-citas') }}"
                       class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors">
                        Mis Citas
                    </a>
                @endif

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                        @php
                            $nombre_completo = session('usuario.nombre_completo') ?? session('usuario.correo');
                            $primer_nombre = session('usuario.primer_nombre') ?? $nombre_completo;
                            $inicial = strtoupper(substr($nombre_completo, 0, 1));
                        @endphp

                        <!-- Saludo -->
                        <span class="text-sm font-bold text-[#F3F4F6] hidden md:block">
                            Hola, {{ $primer_nombre }}
                        </span>


                        <!-- Avatar con inicial -->
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#374151] to-black flex items-center justify-center text-white font-bold text-sm shadow-lg group-hover:border group-hover:border-white/20 transition-all">
                            {{ $inicial }}
                        </div>
                        
                        <i class="fa-solid fa-chevron-down text-[10px] text-[#9CA3AF] group-hover:text-white transition-colors"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-[#1a1a1a] border border-[#374151] shadow-xl z-50 py-2">
                        
                        <div class="px-4 py-2 border-b border-[#374151]/50 mb-1">
                            <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-1">Usuario</p>
                            <p class="text-xs font-bold text-white truncate">{{ $nombre_completo }}</p>
                        </div>

                         @if(session('rol') === 'cliente')
                        <a href="{{ route('booking.mis-citas') }}" class="block px-4 py-2 text-xs text-[#9CA3AF] hover:text-white hover:bg-[#374151]/30 transition-colors uppercase tracking-widest font-bold">
                            <i class="fa-solid fa-calendar-alt mr-2 w-4"></i> Mis Citas
                        </a>
                        @endif


                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-xs text-[#9CA3AF] hover:text-white hover:bg-[#374151]/30 transition-colors uppercase tracking-widest font-bold">
                            <i class="fa-solid fa-user mr-2 w-4"></i> Mi Perfil
                        </a>

                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-400 hover:text-red-300 hover:bg-[#374151]/30 transition-colors uppercase tracking-widest font-bold">
                                <i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>

            @else

                <a href="/login"
                   class="px-5 py-2.5 bg-[#F3F4F6] text-[#1a1a1a] text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white hover:border hover:border-[#F3F4F6] transition-all duration-300">
                    Iniciar Sesión
                </a>

            @endif

        </nav>
    </div>
</header>