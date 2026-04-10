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

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($employees ?? [] as $emp)
    <div class="bg-[#262626] border border-[#374151]/50 p-6 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-[#374151] flex items-center justify-center text-white font-bold text-lg border border-[#4B5563]">
          {{ strtoupper(substr($emp['nombre'] ?? '',0,1)) }}
        </div>
        <div>
          <h3 class="text-white font-bold text-sm">
            {{ trim(($emp['nombre'] ?? '').' '.($emp['app_paterno'] ?? '').' '.($emp['app_materno']
            ?? '')) }}
          </h3>
          <p class="text-[#9CA3AF] text-xs">
            {{ $emp['correo'] ?? '' }} • Comisión: {{ $emp['comision'] ?? '0' }}%
          </p>
        </div>
      </div>
      <div class="flex flex-col items-end gap-2">
        @if(strtolower($emp['estado'] ?? '') === 'activo')
        <span class="bg-emerald-500/10 text-emerald-500 px-2 py-0.5 text-xs border border-emerald-500/20">
          Activo
        </span>
        @else
        <span class="bg-red-500/10 text-red-500 px-2 py-0.5 text-xs border border-red-500/20">
          Inactivo
        </span>
        @endif
        <div class="flex gap-3">
          <button type="button" onclick='openEditEmployee(
          @json($emp["id_empleado"]),
          @json($emp["nombre"]),
          @json($emp["app_paterno"]),
          @json($emp["app_materno"]),
          @json($emp["correo"]),
          @json($emp["comision"]),
          @json($emp["estado"])
          )' class="text-blue-400 text-xs hover:text-blue-300">
            Editar
          </button>
          <button type="button" onclick="openDeleteEmployeeModal({{ $emp['id_empleado'] }}, '{{ trim(($emp['nombre'] ?? '').' '.($emp['app_paterno'] ?? '')) }}')"
          class="text-red-400 text-xs hover:text-red-300">
            Eliminar
          </button>
        </div>
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
    <form method="POST" action="{{ url('/api-proxy/api/admin/register/empleado') }}"
    data-redirect="{{ route('business.profile') }}">
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

<!-- MODAL ELIMINAR EMPLEADO -->
<div id="modal-delete-employee" class="fixed inset-0 hidden z-50">
  <div class="absolute inset-0 bg-black/80" onclick="closeDeleteEmployeeModal()"></div>
  <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#1a1a1a] border border-[#374151] p-8 w-full max-w-md">
      <h3 class="text-red-500 font-bold mb-4 uppercase">Confirmar eliminación</h3>
      <p class="text-white text-sm mb-6">¿Estás seguro que deseas eliminar al empleado <span id="deleteEmployeeName" class="font-bold"></span>?</p>
      <form method="POST" id="deleteEmployeeForm" data-custom-handler="false">
          @csrf
          @method('DELETE')
          <div class="flex gap-4">
              <button type="button" onclick="closeDeleteEmployeeModal()" class="w-1/2 py-2 border border-[#374151] text-white text-xs uppercase">Cancelar</button>
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

  window.openDeleteEmployeeModal = function(id, nombre) {
    document.getElementById('deleteEmployeeName').innerText = nombre;
    const form = document.getElementById('deleteEmployeeForm');
    form.action = '/api-proxy/api/empleados/' + id;
    document.getElementById('modal-delete-employee').classList.remove('hidden');
  }

  window.closeDeleteEmployeeModal = function() {
    document.getElementById('modal-delete-employee').classList.add('hidden');
  }

  // --- CONTROLADORES DE SUBMIT DIRECTOS ---

  // Para el formulario de editar empleado
  document.getElementById('editEmployeeForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const form = this;
      const action = form.action;
      const formData = new FormData(form);
      const redirectUrl = form.getAttribute('data-redirect') || window.location.href;
      const token = getCsrfToken();
      
      // Obtener el método correcto (_method)
      let method = 'POST';
      const methodInput = form.querySelector('input[name="_method"]');
      if (methodInput) {
          method = methodInput.value;
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
          
          if (response.ok && data.success !== false) {
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

  // Para el formulario de eliminar empleado
  document.getElementById('deleteEmployeeForm')?.addEventListener('submit', async function(e) {
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
              if (typeof showToast === 'function') showToast(data.message || 'Empleado eliminado', 'success');
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
          closeDeleteEmployeeModal();
      }
  });
</script>