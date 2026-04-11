<!-- TAB 4: PERSONAL -->
<section id="tab-personnel" class="hidden animate-fade-in-up">
  <div class="flex justify-between items-center mb-8">

    <h2 class="text-xl font-bold uppercase tracking-wide text-white">
      Equipo de Trabajo
    </h2>
    <button onclick="toggleModal('modal-add-employee',true)" class="bg-white text-black px-4 py-2 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition rounded-sm">
      + Agregar Empleado
    </button>

  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    @foreach($employees ?? [] as $emp)
    <div class="bg-[#1a1a1a] border border-[#374151] rounded-lg p-5 flex flex-col gap-4 relative group hover:border-[#25B5DA]/50 transition-all">
        <!-- Encabezado -->
        <div class="flex items-center gap-4">
            <!-- Avatar -->
            <div class="w-12 h-12 rounded-full bg-[#262626] flex items-center justify-center text-white font-bold text-lg border border-[#374151] shrink-0">
                {{ strtoupper(substr($emp['nombre'] ?? '',0,1)) }}
            </div>
            <!-- Info Principal -->
            <div class="flex-1 min-w-0">
                <h3 class="text-white font-semibold text-[1.1rem] truncate flex items-center gap-2">
                    <i class="fas fa-user text-[#25B5DA] text-sm"></i>
                    {{ trim(($emp['nombre'] ?? '').' '.($emp['app_paterno'] ?? '')) }}
                </h3>
                <p class="text-[#6B7280] text-sm truncate flex items-center gap-1.5 mt-0.5">
                    <i class="fas fa-envelope text-xs"></i>
                    {{ $emp['correo'] ?? 'Sin correo' }}
                </p>
            </div>
        </div>
        
        <!-- División -->
        <hr class="border-[#374151]/50">

        <!-- Métricas -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Servicios -->
            <div class="bg-[#262626] rounded p-3 flex flex-col items-center justify-center text-center">
                <span class="text-2xl font-bold text-white leading-none mb-1">{{ $emp['total_servicios'] ?? 0 }}</span>
                <span class="text-[10px] text-[#9CA3AF] uppercase tracking-widest font-bold">Servicios completados</span>
            </div>
            
            <!-- Comisión -->
            <div class="bg-[#262626] rounded p-3 flex flex-col items-center justify-center text-center">
                <span class="text-xl font-bold leading-none mb-1 {{ ($emp['comision'] ?? 0) > 0 ? 'text-emerald-500' : 'text-[#6B7280]' }}">
                    {{ number_format(floatval($emp['comision'] ?? 0), 0) }}%
                </span>
                <span class="text-[10px] text-[#9CA3AF] uppercase tracking-widest font-bold">Comisión</span>
            </div>
        </div>

        <!-- Acciones (Toggle + Editar) -->
        <div class="flex items-center justify-between mt-2">
            <!-- Toggle Estado -->
            <label class="flex items-center cursor-pointer">
                <div class="relative">
                    <input type="checkbox" class="sr-only peer status-toggle-input" 
                        onchange='toggleEmployeeStatus(
                        @json($emp["id_empleado"]),
                        @json($emp["nombre"]),
                        @json($emp["app_paterno"]),
                        @json($emp["app_materno"]),
                        @json($emp["correo"]),
                        @json($emp["comision"]),
                        this.checked
                        )' 
                        {{ strtolower($emp['estado'] ?? '') === 'activo' ? 'checked' : '' }}>
                    <div class="block w-10 h-6 bg-[#374151] rounded-full peer-checked:bg-emerald-500 transition-colors"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-4"></div>
                </div>
                <span class="ml-3 text-xs font-bold uppercase tracking-widest {{ strtolower($emp['estado'] ?? '') === 'activo' ? 'text-emerald-500' : 'text-[#6B7280]' }} status-text-{{ $emp['id_empleado'] }}">
                    {{ strtolower($emp['estado'] ?? '') === 'activo' ? 'Activo' : 'Inactivo' }}
                </span>
            </label>

            <!-- Editar -->
            <button type="button" onclick='openEditEmployee(
              @json($emp["id_empleado"]),
              @json($emp["nombre"]),
              @json($emp["app_paterno"]),
              @json($emp["app_materno"]),
              @json($emp["correo"]),
              @json($emp["comision"]),
              @json($emp["estado"])
              )' class="text-xs text-[#9CA3AF] hover:text-[#25B5DA] uppercase tracking-widest font-bold flex items-center gap-1.5 transition-colors">
                <i class="fas fa-edit"></i> Editar
            </button>
        </div>
    </div>
    @endforeach
  </div>
