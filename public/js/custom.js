document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el modal de agregar cliente
    var agregarClienteModal = new bootstrap.Modal(document.getElementById('agregarClienteModal'));
    var editarClienteModal = new bootstrap.Modal(document.getElementById('editarClienteModal'));

    // Manejar el botón para abrir el modal de agregar cliente
    document.getElementById('openAgregarClienteModal').addEventListener('click', function() {
        agregarClienteModal.show();
    });

    // Función para generar un código aleatorio
    function generateRandomCode() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        for (let i = 0; i < 8; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return code;
    }

    // Agregar el código al enviar el formulario de agregar cliente
    document.querySelector('#agregarClienteForm').addEventListener('submit', function(event) {
        const codigoInput = document.getElementById('Codigo');
        if (!codigoInput.value) {
            const codigo = generateRandomCode();
            codigoInput.value = codigo;
            console.log("Código generado: " + codigo); // Verificar si el código se genera correctamente
        }
    });

    // Función para mostrar alertas
    function mostrarAlerta(form, mensaje) {
        const alertaDiv = document.createElement('div');
        alertaDiv.className = 'alert alert-danger';
        alertaDiv.role = 'alert';
        alertaDiv.textContent = mensaje;
        form.prepend(alertaDiv); // Mostrar alerta antes del formulario

        // Eliminar alerta después de 5 segundos
        setTimeout(() => {
            alertaDiv.remove();
        }, 3000);
    }

    // Validaciones comunes
    function agregarValidaciones(form) {
        const empresaClienteInput = form.querySelector('input[name="Empresa_Cliente"]');
        const telefonoInput = form.querySelector('input[name="Telefono"]');
        const completarDireccionInput = form.querySelector('input[name="Completar_Direccion"]');
        const tipoClienteSelect = form.querySelector('select[name="Tipo_Cliente"]');

        // Validar campo Empresa/Cliente
        empresaClienteInput.addEventListener('input', function() {
            const value = empresaClienteInput.value;
            if (/[^a-zA-Z\s]/.test(value)) {
                mostrarAlerta(form, 'El campo Empresa/Cliente solo debe contener letras.');
                empresaClienteInput.value = value.replace(/[^a-zA-Z\s]/g, '');
            }
        });

        // Validar campo Teléfono
        telefonoInput.addEventListener('input', function() {
            const value = telefonoInput.value;
            if (/[^0-9-]/.test(value)) {
                mostrarAlerta(form, 'El campo Teléfono solo debe contener números y guiones.');
                telefonoInput.value = value.replace(/[^0-9-]/g, '');
            }
        });

        // Validar campo Completar Dirección
        completarDireccionInput.addEventListener('input', function() {
            const value = completarDireccionInput.value;
            if (!/^[\w\s]+$/.test(value)) {
                mostrarAlerta(form, 'Ingrese una dirección coherente.');
            }
        });

        // Habilitar/Deshabilitar campos según el tipo de cliente
        tipoClienteSelect.addEventListener('change', function() {
            const tipoCliente = tipoClienteSelect.value;

            // Si es tipo Empresa, deshabilitar campos específicos
            if (tipoCliente === 'Empresa') {
                form.querySelector('#Nombre_Representante_legal').setAttribute('disabled', 'true');
                form.querySelector('#Genero').setAttribute('disabled', 'true');
                form.querySelector('#Numero_DPI').setAttribute('disabled', 'true');
            } else {
                form.querySelector('#Nombre_Representante_legal').removeAttribute('disabled');
                form.querySelector('#Genero').removeAttribute('disabled');
                form.querySelector('#Numero_DPI').removeAttribute('disabled');
            }
        });
    }

    // Aplicar validaciones al formulario de agregar cliente
    agregarValidaciones(document.querySelector('#agregarClienteForm'));

    // Aplicar validaciones al formulario de editar cliente
    agregarValidaciones(document.querySelector('#editarClienteForm'));

    // Inicializar el estado de los campos al cargar la página
    document.getElementById('Tipo_Cliente').dispatchEvent(new Event('change'));

    // Búsqueda dinámica
    function performSearch() {
        let query = document.getElementById('search').value;
        fetch(`/clientes/buscar?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let tbody = document.querySelector('#clientesTable tbody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="14" class="text-center">Código o cliente no existe</td></tr>';
                } else {
                    data.forEach(item => {
                        let row = `
                            <tr>
                                <td>${item.Codigo}</td>
                                <td>${item.Empresa_Cliente}</td>
                                <td>${item.Correo_Electronico}</td>
                                <td>${item.Estado}</td>
                                <td>${item.Telefono}</td>
                                <td>${item.Genero}</td>
                                <td>${item.NIT}</td>
                                <td>${item.Numero_DPI}</td>
                                <td>${item.Nombre_Representante_legal}</td>
                                <td>${item.Fecha_de_Registro}</td>
                                <td>${item.Tipo_Cliente}</td>
                                <td>${item.Departamento}</td>
                                <td>${item.Municipio}</td>
                                <td>${item.Completar_Direccion}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editarClienteModal" data-id="${item.id}"
                                        data-codigo="${item.Codigo}" data-empresa="${item.Empresa_Cliente}"
                                        data-correo="${item.Correo_Electronico}" data-estado="${item.Estado}"
                                        data-telefono="${item.Telefono}" data-genero="${item.Genero}"
                                        data-nit="${item.NIT}" data-dpi="${item.Numero_DPI}"
                                        data-representante="${item.Nombre_Representante_legal}"
                                        data-fecha-registro="${item.Fecha_de_Registro}"
                                        data-tipo="${item.Tipo_Cliente}" data-departamento="${item.Departamento}"
                                        data-municipio="${item.Municipio}" data-direccion="${item.Completar_Direccion}">
                                        <span class="fa-solid fa-user-edit"></span>
                                    </button>
                                </td>
                                <td>
                                    <form action="javascript:void(0);" method="POST" onsubmit="handleDelete(${item.id});">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <span class="fa-solid fa-trash"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                }
            });
    }

    // Búsqueda al presionar Enter en el campo de búsqueda
    document.getElementById('search').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            performSearch();
        }
    });

    // Búsqueda al hacer clic en el botón de búsqueda
    document.getElementById('searchButton').addEventListener('click', function() {
        performSearch();
    });

    // Recargar la página después de mostrar el mensaje de éxito
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(() => {
            location.reload();
        }, 1000); // Ajusta el tiempo según sea necesario (1000 ms = 1 segundo)
    }
});

