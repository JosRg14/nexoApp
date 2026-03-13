<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ExternalApi\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

protected $employees;

public function __construct(EmployeeService $employees)
{
$this->employees = $employees;

$this->middleware([
'auth.session',
'inject.api.token',
'role:admin'
]);
}

public function index()
{

$employees = [];

try{

$response = $this->employees->list();
$employees = $response['data'] ?? [];

}catch(\Throwable $e){

session()->flash('api_error',$e->getMessage());

}

return view('business.employees',compact('employees'));

}

public function store(Request $request)
{

$data = $request->validate([
'nombre'=>'required',
'app_paterno'=>'required',
'app_materno'=>'nullable',
'correo'=>'required|email',
'contrasena'=>'required|min:6',
'comision'=>'required|numeric',
'estado'=>'required'
]);

$this->employees->create($data);

return back()->with('success','Empleado creado');

}

public function destroy($id)
{

$this->employees->delete($id);

return back()->with('success','Empleado eliminado');

}

public function update(Request $request,$id)
{

$data = $request->only([
'nombre',
'app_paterno',
'app_materno',
'correo',
'comision',
'estado'
]);

$this->employees->update($id,$data);

return back()->with('success','Empleado actualizado');

}



    
}