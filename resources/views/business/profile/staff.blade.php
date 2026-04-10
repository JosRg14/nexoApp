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
          <form method="POST" action="{{ url('/api-proxy/api/empleados/'.$emp['id_empleado']) }}"
          data-redirect="{{ route('business.profile') }}" data-custom-handler="false">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('¿Eliminar empleado?')"
            class="text-red-400 text-xs hover:text-red-300">
              Eliminar
            </button>
          </form>
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
    <form method="POST" id="editEmployeeForm">
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
</script>