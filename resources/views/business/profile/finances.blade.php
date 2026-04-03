<!-- TAB 3: FINANZAS -->
<section id="tab-finances" class="hidden animate-fade-in-up">
    <div class="mb-5">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-bold uppercase tracking-wide text-white">Resumen de la salud de tu negocio</h2>
                <div class="relative group">
                    <i class="fas fa-circle-info text-[#9CA3AF] hover:text-[#25B5DA] cursor-pointer transition-colors text-lg"></i>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block bg-[#1a1a1a] border border-[#374151] rounded-lg p-3 w-64 z-10 shadow-xl">
                        <p class="text-[#9CA3AF] text-xs leading-relaxed text-center">
                            Los datos mostrados corresponden exclusivamente al día de hoy. 
                            <span class="text-white font-bold block mt-1">{{ now()->format('d/m/Y') }}</span>
                        </p>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-solid border-4 border-transparent border-t-[#1a1a1a]"></div>
                    </div>
                </div>
            </div>
            <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg px-4 py-2 flex items-center">
                <span class="text-[#9CA3AF] text-xs uppercase tracking-wider">Datos de hoy</span>
                <span class="text-white text-sm font-bold ml-2">{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
        <p class="text-[#9CA3AF] text-xs mt-2">Métricas actualizadas al día de hoy</p>
    </div>
        
        <!-- KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            
            <!-- Card 1: Ingresos Hoy -->
            <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 flex items-center justify-center text-emerald-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    @php $varHoy = $finanzas['ingresos_hoy']['variacion'] ?? 0; @endphp
                    <span class="text-xs font-bold flex items-center gap-1 {{ $varHoy >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $varHoy > 0 ? '+' : '' }}{{ $varHoy }}% 
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($varHoy >= 0)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            @endif
                        </svg>
                    </span>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white tracking-tight mb-1">${{ number_format($finanzas['ingresos_hoy']['total'] ?? 0, 2) }}</div>
                    <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Ingresos Hoy</div>
                </div>
            </div>

            <!-- Card 2: Citas Hoy -->
            <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 flex items-center justify-center text-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    @php $varCitas = $finanzas['citas_hoy']['variacion'] ?? 0; @endphp
                    <span class="text-xs font-bold flex items-center gap-1 {{ $varCitas >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $varCitas > 0 ? '+' : '' }}{{ $varCitas }}% 
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($varCitas >= 0)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            @endif
                        </svg>
                    </span>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white tracking-tight mb-1" title="Completadas: {{ $finanzas['citas_hoy']['completadas'] ?? 0 }} | Pendientes: {{ $finanzas['citas_hoy']['pendientes'] ?? 0 }} | En proceso: {{ $finanzas['citas_hoy']['en_proceso'] ?? 0 }} | Canceladas: {{ $finanzas['citas_hoy']['canceladas'] ?? 0 }}">
                        {{ $finanzas['citas_hoy']['total'] ?? 0 }}
                    </div>
                    <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Citas Hoy</div>
                    <div class="text-[10px] tracking-wide mt-2 flex items-center justify-start gap-2 flex-wrap">
                        <span class="text-emerald-500 font-medium whitespace-nowrap" title="Completadas"><i class="fas fa-check-circle mr-1"></i> {{ $finanzas['citas_hoy']['completadas'] ?? 0 }}</span>
                        <span class="text-[#F59E0B] font-medium whitespace-nowrap" title="Pendientes"><i class="fas fa-clock mr-1"></i> {{ $finanzas['citas_hoy']['pendientes'] ?? 0 }}</span>
                        <span class="text-blue-500 font-medium whitespace-nowrap" title="En Proceso"><i class="fas fa-spinner fa-spin mr-1"></i> {{ $finanzas['citas_hoy']['en_proceso'] ?? 0 }}</span>
                        <span class="text-red-500 font-medium whitespace-nowrap" title="Canceladas"><i class="fas fa-times-circle mr-1"></i> {{ $finanzas['citas_hoy']['canceladas'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Ingresos Mes -->
            <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="#A855F7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    @php $varMes = $finanzas['ingresos_mes']['variacion'] ?? 0; @endphp
                    <span class="text-xs font-bold flex items-center gap-1 {{ $varMes >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $varMes > 0 ? '+' : '' }}{{ $varMes }}% 
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($varMes >= 0)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            @endif
                        </svg>
                    </span>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white tracking-tight mb-1">${{ number_format($finanzas['ingresos_mes']['total'] ?? 0, 2) }}</div>
                    <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Ingresos Mes ({{ ucfirst(\Carbon\Carbon::now()->translatedFormat('F')) }})</div>
                </div>
            </div>
        </div>

    <!-- Weekly Income Chart -->
    <div class="border border-[#374151] bg-[#1a1a1a] p-5 rounded-sm">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-xl font-bold uppercase tracking-wide text-white">Ingresos Semanales</h2>
            <select class="bg-[#262626] text-white text-xs uppercase tracking-wider border border-[#374151] px-3 py-1 outline-none focus:border-white transition-colors">
                <option>Esta Semana</option>
            </select>
        </div>
        <div class="relative h-64 w-full">
            <canvas id="weeklyIncomeChart"></canvas>
        </div>
    </div>

    <!-- Top Services Section -->
    <div class="mt-5 border border-[#374151] bg-[#1a1a1a] p-5 rounded-sm">
        <h2 class="text-xl font-bold uppercase tracking-wide text-white mb-5">Servicios Top</h2>
        
        <div class="space-y-6">
            @forelse($finanzas['servicios_top'] ?? [] as $index => $servicio)
            <div class="flex items-center justify-between gap-4">
                <span class="text-white font-bold text-sm w-32 shrink-0 truncate">{{ $servicio['nombre'] ?? 'Desconocido' }}</span>
                <div class="flex-1 rounded-full overflow-hidden" style="height: 8px; background-color: #333333;">
                    <div class="h-full rounded-full" style="width: {{ $servicio['porcentaje'] ?? 0 }}%; background-color: #ffffff;"></div>
                </div>
                <span class="text-[#9CA3AF] text-sm w-8 text-right">{{ $servicio['total_citas'] ?? 0 }}</span>
            </div>
            @empty
            <div class="text-[#9CA3AF] text-sm">No hay datos suficientes para mostrar top de servicios.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Chart.js Support for finances tab -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('weeklyIncomeChart');
        if(ctx) {
            // Check if instance already exists and destroy it
            if (window.weeklyIncomeChartInstance) {
                window.weeklyIncomeChartInstance.destroy();
            }
            
            window.weeklyIncomeChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($finanzas['ingresos_semanales']['dias'] ?? []) !!},
                    datasets: [{
                        label: 'Ingresos',
                        data: {!! json_encode($finanzas['ingresos_semanales']['ingresos'] ?? []) !!},
                        backgroundColor: '#ffffff',
                        borderRadius: 4,
                        barThickness: 30,
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
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    }
                                    return label;
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
                                callback: function(value, index, values) {
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
                                color: '#9CA3AF'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
