<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NexoApp - @yield('title', 'Inicio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

</body>
</html>