@props(['size' => 'small'])

@php
    $nombre = session('usuario.primer_nombre') ?? session('usuario.nombre_completo') ?? session('usuario.correo') ?? 'Usuario';
    $inicial = strtoupper(substr($nombre, 0, 1)) ?: 'U';

    $classes = [
        'small' => 'w-9 h-9 text-sm',
        'large' => 'w-32 h-32 text-5xl',
    ];

    $selectedSize = $classes[$size] ?? $classes['small'];
@endphp

<div class="{{ $selectedSize }} rounded-full bg-gradient-to-br from-[#374151] to-black flex items-center justify-center text-white font-bold shadow-md">
    {{ $inicial }}
</div>
