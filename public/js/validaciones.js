document.addEventListener('DOMContentLoaded', function () {
    // Función para manejar la habilitación/deshabilitación de campos según el tipo de cliente
    function toggleFieldsByClientType(form) {
        const tipoCliente = form.querySelector('select[name="Tipo_Cliente"]').value;

        const nombreRepresentante = form.querySelector('input[name="Nombre_Representante_legal"]');
        const genero = form.querySelector('select[name="Genero"]');
        const numeroDPI = form.querySelector('input[name="Numero_DPI"]');
        const nit = form.querySelector('input[name="NIT"]');
        const telefono = form.querySelector('input[name="Telefono"]'); // Añadir el campo Teléfono

        if (tipoCliente === 'Individual') {
            nombreRepresentante.disabled = true;
            genero.disabled = false;
            numeroDPI.disabled = false;
            nit.disabled = false;
            telefono.disabled = false; // Habilitar el teléfono
        } else if (tipoCliente === 'Empresa') {
            nombreRepresentante.disabled = false;
            genero.disabled = true;
            numeroDPI.disabled = true;
            nit.disabled = false;
            telefono.disabled = false; // Habilitar el teléfono
        }
    }

    // Función para mostrar una alerta de error
    function mostrarAlerta(form, mensaje) {
        const alertaDiv = document.createElement('div');
        alertaDiv.className = 'alert alert-danger';
        alertaDiv.role = 'alert';
        alertaDiv.textContent = mensaje;
        form.prepend(alertaDiv); // Mostrar alerta antes del formulario

        // Eliminar alerta después de 5 segundos
        setTimeout(() => {
            alertaDiv.remove();
        }, 5000);
    }

    // Función para validar que el municipio corresponde al departamento
    function validarMunicipio(form) {
        const departamentoSeleccionado = form.querySelector('select[name="Departamento"]').value;
        const municipioSeleccionado = form.querySelector('select[name="Municipio"]').value;

        if (municipioSeleccionado && departamentoSeleccionado) {
            const municipiosValidos = municipiosPorDepartamento[departamentoSeleccionado] || [];
            if (!municipiosValidos.includes(municipioSeleccionado)) {
                mostrarAlerta(form, 'Debe seleccionar un municipio válido para el departamento elegido.');
                form.querySelector('select[name="Municipio"]').value = ''; // Resetear selección de municipio
            }
        }
    }

    // Lista de municipios por departamento
    const municipiosPorDepartamento = {
        Guatemala: ['Ciudad de Guatemala', 'Mixco', 'Villa Nueva', 'Santa Catarina Pinula'],
        Sacatepéquez: ['Antigua Guatemala', 'San Lucas Sacatepéquez', 'San Miguel Dueñas'],
        Chimaltenango: ['Chimaltenango', 'San José Poaquil', 'San Martín Jilotepeque'],
        Escuintla: ['Escuintla', 'Santa Lucía Cotzumalguapa', 'La Democracia'],
        Zacapa: ['Zacapa', 'Chiquimula', 'La Unión', 'San Jorge'],
        Izabal: ['Puerto Barrios', 'Livingston', 'El Estor', 'María Dolores', 'Los Amates'],
    };

    // Validación para Número de NIT, Número de DPI y Teléfono al momento de guardar
    function validarCamposNITDPI(form) {
        const nit = form.querySelector('input[name="NIT"]').value;
        const numeroDPI = form.querySelector('input[name="Numero_DPI"]');
        const telefono = form.querySelector('input[name="Telefono"]').value; // Campo Teléfono

        let valid = true;

        // Validar NIT: debe tener al menos 8 dígitos, no ser solo ceros y no estar formado por el mismo conjunto de números
        if (nit.length < 8 || /^0+$/.test(nit) || /^(\d)\1{7}$/.test(nit)) {
            mostrarAlerta(form, 'Porfavor ingrese un NIT valido.');
            valid = false;
        }

        // Validar DPI: solo si el campo está habilitado
        const dpiSinEspacios = numeroDPI.value.replace(/\s/g, ''); // Eliminar espacios para validar el DPI
        if (!numeroDPI.disabled) {
            if (dpiSinEspacios.length !== 13 || /^0+$/.test(dpiSinEspacios) || /^(\d)\1{12}$/.test(dpiSinEspacios)) {
                mostrarAlerta(form, 'Porfavor ingrese un DPI valido.');
                valid = false;
            }
        }

        // Validar Teléfono: debe tener 8 dígitos, no ser solo ceros
        if (telefono.length !== 8 || /^0+$/.test(telefono) || /^(\d)\1{7}$/.test(telefono)) {
            mostrarAlerta(form, 'Porfavor ingrese un número de teléfono válido (8 dígitos).');
            valid = false;
        }

        return valid;
    }

    // Función para manejar validaciones comunes
    function agregarValidaciones(form) {
        form.querySelector('select[name="Tipo_Cliente"]').addEventListener('change', function () {
            toggleFieldsByClientType(form);
        });

        form.querySelector('select[name="Departamento"]').addEventListener('change', function () {
            validarMunicipio(form);
        });

        form.querySelector('select[name="Municipio"]').addEventListener('change', function () {
            validarMunicipio(form);
        });

        // Validaciones específicas para los campos de NIT, DPI, Teléfono y Nombre del Representante Legal
        form.addEventListener('input', function (event) {
            const target = event.target;
            if (target.matches('input[name="NIT"]')) {
                // Validar NIT: solo números y permitir solo 8 dígitos
                target.value = target.value.replace(/[^0-9]/g, ''); // Solo números
                if (target.value.length > 8) {
                    target.value = target.value.slice(0, 8); // Limitar a 8 dígitos
                }
            } else if (target.matches('input[name="Numero_DPI"]')) {
                // Validar Número de DPI: solo números y formatearlo con espacios
                target.value = target.value.replace(/[^0-9]/g, ''); // Solo números

                // Formato 0000 00000 0000
                if (target.value.length > 4 && target.value.length <= 9) {
                    target.value = target.value.slice(0, 4) + ' ' + target.value.slice(4);
                } else if (target.value.length > 9) {
                    target.value = target.value.slice(0, 4) + ' ' + target.value.slice(4, 9) + ' ' + target.value.slice(9, 13);
                }
            } else if (target.matches('input[name="Telefono"]')) {
                // Validar Teléfono: solo números y permitir solo 8 dígitos
                target.value = target.value.replace(/[^0-9]/g, ''); // Solo números
                if (target.value.length > 8) {
                    target.value = target.value.slice(0, 8); // Limitar a 8 dígitos
                }
            } else if (target.matches('input[name="Nombre_Representante_legal"]')) {
                // Validar Nombre del Representante Legal: solo letras
                target.value = target.value.replace(/[^a-zA-Z\s]/g, '');
            }
        });

        // Validación al enviar el formulario
        form.addEventListener('submit', function (event) {
            if (!validarCamposNITDPI(form)) {
                event.preventDefault(); // Evitar el envío si las validaciones no pasan
            }
        });
    }

    // Agregar cliente
    const agregarClienteForm = document.querySelector('#agregarClienteForm');
    if (agregarClienteForm) {
        agregarValidaciones(agregarClienteForm);
        toggleFieldsByClientType(agregarClienteForm); // Aplicar la validación inicial
    }

    // Editar cliente
    const editarClienteModal = document.querySelector('#editarClienteModal');
    if (editarClienteModal) {
        editarClienteModal.addEventListener('show.bs.modal', function () {
            const form = document.querySelector('#editarClienteForm');
            if (form) {
                agregarValidaciones(form);
                toggleFieldsByClientType(form); // Aplicar la validación inicial cuando se abra el modal
            }
        });
    }

    // Ocultar mensaje de error después de 2000 milisegundos (2 segundos)
    const errorAlert = document.querySelector('.alert-danger');
    if (errorAlert) {
        setTimeout(function () {
            errorAlert.style.display = 'none';
        }, 3000); // 3000 milisegundos = 3 segundos
    }
});
