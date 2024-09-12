<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;

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
       
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'Codigo' => 'required|string|max:255',
            'Empresa_Cliente' => 'required|string|max:255',
            'Correo_Electronico' => 'required|email|max:255',
            'Estado' => 'required|string',
            'Telefono' => 'required|string|max:15',
            'DPI' => 'nullable|file|mimes:pdf|max:2048',
            'Patente' => 'nullable|file|mimes:pdf|max:2048',
            'RTU' => 'nullable|file|mimes:pdf|max:2048',
            'Tipo_Cliente' => 'required|string',
            'Departamento' => 'required|string',
            'Municipio' => 'required|string',
            'Completar_Direccion' => 'required|string',
        ]);
    
        // Crear una nueva instancia del modelo Cliente
        $cliente = new Clientes($validatedData);
    

        // Manejo de archivos basado en el tipo de cliente
        if ($request->input('Tipo_Cliente') === 'Individual') {

            // Solo permitir DPI y desactivar Patente y RTU para clientes individuales
            if ($request->hasFile('DPI')) {
                $cliente->DPI = $request->file('DPI')->store('dpi');
            }
            $cliente->Patente = null;
            $cliente->RTU = null;
            
        } else {

            // Solo permitir Patente y RTU y desactivar DPI para empresas
            if ($request->hasFile('DPI')) {
                $cliente->DPI = null;
            }
            if ($request->hasFile('Patente')) {
                $cliente->Patente = $request->file('Patente')->store('patentes');
            }
            if ($request->hasFile('RTU')) {
                $cliente->RTU = $request->file('RTU')->store('rtu');
            }
        }
    
        // Guardar el cliente en la base de datos
        $cliente->save();
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('clientes.index')->with('success', 'Cliente agregado exitosamente');
    }
    





    public function show($id)
    {
        $clientes = clientes::find($id);
        return view('eliminar', compact('clientes'));
   

        
    }






    public function buscar(Request $request)
{
    $query = $request->input('query');
    
    $datos = Clientes::where('Empresa_Cliente', 'LIKE', "%{$query}%")
                     ->orWhere('codigo', 'LIKE', "%{$query}%")
                     ->get();

    return response()->json($datos);
}






    public function edit($id)
    {   
     
    }



public function update(Request $request, Clientes $cliente)
{
}

  
    public function destroy($id)
    {
        $clientes = Clientes::findOrFail($id);  
        $clientes->delete();  
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito');
    }
    
    
   
}
