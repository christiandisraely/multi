@extends('layouts.plantilla')

@section('tituloPagina', 'Listado de Clientes')

@section('contenido')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Listado de Clientes</h2>
            <div class="row mb-3">
                <!-- Columna para el botón nuevo -->
                <div class="col-md-auto">
                    <button id="openAgregarClienteModal" type="button" class="btn btn-primary">
                        <i class="fa-solid fa-user"></i> Nuevo +
                    </button>
                </div>
                <!-- Espacio flexible -->
                <div class="col-md"></div>
                <!-- Columna para el campo de búsqueda y botón de búsqueda -->
                <div class="col-md-auto">
                    <div class="input-group">
                        <input type="text" id="search" class="form-control small-input" placeholder="Buscar por nombre o código...">
                        <button class="btn btn-primary small-button" type="button" id="searchButton">
                            <i class="fa-solid fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
            <hr>
            
            <!-- Mostrar mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Contenedor para el mensaje de no encontrado -->
            <div id="noResultsMessage" class="alert alert-warning" style="display:none;">
            este codigo o nombre de cliente no existe
            </div>
            
            <!-- Contenedor para el scroll horizontal en pantallas pequeñas -->
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="clientesTable">
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
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datos as $item)
                            <tr>
                                <td>{{ $item->Codigo }}</td>
                                <td>{{ $item->Empresa_Cliente }}</td>
                                <td>{{ $item->Correo_Electronico }}</td>
                                <td>{{ $item->Estado }}</td>
                                <td>{{ $item->Telefono }}</td>
                                <td>
                                    @if ($item->DPI)
                                        <a href="{{ Storage::url($item->DPI) }}" target="_blank">
                                            <img src="{{ asset('images/001.png') }}" alt="PDF" width="20">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->Patente)
                                        <a href="{{ Storage::url($item->Patente) }}" target="_blank">
                                            <img src="{{ asset('images/001.png') }}" alt="PDF" width="20">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->RTU)
                                        <a href="{{ Storage::url($item->RTU) }}" target="_blank">
                                            <img src="{{ asset('images/001.png') }}" alt="PDF" width="20">
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $item->Tipo_Cliente }}</td>
                                <td>{{ $item->Departamento }}</td>
                                <td>{{ $item->Municipio }}</td>
                                <td>{{ $item->Completar_Direccion }}</td>
                                <td>
                                    
                                    <button type="button" class="btn btn-warning btn-sm" onclick="editClient({{ $item->id }})">
                                        <span class="fa-solid fa-pen"></span>
                                    </button>
                                    
                                </td>
                                
                                <td>
                                    <form action="{{ route('clientes.show', $item->id) }}" method="GET">
                                       @csrf
                                       @method('DELETE')
                                       <button type="submit" class="btn btn-danger btn-sm">
                                           <span class="fa-solid fa-trash"></span>
                                       </button> 
                                    </form> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <hr>
    <div class="">
        {{ $datos->links() }}
    </div>

    @include('agregar')
    
@endsection

@section('scripts')
<script src="{{ asset('js/custom.js') }}"></script>



@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection
