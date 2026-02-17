<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - Disponibilidad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#1a1a1a] text-[#F3F4F6] font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full py-5 px-8 flex justify-between items-center border-b border-[#374151]/50 bg-[#1a1a1a]/95 backdrop-blur-sm sticky top-0 z-50">
        <a href="/" class="text-xl tracking-widest font-bold uppercase text-white hover:text-white/80 transition-colors">
            NexoApp
        </a>
        <div class="flex items-center gap-6">
            <a href="{{ route('service.show') }}" class="text-xs uppercase tracking-widest text-[#9CA3AF] hover:text-white transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al Servicio
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-start p-6 md:p-12">
        
        <div class="w-full max-w-7xl space-y-8 animate-fade-in-up">
            
            <!-- Header Section -->
            <div class="text-center space-y-2">
                <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-wide text-white">
                    Selecciona tu Horario
                </h1>
                <p class="text-[#9CA3AF] text-sm">
                    Urban Fade Studio - Corte Ejecutivo
                </p>
            </div>

            <!-- Content will be added here -->
            <!-- Calendar Section -->
            <div class="bg-[#262626] border border-[#374151]/50 p-6 md:p-8 rounded-sm shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold uppercase tracking-wide text-white">{{ $monthName }} {{ $year }}</h2>
                    <div class="flex gap-2">
                        <a href="{{ $prevLink }}" class="p-2 border border-[#374151] hover:bg-[#374151] text-white transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                        <a href="{{ $nextLink }}" class="p-2 border border-[#374151] hover:bg-[#374151] text-white transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-px bg-[#374151]/50 border border-[#374151]/50">
                    <!-- Setup: Dynamic Month -->
                    
                    <!-- Headers -->
                    <div class="bg-[#1a1a1a] p-3 text-center text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Dom</div>
                    <div class="bg-[#1a1a1a] p-3 text-center text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Lun</div>
                    <div class="bg-[#1a1a1a] p-3 text-center text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Mar</div>
                    <div class="bg-[#1a1a1a] p-3 text-center text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Mié</div>
                    <div class="bg-[#1a1a1a] p-3 text-center text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Jue</div>
                    <div class="bg-[#1a1a1a] p-3 text-center text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Vie</div>
                    <div class="bg-[#1a1a1a] p-3 text-center text-xs font-bold uppercase tracking-widest text-[#9CA3AF]">Sáb</div>

                    <!-- Padding for Start of Month -->
                    @for ($i = 0; $i < $firstDayOfWeek; $i++)
                        <div class="bg-[#262626]/50 min-h-[180px] border border-transparent"></div>
                    @endfor

                    <!-- Days Loop -->
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $cellDate = \Carbon\Carbon::createFromDate($year, $month, $day)->startOfDay();
                            // Check if date is within range: today <= date <= maxDate
                            $available = $cellDate->greaterThanOrEqualTo($now) && $cellDate->lessThanOrEqualTo($maxDate);
                            
                            // Style: Available vs Unavailable
                            $disabledClass = $available 
                                ? 'hover:bg-black group cursor-pointer hover:border-[#F3F4F6]' 
                                : 'opacity-30 cursor-not-allowed';
                        @endphp
                        
                        <div class="bg-[#262626] min-h-[180px] p-4 transition-colors relative border border-transparent {{ $disabledClass }}">
                            <span class="text-xl font-bold text-white">{{ $day }}</span>
                        </div>
                    @endfor
                </div>


            </div>

        </div>

    </main>

    <!-- Time Slot Modal -->
    <div id="time-slot-modal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/90 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop"></div>
        
        <!-- Modal Content -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg bg-[#1a1a1a] border border-[#374151] shadow-2xl p-8 opacity-0 scale-95 transition-all duration-300" id="modal-content">
            
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold uppercase tracking-wide text-white mb-2" id="modal-date-title">
                    14 de Febrero
                </h3>
                <p class="text-[#9CA3AF] text-sm tracking-wider">SELECCIONA UN HORARIO DISPONIBLE</p>
            </div>

            <!-- Time Slots Grid -->
            <div class="grid grid-cols-3 gap-4 mb-8" id="time-slots-container">
                <!-- Morning -->
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">10:00 AM</button>
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">10:30 AM</button>
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">11:00 AM</button>
                
                <!-- Afternoon -->
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">02:00 PM</button>
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">02:30 PM</button>
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">03:00 PM</button>
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">04:00 PM</button>
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">04:30 PM</button>
                <button class="time-slot p-3 border border-[#374151] text-white text-sm font-bold tracking-wider hover:bg-white hover:text-black transition-all">05:00 PM</button>
            </div>

            <!-- Actions -->
            <div class="flex gap-4">
                <button id="btn-cancel" class="flex-1 py-3 border border-[#374151] text-[#9CA3AF] font-bold uppercase tracking-widest text-xs hover:text-white hover:border-white transition-all">
                    Cancelar
                </button>
                <button class="flex-1 py-3 bg-[#F3F4F6] text-[#1a1a1a] font-bold uppercase tracking-widest text-xs hover:bg-white hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] transition-all">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="success-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-md transition-opacity opacity-0" id="success-backdrop"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center space-y-6 opacity-0 scale-90 transition-all duration-500" id="success-content">
            <div class="h-20 w-20 rounded-full border-2 border-emerald-500 flex items-center justify-center text-emerald-500 shadow-[0_0_30px_rgba(16,185,129,0.3)]">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-3xl font-bold uppercase tracking-widest text-white text-center">Cita Agendada</h2>
            <p class="text-[#9CA3AF] tracking-wider text-sm">TU RESERVA HA SIDO CONFIRMADA</p>
        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="border-t border-[#374151]/30 py-8 bg-black mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="text-[10px] text-[#52525b] tracking-wider uppercase">
                © 2026 NexoApp Inc.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Modal Elements
            const modal = document.getElementById('time-slot-modal');
            const backdrop = document.getElementById('modal-backdrop');
            const content = document.getElementById('modal-content');
            const dateTitle = document.getElementById('modal-date-title');
            
            // Buttons
            const btnCancel = document.getElementById('btn-cancel');
            const btnConfirm = document.querySelector('button[class*="bg-[#F3F4F6]"]'); // Selecting by class since ID wasn't added yet
            
            // Interactive Elements
            const dayCells = document.querySelectorAll('.group.cursor-pointer');
            const timeSlots = document.querySelectorAll('.time-slot');

            // Success Elements
            const successModal = document.getElementById('success-modal');
            const successBackdrop = document.getElementById('success-backdrop');
            const successContent = document.getElementById('success-content');

            // State
            let selectedTime = null;

            // Open Modal
            dayCells.forEach(cell => {
                cell.addEventListener('click', function() {
                    const day = this.querySelector('span').innerText;
                    dateTitle.innerText = `${day} de {{ $monthName }}`;
                    
                    // Reset selection
                    selectedTime = null;
                    resetTimeSlots();
                    
                    modal.classList.remove('hidden');
                    // Animate in
                    setTimeout(() => {
                        backdrop.classList.remove('opacity-0');
                        content.classList.remove('opacity-0', 'scale-95');
                        content.classList.add('scale-100');
                    }, 10);
                });
            });

            // Close Modal Function
            function closeModal() {
                backdrop.classList.add('opacity-0');
                content.classList.remove('scale-100');
                content.classList.add('opacity-0', 'scale-95');
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            // Close Events
            btnCancel.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);

            // Time Slot Selection Logic
            function resetTimeSlots() {
                timeSlots.forEach(s => {
                    s.classList.remove('bg-white', 'text-black', 'border-transparent');
                    s.classList.add('border-[#374151]', 'text-white');
                });
            }

            timeSlots.forEach(slot => {
                slot.addEventListener('click', function() {
                    resetTimeSlots();
                    
                    // Select clicked
                    this.classList.remove('border-[#374151]', 'text-white');
                    this.classList.add('bg-white', 'text-black', 'border-transparent');
                    selectedTime = this.innerText;
                });
            });

            // Confirm Logic
            btnConfirm.addEventListener('click', () => {
                if (!selectedTime) {
                    alert('Por favor selecciona un horario');
                    return;
                }

                closeModal();

                // Show Success
                setTimeout(() => {
                    successModal.classList.remove('hidden');
                    setTimeout(() => {
                        successBackdrop.classList.remove('opacity-0');
                        successContent.classList.remove('opacity-0', 'scale-90');
                        successContent.classList.add('scale-100');
                    }, 10);

                    // Auto hide after 3 seconds
                    setTimeout(() => {
                        successBackdrop.classList.add('opacity-0');
                        successContent.classList.remove('scale-100');
                        successContent.classList.add('opacity-0', 'scale-90');
                        setTimeout(() => {
                            successModal.classList.add('hidden');
                        }, 500);
                    }, 2000);
                }, 300);
            });
        });
    </script>
</body>
</html>