</section>

<!-- MODAL CREAR EMPLEADO -->
<div id="modal-add-employee" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black/80" onclick="toggleModal('modal-add-employee',false)">
  </div>
  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-8 w-full max-w-md">
    <h3 class="text-white font-bold mb-6">
      Nuevo Empleado
    </h3>
    <form method="POST" id="addEmployeeForm" action="{{ url('/api-proxy/api/admin/register/empleado') }}"
    data-redirect="{{ route('business.profile') }}"
    data-custom-handler="false">
      @csrf
      <input type="text" name="nombre" placeholder="Nombre" id="create_nombre"
      class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="text" name="app_paterno" placeholder="Apellido paterno" class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="text" name="app_materno" placeholder="Apellido materno" class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="email" name="correo" placeholder="Correo" class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="password" name="contrasena" placeholder="Contraseña" class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="number" name="comision" placeholder="Comisión" class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="hidden" name="estado" value="activo">
      <button class="w-full bg-white text-black py-2 mt-4">
        Crear Empleado
      </button>
      <button type="button" onclick="toggleModal('modal-add-employee',false)"
      class="w-full text-gray-400 mt-2">
        Cancelar
      </button>
    </form>
  </div>
</div>

<!-- MODAL EDITAR EMPLEADO -->
<div id="modal-edit-employee" class="fixed inset-0 hidden z-50">
  <div class="absolute inset-0 bg-black/80" onclick="toggleModal('modal-edit-employee',false)">
  </div>
  <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] p-8 border border-[#374151] w-full max-w-md">
    <h3 class="text-white font-bold mb-6">
      Editar empleado
    </h3>
    <form method="POST" id="editEmployeeForm" data-custom-handler="false" data-redirect="{{ route('business.profile') }}">
      @csrf @method('PUT')
      <input type="hidden" id="edit_id">
      <input type="text" name="nombre" id="edit_nombre_empleado" placeholder="Nombre"
      class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="text" name="app_paterno" id="edit_app_paterno" placeholder="Apellido paterno"
      class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="text" name="app_materno" id="edit_app_materno" placeholder="Apellido materno"
      class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="email" name="correo" id="edit_correo" placeholder="Correo"
      readonly class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <input type="number" name="comision" id="edit_comision" placeholder="Comisión"
      class="w-full mb-3 bg-transparent border-b border-gray-600 text-white">
      <select name="estado" id="edit_estado" class="w-full mb-4 bg-[#262626] text-white border border-gray-600">
        <option value="activo">
          Activo
        </option>
        <option value="inactivo">
          Inactivo
        </option>
      </select>
      <button class="bg-white text-black px-4 py-2 w-full">
        Actualizar
      </button>
    </form>
  </div>
</div>


<script>
  function getCsrfToken() {
      return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
             document.querySelector('input[name="_token"]')?.value;
  }

  window.openEditEmployee = function(id, nombre, app_paterno, app_materno, correo, comision, estado) {
    console.log({
      nombre,
      app_paterno,
      app_materno
    })

    document.getElementById("edit_nombre_empleado").value = nombre || ""
    document.getElementById("edit_app_paterno").value = app_paterno || ""
    document.getElementById("edit_app_materno").value = app_materno || ""
    document.getElementById("edit_correo").value = correo || ""
    document.getElementById("edit_comision").value = comision || ""
    document.getElementById("edit_estado").value = estado || "activo"

    document.getElementById("editEmployeeForm").action = "/api-proxy/api/empleados/" + id;
    document.getElementById("editEmployeeForm").setAttribute("data-redirect", "{{ route('business.profile') }}");
    toggleModal("modal-edit-employee", true)
  }



  window.toggleEmployeeStatus = async function(id, nombre, app_paterno, app_materno, correo, comision, isChecked) {
      const newStatus = isChecked ? 'activo' : 'inactivo';
      const statusTextParams = document.querySelectorAll('.status-text-' + id);
      
      // Update UI optimistically
      statusTextParams.forEach(el => {
          el.innerText = newStatus.toUpperCase();
          if (isChecked) {
              el.classList.remove('text-[#6B7280]', 'text-red-500');
              el.classList.add('text-emerald-500');
          } else {
              el.classList.remove('text-emerald-500', 'text-red-500');
              el.classList.add('text-[#6B7280]');
          }
      });
      
      const token = getCsrfToken();
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('estado', newStatus);
      if (nombre) formData.append('nombre', nombre);
      if (app_paterno) formData.append('app_paterno', app_paterno);
      if (app_materno) formData.append('app_materno', app_materno);
      if (comision) formData.append('comision', comision);
      
      try {
          const response = await fetch(`/api-proxy/api/empleados/${id}`, {
              method: 'POST', // Spoofed to PUT
              headers: {
                  'Accept': 'application/json',
                  'X-CSRF-TOKEN': token
              },
              body: formData
          });
          
          if (!response.ok) {
              throw new Error('Error al actualizar estado');
          }
          if (typeof showToast === 'function') showToast(`Estado actualizado: ${newStatus}`, 'success');
      } catch (error) {
          console.error(error);
          if (typeof showToast === 'function') showToast('Error al actualizar estado', 'error');
          // Nota: Aquí se podría revertir el checkbox si falla la llamada
      }
  };

  // --- CONTROLADORES DE SUBMIT DIRECTOS ---

  // Para el formulario de crear empleado
  document.getElementById('addEmployeeForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const form = this;
      const action = form.action;
      const formData = new FormData(form);
      const redirectUrl = form.getAttribute('data-redirect') || window.location.href;
      const token = getCsrfToken();
      
      const method = 'POST';
      
      const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('button');
      let originalBtnContent = '';
      if (submitBtn) {
          originalBtnContent = submitBtn.innerHTML;
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Cargando...';
      }

      if (typeof showLoader === 'function') showLoader();
      
      try {
          const response = await fetch(action, {
              method: method,
              headers: {
                  'Accept': 'application/json',
                  'X-CSRF-TOKEN': token
              },
              body: formData
          });
          
          const data = await response.json();
          
          if (response.ok) {
              if (typeof showToast === 'function') showToast(data.message || 'Operación exitosa', 'success');
              setTimeout(() => {
                  window.location.href = redirectUrl;
              }, 1000);
          } else {
              if (typeof showToast === 'function') showToast(data.message || 'Error en la operación', 'error');
          }
      } catch (error) {
          console.error(error);
          if (typeof showToast === 'function') showToast('Error de conexión', 'error');
      } finally {
          if (submitBtn) {
              submitBtn.disabled = false;
              submitBtn.innerHTML = originalBtnContent;
          }
          if (typeof hideLoader === 'function') hideLoader();
      }
  });

  // Para el formulario de editar empleado
  document.getElementById('editEmployeeForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const form = this;
      const action = form.action;
      const formData = new FormData(form);
      const redirectUrl = form.getAttribute('data-redirect') || window.location.href;
      const token = getCsrfToken();
      
      // Siempre POST: PHP no parsea body multipart en PUT/PATCH.
      // El campo _method=PUT en el FormData hace el spoofing para Laravel.
      const method = 'POST';
      
      if (typeof showLoader === 'function') showLoader();
      
      try {
          const response = await fetch(action, {
              method: method,
              headers: {
                  'Accept': 'application/json',
                  'X-CSRF-TOKEN': token
              },
              body: formData
          });
          
          const data = await response.json();
          
          if (response.ok) {
              if (typeof showToast === 'function') showToast(data.message || 'Operación exitosa', 'success');
              setTimeout(() => {
                  window.location.href = redirectUrl;
              }, 1000);
          } else {
              if (typeof showToast === 'function') showToast(data.message || 'Error en la operación', 'error');
          }
      } catch (error) {
          console.error(error);
          if (typeof showToast === 'function') showToast('Error de conexión', 'error');
      } finally {
          if (typeof hideLoader === 'function') hideLoader();
      }
  });


</script>