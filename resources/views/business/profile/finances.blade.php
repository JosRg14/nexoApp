<!-- TAB 3: FINANZAS -->
<section id="tab-finances" class="hidden animate-fade-in-up">
    <div class="mb-8">
        <h2 class="text-xl font-bold uppercase tracking-wide text-white mb-6">Resumen de la salud de tu negocio</h2>
        
        <!-- KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Card 1: Ingresos Hoy -->
            <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 flex items-center justify-center text-emerald-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-white flex items-center gap-1">
                        +12% <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    </span>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white tracking-tight mb-1">$150.00</div>
                    <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Ingresos Hoy</div>
                </div>
            </div>

            <!-- Card 2: Citas Hoy -->
            <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 flex items-center justify-center text-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-red-500 flex items-center gap-1">
                        -5% <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </span>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white tracking-tight mb-1">12</div>
                    <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Citas Hoy</div>
                </div>
            </div>

            <!-- Card 3: Ingresos Mes -->
            <div class="bg-[#262626] border border-[#374151]/50 p-6 flex flex-col justify-between h-40 group hover:border-[#F3F4F6]/30 transition-colors duration-300">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="#A855F7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-white flex items-center gap-1">
                        +8% <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    </span>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white tracking-tight mb-1">$4,250</div>
                    <div class="text-[#9CA3AF] text-xs uppercase tracking-wider">Ingresos Mes</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Income Chart -->
    <div class="border border-[#374151] bg-[#1a1a1a] p-6 rounded-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold uppercase tracking-wide text-white">Ingresos Semanales</h2>
            <select class="bg-[#262626] text-white text-xs uppercase tracking-wider border border-[#374151] px-3 py-1 outline-none focus:border-white transition-colors">
                <option>Esta Semana</option>
                <option>Semana Pasada</option>
            </select>
        </div>
        <div class="relative h-64 w-full">
            <canvas id="weeklyIncomeChart"></canvas>
        </div>
    </div>

    <!-- Top Services Section -->
    <div class="mt-6 border border-[#374151] bg-[#1a1a1a] p-6 rounded-sm">
        <h2 class="text-xl font-bold uppercase tracking-wide text-white mb-6">Servicios Top</h2>
        
        <div class="space-y-6">
            <!-- Service 1 -->
            <div class="flex items-center justify-between gap-4">
                <span class="text-white font-bold text-sm w-32 shrink-0">Corte Clásico</span>
            </div>

            <!-- Service 2 -->
            <div class="flex items-center justify-between gap-4">
                <span class="text-white font-bold text-sm w-32 shrink-0">Barba Premium</span>
                <div class="flex-1 rounded-full overflow-hidden" style="height: 8px; background-color: #333333;">
                    <div class="h-full rounded-full" style="width: 45%; background-color: #ffffff;"></div>
                </div>
                <span class="text-[#9CA3AF] text-sm w-8 text-right">28</span>
            </div>

            <!-- Service 3 -->
            <div class="flex items-center justify-between gap-4">
                <span class="text-white font-bold text-sm w-32 shrink-0">Corte + Barba</span>
                <div class="flex-1 rounded-full overflow-hidden" style="height: 8px; background-color: #333333;">
                    <div class="h-full rounded-full" style="width: 25%; background-color: #ffffff;"></div>
                </div>
                <span class="text-[#9CA3AF] text-sm w-8 text-right">15</span>
            </div>
        </div>
    </div>
</section>
