<section id="tab-info" class="animate-fade-in-up">
@php
    \Log::info('Negocio en vista profile.information:', [
        'id' => $negocio['id_negocio'] ?? $negocio['id'] ?? null,
        'tiene_imagenes' => isset($negocio['imagenes']),
        'imagenes' => $negocio['imagenes'] ?? [],
        'foto_perfil' => $negocio['foto_perfil'] ?? null,
        'banner' => $negocio['banner'] ?? null
    ]);
@endphp

@if(!$negocio || empty($negocio))
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="bg-[#25B5DA]/10 border border-[#25B5DA]/30 rounded-full p-6 mb-6">
            <i class="fas fa-store text-5xl text-[#25B5DA]"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-2">¡Bienvenido a NexoApp!</h2>
        <p class="text-[#9CA3AF] mb-8 max-w-md">Completa los datos de tu negocio para comenzar a usar la plataforma.</p>
        
        <button onclick="mostrarFormularioRegistro()" 
                class="px-8 py-3 bg-[#25B5DA] text-black font-bold rounded-lg hover:bg-[#1c8fb0] transition-all duration-300 flex items-center gap-2">
            <i class="fas fa-plus-circle"></i>
            Registrar mi Negocio
        </button>
    </div>
    
    <div id="formulario-registro" class="hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div class="space-y-8">
                <form id="registro-negocio-form" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <div class="space-y-6">
                        <div class="group/input relative">
                            <input type="text" name="nombre_negocio" id="nombre_negocio" required
                                   class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent">
                            <label for="nombre_negocio" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                                Nombre del Negocio *
                            </label>
                        </div>
          
                        <div class="group/input relative">
                            <select name="tipo_negocio" id="tipo_negocio_reg" required
                                    class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors appearance-none cursor-pointer">
                                <option value="" disabled selected>Selecciona un tipo de negocio</option>
                                <option value="barberia">Barbería</option>
                                <option value="salon">Salón de belleza</option>
                                <option value="peluqueria">Peluquería</option>
                                <option value="spa">Spa</option>
                                <option value="otros">Otros</option>
                            </select>
                            <label for="tipo_negocio_reg" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">
                                Tipo de Negocio *
                            </label>
                            <div class="absolute right-0 top-3.5 pointer-events-none text-[#9CA3AF]">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
   
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group/input relative">
                                <input type="tel" name="telefono" id="telefono_reg" required
                                       class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent">
                                <label for="telefono_reg" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all">
                                    Teléfono *
                                </label>
                            </div>
                            
                            <div class="group/input relative">
                                <input type="url" name="redes_sociales" id="redes_sociales_reg"
                                       class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent">
                                <label for="redes_sociales_reg" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">
                                    Redes Sociales (Link)
                                </label>
                            </div>
                        </div>
                        
                        <div class="group/input relative">
                            <input type="text" name="rfc" id="rfc_reg"
                                   class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent">
                            <label for="rfc_reg" class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">
                                RFC
                            </label>
                        </div>
                        
                        <div class="group/input relative">
                            <textarea name="acerca_de" id="acerca_de_reg" rows="4"
                                      class="peer w-full bg-transparent border border-[#374151] p-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent resize-y text-sm"></textarea>
                            <label for="acerca_de_reg" class="absolute left-3 -top-2.5 bg-[#1a1a1a] px-1 text-[#9CA3AF] text-xs">
                                Acerca de mi negocio
                            </label>
                        </div>
                        
                        <div class="border-t border-[#374151] pt-6 mt-6">
                            <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF] mb-4">Dirección</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group/input relative md:col-span-2">
                                    <input type="text" name="calle" id="calle_reg" required
                                           class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none">
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Calle *</label>
                                </div>
                                <div class="group/input relative">
                                    <input type="text" name="numero" id="numero_reg" required
                                           class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none">
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Número *</label>
                                </div>
                                <div class="group/input relative">
                                    <input type="text" name="colonia" id="colonia_reg" required
                                           class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none">
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Colonia *</label>
                                </div>
                                <div class="group/input relative">
                                    <input type="text" name="ciudad" id="ciudad_reg" required
                                           class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none">
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Ciudad *</label>
                                </div>
                                <div class="group/input relative">
                                    <input type="text" name="estado" id="estado_reg" required
                                           class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none">
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Estado *</label>
                                </div>
                                <div class="group/input relative">
                                    <input type="text" name="codigo_postal" id="cp_reg" required
                                           class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none">
                                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Código Postal *</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-[#374151] pt-6">
                            <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF] mb-4">Plan de Suscripción</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center gap-3 p-4 border border-[#374151] rounded-lg cursor-pointer hover:border-[#25B5DA] transition-all">
                                    <input type="radio" name="suscripcion_id" value="1" required class="accent-[#25B5DA]">
                                    <div>
                                        <span class="font-bold text-white">Plan Básico</span>
                                        <p class="text-xs text-[#9CA3AF]">$199/mes</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-4 border border-[#374151] rounded-lg cursor-pointer hover:border-[#25B5DA]">
                                    <input type="radio" name="suscripcion_id" value="2" class="accent-[#25B5DA]">
                                    <div>
                                        <span class="font-bold text-white">Plan Premium</span>
                                        <p class="text-xs text-[#9CA3AF]">$399/mes</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="border-t border-[#374151] pt-6">
                            <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF] mb-4">Imágenes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs text-[#9CA3AF] mb-2">Foto de perfil</label>
                                    <input type="file" name="foto_perfil" accept="image/*"
                                           class="w-full bg-[#1a1a1a] border border-[#374151] rounded px-4 py-2 text-white">
                                </div>
                                <div>
                                    <label class="block text-xs text-[#9CA3AF] mb-2">Banner</label>
                                    <input type="file" name="banner" accept="image/*"
                                           class="w-full bg-[#1a1a1a] border border-[#374151] rounded px-4 py-2 text-white">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" 
                                class="w-full py-4 bg-gradient-to-r from-[#25B5DA] to-[#1c8fb0] text-black font-bold uppercase tracking-wider rounded-lg hover:from-[#1c8fb0] hover:to-[#25B5DA] transition-all">
                            Registrar Negocio
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="flex flex-col items-center justify-center border border-[#374151]/30 bg-[#0f0f0f] p-12 relative overflow-hidden">
                <div class="relative z-10 text-center">
                    <div class="w-32 h-32 rounded-full bg-[#262626] border-2 border-[#374151] mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-store text-4xl text-[#9CA3AF]"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white uppercase tracking-wide">Tu Negocio</h2>
                    <p class="text-[#9CA3AF] text-sm mt-1">Completa el formulario para comenzar</p>
                </div>
            </div>
        </div>
    </div>

