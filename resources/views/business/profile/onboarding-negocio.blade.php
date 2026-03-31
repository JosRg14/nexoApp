<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXOAPP - Configura tu Negocio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#111111] text-white antialiased font-sans">

    <div class="flex min-h-screen">
        <!-- LADO IZQUIERDO: FORMULARIO -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 md:px-24 py-12">

            <div class="mb-10">
                <h1 class="text-4xl font-bold uppercase tracking-tighter italic">NEXO<span
                        class="text-gray-500 text-2xl not-italic ml-2">APP</span></h1>
                <div class="h-1 w-12 bg-white mt-2"></div>
                <h2 class="text-2xl font-bold uppercase mt-8 tracking-wider">Configura tu Negocio</h2>
                <p class="text-[#9CA3AF] mt-2 uppercase text-xs tracking-[0.2em]">Paso 2 de 2: Detalles y Plan</p>
            </div>

            <form action="{{ route('registro.negocio.save') }}" method="POST" class="space-y-10">
                @csrf

                <!-- Nombre del Negocio (Mismo estilo que tu código) -->
                <div class="group/input relative">
                    <input type="text" name="nombre" id="nombre" required placeholder="Nombre del Negocio"
                        class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" />
                    <label for="nombre"
                        class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                        Nombre del Negocio *
                    </label>
                </div>

                <!-- Tipo de Negocio (Mismo estilo que tu código) -->
                <div class="group/input relative">
                    <select name="tipo_negocio" id="tipo_negocio" required
                        class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors appearance-none cursor-pointer">
                        <option value="" disabled selected class="bg-[#1a1a1a]">Selecciona un tipo</option>
                        <option value="barberia" class="bg-[#1a1a1a]">Barbería</option>
                        <option value="salon" class="bg-[#1a1a1a]">Salón</option>
                        <option value="spa" class="bg-[#1a1a1a]">Spa</option>
                        <option value="otros" class="bg-[#1a1a1a]">Otros</option>
                    </select>
                    <label for="tipo_negocio" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">
                        Tipo de Negocio *
                    </label>
                    <div class="absolute right-0 top-3.5 pointer-events-none text-[#9CA3AF]">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <!-- SELECCIÓN DE PLANES -->
                <div class="space-y-4">
                    <label class="text-xs uppercase tracking-widest text-[#9CA3AF]">Selecciona tu Plan</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($planes as $plan)
                            <label class="relative cursor-pointer group">
                                <!-- Usamos 'id' porque así viene de tu map en el controlador -->
                                <input type="radio" name="plan_id" value="{{ $plan['id'] }}" class="peer sr-only"
                                    {{ $loop->first ? 'checked' : '' }}>

                                <div
                                    class="p-4 bg-[#1a1a1a] border border-[#374151]/50 transition-all duration-300 peer-checked:border-white peer-checked:bg-[#222] group-hover:border-gray-500">
                                    <div class="flex justify-between items-center mb-1">
                                        <!-- CAMBIO: 'nombre' por 'tipo' -->
                                        <span
                                            class="text-xs font-bold uppercase tracking-tighter">{{ $plan['tipo'] }}</span>
                                        <div
                                            class="w-2 h-2 rounded-full border border-[#374151] peer-checked:bg-white bg-transparent">
                                        </div>
                                    </div>
                                    <div class="text-xl font-black italic">
                                        <!-- CAMBIO: 'precio' por 'costo' -->
                                        ${{ number_format($plan['costo'], 0) }}
                                        <!-- Agregamos la duración que también viene en tu API -->
                                        <span class="text-[10px] text-gray-500 not-italic uppercase tracking-tighter">/
                                            {{ $plan['duracion'] }}</span>
                                    </div>
                                </div>
                            </label>
                        @empty
                            <p class="text-xs text-red-500 uppercase">No hay planes disponibles.</p>
                        @endforelse
                    </div>
                </div>

                <!-- BOTÓN (Mismo estilo que tu botón "Guardar Cambios") -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-[0.2em] uppercase text-sm border border-transparent transition-all duration-300 hover:bg-white hover:shadow-[0_0_20px_rgba(255,255,255,0.2)]">
                        Finalizar Registro
                    </button>
                </div>
            </form>
        </div>

        <!-- LADO DERECHO: DECORATIVO (Estilo NEXOAPP) -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-[#0a0a0a] items-center justify-center relative overflow-hidden border-l border-[#374151]/30">
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent">
            </div>
            <div class="relative z-10 text-center">
                <h2 class="text-[150px] font-black text-white/[0.03] tracking-tighter select-none leading-none">NEXO
                </h2>
                <div class="text-xs tracking-[1em] text-gray-600 uppercase mt-[-40px]">Management System</div>
            </div>
        </div>
    </div>

</body>

</html>
