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

    {{-- Banner de Promociones (Solo para Clientes) --}}
    @if(session('rol') === 'cliente')
    <div id="promo-banner" class="hidden max-w-7xl mx-auto px-6 mt-4">
        <div class="bg-[#262626] border border-[#25B5DA] rounded-lg p-5 shadow-2xl relative overflow-hidden">
            {{-- Fondo decorativo --}}
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#25B5DA]/10 rounded-full blur-2xl"></div>
            
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#25B5DA]/20 rounded-full flex items-center justify-center text-[#25B5DA]">
                        <i class="fas fa-tags text-lg"></i>
                    </div>
                    <div>
                        <h3 id="promo-banner-title" class="text-white font-bold tracking-wide">¡Tienes promociones activas!</h3>
                        <p class="text-[#9CA3AF] text-xs mt-0.5">Aprovecha estos beneficios exclusivos antes de que venzan.</p>
                    </div>
                </div>
                <button id="close-promo-banner" class="text-[#9CA3AF] hover:text-white transition-colors p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="promo-banner-list" class="space-y-2 mb-5">
                {{-- Se llena vía JS --}}
            </div>

            <div class="flex">
                <a href="/agendar-cita" class="bg-[#25B5DA] hover:bg-[#1c8fb0] text-black text-xs font-bold uppercase tracking-widest px-6 py-2.5 rounded-md transition-all shadow-lg hover:shadow-[#25B5DA]/20">
                    Agendar ahora
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const clienteId = @json(session('usuario.cliente.id_cliente') ?? session('usuario.id'));
            if (!clienteId) return;

            const banner = document.getElementById('promo-banner');
            const list = document.getElementById('promo-banner-list');
            const title = document.getElementById('promo-banner-title');
            const closeBtn = document.getElementById('close-promo-banner');
            const bannerKey = `promo_banner_closed_${clienteId}`;

            // Si ya lo cerró en esta sesión/estado, no mostrar
            if (localStorage.getItem(bannerKey)) return;

            try {
                const response = await fetch('/api-proxy/api/mis-promociones', {
                    headers: { 'Accept': 'application/json' }
                });

                if (response.ok) {
                    const data = await response.json();
                    const promos = data.data || [];
                    
                    // Filtrar solo promociones no usadas y vigentes
                    const activePromos = promos.filter(p => !p.usada);

                    if (activePromos.length > 0) {
                        title.textContent = `¡Tienes ${activePromos.length} ${activePromos.length === 1 ? 'promoción activa' : 'promociones activas'}!`;
                        
                        list.innerHTML = activePromos.slice(0, 2).map(p => {
                            const desc = p.titulo || p.promocion?.nombre || 'Promoción Especial';
                            let fechaVence = p.fecha_vencimiento || p.vigencia_fin || '';
                            if (fechaVence) {
                                const d = new Date(fechaVence);
                                fechaVence = `(vence: ${d.toLocaleDateString('es-CL', { day: '2-digit', month: '2-digit', year: 'numeric' })})`;
                            }
                            const beneficio = p.beneficio_tipo === 'descuento' ? `${p.beneficio_valor}% OFF` : 'Servicio Gratis';
                            
                            return `
                                <div class="flex items-center gap-2 text-sm">
                                    <div class="w-1.5 h-1.5 rounded-full bg-[#25B5DA]"></div>
                                    <span class="text-white font-medium">${beneficio}</span>
                                    <span class="text-[#9CA3AF] text-xs">en ${desc} ${fechaVence}</span>
                                </div>
                            `;
                        }).join('');

                        if (activePromos.length > 2) {
                            list.insertAdjacentHTML('beforeend', `<p class="text-[10px] text-[#9CA3AF] italic pl-3">+ ${activePromos.length - 2} más disponibles</p>`);
                        }

                        banner.classList.remove('hidden');
                    }
                }
            } catch (e) {
                console.error('Error fetching promos for banner:', e);
            }

            closeBtn.addEventListener('click', () => {
                banner.classList.add('hidden');
                localStorage.setItem(bannerKey, 'true');
            });
        });
    </script>
    @endif

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

            if (action && action.includes('/api-proxy/') && form.getAttribute('data-custom-handler') === 'false') {
                e.preventDefault();

                // Siempre POST: PHP no parsea body multipart en PUT/PATCH.
                // El campo _method en el FormData hace el spoofing para Laravel.
                const method = 'POST';

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
                        method: method,
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