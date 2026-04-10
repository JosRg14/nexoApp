<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NexoApp - @yield('title', 'Inicio')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Custom SweetAlert theme para dark mode
        const swalCustom = Swal.mixin({
            background: '#262626',
            color: '#fff',
            customClass: {
                popup: 'border border-[#374151] rounded-xl',
                confirmButton: 'bg-[#25B5DA] hover:bg-[#1c8fb0] text-black px-4 py-2 rounded-lg font-bold transition-all',
                cancelButton: 'bg-transparent text-[#9CA3AF] hover:text-white px-4 py-2 transition-colors'
            },
            buttonsStyling: false
        });
        window.confirmCustom = function(title, text = '') {
            return swalCustom.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            });
        }
    </script>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

    @include('components.toast')

    {{-- Intercepción de Solicitudes vía API Proxy --}}
    <script>
        document.addEventListener('submit', async function(e) {
            const form = e.target;
            const action = form.getAttribute('action');

            if (action && action.includes('/api-proxy/') && form.getAttribute('data-custom-handler') !== 'true') {
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
                        method: method, // Usamos el método detectado (POST, PUT, DELETE, etc.)
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        },
                        body: formData
                    });

                    if (response.ok) {
                        // Éxito: redirigir o recargar
                        const data = await response.json();
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Operación exitosa', 'success');
                        }
                        if (redirectUrl) {
                            setTimeout(() => { window.location.href = redirectUrl; }, 1000);
                        } else {
                            setTimeout(() => { window.location.reload(); }, 1000);
                        }
                    } else {
                        // Error: NUNCA mostrar JSON en la página
                        let errorMessage = 'Error en la solicitud';
                        try {
                            const data = await response.json();
                            errorMessage = data.message || errorMessage;
                        } catch (e) {
                            errorMessage = `Error ${response.status}: ${response.statusText}`;
                        }
                        // SOLO mostrar toast, NADA más
                        if (typeof showToast === 'function') {
                            showToast(errorMessage, 'error');
                        } else {
                            alert(errorMessage);
                        }
                    }
                } catch (error) {
                    console.error('Submission error:', error);
                    showToast('Error de conexión con el servidor.', 'error');
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
                showToast(msg, 'success');
                sessionStorage.removeItem('success_message');
            }
        });
    </script>
</body>
</html>