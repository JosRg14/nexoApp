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

            <form method="POST" action="{{ url('/api-proxy/api/servicios') }}" data-redirect="{{ route('business.profile') }}" enctype="multipart/form-data" class="space-y-6" data-custom-handler="false">
                @csrf
                {{-- NOMBRE --}}
                <div class="group/input relative">
                    <input type="text" name="nombre_servicio" value="{{ old('nombre') }}" maxlength="100" required class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Nombre del servicio" />
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
                    <label for="imagen" class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#374151] border-dashed rounded-lg cursor-pointer bg-[#1a1a1a] hover:bg-[#262626] hover:border-white transition-all group overflow-hidden">
                        <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fa-solid fa-image text-2xl text-[#9CA3AF] mb-3 group-hover:text-white transition-colors"></i>
                            <p class="mb-2 text-xs text-[#9CA3AF] font-bold group-hover:text-white uppercase tracking-widest">Subir imagen</p>
                            <p class="text-[10px] text-[#9CA3AF]">PNG, JPG o JPEG (MÁX. 2MB)</p>
                        </div>
                        <input id="imagen" name="imagen" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" onchange="handleImagePreview(this, 'preview-container', 'preview-img')" />
                    </label>
                    
                    <div id="preview-container" class="mt-4 hidden animate-fade-in">
                        <p class="text-[10px] text-[#9CA3AF] uppercase tracking-widest mb-2 font-bold">Vista previa:</p>
                        <img id="preview-img" class="w-full h-40 object-cover rounded border border-[#374151]" />
                    </div>
                    
                    <p id="image-error" class="text-red-400 text-[10px] mt-2 hidden uppercase tracking-widest font-bold">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i> Archivo inválido. Solo se permiten imágenes PNG, JPG o JPEG.
                    </p>
                    
                    <p class="text-[10px] text-[#9CA3AF] mt-2 uppercase tracking-widest">
                        Formatos permitidos: PNG, JPG, JPEG
                    </p>
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
                    <input type="number" name="duracion_estimada" value="{{ old('duracion') }}" min="5" max="480" required class="peer w-full bg-transparent border-b border-[#374151] py-3 text-white focus:border-white focus:outline-none transition-colors placeholder-transparent" placeholder="Duración (Minutos)" />
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

    <!-- Gestión de Evidencias -->
    <div class="mt-12 pt-8 border-t border-[#374151] w-full">
        <h3 class="text-xl font-bold uppercase tracking-widest text-white mb-6 flex items-center gap-2">
            <i class="fas fa-camera text-[#25B5DA]"></i>
            Galería de Trabajos (Evidencias)
        </h3>
        <div id="admin-evidencias-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div class="col-span-full py-8 text-center text-[#9CA3AF]">
                <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                <p class="text-xs uppercase tracking-widest">Cargando galería...</p>
            </div>
        </div>
    </div>
</section>

<!-- Modales de Servicios -->
<div id="modal-edit-service" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/80" onclick="closeEditModal()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-8 w-full max-w-md">
        <h3 id="editModalTitle" class="text-white font-bold mb-6 uppercase">Editar Servicio</h3>
        <form method="POST" id="editServiceForm" data-redirect="{{ route('business.profile') }}" enctype="multipart/form-data" data-custom-handler="false">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <div class="space-y-5">
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-2">Imagen actual / Vista previa</label>
                    <div class="relative">
                        <img id="edit_imagen_preview" class="w-full h-40 object-cover rounded border border-[#374151] mb-3 hidden" alt="Imagen del servicio">
                    </div>
                    
                    <label for="edit_imagen" class="flex flex-col items-center justify-center w-full h-24 border-2 border-[#374151] border-dashed rounded-lg cursor-pointer bg-[#1a1a1a] hover:bg-[#262626] hover:border-white transition-all group overflow-hidden">
                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                            <i class="fa-solid fa-cloud-arrow-up text-lg text-[#9CA3AF] mb-1 group-hover:text-white"></i>
                            <p class="text-[10px] text-[#9CA3AF] font-bold group-hover:text-white uppercase">Cambiar imagen</p>
                        </div>
                        <input id="edit_imagen" name="imagen" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" onchange="handleImagePreview(this, 'edit_preview_wrapper', 'edit_imagen_preview', true)" />
                    </label>

                    <p id="edit-image-error" class="text-red-400 text-[10px] mt-2 hidden uppercase tracking-widest font-bold">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i> Archivo inválido.
                    </p>

                    <p class="text-[10px] text-[#9CA3AF] mt-2 uppercase tracking-widest">
                        Formatos permitidos: PNG, JPG, JPEG
                    </p>
                </div>
                <div>
                    <label class="block text-xs text-[#9CA3AF] uppercase tracking-widest mb-1">Nombre del servicio</label>
                    <input type="text" name="nombre_servicio" id="edit_nombre" maxlength="100" required class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
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
                    <input type="number" name="duracion_estimada" id="edit_duracion" min="5" max="480" required class="w-full bg-transparent border-b border-[#374151] py-2 text-white focus:border-white outline-none">
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
        <form method="POST" id="deleteServiceForm" data-custom-handler="false">
            @csrf
            @method('DELETE')
            <div class="flex gap-4">
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 py-2 border border-[#374151] text-white text-xs uppercase">Cancelar</button>
                <button type="submit" class="w-1/2 py-2 bg-red-600 text-white text-xs uppercase font-bold hover:bg-red-700">Eliminar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
               document.querySelector('input[name="_token"]')?.value;
    }

    // --- CIERRE CORRECTO DE openDeleteModal ---
    function openDeleteModal(id, nombre) 
    {
        console.log('🗑️ Abriendo modal de eliminación para servicio ID:', id);
        document.getElementById('deleteServiceName').innerText = nombre;
        const form = document.getElementById('deleteServiceForm');
        form.action = '/api-proxy/api/servicios/' + id;
        document.getElementById('modal-delete-service').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('modal-delete-service').classList.add('hidden');
    }

    function openEditModal(id, nombre, descripcion, precio, duracion, imagen) {
        console.log('=== openEditModal DEBUG ===');
        console.log('ID:', id);
        console.log('Nombre:', nombre);
        console.log('Descripcion:', descripcion);
        console.log('Precio:', precio);
        console.log('Duracion:', duracion);
        
        const modal = document.getElementById('modal-edit-service');
        const form = document.getElementById('editServiceForm');
        
        // Seteamos los campos del formulario
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_descripcion').value = descripcion || '';
        document.getElementById('edit_precio').value = precio;
        document.getElementById('edit_duracion').value = duracion;
        
        // Verificar después de asignar
        console.log('Input nombre valor:', document.getElementById('edit_nombre').value);
        console.log('Input precio valor:', document.getElementById('edit_precio').value);
        console.log('Input duracion valor:', document.getElementById('edit_duracion').value);
        
        // Manejo de la previsualización de imagen
        const previewImg = document.getElementById('edit_imagen_preview');
        if (imagen) {
            previewImg.src = imagen;
            previewImg.classList.remove('hidden');
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden');
        }
        
        // CORRECCIÓN: Setear el action correctamente para la API
        form.action = '/api-proxy/api/servicios/' + id;
        
        // Mostramos el modal
        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modal-edit-service').classList.add('hidden');
    }

    function handleImagePreview(input, containerId, imgId, isEdit = false) {
        const errorId = isEdit ? 'edit-image-error' : 'image-error';
        const errorElement = document.getElementById(errorId);
        const container = document.getElementById(containerId);
        const img = document.getElementById(imgId);
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            
            if (!validTypes.includes(file.type)) {
                if (errorElement) errorElement.classList.remove('hidden');
                input.value = '';
                if (!isEdit && container) container.classList.add('hidden');
                return;
            }
            
            if (errorElement) errorElement.classList.add('hidden');
            const reader = new FileReader();
            
            reader.onload = function(e) {
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (!isEdit && container) container.classList.remove('hidden');
            };
            
            reader.readAsDataURL(file);
        }
    }

    // --- LOGICA DE EVIDENCIAS EN EL PANEL ADMIN ---
    let adminEvidenciasData = [];

    document.addEventListener('DOMContentLoaded', () => {
        cargarEvidenciasAdmin();
    });

    async function cargarEvidenciasAdmin() {
        const grid = document.getElementById('admin-evidencias-grid');
        if (!grid) return;
        
        grid.innerHTML = `
            <div class="col-span-full py-8 text-center text-[#9CA3AF]">
                <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                <p class="text-xs uppercase tracking-widest">Cargando galería...</p>
            </div>
        `;
        
        try {
            const res = await fetch('/api-proxy/evidencias', {
                headers: { 'Accept': 'application/json' }
            });
            
            if (!res.ok) {
                throw new Error(`HTTP ${res.status}`);
            }
            
            const json = await res.json();
            
            if (json.success && json.data) {
                renderAdminEvidencias(json.data);
            } else {
                renderAdminEvidencias([]);
            }
        } catch (error) {
            console.error("Error cargando evidencias:", error);
            renderAdminEvidencias([]);
        }
    }

    function renderAdminEvidencias(evidencias) {
        adminEvidenciasData = evidencias;
        const grid = document.getElementById('admin-evidencias-grid');
        
        if (!grid) return;
        grid.innerHTML = '';

        if (evidencias.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full py-12 text-center text-[#9CA3AF]">
                    <i class="fas fa-images text-4xl mb-3 opacity-50"></i>
                    <p class="text-sm">No hay evidencias registradas en tu negocio.</p>
                </div>
            `;
            return;
        }

        // Usar la URL base desde un meta tag o definirla manualmente
        const baseUrl = "https://devlink-servidorapi.td60xq.easypanel.host";

        evidencias.forEach(ev => {
            const isPublic = ev.publica === true || ev.publica === 1;
            let imgUrl = ev.url_imagen;
            if (imgUrl && !imgUrl.startsWith('http')) {
                imgUrl = baseUrl + (imgUrl.startsWith('/') ? '' : '/') + imgUrl;
            }

            const nombreServicio = ev.servicio_nombre || 'General';
            const idItem = ev.id_evidencia || ev.id;

            const card = document.createElement('div');
            card.className = 'bg-[#262626] border border-[#374151] rounded-lg overflow-hidden flex flex-col group transition-colors hover:border-[#F3F4F6]/50';
            card.innerHTML = `
                <div class="relative h-32 overflow-hidden bg-[#1a1a1a]">
                    <img src="${imgUrl}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 ${!isPublic ? 'opacity-60' : ''}" alt="${nombreServicio}">
                </div>
                <div class="p-3 flex flex-col flex-grow justify-between">
                    <div>
                        <p class="text-white text-xs font-bold truncate uppercase tracking-widest mb-1" title="${nombreServicio}">${nombreServicio}</p>
                        ${ev.descripcion ? `<p class="text-[10px] text-[#9CA3AF] line-clamp-2 leading-tight">${ev.descripcion}</p>` : ''}
                    </div>
                    <div class="flex justify-between items-center mt-3 pt-2 border-t border-[#374151]">
                        <button onclick="toggleEvidenciaState(${idItem}, ${!isPublic})" class="text-[10px] font-bold uppercase ${isPublic ? 'text-[#25B5DA]' : 'text-[#9CA3AF]'} hover:brightness-125 transition-all flex items-center gap-1">
                            <i class="fas ${isPublic ? 'fa-eye' : 'fa-eye-slash'}"></i> ${isPublic ? 'Pública' : 'Privada'}
                        </button>
                        <button onclick="deleteEvidenciaItem(${idItem})" class="text-red-500 hover:text-red-400 text-xs transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    async function toggleEvidenciaState(id, makePublic) {
        if (typeof showLoader === 'function') showLoader();
        try {
            const token = document.querySelector('input[name="_token"]')?.value || 
                          document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                          
            const res = await fetch(`/api-proxy/evidencias/${id}/publica`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ publica: makePublic })
            });

            const data = await res.json();
            
            if (data.success || res.ok) {
                const evIndex = adminEvidenciasData.findIndex(e => (e.id_evidencia || e.id) === id);
                if (evIndex !== -1) {
                    adminEvidenciasData[evIndex].publica = makePublic;
                    renderAdminEvidencias(adminEvidenciasData);
                    if (typeof showToast === 'function') showToast(`Evidencia ${makePublic ? 'publicada' : 'privada'}`, 'success');
                }
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error al cambiar visibilidad', 'error');
            }
        } catch (error) {
            console.error(error);
            if (typeof showToast === 'function') showToast('Error de conexión', 'error');
        } finally {
            if (typeof hideLoader === 'function') hideLoader();
        }
    }

    async function deleteEvidenciaItem(id) {
        if (!confirm('¿Estás seguro de eliminar esta evidencia permanentemente?')) return;
        
        if (typeof showLoader === 'function') showLoader();
        try {
            const token = document.querySelector('input[name="_token"]')?.value || 
                          document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                          
            const res = await fetch(`/api-proxy/evidencias/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });

            const data = await res.json();
            
            if (data.success || res.ok) {
                adminEvidenciasData = adminEvidenciasData.filter(e => (e.id_evidencia || e.id) !== id);
                renderAdminEvidencias(adminEvidenciasData);
                if (typeof showToast === 'function') showToast('Evidencia eliminada', 'success');
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error al eliminar', 'error');
            }
        } catch (error) {
            console.error(error);
            if (typeof showToast === 'function') showToast('Error de conexión', 'error');
        } finally {
            if (typeof hideLoader === 'function') hideLoader();
        }
    }

    // --- CONTROLADORES DE SUBMIT DIRECTOS ---

    // Para el formulario de agregar servicio (nuevo)
    document.querySelector('form[action*="/api-proxy/api/servicios"]:not(#editServiceForm):not(#deleteServiceForm)')
        ?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const redirectUrl = form.getAttribute('data-redirect') || window.location.href;
        const token = getCsrfToken();
        
        if (typeof showLoader === 'function') showLoader();
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok) {
                if (typeof showToast === 'function') showToast(data.message || 'Servicio creado', 'success');
                setTimeout(() => { window.location.href = redirectUrl; }, 1000);
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error al crear servicio', 'error');
            }
        } catch (error) {
            console.error(error);
            if (typeof showToast === 'function') showToast('Error de conexión', 'error');
        } finally {
            if (typeof hideLoader === 'function') hideLoader();
        }
    });

    // Para el formulario de editar servicio
    document.getElementById('editServiceForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const action = form.action;
        const token = getCsrfToken();
        
        // 🔥 LOG DE DEPURACIÓN: verificar qué campos contiene el FormData
        console.log('=== FORMULARIO EDITAR SERVICIO ===');
        console.log('Action:', action);
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        // ✅ SIEMPRE usar 'POST' en fetch — PHP no parsea body multipart en PUT/PATCH.
        // El campo _method=PUT dentro del FormData hace el method spoofing de Laravel.
        const method = 'POST';
        
        showLoader();
        
        try {
            const response = await fetch(action, {
                method: method,
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok) {
                if (typeof showToast === 'function') showToast(data.message || 'Servicio actualizado', 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error', 'error');
            }
        } catch (error) {
            console.error(error);
            if (typeof showToast === 'function') showToast('Error de conexión', 'error');
        } finally {
            hideLoader();
        }
    });

    // Para el formulario de eliminar servicio
    document.getElementById('deleteServiceForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = this;
        const action = form.action;
        const token = getCsrfToken();
        
        if (typeof showLoader === 'function') showLoader();
        
        try {
            const response = await fetch(action, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success !== false) {
                if (typeof showToast === 'function') showToast(data.message || 'Servicio eliminado', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error al eliminar', 'error');
            }
        } catch (error) {
            console.error(error);
            if (typeof showToast === 'function') showToast('Error de conexión', 'error');
        } finally {
            if (typeof hideLoader === 'function') hideLoader();
            if (typeof closeDeleteModal === 'function') closeDeleteModal();
        }
    });
</script>