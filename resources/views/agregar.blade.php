<!-- Modal para agregar cliente -->
<div class="modal fade" id="agregarClienteModal" tabindex="-1" aria-labelledby="agregarClienteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="agregarClienteModalLabel">Agregar Nuevo Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <img src="{{ asset('images/49575_accept_male_user_icon.png') }}" alt="Imagen del Modal" class="img-fluid"
                style="width: 200px; display: block; margin: 0 auto;">
            <form id="agregarClienteForm" action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Codigo" class="form-label">Código</label>
                                <input type="text" class="form-control" id="Codigo" name="Codigo" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="Tipo_Cliente" class="form-label">Tipo de Cliente</label>
                                <select class="form-select" id="Tipo_Cliente" name="Tipo_Cliente" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Individual">Individual</option>
                                    <option value="Empresa">Empresa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Empresa_Cliente" class="form-label">Empresa/Cliente</label>
                                <input type="text" class="form-control" id="Empresa_Cliente" name="Empresa_Cliente"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="Correo_Electronico" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="Correo_Electronico" name="Correo_Electronico"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="Estado" class="form-label">Estado</label>
                                <select class="form-select" id="Estado" name="Estado" required>
                                    <option value="">Seleccione un estado</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                           
                            <div class="mb-3">
                                <label for="Genero" class="form-label">Género</label>
                                <select class="form-select" id="Genero" name="Genero" required>
                                    <option value="">Seleccione un género</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Masculino">Masculino</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="NIT" class="form-label">Número de NIT</label>
                                <input type="text" class="form-control" id="NIT" name="NIT" required>
                            </div>
                        </div>
                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Numero_DPI" class="form-label">Número de DPI</label>
                                <input type="text" class="form-control" id="Numero_DPI" name="Numero_DPI" required>
                            </div>
                            <div class="mb-3">
                                <label for="Nombre_Representante_legal" class="form-label">Nombre del Representante Legal</label>
                                <input type="text" class="form-control" id="Nombre_Representante_legal" name="Nombre_Representante_legal" required>
                            </div>
                            <div class="mb-3">
                                <label for="Fecha_de_Registro" class="form-label">Fecha de Registro</label>
                                <input type="date" class="form-control" id="Fecha_de_Registro" name="Fecha_de_Registro" required>
                            </div>
                            <div class="mb-3">
                                <label for="Telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="Telefono" name="Telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="Departamento" class="form-label">Departamento</label>
                                <select class="form-select" id="Departamento" name="Departamento" required>
                                    <option value="">Seleccione un departamento</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Sacatepéquez">Sacatepéquez</option>
                                    <option value="Chimaltenango">Chimaltenango</option>
                                    <option value="Escuintla">Escuintla</option>
                                    <option value="Zacapa">Zacapa</option>
                                    <option value="Izabal">Izabal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Municipio" class="form-label">Municipio</label>
                                <select class="form-select" id="Municipio" name="Municipio" required>
                                    <option value="">Seleccione un municipio</option>
                                    <optgroup label="Guatemala">
                                        <option value="Ciudad de Guatemala">Ciudad de Guatemala</option>
                                        <option value="Mixco">Mixco</option>
                                        <option value="Villa Nueva">Villa Nueva</option>
                                        <option value="Santa Catarina Pinula">Santa Catarina Pinula</option>
                                    </optgroup>
                                    <optgroup label="Sacatepéquez">
                                        <option value="Antigua Guatemala">Antigua Guatemala</option>
                                        <option value="San Lucas Sacatepéquez">San Lucas Sacatepéquez</option>
                                        <option value="San Miguel Dueñas">San Miguel Dueñas</option>
                                    </optgroup>
                                    <optgroup label="Chimaltenango">
                                        <option value="Chimaltenango">Chimaltenango</option>
                                        <option value="San José Poaquil">San José Poaquil</option>
                                        <option value="San Martín Jilotepeque">San Martín Jilotepeque</option>
                                    </optgroup>
                                    <optgroup label="Escuintla">
                                        <option value="Escuintla">Escuintla</option>
                                        <option value="Santa Lucía Cotzumalguapa">Santa Lucía Cotzumalguapa</option>
                                        <option value="La Democracia">La Democracia</option>
                                    </optgroup>
                                    <optgroup label="Zacapa">
                                        <option value="Zacapa">Zacapa</option>
                                        <option value="Chiquimula">Chiquimula</option>
                                        <option value="La Unión">La Unión</option>
                                        <option value="San Jorge">San Jorge</option>
                                    </optgroup>
                                    <optgroup label="Izabal">
                                        <option value="Puerto Barrios">Puerto Barrios</option>
                                        <option value="Livingston">Livingston</option>
                                        <option value="El Estor">El Estor</option>
                                        <option value="María Dolores">María Dolores</option>
                                        <option value="Los Amates">Los Amates</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Completar_Direccion" class="form-label">Completar Dirección</label>
                                <input type="text" class="form-control" id="Completar_Direccion" name="Completar_Direccion" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Guardar <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
