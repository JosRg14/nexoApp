<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil en Validación | NEXOAPP</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0a0a0a] text-white">

    <div class="flex min-h-screen items-center justify-center px-6">
        <div class="max-w-md w-full text-center space-y-8">

            <!-- Icono de Reloj con Animación -->
            <div class="flex justify-center">
                <div class="relative">
                    <div class="w-24 h-24 border-2 border-gray-800 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 animate-pulse"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-white rounded-full blur-sm opacity-20"></div>
                </div>
            </div>

            <!-- Cabecera -->
            <div class="space-y-3">
                <h1 class="text-2xl font-black uppercase tracking-[0.2em]">Perfil en Validación</h1>
                <p class="text-gray-500 text-xs uppercase tracking-widest leading-relaxed">
                    Estamos revisando los detalles de <span
                        class="text-white">"{{ $suscripcion['negocio_nombre'] ?? 'tu negocio' }}"</span> y la activación
                    de tu plan <span class="text-white">{{ $suscripcion['plan_nombre'] ?? 'seleccionado' }}</span>.
                </p>
            </div>

            <!-- Información de tiempos -->
            <div class="bg-[#111] border border-gray-900 p-6 rounded-sm space-y-4">
                <div class="flex items-start space-x-3 text-left">
                    <div class="mt-1">
                        <div class="w-2 h-2 bg-white rounded-full"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">
                        Tu acceso será habilitado en un lapso de <span class="text-white">12 a 24 horas</span> hábiles.
                    </p>
                </div>
                <div class="flex items-start space-x-3 text-left">
                    <div class="mt-1">
                        <div class="w-2 h-2 bg-gray-700 rounded-full"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-tighter">
                        Recibirás una notificación en <span
                            class="text-white">{{ auth()->user()->email ?? 'tu correo' }}</span> cuando todo esté listo.
                    </p>
                </div>
            </div>

            <!-- Acciones -->
            <div class="flex flex-col space-y-4 pt-4">
                <a href="https://wa.me/522381703277?text=Hola,%20aquí%20envío%20mi%20comprobante" target="_blank"
                    rel="noopener noreferrer"
                    class="inline-block bg-white text-black py-4 px-6 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition-all text-center">
                    Enviar comprobante por WhatsApp
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="text-gray-600 hover:text-white text-[10px] uppercase tracking-widest transition-colors">
                        ← Salir de la cuenta
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="pt-12">
                <p class="text-[9px] text-gray-800 uppercase tracking-[0.5em]">NEXOAPP • SISTEMA DE GESTIÓN</p>
            </div>
        </div>
    </div>

</body>

</html>
