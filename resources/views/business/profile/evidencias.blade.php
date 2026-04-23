<!-- TAB: EVIDENCIAS -->
<section id="tab-evidencias" class="hidden animate-fade-in-up">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold uppercase tracking-wide text-white">Galería de Evidencias</h2>
            <p class="text-[#9CA3AF] text-xs mt-1">Gestiona los trabajos o fotos de todos tus servicios</p>
        </div>
        <span id="evidencias-global-total" class="text-xs text-[#9CA3AF] tracking-widest font-bold">TOTAL: 0</span>
    </div>

    <!-- Contenedor dinámico del Grid -->
    <div id="grid-evidencias" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <!-- Estado de carga -->
        <div class="col-span-full py-8 text-center text-[#9CA3AF]">
            <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
            <p class="text-xs uppercase tracking-widest">Cargando galería...</p>
        </div>
    </div>
</section>

<script>
    let panelEvidenciasData = [];

    document.addEventListener('DOMContentLoaded', () => {
        cargarEvidenciasAdmin();
    });

    async function cargarEvidenciasAdmin() {
        try {
            const res = await fetch('/api-proxy/evidencias');
            const json = await res.json();
            if(json.success && json.data) {
                renderGridEvidencias(json.data);
            } else {
                renderGridEvidencias([]);
            }
        } catch (error) {
            console.error("Error cargando evidencias", error);
            renderGridEvidencias([]);
        }
    }

    function renderGridEvidencias(evidencias) {
        panelEvidenciasData = evidencias;
        const grid = document.getElementById('grid-evidencias');
        const total = document.getElementById('evidencias-global-total');
        
        grid.innerHTML = '';
        total.innerText = `TOTAL: ${evidencias.length}`;

        if(evidencias.length === 0) {
            grid.innerHTML = `
                <div class="col-span-full py-12 text-center text-[#9CA3AF]">
                    <i class="fas fa-images text-4xl mb-3 opacity-50"></i>
                    <p class="text-sm">No hay evidencias registradas en tu negocio.</p>
                </div>
            `;
            return;
        }

        const baseUrl = "{{ rtrim(config('services.api.url'), '/') }}";

        evidencias.forEach(ev => {
            const isPublic = ev.es_publica;
            let imgUrl = ev.url_imagen;
            if(imgUrl && !imgUrl.startsWith('http')) {
                imgUrl = baseUrl + (imgUrl.startsWith('/') ? '' : '/') + imgUrl;
            }

            const nombreServicio = ev.servicio?.nombre || 'General';
            
            // Toggle aesthetics
            const toggleColor = isPublic ? 'text-[#25B5DA]' : 'text-[#9CA3AF]';
            const toggleIcon = isPublic ? 'fa-eye' : 'fa-eye-slash';
            const toggleText = isPublic ? 'Pública' : 'Privada';

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
                        <button onclick="toggleEvidenciaState(${ev.id}, ${!isPublic})" class="text-[10px] font-bold uppercase ${toggleColor} hover:brightness-125 transition-all flex items-center gap-1">
                            <i class="fas ${toggleIcon}"></i> ${toggleText}
                        </button>
                        <button onclick="deleteEvidenciaItem(${ev.id})" class="text-[#EF4444] hover:text-red-400 text-xs transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    async function toggleEvidenciaState(id, makePublic) {
        if(typeof showLoader === 'function') showLoader();
        try {
            const token = document.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/api-proxy/evidencias/${id}/publica`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ es_publica: makePublic })
            });

            const data = await res.json();
            if(data.success || res.ok) {
                const evIndex = panelEvidenciasData.findIndex(e => e.id === id);
                if(evIndex !== -1) {
                    panelEvidenciasData[evIndex].es_publica = makePublic;
                    renderGridEvidencias(panelEvidenciasData);
                    if(typeof showToast === 'function') showToast(`Evidencia actualizada a ${makePublic ? 'Pública' : 'Privada'}`);
                }
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error al cambiar visibilidad', 'error');
            }
        } catch (error) {
            console.error(error);
        } finally {
            if(typeof hideLoader === 'function') hideLoader();
        }
    }

    async function deleteEvidenciaItem(id) {
        if(!confirm('¿Estás seguro de eliminar esta evidencia permanentemente?')) return;
        
        if(typeof showLoader === 'function') showLoader();
        try {
            const token = document.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/api-proxy/evidencias/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });

            const data = await res.json();
            if(data.success || res.ok) {
                const navArr = panelEvidenciasData.filter(e => e.id !== id);
                renderGridEvidencias(navArr);
                if(typeof showToast === 'function') showToast('Evidencia borrada exitosamente');
            } else {
                if (typeof showToast === 'function') showToast(data.message || 'Error al eliminar', 'error');
            }
        } catch (error) {
            console.error(error);
        } finally {
            if(typeof hideLoader === 'function') hideLoader();
        }
    }
</script>
