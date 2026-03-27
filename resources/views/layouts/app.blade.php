<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - @yield('title', 'Inicio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    {{-- Top Banner --}}
    <div class="bg-black py-2 text-center">
        <p class="text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF]">
            Bienvenido a NexoApp
        </p>
    </div>

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Contenido dinámico --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Intercepción de Solicitudes vía API Proxy --}}
    <script>
        document.addEventListener('submit', async function(e) {
            const form = e.target;
            const action = form.getAttribute('action');

            if (action && action.includes('/api-proxy/') && !form.hasAttribute('data-custom-handler')) {
                e.preventDefault();

                let method = form.getAttribute('method') || 'POST';
                const methodOverride = form.querySelector('input[name="_method"]');
                if (methodOverride) {
                    method = methodOverride.value;
                }

                const submitBtn = form.querySelector('button[type="submit"]');
                let originalBtnContent = '';
                if (submitBtn) {
                    originalBtnContent = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Cargando...';
                }

                const formData = new FormData(form);
                const redirectUrl = form.getAttribute('data-redirect');

                try {
                    const response = await fetch(action, {
                        method: 'POST', // Usamos POST siempre; Laravel detecta el spoofing con _method en FormData.
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || form.querySelector('input[name="_token"]')?.value
                        },
                        body: formData
                    });

                    // Intentar parsear JSON
                    let data = {};
                    try {
                        data = await response.json();
                    } catch (parseErr) {
                        data = { message: 'Error procesando respuesta del servidor' };
                    }

                    if (response.ok) {
                        // Success
                        sessionStorage.setItem('success_message', data.message || 'Operación exitosa');
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else {
                            window.location.reload();
                        }
                    } else {
                        // Error
                        alert(data.message || 'Ocurrió un error en la solicitud.');
                    }
                } catch (error) {
                    console.error('Submission error:', error);
                    alert('Error de conexión con el servidor.');
                } finally {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnContent;
                    }
                }
            }
        });

        // Revisar y notificar mensajes de éxito post-redirección
        document.addEventListener('DOMContentLoaded', () => {
            const msg = sessionStorage.getItem('success_message');
            if (msg) {
                alert(msg); // O puedes reemplazarlo con un Toast
                sessionStorage.removeItem('success_message');
            }
        });
    </script>
</body>
</html>