@extends('layouts.dashboard')

@section('title', 'NexoApp - Suscripciones Pendientes')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-bold uppercase tracking-wide text-white">Suscripciones Pendientes</h1>
        <p class="text-[#52525b] text-xs uppercase mt-2 tracking-widest font-bold">Validación de pagos y activación de negocios</p>
    </div>

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
                {{-- Aquí iteraremos con @forelse($pendientes as $item) --}}
                <tr class="hover:bg-[#2d2d2d] transition-colors group">
                    <td class="p-4">
                        <div class="text-white font-bold text-sm">Barbería Test</div>
                        <div class="text-[#52525b] text-[11px]">juan@test.com • Juan Pérez</div>
                    </td>
                    <td class="p-4">
                        <span class="text-white font-mono text-xs font-bold">$499.00</span>
                        <div class="text-[#9CA3AF] text-[10px] uppercase tracking-tighter">Plan Básico (1 mes)</div>
                    </td>
                    <td class="p-4 text-[#9CA3AF] text-xs font-mono">
                        20 Mar 2026
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex justify-end gap-2">
                            {{-- Botón Activar (POST /api/admin/suscripciones/{id}/activar) --}}
                            <button class="bg-emerald-500 hover:bg-emerald-600 text-black text-[10px] font-bold uppercase px-4 py-2 transition-all">
                                Activar
                            </button>
                            {{-- Botón Rechazar (POST /api/admin/suscripciones/{id}/rechazar) --}}
                            <button class="border border-red-500/50 text-red-500 hover:bg-red-500 hover:text-white text-[10px] font-bold uppercase px-4 py-2 transition-all">
                                Rechazar
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        
        {{-- Estado vacío --}}
        {{-- <div class="py-20 text-center opacity-30"> <p class="text-xs uppercase tracking-[0.5em]">No hay pagos pendientes</p> </div> --}}
    </div>
@endsection