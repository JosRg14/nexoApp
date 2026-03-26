@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <!-- Main Content -->
    <main class="flex-grow">
        
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 py-20 md:py-32">
            <div class="max-w-3xl space-y-8 animate-fade-in-up">
                <h1 class="text-5xl md:text-7xl font-bold uppercase tracking-wide text-white leading-tight">
                    Bienvenido a <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-[#374151]">Nexo App!</span>
                </h1>
                
                <p class="text-[#9CA3AF] text-lg leading-relaxed max-w-2xl border-l border-[#374151] pl-6">
                    Conectamos necesidades con soluciones. Descubre una red exclusiva de servicios y negocios curados para ofrecerte la mejor experiencia en tu ciudad. Calidad, rapidez y estilo en un solo lugar.
                </p>
                @if(!session()->has('rol'))
                <div class="pt-4">
                    <a href="/register" class="inline-block py-4 px-10 bg-[#1a1a1a] border border-[#F3F4F6] text-[#F3F4F6] text-sm font-bold uppercase tracking-[0.2em] hover:bg-[#F3F4F6] hover:text-[#1a1a1a] transition-all duration-300">
                        Empezar Ahora
                    </a>
                </div>
                @endif
            </div>
        </section>

        <!-- Filters & Grid -->
        <section class="max-w-7xl mx-auto px-6 pb-24">
            
            <!-- Filter Bar -->
            <div class="flex flex-wrap gap-4 mb-12 border-b border-[#374151] pb-6 items-center justify-between">
                <div class="flex gap-4">
                    <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                        Ordenar
                    </button>
                    <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                        Categoría
                    </button>
                    <button class="px-4 py-1.5 border border-[#374151] text-[#9CA3AF] text-[10px] uppercase tracking-widest hover:border-white hover:text-white transition-all">
                        Precio
                    </button>
                </div>
                <div class="text-[#374151] text-xs uppercase tracking-widest">
                    Mostrando {{ count($negocios) }} resultados
                </div>
            </div>

            <!-- Trends Title -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold uppercase tracking-widest text-white flex items-center gap-4">
                    Tendencias
                    <span class="h-px w-20 bg-[#374151]"></span>
                </h2>
            </div>

            <!-- Grid de Negocios desde API -->
            @if(count($negocios) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($negocios as $negocio)
                <article onclick="window.location.href='/negocio/{{ $negocio['id_negocio'] ?? $negocio['id'] }}'" 
                         class="group relative flex flex-col bg-[#1a1a1a] border border-[#374151]/50 hover:border-[#F3F4F6]/50 transition-all duration-500 cursor-pointer">
                    
                    <!-- Image Area -->
                    <div class="aspect-[4/5] bg-[#0f0f0f] relative overflow-hidden">
                        @if(isset($negocio['foto_perfil']) && $negocio['foto_perfil'])
                            <img src="{{ $negocio['foto_perfil'] }}" 
                                 alt="{{ $negocio['nombre'] }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center opacity-20">
                                <svg class="w-16 h-16 text-[#374151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-transparent group-hover:bg-white/5 transition-colors duration-300"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-white font-bold uppercase tracking-wide text-sm group-hover:text-[#9CA3AF] transition-colors">
                                {{ $negocio['nombre'] }}
                            </h3>
                            <span class="text-[10px] text-[#F3F4F6] bg-[#374151]/50 px-2 py-1 tracking-widest">
                                {{ isset($negocio['calificacion']) ? number_format($negocio['calificacion'], 1) . ' ★' : 'NUEVO' }}
                            </span>
                        </div>
                        <p class="text-[#9CA3AF] text-xs leading-relaxed border-l border-[#374151] pl-3 py-1">
                            {{ $negocio['acerca_de'] ?? 'Descubre los mejores servicios en ' . $negocio['nombre'] }}
                        </p>
                        <div class="mt-3 text-[10px] text-[#9CA3AF] uppercase tracking-wider">
                            {{ ucfirst($negocio['tipo_negocio'] ?? 'Barbería') }}
                        </div>
                    </div>
                    
                    <!-- Hover Action -->
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-[#F3F4F6] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                </article>
                @endforeach
            </div>

            <!-- Contador de resultados al final -->
            <div class="text-center mt-12 text-[#374151] text-xs uppercase tracking-widest">
                Mostrando {{ count($negocios) }} negocios registrados
            </div>

            @else
            <!-- Mensaje cuando no hay negocios -->
            <div class="text-center py-20">
                <div class="text-[#9CA3AF] text-lg mb-4">No hay negocios registrados aún</div>
                <p class="text-[#374151] text-sm">Sé el primero en registrar tu negocio</p>
                @if(!session()->has('rol'))
                <a href="/register" class="inline-block mt-6 py-2 px-6 border border-[#F3F4F6] text-white text-sm hover:bg-white hover:text-black transition-colors">
                    Registrar Negocio
                </a>
                @endif
            </div>
            @endif

        </section>

    </main>

@endsection