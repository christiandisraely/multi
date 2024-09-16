<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientesController extends Controller
{
    // Método index
    public function index()
    {
        $datos = Clientes::paginate(5);
        return view('inicio', compact('datos'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        // Validar campos básicos
    $request->validate([
        'Codigo' => 'required|string|max:255',
        'Empresa_Cliente' => 'required|string|max:255',
        'Correo_Electronico' => 'required|email|max:255',
        'Estado' => 'required|string',
        'Telefono' => 'required|string|max:15',
        'Genero' => 'nullable|string|max:50',
        'NIT' => 'nullable|string|max:50',
        'Numero_DPI' => 'nullable|string|max:50',
        'Nombre_Representante_legal' => 'nullable|string|max:255',
        'Fecha_de_Registro' => 'required|date',
        'Tipo_Cliente' => 'required|string',
        'Departamento' => 'required|string',
        'Municipio' => 'required|string',
        'Completar_Direccion' => 'required|string'
    ]);

    // Validar unicidad por campo
    $fields = [
        'Codigo' => $request->Codigo,
        'Empresa_Cliente' => $request->Empresa_Cliente,
        'Correo_Electronico' => $request->Correo_Electronico,
        'Telefono' => $request->Telefono,
        'NIT' => $request->NIT,
        'Numero_DPI' => $request->Numero_DPI,
        'Nombre_Representante_legal' => $request->Nombre_Representante_legal
    ];

    foreach ($fields as $field => $value) {
        if ($value) { // Verificar si el valor no es nulo
            $existingClient = Clientes::where($field, $value)->first();
            if ($existingClient) {
                return redirect()->back()->withErrors(['message' => "Ya existe un cliente con el campo $field: $value."])->withInput();
            }
        }
    }

    // Guardar el cliente si no hay duplicados
    $cliente = new Clientes($request->all());
    $cliente->save();

    return redirect()->route('clientes.index')->with('success', 'Cliente agregado exitosamente');
    
        


    }
    public function show($id)
    {
        $clientes = Clientes::find($id);
        return view('eliminar', compact('clientes'));
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');

        $datos = Clientes::where('Empresa_Cliente', 'LIKE', "%{$query}%")
            ->orWhere('Codigo', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($datos);
    }

    public function edit($id)
    {
        $cliente = Clientes::findOrFail($id);
        return view('clientes.editar', compact('cliente'));
    }

 
    public function update(Request $request, $id)
    {
        // Validar campos básicos
        $request->validate([
            'Codigo' => 'required|string|max:255',
            'Empresa_Cliente' => 'required|string|max:255',
            'Correo_Electronico' => 'required|email|max:255',
            'Estado' => 'required|string',
            'Telefono' => 'required|string|max:15',
            'Genero' => 'nullable|string|max:50',
            'NIT' => 'nullable|string|max:50',
            'Numero_DPI' => 'nullable|string|max:50',
            'Nombre_Representante_legal' => 'nullable|string|max:255',
            'Fecha_de_Registro' => 'required|date',
            'Tipo_Cliente' => 'required|string',
            'Departamento' => 'required|string',
            'Municipio' => 'required|string',
            'Completar_Direccion' => 'required|string'
        ]);
    
        // Obtener el cliente actual
        $cliente = Clientes::findOrFail($id);
    
        // Validar unicidad solo si los valores han cambiado
        $existingClient = Clientes::where(function ($query) use ($request, $cliente) {
            // Solo agregar condiciones para los campos que han cambiado
            if ($request->Codigo !== $cliente->Codigo) {
                $query->orWhere('Codigo', $request->Codigo);
            }
            if ($request->Empresa_Cliente !== $cliente->Empresa_Cliente) {
                $query->orWhere('Empresa_Cliente', $request->Empresa_Cliente);
            }
            if ($request->Correo_Electronico !== $cliente->Correo_Electronico) {
                $query->orWhere('Correo_Electronico', $request->Correo_Electronico);
            }
            if ($request->Telefono !== $cliente->Telefono) {
                $query->orWhere('Telefono', $request->Telefono);
            }
            if ($request->NIT !== $cliente->NIT) {
                $query->orWhere('NIT', $request->NIT);
            }
            if ($request->Numero_DPI !== $cliente->Numero_DPI) {
                $query->orWhere('Numero_DPI', $request->Numero_DPI);
            }
            if ($request->Nombre_Representante_legal !== $cliente->Nombre_Representante_legal) {
                $query->orWhere('Nombre_Representante_legal', $request->Nombre_Representante_legal);
            }
        })->where('id', '!=', $id)->first();
    
        if ($existingClient) {
            return redirect()->back()->withErrors(['message' => 'Ya existe un cliente con estos datos.'])->withInput();
        }
    
        // Actualizar el cliente
        $cliente->update($request->all());
    
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente');
    }
    







public function destroy($id)
    {
        $clientes = Clientes::findOrFail($id);
        $clientes->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito');
    }



}