@else
@php
    // Extraer imágenes desde el array 'imagenes' por tipo
    $fotoPerfil = null;
    $bannerImg  = null;
    if (isset($negocio['imagenes']) && is_array($negocio['imagenes'])) {
        foreach ($negocio['imagenes'] as $img) {
            if (isset($img['tipo'])) {
                if ($img['tipo'] === 'perfil_negocio' && !empty($img['url_imagen'])) {
                    $fotoPerfil = $img['url_imagen'];
                }
                if ($img['tipo'] === 'banner_negocio' && !empty($img['url_imagen'])) {
                    $bannerImg = $img['url_imagen'];
                }
            }
        }
    }
    // Función helper para construir URL absoluta
    $buildUrl = function(?string $url) {
        if (!$url) return '';
        if (\Illuminate\Support\Str::startsWith($url, 'http')) return $url;
        return rtrim(config('services.api.url'), '/') . '/' . ltrim($url, '/');
    };
@endphp
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
        <div class="space-y-8">
            <form method="POST" id="editNegocioForm" action="{{ url('/api-proxy/api/negocios/mi-negocio') }}" data-redirect="{{ route('business.profile') }}" class="space-y-8" enctype="multipart/form-data" data-custom-handler="false">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div class="group/input relative mt-2 md:mt-0">
                        <input type="text" name="nombre" id="nombre_edit" value="{{ old('nombre', $negocio['nombre'] ?? '') }}" placeholder="Ej. Barbería El Maestro" required maxlength="100" class="peer w-full bg-transparent border-b @error('nombre') border-red-500 @else border-[#374151] @enderror py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" />
                        <label for="nombre_edit" class="absolute left-0 -top-3.5 @error('nombre') text-red-500 @else text-[#9CA3AF] @enderror text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">Nombre del Negocio *</label>
                        @error('nombre')<span class="text-red-500 text-xs mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span>@enderror
                    </div>
                    
                    <div class="group/input relative mt-6">
                        <select name="tipo_negocio" id="tipo_negocio_edit" required class="peer w-full bg-transparent border-b @error('tipo_negocio') border-red-500 @else border-[#374151] @enderror py-3 text-white focus:border-white focus:outline-none transition-colors appearance-none cursor-pointer">
                            <option value="" disabled {{ empty($negocio['tipo_negocio']) ? 'selected' : '' }}>Selecciona un tipo de negocio</option>
                            @php 
                                $tipos = ['barberia' => 'Barbería', 'salon' => 'Salón', 'peluqueria' => 'Peluquería', 'spa' => 'Spa', 'otros' => 'Otros'];
                            @endphp
                            @foreach($tipos as $val => $label)
                                <option value="{{ $val }}" class="bg-[#1a1a1a] text-white" {{ (strtolower($negocio['tipo_negocio'] ?? '') === $val) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <label for="tipo_negocio_edit" class="absolute left-0 -top-3.5 @error('tipo_negocio') text-red-500 @else text-[#9CA3AF] @enderror text-xs">Tipo de Negocio *</label>
                        <div class="absolute right-0 top-3.5 pointer-events-none text-[#9CA3AF]"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="group/input relative">
                            <input type="tel" name="telefono" id="telefono_edit" value="{{ old('telefono', $negocio['telefono'] ?? '') }}" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" />
                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Teléfono</label>
                        </div>
                        <div class="group/input relative">
                            <input type="url" name="redes_sociales" id="redes_sociales_edit" value="{{ old('redes_sociales', $negocio['redes_sociales'] ?? '') }}" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none" />
                            <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Redes Sociales</label>
                        </div>
                    </div>
           
                    <div class="group/input relative">
                        <input type="text" name="rfc" id="rfc_edit" value="{{ old('rfc', $negocio['rfc'] ?? '') }}" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none" />
                        <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">RFC</label>
                    </div>
                    
                    <div class="group/input relative">
                        <textarea name="acerca_de" id="acerca_de_edit" rows="4" class="peer w-full bg-transparent border border-[#374151] p-3 text-white focus:border-white focus:outline-none transition-colors resize-y text-sm">{{ old('acerca_de', $negocio['acerca_de'] ?? '') }}</textarea>
                        <label class="absolute left-3 -top-2.5 bg-[#1a1a1a] px-1 text-[#9CA3AF] text-xs">Acerca de mi negocio</label>
                    </div>
                    
                    <div class="border-t border-[#374151] pt-6 mt-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-3">
                            <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF]">Dirección</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="group/input relative md:col-span-2">
                                <input type="text" name="calle" value="{{ old('calle', $negocio['direccion']['calle'] ?? '') }}" required class="w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Calle *</label>
                            </div>
                            <div class="group/input relative">
                                <input type="text" name="numero" value="{{ old('numero', $negocio['direccion']['numero'] ?? '') }}" required class="w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Número *</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="group/input relative">
                                <input type="text" name="colonia" value="{{ old('colonia', $negocio['direccion']['colonia'] ?? '') }}" required class="w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Colonia *</label>
                            </div>
                            <div class="group/input relative">
                                <input type="text" name="codigo_postal" value="{{ old('codigo_postal', $negocio['direccion']['codigo_postal'] ?? '') }}" required class="w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Código Postal *</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group/input relative">
                                <input type="text" name="ciudad" value="{{ old('ciudad', $negocio['direccion']['ciudad'] ?? '') }}" required class="w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Ciudad *</label>
                            </div>
                            <div class="group/input relative">
                                <input type="text" name="estado" value="{{ old('estado', $negocio['direccion']['estado'] ?? '') }}" required class="w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors" />
                                <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs">Estado *</label>
                            </div>
                        </div>
                    </div>

                    <!-- CAMPOS: IMÁGENES -->
                    <div class="border-t border-[#374151] pt-6 mt-8">
                        <h3 class="text-xs uppercase tracking-wider text-[#9CA3AF] mb-6">Imágenes del Negocio</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Foto Perfil -->
                            <div class="space-y-4">
                                <label class="block text-xs text-[#9CA3AF] uppercase tracking-wider">Foto de Perfil</label>
                                @php
                                    // Priorizar imagen desde array 'imagenes', luego campo directo
                                    $prevPerfil = $buildUrl($fotoPerfil);
                                    if (!$prevPerfil) {
                                        if (isset($negocio['foto_perfil']) && is_array($negocio['foto_perfil']) && isset($negocio['foto_perfil']['url_imagen'])) {
                                            $prevPerfil = $buildUrl($negocio['foto_perfil']['url_imagen']);
                                        } elseif (isset($negocio['foto_perfil']) && is_string($negocio['foto_perfil']) && !empty($negocio['foto_perfil'])) {
                                            $prevPerfil = $buildUrl($negocio['foto_perfil']);
                                        }
                                    }
                                @endphp
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-full bg-[#1a1a1a] border border-[#374151] overflow-hidden flex-shrink-0 relative">
                                        <img id="preview_img_perfil" src="{{ $prevPerfil }}" class="w-full h-full object-cover {{ empty($prevPerfil) ? 'hidden' : '' }}">
                                        @if(empty($prevPerfil))
                                            <div id="placeholder_perfil" class="absolute inset-0 flex items-center justify-center text-[#374151]"><i class="fas fa-store"></i></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="foto_perfil" id="input_foto_perfil" accept="image/*" class="w-full text-xs text-[#9CA3AF] file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#25B5DA]/10 file:text-[#25B5DA] hover:file:bg-[#25B5DA]/20 transition-all cursor-pointer">
                                        <p class="mt-1 text-[10px] text-[#6B7280]">Recomendado: 500x500px, máx 2MB</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Banner -->
                            <div class="space-y-4">
                                <label class="block text-xs text-[#9CA3AF] uppercase tracking-wider">Banner Principal</label>
                                @php
                                    // Priorizar imagen desde array 'imagenes', luego campo directo
                                    $prevBanner = $buildUrl($bannerImg);
                                    if (!$prevBanner) {
                                        if (isset($negocio['banner']) && is_array($negocio['banner']) && isset($negocio['banner']['url_imagen'])) {
                                            $prevBanner = $buildUrl($negocio['banner']['url_imagen']);
                                        } elseif (isset($negocio['banner']) && is_string($negocio['banner']) && !empty($negocio['banner'])) {
                                            $prevBanner = $buildUrl($negocio['banner']);
                                        }
                                    }
                                @endphp
                                <div class="flex items-center gap-4">
                                    <div class="w-24 h-16 rounded bg-[#1a1a1a] border border-[#374151] overflow-hidden flex-shrink-0 relative">
                                        <img id="preview_img_banner" src="{{ $prevBanner }}" class="w-full h-full object-cover {{ empty($prevBanner) ? 'hidden' : '' }}">
                                        @if(empty($prevBanner))
                                            <div id="placeholder_banner" class="absolute inset-0 flex items-center justify-center text-[#374151]"><i class="fas fa-image"></i></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="banner" id="input_banner" accept="image/*" class="w-full text-xs text-[#9CA3AF] file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#25B5DA]/10 file:text-[#25B5DA] hover:file:bg-[#25B5DA]/20 transition-all cursor-pointer">
                                        <p class="mt-1 text-[10px] text-[#6B7280]">Recomendado: 1200x400px, máx 5MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="pt-6">
                    <button type="submit" class="w-full py-4 px-6 bg-[#F3F4F6] text-[#1a1a1a] font-bold tracking-widest uppercase text-sm border border-transparent transition-all duration-300 hover:bg-white hover:shadow-[0_0_15px_rgba(255,255,255,0.3)]">Guardar Cambios</button>
                </div>
            </form>
        </div>
        
        <div class="flex flex-col items-center justify-center border border-[#374151]/30 bg-[#0f0f0f] p-12 relative overflow-hidden">
            <div class="relative z-10 text-center">
                <div class="w-32 h-32 rounded-full bg-[#262626] border-2 border-[#374151] mx-auto mb-6 flex items-center justify-center overflow-hidden">
                    @php
                        // Priorizar imagen desde array 'imagenes', luego campo directo
                        $sidePerfil = $buildUrl($fotoPerfil);
                        if (!$sidePerfil) {
                            if (isset($negocio['foto_perfil']) && is_array($negocio['foto_perfil']) && isset($negocio['foto_perfil']['url_imagen'])) {
                                $sidePerfil = $buildUrl($negocio['foto_perfil']['url_imagen']);
                            } elseif (isset($negocio['foto_perfil']) && is_string($negocio['foto_perfil']) && !empty($negocio['foto_perfil'])) {
                                $sidePerfil = $buildUrl($negocio['foto_perfil']);
                            }
                        }
                    @endphp
                    @if($sidePerfil)
                        <img id="side_preview_perfil" src="{{ $sidePerfil }}" class="w-full h-full object-cover">
                    @else
                        <img id="side_preview_perfil" src="" class="w-full h-full object-cover hidden">
                        <i id="side_placeholder_perfil" class="fas fa-store text-4xl text-[#9CA3AF]"></i>
                    @endif
                </div>
                <h2 class="text-2xl font-bold text-white uppercase tracking-wide">{{ $negocio['nombre'] ?? 'Mi Negocio' }}</h2>
                <p class="text-[#9CA3AF] text-sm mt-1 uppercase">{{ $negocio['tipo_negocio'] ?? '' }}</p>
            </div>
        </div>
    </div>
@endif

</section>

<script>
function mostrarFormularioRegistro() {
    const mensajeBienvenida = document.querySelector('#tab-info > .flex');
    if (mensajeBienvenida) mensajeBienvenida.classList.add('hidden');
    
    const formularioRegistro = document.getElementById('formulario-registro');
    if (formularioRegistro) formularioRegistro.classList.remove('hidden');
}

// Manejar envío del formulario de registro
const registroForm = document.getElementById('registro-negocio-form');
if (registroForm) {
    registroForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const token = '{{ session('api_token') }}'; // Ajustado según tus middlewares
        
        if (typeof showLoader === 'function') showLoader();
        
        try {
            const response = await fetch('/api-proxy/negocio/completar', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                showToast('¡Negocio registrado exitosamente!', 'success');
                window.location.reload();
            } else {
                showToast(data.message || 'Error al registrar negocio', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Error de conexión al servidor', 'error');
        } finally {
            if (typeof hideLoader === 'function') hideLoader();
        }
    });
}
</script>

<script>
    document.getElementById('input_foto_perfil')?.addEventListener('change', function(e) {
        if(e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview_img_perfil');
                img.src = e.target.result;
                img.classList.remove('hidden');
                
                // Update side panel preview as well
                const sideImg = document.getElementById('side_preview_perfil');
                if(sideImg) { sideImg.src = e.target.result; sideImg.classList.remove('hidden'); }
                
                const placeholder = document.getElementById('placeholder_perfil');
                if(placeholder) placeholder.classList.add('hidden');
                
                const sidePlaceholder = document.getElementById('side_placeholder_perfil');
                if(sidePlaceholder) sidePlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    document.getElementById('input_banner')?.addEventListener('change', function(e) {
        if(e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview_img_banner');
                img.src = e.target.result;
                img.classList.remove('hidden');
                
                const placeholder = document.getElementById('placeholder_banner');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>

<script>
    const editNegocioForm = document.getElementById('editNegocioForm');
    if (editNegocioForm) {
        editNegocioForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (typeof showLoader === 'function') showLoader();
            
            const formData = new FormData(this);
            const action = this.getAttribute('action');
            const redirectUrl = this.getAttribute('data-redirect');
            const csrfToken = getCsrfToken();
            const authToken = '{{ session("auth_token") }}';

            // Limpiar campos de archivo vacíos para no enviar límites multipart vacíos
            const fileInputs = this.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                if (!input.files || !input.files.length) {
                    formData.delete(input.name);
                }
            });

            // Eliminar campo 'estado' si existe, ya que colisiona con el estado geográfico
            formData.delete('estado');

            // === DEBUG ===
            console.log('=== DEBUG ENVÍO NEGOCIO ===');
            console.log('URL:', action);
            console.log('Auth token existe:', !!authToken);
            console.log('CSRF token existe:', !!csrfToken);
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    console.log(`  ${key}: [ARCHIVO] "${value.name}" (${value.size} bytes, ${value.type})`);
                } else {
                    console.log(`  ${key}: ${value}`);
                }
            }
            console.log('=== FIN DEBUG ===');
            
            try {
                const response = await fetch(action, {
                    method: 'POST', // siempre POST; _method=PUT en el FormData maneja el spoofing
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Authorization': 'Bearer ' + authToken,
                    },
                    body: formData
                });
                
                console.log('Respuesta HTTP status:', response.status);

                let data = {};
                try {
                    data = await response.json();
                } catch (err) {
                    data = { message: 'Error procesando respuesta del servidor' };
                }
                
                console.log('Respuesta completa:', data);

                if (response.ok) {
                    if (typeof showToast === 'function') {
                        showToast(data.message || 'Información del negocio actualizada', 'success');
                    }
                    setTimeout(() => {
                        window.location.href = redirectUrl || window.location.href;
                    }, 1200);
                } else {
                    if (data.errors) {
                        const msgs = Object.entries(data.errors)
                            .map(([f, errs]) => `${f}: ${errs.join(', ')}`)
                            .join('\n');
                        if (typeof showToast === 'function') showToast(msgs, 'error');
                    } else {
                        if (typeof showToast === 'function') showToast(data.message || 'Error al actualizar el negocio', 'error');
                    }
                    if (typeof hideLoader === 'function') hideLoader();
                }
            } catch (error) {
                console.error('Error de red:', error);
                if (typeof showToast === 'function') showToast('Error de conexión con el servidor', 'error');
                if (typeof hideLoader === 'function') hideLoader();
            }
        });
    }
</script>