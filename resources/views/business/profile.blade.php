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
    <title>NexoApp - Mi Negocio</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
    
    <a href="{{ url('/') }}" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
        NexoApp
    </a>

    <div class="flex items-center gap-6">

<div x-data="{ open: false }" class="relative">

<button @click="open = !open"
        @click.away="open = false"
        class="flex items-center gap-3 focus:outline-none group">

<span class="text-sm font-bold text-[#F3F4F6] hidden md:block">
Hola, {{ session('usuario.primer_nombre') ?? session('usuario.correo') ?? 'Usuario' }}
</span>

<div class="h-9 w-9 rounded-full 
bg-gradient-to-br from-[#374151] to-black 
flex items-center justify-center 
text-white font-bold text-sm shadow-md">
{{ $inicial }}
</div>

<i class="fa-solid fa-chevron-down text-[10px] text-[#9CA3AF] group-hover:text-white"></i>

</button>

<div x-show="open"
class="absolute right-0 mt-2 w-48 bg-[#1a1a1a] border border-[#374151] shadow-xl z-50 py-2">

<div class="px-4 py-2 border-b border-[#374151]/50 mb-1">
<p class="text-[10px] uppercase tracking-widest text-[#9CA3AF] mb-1">Usuario</p>
<p class="text-xs font-bold text-white truncate">
{{ session('usuario.nombre_completo') ?? session('usuario.correo') }}
</p>
</div>

<a href="{{ url('/profile') }}"
class="block px-4 py-2 text-xs text-[#9CA3AF] hover:text-white hover:bg-[#374151]/30 uppercase tracking-widest font-bold">

<i class="fa-solid fa-user mr-2"></i> Mi Perfil
</a>

<form method="POST" action="/logout">
@csrf
<button type="submit"
class="w-full text-left px-4 py-2 text-xs text-red-400 hover:text-red-300 hover:bg-[#374151]/30 uppercase tracking-widest font-bold">

<i class="fa-solid fa-right-from-bracket mr-2"></i> Cerrar Sesión
</button>
</form>

</div>

</div>

</div>

</header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-12">
        
        <!-- Header Section -->
        <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 overflow-hidden">
            <div>
                <h1 class="text-4xl font-bold uppercase tracking-wide text-white mb-2">Mi Negocio</h1>
                <p class="text-[#9CA3AF] text-sm tracking-wide">GESTIONA TU PERFIL Y SERVICIOS</p>
            </div>
            
            <!-- Tabs Navigation -->
            <div class="w-full md:w-auto flex space-x-1 bg-[#0f0f0f] p-1 border border-[#374151]/50 rounded-sm overflow-x-auto whitespace-nowrap [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <button onclick="switchTab('info')" id="tab-btn-info" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#1a1a1a] bg-[#F3F4F6]">
                    Información
                </button>
                <button onclick="switchTab('services')" id="tab-btn-services" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Servicios
                </button>
                <button onclick="switchTab('evidencias')" id="tab-btn-evidencias" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Evidencias
                </button>
                <button onclick="switchTab('schedule')" id="tab-btn-schedule" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Horario
                </button>
                <button onclick="switchTab('finances')" id="tab-btn-finances" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Finanzas
                </button>
                <button onclick="switchTab('personnel')" id="tab-btn-personnel" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Personal
                </button>
                <button onclick="switchTab('clientes-promociones')" id="tab-btn-clientes-promociones" class="shrink-0 px-6 py-2 text-xs font-bold uppercase tracking-widest transition-all text-[#9CA3AF] hover:text-white">
                    Clientes y Promociones
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="relative w-full">
            @include('business.profile.information')
            @include('business.profile.services')
            @include('business.profile.evidencias')
            @include('business.profile.schedule')
            @include('business.profile.finances')
            @include('business.profile.staff')
            @include('business.profile.clientes-promociones')
        </div>

<div id="global-loader" class="fixed inset-0 hidden z-50 flex items-center justify-center bg-black/70">
    <div class="w-10 h-10 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
</div>

<div id="toast"
     class="fixed bottom-6 right-6 hidden bg-[#1a1a1a] border border-[#374151] text-white px-6 py-3 text-sm uppercase tracking-widest shadow-lg">
</div>

    <script>
        function switchTab(tab) {
            const tabs = ['info', 'services', 'evidencias', 'schedule', 'finances', 'personnel', 'clientes-promociones'];
            
            tabs.forEach(t => {
                const section = document.getElementById(`tab-${t}`);
                const btn = document.getElementById(`tab-btn-${t}`);
                
                if (t === tab) {
                    section.classList.remove('hidden');
                    // Active Styles
                    btn.classList.add('bg-[#F3F4F6]', 'text-[#1a1a1a]');
                    btn.classList.remove('text-[#9CA3AF]', 'hover:text-white');
                    
                    // Resize chart if finances tab is opened
                    if (t === 'finances' && window.myChart) {
                        setTimeout(() => {
                           window.myChart.resize();
                        }, 100);
                    }
                } else {
                    section.classList.add('hidden');
                    // Inactive Styles
                    btn.classList.remove('bg-[#F3F4F6]', 'text-[#1a1a1a]');
                    btn.classList.add('text-[#9CA3AF]', 'hover:text-white');
                }
            });
        }

        function openEditModal(id, nombre, descripcion, precio, duracion, imagen) {

    document.getElementById('modal-edit-service').classList.remove('hidden');

    document.getElementById('editModalTitle').innerText =
        `Editando: ${nombre}`;

    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('edit_precio').value = precio;
    document.getElementById('edit_duracion').value = duracion;

    // 🔥 NUEVO: Mostrar imagen actual
    const preview = document.getElementById('edit_imagen_preview');

if (imagen) {
    preview.src = imagen;
    preview.classList.remove('hidden');
} else {
    preview.src = '';
    preview.classList.add('hidden');
}

    document.getElementById('editServiceForm').action =
        `/api-proxy/api/servicios/${id}`;
    document.getElementById('editServiceForm').setAttribute('data-redirect', '{{ route("business.profile") }}');
}

function openDeleteModal(id, nombre) {
    document.getElementById('modal-delete-service').classList.remove('hidden');
    document.getElementById('deleteServiceName').innerText = nombre;
    document.getElementById('deleteServiceForm').action = `/api-proxy/api/servicios/${id}`;
}

function closeDeleteModal() {
    document.getElementById('modal-delete-service').classList.add('hidden');
}

document.getElementById('deleteServiceForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const url = form.action;
    const serviceId = url.split('/').pop();
    const card = document.getElementById(`service-${serviceId}`);

    showLoader();

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams(new FormData(form))
    })
    .then(() => {
        hideLoader();

        // Animación fade out
        card.style.opacity = '0';
        card.style.transform = 'translateX(20px)';

        setTimeout(() => {
    card.remove();

    // 🔥 ACTUALIZAR CONTADOR
    const totalElement = document.getElementById('services-total');
const newTotal = document.querySelectorAll('.service-card').length;
totalElement.dataset.count = newTotal;
totalElement.innerText = "TOTAL: " + newTotal;

    showToast("Servicio eliminado correctamente");
}, 300);

        closeDeleteModal();
    });
});

    
function closeEditModal() {
    document.getElementById('modal-edit-service').classList.add('hidden');
}


        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            // Modal Logic
            const btnAddEmployee = document.getElementById('btn-add-employee');
            if (btnAddEmployee) {
                btnAddEmployee.addEventListener('click', () => toggleModal('modal-add-employee', true));
            }

            // Chart Logic
            const chartCanvas = document.getElementById('weeklyIncomeChart');
            if (chartCanvas && chartCanvas.getContext) {
                const ctx = chartCanvas.getContext('2d');
                
                // Gradient for bars
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, '#A855F7'); // Purple start
                gradient.addColorStop(1, '#3B82F6'); // Blue end

                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                        datasets: [{
                            label: 'Ingresos ($)',
                            data: [120, 190, 150, 250, 320, 450, 280],
                            backgroundColor: gradient,
                            borderRadius: 4,
                            hoverBackgroundColor: '#F3F4F6'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#262626',
                                titleColor: '#F3F4F6',
                                bodyColor: '#9CA3AF',
                                borderColor: '#374151',
                                borderWidth: 1,
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return '$ ' + context.raw;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#374151',
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#9CA3AF',
                                    font: {
                                        family: 'sans-serif',
                                        size: 10
                                    },
                                    callback: function(value) {
                                        return '$' + value;
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false,
                                },
                                ticks: {
                                    color: '#9CA3AF',
                                    font: {
                                        family: 'sans-serif',
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });

        // Toggle Modal Helper
        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        function showLoader() {
    document.getElementById('global-loader').classList.remove('hidden');
}

function hideLoader() {
    document.getElementById('global-loader').classList.add('hidden');
}

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.innerText = message;
    toast.classList.remove('hidden');
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(10px)';

    setTimeout(() => {
        toast.style.transition = 'all 0.3s ease';
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 10);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 300);
    }, 3000);
}
    </script>

</body>
</html>
