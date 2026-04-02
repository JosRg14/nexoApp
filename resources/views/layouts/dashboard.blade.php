@php
    $correo = session('usuario.correo') ?? session('usuario');
    $nombre = session('usuario.nombre') ?? session('usuario.nombre_completo');
    $inicial = ($nombre ? substr($nombre, 0, 1) : ($correo ? substr($correo, 0, 1) : '?'));
    $inicial = strtoupper($inicial);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NexoApp - Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
        <a href="{{ url('/') }}" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <div class="flex items-center gap-6">
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                    <span class="text-sm font-bold text-[#F3F4F6] hidden md:block">
                        Hola, {{ session('usuario.primer_nombre') ?? session('usuario.correo') ?? 'Usuario' }}
                    </span>

                    <x-profile-avatar size="small" />
                    
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
                        <p class="text-xs font-bold text-white truncate">{{ session('usuario.nombre_completo') ?? session('usuario.correo') ?? 'Usuario' }}</p>
                    </div>

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
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#262626] border-r border-[#374151]/50 hidden md:flex flex-col">
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard.index') ? 'bg-[#374151] text-white' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2-2V16zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V16z"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Overview</span>
                </a>
                <a href="{{ route('dashboard.businesses') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard.businesses*') ? 'bg-[#374151] text-white' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-15 0V10.5a.75.75 0 01.75-.75h7.5a.75.75 0 01.75.75V21M2 10l10.5-3L22 10" /></svg>
                    <span class="text-sm font-bold tracking-wide">Negocios</span>
                </a>
                <a href="{{ route('dashboard.promotions') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard.promotions*') ? 'bg-[#374151] text-white' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Planes</span>
                </a>
                <a href="{{ route('dashboard.notices') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard.notices*') ? 'bg-[#374151] text-white' : 'text-[#9CA3AF] hover:bg-[#374151]/50 hover:text-white' }} rounded-md transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="text-sm font-bold tracking-wide">Avisos</span>
                </a>
            </nav>
        </aside>

        <!-- Content -->
        <main class="flex-1 overflow-auto p-8">
            @yield('content')
        </main>
    </div>

    <!-- Simple Footer -->
    <footer class="border-t border-[#374151]/30 py-8 bg-black mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="text-[10px] text-[#52525b] tracking-wider uppercase">
                © {{ date('Y') }} NexoApp Inc.
            </div>
        </div>
    </footer>

</body>
</html>