// Mostrar los datos del cliente en el modal de edición
document.addEventListener('DOMContentLoaded', function() {
    var editarModal = document.getElementById('editarClienteModal');

    editarModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;

        // Obtener el ID del cliente antes de asignar la acción del formulario
        var id = button.getAttribute('data-id');

        // Actualizar la acción del formulario con el ID del cliente
        var formAction = editarModal.querySelector('#editarClienteForm');
        formAction.action = '/clientes/' + id;

        // Obtener los demás datos del cliente del botón
        var codigo = button.getAttribute('data-codigo');
        var empresa = button.getAttribute('data-empresa');
        var correo = button.getAttribute('data-correo');
        var estado = button.getAttribute('data-estado');
        var telefono = button.getAttribute('data-telefono');
        var genero = button.getAttribute('data-genero');
        var nit = button.getAttribute('data-nit');
        var dpi = button.getAttribute('data-dpi');
        var representante = button.getAttribute('data-representante');
        var fechaRegistro = button.getAttribute('data-fecha-registro');
        var tipo = button.getAttribute('data-tipo');
        var departamento = button.getAttribute('data-departamento');
        var municipio = button.getAttribute('data-municipio');
        var direccion = button.getAttribute('data-direccion');

        // Asignar los valores a los campos del modal de edición
        editarModal.querySelector('#editClienteId').value = id;
        editarModal.querySelector('#Codigo').value = codigo;
        editarModal.querySelector('#Empresa_Cliente').value = empresa;
        editarModal.querySelector('#Correo_Electronico').value = correo;
        editarModal.querySelector('#Estado').value = estado;
        editarModal.querySelector('#Telefono').value = telefono;
        editarModal.querySelector('#Genero').value = genero;
        editarModal.querySelector('#NIT').value = nit;
        editarModal.querySelector('#Numero_DPI').value = dpi;
        editarModal.querySelector('#Nombre_Representante_legal').value = representante;
        editarModal.querySelector('#Fecha_de_Registro').value = fechaRegistro;
        editarModal.querySelector('#Tipo_Cliente').value = tipo;
        editarModal.querySelector('#Departamento').value = departamento;
        editarModal.querySelector('#Municipio').value = municipio;
        editarModal.querySelector('#Completar_Direccion').value = direccion;

        // Habilitar/deshabilitar campos según el tipo de cliente
        function actualizarCamposSegunTipo() {
            const tipoCliente = editarModal.querySelector('#Tipo_Cliente').value;

            if (tipoCliente === 'Empresa') {
                editarModal.querySelector('#Nombre_Representante_legal').setAttribute('disabled', 'true');
                editarModal.querySelector('#Genero').setAttribute('disabled', 'true');
                editarModal.querySelector('#Numero_DPI').setAttribute('disabled', 'true');
            } else {
                editarModal.querySelector('#Nombre_Representante_legal').removeAttribute('disabled');
                editarModal.querySelector('#Genero').removeAttribute('disabled');
                editarModal.querySelector('#Numero_DPI').removeAttribute('disabled');
            }
        }

        // Inicializar el estado de los campos en el modal de edición
        actualizarCamposSegunTipo();

        // Actualizar los campos al cambiar el tipo de cliente en el modal de edición
        editarModal.querySelector('#Tipo_Cliente').addEventListener('change', actualizarCamposSegunTipo);
    });
});

// Función para manejar la eliminación
function handleDelete(itemId) {
    // Redirige a la vista de eliminación usando la ruta show
    window.location.href = `/clientes/${itemId}/show`;
}

