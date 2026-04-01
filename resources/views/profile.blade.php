@extends('layouts.app')

@section('title', 'Mi Perfil')



@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    
    <div class="mb-12">
        <h1 class="text-4xl font-bold uppercase tracking-wide text-white mb-2">Mi Perfil</h1>
        <p class="text-[#9CA3AF] text-sm tracking-wide">GESTIONA TU INFORMACIÓN PERSONAL</p>
    </div>

    <div class="bg-[#262626] border border-[#374151] shadow-2xl overflow-hidden">
        <div class="md:flex">
            <!-- Left Side: Profile Side -->
            <div class="md:w-1/3 bg-[#1a1a1a] p-8 flex flex-col items-center border-r border-[#374151]">
                <div class="mb-6 shadow-2xl rounded-full">
                    <x-profile-avatar size="large" />
                </div>
                <h2 class="text-xl font-bold text-white text-center mb-1">{{ $usuario['nombre_completo'] ?? $usuario['nombre'] ?? 'Usuario' }}</h2>
                <div class="px-3 py-1 bg-white/10 rounded-full">
                    <span class="text-[10px] uppercase tracking-widest text-[#9CA3AF] font-bold">{{ $rol }}</span>
                </div>
            </div>

            <!-- Right Side: Details -->
            <div class="md:w-2/3 p-8 lg:p-12 space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-1 font-bold">Nombre Completo</p>
                        <p class="text-white font-medium">{{ $usuario['nombre_completo'] ?? $usuario['nombre'] ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-1 font-bold">Correo Electrónico</p>
                        <p class="text-white font-medium">{{ $usuario['correo'] ?? 'No disponible' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-1 font-bold">Teléfono</p>
                        <p class="text-white font-medium">{{ $usuario['telefono'] ?? 'No especificado' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-1 font-bold">Rol en el Sistema</p>
                        <p class="text-white font-medium capitalize">{{ $rol }}</p>
                    </div>
                </div>

                <div class="pt-8 border-t border-[#374151]">
                    <button class="px-8 py-3 bg-[#F3F4F6] text-[#1a1a1a] text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white hover:border hover:border-[#F3F4F6] transition-all duration-300">
                        Editar Perfil
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Additional Info Cards if needed -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#262626] border border-[#374151] p-6">
            <i class="fa-solid fa-shield-halved text-2xl text-[#9CA3AF] mb-4"></i>
            <h3 class="text-white font-bold text-xs uppercase tracking-widest mb-2">Seguridad</h3>
            <p class="text-[#9CA3AF] text-xs">Tu cuenta está protegida por una contraseña fuerte y autenticación segura.</p>
        </div>
        <div class="bg-[#262626] border border-[#374151] p-6">
            <i class="fa-solid fa-clock-rotate-left text-2xl text-[#9CA3AF] mb-4"></i>
            <h3 class="text-white font-bold text-xs uppercase tracking-widest mb-2">Actividad</h3>
            <p class="text-[#9CA3AF] text-xs">Puedes ver tu historial de reservas y servicios contratados desde aquí.</p>
        </div>
        <div class="bg-[#262626] border border-[#374151] p-6">
            <i class="fa-solid fa-bell text-2xl text-[#9CA3AF] mb-4"></i>
            <h3 class="text-white font-bold text-xs uppercase tracking-widest mb-2">Notificaciones</h3>
            <p class="text-[#9CA3AF] text-xs">Administra cómo quieres recibir las alertas de tus servicios.</p>
        </div>
    </div>

</div>
@endsection
