@extends('layouts.plantilla')

@section('tituloPagina', 'Listado de Clientes')

@section('contenido')
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Listado de Clientes</h1>
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
                        <input type="text" id="search" class="form-control small-input" placeholder="Buscar por nombre o código..." required>
                        <button class="btn btn-primary small-button" type="button" id="searchButton">
                            <i class="fa-solid fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
            <hr>

            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mensaje de error -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert" style="margin-bottom: 20px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tabla de clientes -->
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="clientesTable">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Empresa/Cliente</th>
                            <th>Correo Electrónico</th>
                            <th>Estado</th>
                            <th>Teléfono</th>
                            <th>Genero</th>
                            <th>NIT</th>
                            <th>Numero De DPI</th>
                            <th>Nombre Representante Legal</th>
                            <th>Fecha de Registro</th>
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
                                <td>{{ $item->Genero }}</td>
                                <td>{{ $item->NIT }}</td>
                                <td>{{ $item->Numero_DPI }}</td>
                                <td>{{ $item->Nombre_Representante_legal }}</td>
                                <td>{{ $item->Fecha_de_Registro }}</td>
                                <td>{{ $item->Tipo_Cliente }}</td>
                                <td>{{ $item->Departamento }}</td>
                                <td>{{ $item->Municipio }}</td>
                                <td>{{ $item->Completar_Direccion }}</td>
                                <td>
                                    <!-- Botón de editar -->
                                    <form>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editarClienteModal" data-id="{{ $item->id }}"
                                            data-codigo="{{ $item->Codigo }}" data-empresa="{{ $item->Empresa_Cliente }}"
                                            data-correo="{{ $item->Correo_Electronico }}" data-estado="{{ $item->Estado }}"
                                            data-telefono="{{ $item->Telefono }}" data-genero="{{ $item->Genero }}"
                                            data-nit="{{ $item->NIT }}" data-dpi="{{ $item->Numero_DPI }}"
                                            data-representante="{{ $item->Nombre_Representante_legal }}"
                                            data-fecha-registro="{{ $item->Fecha_de_Registro }}" data-tipo="{{ $item->Tipo_Cliente }}"
                                            data-departamento="{{ $item->Departamento }}" data-municipio="{{ $item->Municipio }}"
                                            data-direccion="{{ $item->Completar_Direccion }}">
                                            <span class="fa-solid fa-pen"></span>
                                        </button>
                                    </form>
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
    <div class="">
        {{ $datos->links() }}
    </div>

    @include('agregar')
    @include('editar')
@endsection

@section('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/validaciones.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection
