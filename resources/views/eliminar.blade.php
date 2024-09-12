@extends('layouts.plantilla')

@section('tituloPagina', 'Eliminar Clientes')

@section('contenido')
<div class="card">
    <h3 class="card-header">Eliminar Cliente</h3>
    <div class="card-body">
        <div class="alert alert-danger" role="alert">
            ¿Estás seguro de eliminar este cliente?

            <div class="table-responsive">
                <table class="table table-sm table-hover mt-3" style="background-color:white">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Empresa/Cliente</th>
                            <th>Correo Electrónico</th>
                            <th>Estado</th>
                            <th>Teléfono</th>
                            <th>DPI</th>
                            <th>Patente</th>
                            <th>RTU</th>
                            <th>Tipo de Cliente</th>
                            <th>Departamento</th>
                            <th>Municipio</th>
                            <th>Completar Dirección</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$clientes->Codigo}}</td>
                            <td>{{$clientes->Empresa_Cliente}}</td>
                            <td>{{$clientes->Correo_Electronico}}</td>
                            <td>{{$clientes->Estado}}</td>
                            <td>{{$clientes->Telefono}}</td>
                            <td>{{$clientes->DPI}}</td>
                            <td>{{$clientes->Patente}}</td>
                            <td>{{$clientes->RTU}}</td>
                            <td>{{$clientes->Tipo_Cliente}}</td>
                            <td>{{$clientes->Departamento}}</td>
                            <td>{{$clientes->Municipio}}</td>
                            <td>{{$clientes->Completar_Direccion}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <form action="{{ route('clientes.destroy', $clientes->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <a href="{{ route('clientes.index') }}" class="btn btn-info">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Regresar
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-trash"></i> Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection
