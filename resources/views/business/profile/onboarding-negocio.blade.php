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

    <div class="flex min-h-screen relative bg-[#111111]">
        
        <!-- FONDO DECORATIVO ABSOLUTO -->
        <div class="fixed inset-0 z-0 flex items-center justify-center overflow-hidden pointer-events-none">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
            <div class="relative z-10 text-center">
                <h2 class="text-[100px] md:text-[180px] font-black text-white/[0.03] tracking-tighter select-none leading-none">NEXO</h2>
                <div class="text-[8px] md:text-sm tracking-[1em] md:tracking-[2em] text-gray-600 uppercase mt-[-20px] md:mt-[-50px]">Management System</div>
            </div>
        </div>

        <!-- FORMULARIO AL CENTRO -->
        <div class="w-full max-w-2xl mx-auto flex flex-col justify-center px-8 md:px-12 py-12 relative z-10">

            <div class="mb-10 text-center flex flex-col items-center">
                <h1 class="text-4xl font-bold uppercase tracking-tighter italic">NEXO<span
                        class="text-gray-500 text-2xl not-italic ml-2">APP</span></h1>
                <div class="h-1 w-12 bg-[#25B5DA] mt-4 mb-6"></div>
                <h2 class="text-2xl font-bold uppercase tracking-wider">Configura tu Negocio</h2>
                <p class="text-[#9CA3AF] mt-2 uppercase text-xs tracking-[0.2em]">Paso 2 de 2: Detalles y Plan</p>
            </div>

            <div class="bg-[#1a1a1a] p-8 md:p-12 rounded-2xl border border-[#374151]/50 shadow-2xl backdrop-blur-xl">
                <form id="onboarding-form" action="{{ route('payment.checkout.from.register.process') }}" method="POST" class="space-y-10">
                    @csrf

                    {{-- Campos ocultos de sincronización --}}
                    <input type="hidden" name="nombre" id="nombre_hidden">
                    <input type="hidden" name="tipo_negocio" id="tipo_hidden">
                    <input type="hidden" name="metodo_pago" id="metodo_pago_hidden" value="stripe">
                    <input type="hidden" name="price_id" id="price_id_hidden">

                    <!-- Nombre del Negocio -->
                    <div class="group/input relative">
                        <input type="text" id="nombre_visible" required placeholder="Nombre del Negocio"
                            class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" />
                        <label for="nombre_visible"
                            class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                            Nombre del Negocio *
                        </label>
                    </div>

                    <!-- Tipo de Negocio -->
                    <div class="group/input relative">
                        <select id="tipo_visible" required
                            class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors appearance-none cursor-pointer">
                            <option value="" disabled selected class="bg-[#1a1a1a]">Selecciona un tipo</option>
                            <option value="barberia" class="bg-[#1a1a1a]">Barbería</option>
                            <option value="salon" class="bg-[#1a1a1a]">Salón</option>
                            <option value="spa" class="bg-[#1a1a1a]">Spa</option>
                            <option value="otros" class="bg-[#1a1a1a]">Otros</option>
                        </select>
                        <label for="tipo_visible" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">
                            Tipo de Negocio *
                        </label>
                        <div class="absolute right-0 top-3.5 pointer-events-none text-[#9CA3AF]">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>

                    <!-- ── MÉTODO DE PAGO ───────────────────────── -->
                    <div class="space-y-3">
                        <label class="text-xs uppercase tracking-widest text-[#9CA3AF]">Método de Pago</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                            {{-- Opción: Stripe --}}
                            <label id="opt-stripe" class="relative cursor-pointer group">
                                <input type="radio" name="metodo_ui" value="stripe" class="peer sr-only" checked>
                                <div class="p-4 bg-[#111] border border-white/80 rounded-lg transition-all duration-300 group-hover:border-white h-full">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fab fa-stripe text-[#635bff] text-xl"></i>
                                        <span class="text-xs font-black uppercase tracking-wider">Stripe</span>
                                    </div>
                                    <p class="text-[10px] text-[#9CA3AF] leading-relaxed">Pago en línea seguro. Tarjeta de crédito o débito.</p>
                                </div>
                            </label>

                            {{-- Opción: Efectivo / Manual --}}
                            <label id="opt-manual" class="relative cursor-pointer group">
                                <input type="radio" name="metodo_ui" value="manual" class="peer sr-only">
                                <div class="p-4 bg-[#111] border border-[#374151]/50 rounded-lg transition-all duration-300 group-hover:border-gray-500 h-full">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fas fa-money-bill-wave text-green-400 text-xl"></i>
                                        <span class="text-xs font-black uppercase tracking-wider">Efectivo</span>
                                    </div>
                                    <p class="text-[10px] text-[#9CA3AF] leading-relaxed">Pago manual. Un administrador validará tu cuenta.</p>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- ── SELECCIÓN DE PLAN (solo Stripe) ────────── -->
                    <div id="plan-selector" class="space-y-3">
                        <label class="text-xs uppercase tracking-widest text-[#9CA3AF]">Selecciona tu Plan</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($planes as $plan)
                            @php $stripeId = $plan['stripe_price_id'] ?? ''; @endphp
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="plan_id" value="{{ $plan['id'] ?? '' }}"
                                    data-price-id="{{ $stripeId }}"
                                    data-stripe-price-id="{{ $plan['stripe_price_id'] ?? '' }}"
                                    class="plan-radio peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                <div class="p-4 bg-[#111] border border-[#374151]/50 rounded-lg transition-all duration-300 peer-checked:border-[#25B5DA] peer-checked:bg-[#25B5DA]/5 peer-checked:shadow-[0_0_15px_rgba(37,181,218,0.15)] group-hover:border-[#25B5DA]/50 h-full">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-bold uppercase tracking-tighter peer-checked:text-[#25B5DA]">{{ $plan['tipo'] }}</span>
                                        <div class="w-3 h-3 rounded-full border border-[#374151] peer-checked:border-[#25B5DA] peer-checked:bg-[#25B5DA] bg-transparent flex items-center justify-center transition-colors">
                                             <div class="w-1.5 h-1.5 bg-[#111] rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </div>
                                    </div>
                                    <div class="text-xl font-black italic mt-2">
                                        ${{ number_format($plan['costo'], 0) }}
                                        <span class="text-[10px] text-[#9CA3AF] not-italic uppercase tracking-tighter">/ {{ $plan['duracion'] ?? ($plan['duracion_meses'] ?? '') }}</span>
                                    </div>
                                    @if($stripeId)
                                    <p class="text-[10px] text-[#635bff] mt-2 font-bold"><i class="fab fa-stripe"></i> Pago via Stripe</p>
                                    @else
                                    <p class="text-[10px] text-yellow-500 mt-2"><i class="fas fa-exclamation-triangle"></i> Sin precio Stripe configurado</p>
                                    @endif
                                </div>
                            </label>
                            @empty
                            <p class="text-xs text-red-500 uppercase">No hay planes disponibles.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- ── AVISO PAGO MANUAL ───────────────────────── -->
                    <div id="manual-notice" class="hidden p-4 border border-yellow-500/30 bg-yellow-500/5 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-yellow-400 mt-0.5 shrink-0"></i>
                            <div>
                                <p class="text-xs font-bold text-yellow-300 uppercase tracking-widest mb-1">Validación pendiente</p>
                                <p class="text-[11px] text-[#9CA3AF] leading-relaxed">
                                    Tu negocio quedará en estado <strong class="text-white">pendiente de pago</strong>. Un administrador revisará y activará tu cuenta una vez confirmado el pago.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- BOTÓN SUBMIT -->
                    <div class="pt-6">
                        <button type="submit" id="btn-submit-onboarding"
                            class="w-full py-4 px-6 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-black tracking-[0.2em] uppercase text-sm rounded-full transition-all duration-300 hover:shadow-[0_0_20px_rgba(37,181,218,0.4)] hover:scale-[1.02] flex items-center justify-center gap-3">
                            <i id="btn-icon" class="fab fa-stripe text-lg"></i>
                            <span id="btn-label">Continuar con Stripe</span>
                        </button>
                    </div>
                </form>

                <script>
                (function () {
                    const form          = document.getElementById('onboarding-form');
                    const nombreVisible = document.getElementById('nombre_visible');
                    const tipoVisible   = document.getElementById('tipo_visible');
                    const nombreHidden  = document.getElementById('nombre_hidden');
                    const tipoHidden    = document.getElementById('tipo_hidden');
                    const metodoPagoH   = document.getElementById('metodo_pago_hidden');
                    const priceIdH      = document.getElementById('price_id_hidden');

                    const planSelector  = document.getElementById('plan-selector');
                    const manualNotice  = document.getElementById('manual-notice');
                    const btnIcon       = document.getElementById('btn-icon');
                    const btnLabel      = document.getElementById('btn-label');

                    const optStripe     = document.querySelector('input[name="metodo_ui"][value="stripe"]');
                    const optManual     = document.querySelector('input[name="metodo_ui"][value="manual"]');

                    // ── Tarjetas de selección ──────────────────────────────────
                    function updateCardStyles() {
                        const isStripe = optStripe.checked;

                        // Borde activo / inactivo en las tarjetas de método de pago
                        document.getElementById('opt-stripe').querySelector('div')
                            .classList.toggle('border-white/80', isStripe);
                        document.getElementById('opt-stripe').querySelector('div')
                            .classList.toggle('border-[#374151]/50', !isStripe);

                        document.getElementById('opt-manual').querySelector('div')
                            .classList.toggle('border-white/80', !isStripe);
                        document.getElementById('opt-manual').querySelector('div')
                            .classList.toggle('border-[#374151]/50', isStripe);

                        // Mostrar / ocultar secciones
                        planSelector.classList.toggle('hidden', !isStripe);
                        manualNotice.classList.toggle('hidden', isStripe);

                        // Sincronizar campo oculto
                        metodoPagoH.value = isStripe ? 'stripe' : 'manual';

                        // Cambiar botón
                        if (isStripe) {
                            btnIcon.className  = 'fab fa-stripe text-lg';
                            btnLabel.textContent = 'Continuar con Stripe';
                        } else {
                            btnIcon.className  = 'fas fa-money-bill-wave text-lg';
                            btnLabel.textContent = 'Registrar (Pago Manual)';
                        }
                    }

                    // ── Sincronizar price_id al seleccionar plan ───────────────
                    function syncPriceId() {
                        const checked = document.querySelector('.plan-radio:checked');
                        priceIdH.value = checked ? (checked.dataset.priceId || '') : '';
                    }

                    // ── Listeners ─────────────────────────────────────────────
                    [optStripe, optManual].forEach(r => r.addEventListener('change', updateCardStyles));

                    document.querySelectorAll('.plan-radio').forEach(r =>
                        r.addEventListener('change', syncPriceId));

                    // ── Sincronizar nombre y tipo antes del submit ─────────────
                    form.addEventListener('submit', function (e) {
                        nombreHidden.value = nombreVisible.value.trim();
                        tipoHidden.value   = tipoVisible.value;

                        if (!nombreHidden.value) {
                            e.preventDefault();
                            nombreVisible.focus();
                            return;
                        }
                        if (!tipoHidden.value) {
                            e.preventDefault();
                            tipoVisible.focus();
                            return;
                        }

                        if (optStripe.checked) {
                            syncPriceId();
                            if (!priceIdH.value) {
                                e.preventDefault();
                                alert('El plan seleccionado no tiene precio Stripe configurado.');
                                return;
                            }
                        }
                    });

                    // Inicializar
                    updateCardStyles();
                    syncPriceId();
                })();
                </script>
            </div>
        </div>
    </div>

</body>

</html>
