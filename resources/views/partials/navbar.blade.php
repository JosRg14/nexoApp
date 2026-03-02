<header class="w-full border-b border-[#374151]/50 sticky top-0 bg-[#1a1a1a]/95 backdrop-blur-sm z-50">
    <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col md:flex-row justify-between items-center gap-6">

        <div class="flex items-center w-full md:w-auto gap-8">
            <div class="text-2xl font-bold tracking-widest uppercase text-white shrink-0">
                NEXOAPP
            </div>
        </div>

        <nav class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">

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


<div class="flex items-center gap-3">

    @php
        $correo = session('usuario.correo') ?? session('usuario');
        $inicial = $correo ? strtoupper(substr($correo, 0, 1)) : '?';
        $correoCorto = $correo ? substr($correo, 0, 12) . '...' : '';
    @endphp

    <!-- Avatar con inicial -->
    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#374151] to-black flex items-center justify-center text-white font-bold text-sm shadow-lg">
        {{ $inicial }}
    </div>

    <!-- Correo corto -->
    <span class="text-xs text-[#9CA3AF] tracking-wide">
        {{ $correoCorto }}
    </span>

</div>
                
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 bg-[#F3F4F6] text-[#1a1a1a] text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white hover:border hover:border-[#F3F4F6] transition-all duration-300">
                        Cerrar Sesión
                    </button>
                </form>

            @else

                <a href="/login"
                   class="px-5 py-2.5 bg-[#F3F4F6] text-[#1a1a1a] text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white hover:border hover:border-[#F3F4F6] transition-all duration-300">
                    Iniciar Sesión
                </a>

            @endif

        </nav>
    </div>
</header>