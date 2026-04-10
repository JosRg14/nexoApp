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
    <div class="bg-[#1a1a1a] border border-[#374151] p-4 flex items-center justify-between group hover:border-white/20 transition-all">
      <div class="flex items-center gap-4">
        <div class="w-10 h-10 rounded shadow-lg bg-[#262626] flex items-center justify-center text-white font-bold text-sm border border-[#374151]">
          {{ strtoupper(substr($emp['nombre'] ?? '',0,1)) }}
        </div>
        <div>
          <h3 class="text-white font-bold text-sm uppercase tracking-wide">
            {{ trim(($emp['nombre'] ?? '').' '.($emp['app_paterno'] ?? '')) }}
          </h3>
          <p class="text-[#9CA3AF] text-[10px] uppercase tracking-widest mt-0.5">
            {{ $emp['correo'] ?? '' }}
          </p>
        </div>
      </div>

      <!-- Columna de Servicios ( cuantitativa ) -->
      <div class="hidden md:flex flex-col items-center px-4 border-l border-r border-[#374151]/50">
        <span class="text-white font-bold text-sm">{{ $emp['total_servicios'] ?? 0 }}</span>
        <span class="text-[#9CA3AF] text-[10px] uppercase tracking-widest">Servicios</span>
      </div>

      <div class="flex flex-col items-end gap-2">
        <div class="flex items-center gap-3">
          <div class="flex flex-col items-end">
            <span class="text-[10px] text-[#9CA3AF] uppercase tracking-widest">Comisión: {{ $emp['comision'] ?? '0' }}%</span>
            @if(strtolower($emp['estado'] ?? '') === 'activo')
            <span class="text-emerald-500 text-[10px] font-bold uppercase tracking-widest">Activo</span>
            @else
            <span class="text-red-500 text-[10px] font-bold uppercase tracking-widest">Inactivo</span>
            @endif
          </div>
          <button type="button" onclick='openEditEmployee(
          @json($emp["id_empleado"]),
          @json($emp["nombre"]),
          @json($emp["app_paterno"]),
          @json($emp["app_materno"]),
          @json($emp["correo"]),
          @json($emp["comision"]),
          @json($emp["estado"])
          )' class="bg-[#262626] border border-[#374151] text-white px-3 py-1.5 text-[10px] uppercase font-bold hover:bg-white hover:text-black transition-all">
            Editar
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



  // --- CONTROLADORES DE SUBMIT DIRECTOS ---

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