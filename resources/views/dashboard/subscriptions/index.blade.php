@extends('layouts.dashboard')

@section('title', 'NexoApp - Suscripciones Pendientes')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Suscripciones Pendientes</h1>
        <p class="text-[#52525b] text-xs uppercase mt-2 tracking-widest font-bold">Validación de pagos y activación de negocios</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500 text-emerald-500 p-4 mb-6 text-[10px] uppercase font-bold tracking-widest">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#262626] border border-[#374151] rounded-sm overflow-hidden shadow-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-[#374151] bg-[#1a1a1a]">
                    <th class="p-4 text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF] font-bold">Negocio / Propietario</th>
                    <th class="p-4 text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF] font-bold">Plan Solicitado</th>
                    <th class="p-4 text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF] font-bold">Fecha Solicitud</th>
                    <th class="p-4 text-[10px] uppercase tracking-[0.2em] text-[#9CA3AF] font-bold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#374151]">
                @forelse($pendientes as $item)
                    <tr class="hover:bg-[#2d2d2d] transition-colors group">
                        <td class="p-4">
                            <div class="text-white font-bold text-sm">{{ $item['negocio_nombre'] ?? 'Sin Nombre' }}</div>
                            <div class="text-[#52525b] text-[11px]">{{ $item['email'] ?? '' }} • {{ $item['propietario'] ?? 'N/A' }}</div>
                        </td>
                        <td class="p-4">
                            <span class="text-white font-mono text-xs font-bold">${{ number_format($item['costo'], 0, ',', '.') }}</span>
                            <div class="text-[#9CA3AF] text-[10px] uppercase tracking-tighter">{{ $item['plan_tipo'] ?? 'Plan' }}</div>
                        </td>
                        <td class="p-4 text-[#9CA3AF] text-xs font-mono">
                            {{ \Carbon\Carbon::parse($item['created_at'])->format('d M Y') }}
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('dashboard.subscriptions.activate', $item['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-black text-[10px] font-bold uppercase px-4 py-2 transition-all">
                                        Activar
                                    </button>
                                </form>

                                <form action="{{ route('dashboard.subscriptions.reject', $item['id']) }}" method="POST" onsubmit="return confirm('¿Rechazar este pago?')">
                                    @csrf
                                    <button type="submit" class="border border-red-500/50 text-red-500 hover:bg-red-500 hover:text-white text-[10px] font-bold uppercase px-4 py-2 transition-all">
                                        Rechazar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center opacity-30">
                            <p class="text-xs uppercase tracking-[0.5em]">No hay pagos pendientes</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection