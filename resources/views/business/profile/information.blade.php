<!-- TAB 1: INFORMACIÓN -->
<section id="tab-info" class="animate-fade-in-up">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

<!-- Left: Form -->
<div class="space-y-8">

<form method="POST" action="{{ route('business.update') }}" class="space-y-8">
@csrf

<div class="space-y-6">

<!-- Nombre -->
<div class="group/input relative mt-2 md:mt-0">
<input
type="text"
name="nombre"
id="nombre"
value="{{ old('nombre', $negocio['nombre'] ?? '') }}"
placeholder="Ej. Barbería El Maestro"
required
maxlength="100"
class="peer w-full bg-transparent border-b @error('nombre') border-red-500 @else border-[#374151] @enderror py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent"
/>
<label for="nombre" class="absolute left-0 -top-3.5 @error('nombre') text-red-500 @else text-[#9CA3AF] @enderror text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
Nombre del Negocio *
</label>
@error('nombre')
    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>
@enderror
</div>

<!-- Tipo de Negocio -->
<div class="group/input relative mt-6">
<select
name="tipo_negocio"
id="tipo_negocio"
required
class="peer w-full bg-transparent border-b @error('tipo_negocio') border-red-500 @else border-[#374151] @enderror py-3 text-white focus:border-white focus:outline-none transition-colors appearance-none cursor-pointer"
>
    <!-- Seleccionar el valor por defecto si existe -->
    <option value="" disabled {{ empty($negocio['tipo_negocio']) ? 'selected' : '' }}>Selecciona un tipo de negocio</option>
    @php
        $tipos = ['barberia' => 'Barbería', 'salon' => 'Salón', 'peluqueria' => 'Peluquería', 'spa' => 'Spa', 'otros' => 'Otros'];
        // Obtenemos el tipo de negocio validando primero si hay un "old" value o el existente
        $currentTipo = old('tipo_negocio', $negocio['tipo_negocio'] ?? '');
    @endphp
    @foreach($tipos as $val => $label)
        <option value="{{ $val }}" class="bg-[#1a1a1a] text-white" {{ strtolower($currentTipo) === strtolower($val) || strtolower($currentTipo) === strtolower($label) ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>
<label for="tipo_negocio" class="absolute left-0 -top-3.5 @error('tipo_negocio') text-red-500 @else text-[#9CA3AF] @enderror text-xs transition-all">
Tipo de Negocio *
</label>
<div class="absolute right-0 top-3.5 pointer-events-none text-[#9CA3AF]">
    <i class="fa-solid fa-chevron-down text-xs"></i>
</div>
@error('tipo_negocio')
    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>
@enderror
</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

<!-- Teléfono -->
<div class="group/input relative">
<input
type="tel"
name="telefono"
id="telefono"
value="{{ old('telefono', $negocio['telefono'] ?? '') }}"
placeholder="Ej. 5512345678"
maxlength="20"
pattern="[0-9+\-\s()]+"
class="peer w-full bg-transparent border-b @error('telefono') border-red-500 @else border-[#374151] @enderror py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent"
/>
<label for="telefono" class="absolute left-0 -top-3.5 @error('telefono') text-red-500 @else text-[#9CA3AF] @enderror text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
Teléfono
</label>
@error('telefono')
    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>
@enderror
</div>

<!-- Redes Sociales -->
<div class="group/input relative mt-2 md:mt-0">
<input
type="url"
name="redes_sociales"
id="redes_sociales"
value="{{ old('redes_sociales', $negocio['redes_sociales'] ?? '') }}"
placeholder="Ej. https://instagram.com/minegocio"
maxlength="255"
class="peer w-full bg-transparent border-b @error('redes_sociales') border-red-500 @else border-[#374151] @enderror py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent"
/>
<label for="redes_sociales" class="absolute left-0 -top-3.5 @error('redes_sociales') text-red-500 @else text-[#9CA3AF] @enderror text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
Redes Sociales (Link)
</label>
@error('redes_sociales')
    <span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>
@enderror
</div>

</div>


<!-- Acerca de -->
<div class="group/input relative mt-6">

<textarea
rows="4"
name="acerca_de"
id="acerca_de"
placeholder="Describe tu negocio..."
maxlength="1000"
class="peer w-full bg-transparent border @error('acerca_de') border-red-500 @else border-[#374151] @enderror p-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent text-sm resize-y"
>{{ old('acerca_de', $negocio['acerca_de'] ?? '') }}</textarea>

<label for="acerca_de" class="absolute left-3 -top-2.5 bg-[#1a1a1a] px-1 @error('acerca_de') text-red-500 @else text-[#9CA3AF] @enderror text-xs">
Acerca de mi negocio
</label>
@error('acerca_de')
    <span class="text-red-500 text-xs mt-1 block pl-3"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>
@enderror

</div>


<!-- Dirección (Solo Lectura) -->
<div class="border-t border-[#374151] pt-6 mt-8">

<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-3">
    <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF]">
    Dirección
    </h3>
    <div class="px-3 py-2 bg-[#3B82F6]/10 border border-[#3B82F6]/30 rounded text-xs text-[#9CA3AF] flex items-center gap-2">
        <i class="fa-solid fa-circle-info text-[#3B82F6]"></i>
        Para modificar la dirección contacte al administrador del sistema.
    </div>
</div>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

<div class="group/input relative md:col-span-2 mt-2 md:mt-0">
<input
type="text"
name="calle"
id="calle"
value="{{ $negocio['direccion']['calle'] ?? '' }}"
readonly
class="w-full bg-transparent border-b border-[#374151]/30 py-3 text-[#6B7280] focus:outline-none cursor-not-allowed"
/>
<label for="calle" class="absolute left-0 -top-3.5 text-[#6B7280] text-xs">
Calle
</label>
</div>

<div class="group/input relative mt-2 md:mt-0">
<input
type="text"
name="numero"
id="numero"
value="{{ $negocio['direccion']['numero'] ?? '' }}"
readonly
class="w-full bg-transparent border-b border-[#374151]/30 py-3 text-[#6B7280] focus:outline-none cursor-not-allowed"
/>
<label for="numero" class="absolute left-0 -top-3.5 text-[#6B7280] text-xs">
Número
</label>
</div>

</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

<div class="group/input relative mt-2 md:mt-0">
<input
type="text"
name="colonia"
id="colonia"
value="{{ $negocio['direccion']['colonia'] ?? '' }}"
readonly
class="w-full bg-transparent border-b border-[#374151]/30 py-3 text-[#6B7280] focus:outline-none cursor-not-allowed"
/>
<label for="colonia" class="absolute left-0 -top-3.5 text-[#6B7280] text-xs">
Colonia
</label>
</div>

<div class="group/input relative mt-2 md:mt-0">
<input
type="text"
name="codigo_postal"
id="codigo_postal"
value="{{ $negocio['direccion']['codigo_postal'] ?? '' }}"
readonly
class="w-full bg-transparent border-b border-[#374151]/30 py-3 text-[#6B7280] focus:outline-none cursor-not-allowed"
/>
<label for="codigo_postal" class="absolute left-0 -top-3.5 text-[#6B7280] text-xs">
Código Postal
</label>
</div>

</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div class="group/input relative mt-2 md:mt-0">
<input
type="text"
name="ciudad"
id="ciudad"
value="{{ $negocio['direccion']['ciudad'] ?? '' }}"
readonly
class="w-full bg-transparent border-b border-[#374151]/30 py-3 text-[#6B7280] focus:outline-none cursor-not-allowed"
/>
<label for="ciudad" class="absolute left-0 -top-3.5 text-[#6B7280] text-xs">
Ciudad
</label>
</div>

<div class="group/input relative mt-2 md:mt-0">
<input
type="text"
name="estado"
id="estado"
value="{{ $negocio['direccion']['estado'] ?? '' }}"
readonly
class="w-full bg-transparent border-b border-[#374151]/30 py-3 text-[#6B7280] focus:outline-none cursor-not-allowed"
/>
<label for="estado" class="absolute left-0 -top-3.5 text-[#6B7280] text-xs">
Estado
</label>
</div>

</div>

</div>

</div>


<div class="pt-6">
<button
type="submit"
class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-white hover:shadow-[0_0_15px_rgba(255,255,255,0.3)] focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#1a1a1a]"
>
Guardar Cambios
</button>
</div>

</form>

</div>


<!-- Right: Profile Visual -->

<div class="flex flex-col items-center justify-center border border-[#374151]/30 bg-[#0f0f0f] p-12 relative overflow-hidden">

<div class="relative z-10 text-center">

<div class="w-32 h-32 rounded-full bg-[#262626] border-2 border-[#374151] mx-auto mb-6 flex items-center justify-center overflow-hidden">

@if(isset($negocio['foto_perfil']))
<img src="{{ url('/api-proxy/public/' . ltrim($negocio['foto_perfil']['url_imagen'], '/')) }}"
class="w-full h-full object-cover">
@endif

</div>

<h2 class="text-2xl font-bold text-white uppercase tracking-wide">
{{ $negocio['nombre'] ?? 'Mi Negocio' }}
</h2>

<p class="text-[#9CA3AF] text-sm mt-1">
{{ $negocio['tipo_negocio'] ?? '' }}
</p>

</div>

</div>

</div>
</section>