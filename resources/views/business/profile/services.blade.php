<!-- TAB 2: SERVICIOS -->
<section id="tab-services" class="hidden animate-fade-in-up">
    <div class="flex flex-col lg:flex-row gap-12">
        
        <!-- Left: Services List -->
        <div class="w-full lg:w-1/2 space-y-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold uppercase tracking-wide text-white">Mis Servicios</h2>
                @if(isset($services) && count($services) > 0)
                    <span id="services-total" class="text-xs text-[#9CA3AF] tracking-widest">
                        TOTAL: {{ count($services) }}
                    </span>
                @endif
            </div>

            @foreach($services as $service)
                <div id="service-{{ $service['id'] }}" class="service-card flex bg-[#1a1a1a] border border-[#374151] p-4 gap-4 hover:border-[#F3F4F6]/50 transition-all duration-300 group">
                    {{-- IMAGEN --}}
                    <div class="w-24 h-24 shrink-0 bg-[#262626] rounded overflow-hidden">
                        @if($service['imagen'])
                            <img src="{{ $service['imagen'] }}?v={{ time() }}" class="block w-24 h-24 object-cover">
                        @else
                            <div class="w-24 h-24 flex items-center justify-center text-[#374151] text-xs">
                                SIN IMAGEN
                            </div>
                        @endif
                    </div>

                    {{-- CONTENIDO --}}
                    <div class="flex-grow flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-white font-bold uppercase tracking-wide text-sm">
                                    {{ $service['nombre'] }}
                                </h3>
                                <p class="text-[#9CA3AF] text-[10px] mt-1">
                                    {{ $service['descripcion'] ?? 'Sin descripción' }}
                                </p>
                            </div>
                            <span class="text-lg font-bold text-white">
                                ${{ $service['precio'] }}
                            </span>
                        </div>

                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button 
                                onclick='openEditModal(
                                    @json($service["id"]),
                                    @json($service["nombre"]),
                                    @json($service["descripcion"] ?? ""),
                                    @json($service["precio"]),
                                    @json($service["duracion"] ?? 0),
                                    @json($service["imagen"] ?? null)
                                )'
                                class="text-[10px] uppercase tracking-widest text-[#9CA3AF] hover:text-white">
                                Editar
                            </button>

                            <button onclick="openDeleteModal({{ $service['id'] }}, '{{ $service['nombre'] }}')" class="text-[10px] uppercase tracking-widest text-red-500 hover:text-red-400">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Right: Add Service Form -->
        <div class="w-full lg:w-1/2 border-l border-[#374151]/30 lg:pl-12">
            <div class="mb-8">
                <h2 class="text-3xl font-bold uppercase tracking-wide text-white">
                    Agregar Servicio
                </h2>
                <p class="text-[#9CA3AF] text-xs mt-2 tracking-wide">
                    COMPLETA LOS DETALLES DEL NUEVO SERVICIO
                </p>
            </div>

            <form method="POST" action="{{ route('business.services.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                {{-- NOMBRE --}}
                <div class="group/input relative">
                    <input type="text" name="nombre" value="{{ old('nombre') }}" maxlength="100" required class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Nombre del servicio" />
                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                        Nombre del servicio
                    </label>
                    @error('nombre')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="group/input relative">
                    <input type="text" name="descripcion" value="{{ old('descripcion') }}" maxlength="255" class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Descripción breve" />
                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                        Descripción breve
                    </label>
                    @error('descripcion')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">
                        Imagen del servicio
                    </label>
                    <input type="file" name="imagen" accept="image/*" class="w-full text-xs text-[#9CA3AF]">
                </div>

                {{-- PRECIO --}}
                <div class="group/input relative">
                    <input type="number" name="precio" value="{{ old('precio') }}" min="1" max="10000" step="0.01" required class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Precio" />
                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                        Precio
                    </label>
                    @error('precio')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DURACIÓN --}}
                <div class="group/input relative">
                    <input type="number" name="duracion" value="{{ old('duracion') }}" min="5" max="480" required class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Duración (Minutos)" />
                    <label class="absolute left-0 -top-3.5 text-[#9CA3AF] text-xs transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-white">
                        Duración (Minutos)
                    </label>
                    @error('duracion')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-4 px-6 bg-[#1a1a1a] text-[#F3F4F6] font-bold tracking-widest uppercase text-sm border border-[#374151] transition-all duration-300 hover:bg-[#F3F4F6] hover:text-[#1a1a1a] mt-4">
                    Agregar Servicio
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Modales de Servicios -->
<div id="modal-edit-service" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="closeEditModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-8 w-full max-w-md">
        <h3 id="editModalTitle" class="text-white font-bold mb-6 uppercase">Editar Servicio</h3>
        <form method="POST" id="editServiceForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <div class="space-y-5">
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">Imagen actual</label>
                    <img id="edit_imagen_preview" class="w-full h-40 object-cover rounded-lg mb-3 hidden border border-[#374151]" alt="Imagen del servicio">
                </div>
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">Cambiar imagen</label>
                    <input type="file" name="imagen" id="edit_imagen" accept="image/*" class="w-full text-xs text-[#9CA3AF]">
                </div>
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">Nombre del servicio</label>
                    <input type="text" name="nombre" id="edit_nombre" maxlength="100" required class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
                </div>
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">Descripción</label>
                    <input type="text" name="descripcion" id="edit_descripcion" maxlength="255" class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
                </div>
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">Precio ($)</label>
                    <input type="number" name="precio" id="edit_precio" min="1" max="10000" step="0.01" required class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
                </div>
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">Duración (minutos)</label>
                    <input type="number" name="duracion" id="edit_duracion" min="5" max="480" required class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
                </div>
            </div>
            <button class="mt-6 w-full bg-white text-black py-2 uppercase text-xs font-bold">Guardar Cambios</button>
        </form>
    </div>
</div>

<div id="modal-delete-service" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="closeDeleteModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-8 w-full max-w-md">
        <h3 class="text-red-500 font-bold mb-4 uppercase">Confirmar eliminación</h3>
        <p class="text-white text-sm mb-6">¿Estás seguro que deseas eliminar <span id="deleteServiceName" class="font-bold"></span>?</p>
        <form method="POST" id="deleteServiceForm">
            @csrf
            @method('DELETE')
            <div class="flex gap-4">
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-2 border border-[#374151] text-white text-xs uppercase">Cancelar</button>
                <button type="submit" class="w-1/2 py-2 bg-red-600 text-white text-xs uppercase font-bold hover:bg-red-700">Eliminar</button>
            </div>
        </form>
    </div>
</div>
